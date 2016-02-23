<?php

namespace backend\controllers\sales;

use Yii;
use backend\models\sales\Sales;
use backend\models\sales\search\Sales as SalesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\master\Product;
use backend\models\master\Vendor;
use yii\base\UserException;
use backend\models\accounting\Invoice;
use backend\models\accounting\Payment;
use common\classes\Helper;

/**
 * SalesController implements the CRUD actions for Sales model.
 */
class SalesXController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Sales models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sales model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sales();

        $model->status = Sales::STATUS_APPLIED;
        $model->date = date('Y-m-d');
        $error = false;
        $payments = [];
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $payments = Helper::createMultiple(Payment::className(), Yii::$app->request->post());
                if (!empty($payments)) {
                    $model->items = Yii::$app->request->post('SalesDtl', []);
                    if ($model->save()) {
                        $movement = $model->createMovement([
                            'warehouse_id' => 1
                        ]);
                        if ($movement && $movement->save()) {
                            $invoice = $movement->createInvoice();
                            if ($invoice && $invoice->save()) {
                                /* @var $payment Payment */
                                $success = true;
                                $total = 0;
                                $paymentData = [
                                    'vendor_id'=>$invoice->vendor_id,
                                    'date'=>  date('Y-m-d'),
                                    'type'=>$invoice->type,
                                ];
                                foreach ($payments as $payment) {
                                    $payment->attributes = $paymentData;
                                    $payment->status = Payment::STATUS_APPLIED;

                                    $payItems = $payment->items;
                                    $payItems[0]->invoice_id = $invoice->id;
                                    $total += $payItems[0]->value;
                                    $payment->items = $payItems;
                                }
                                if ($invoice->value == $total) {
                                    foreach ($payments as $i => $payment) {
                                        if (!$payment->save()) {
                                            $success = false;
                                            $firstErrors = $payment->firstErrors;
                                            $error = "Payment {$i}: " . reset($firstErrors);
                                            break;
                                        }
                                    }
                                }  else {
                                    $success = false;
                                    $error = 'Total payment tidak sama dengan invoice';
                                }
                                if ($success) {
                                    $transaction->commit();
                                    return $this->redirect(['view', 'id' => $model->id]);
                                }
                            } else {
                                if ($invoice) {
                                    $firstErrors = $invoice->firstErrors;
                                    $error = "Invoice: " . reset($firstErrors);
                                } else {
                                    $error = 'Cannot create invoice';
                                }
                            }
                        } else {
                            if ($movement) {
                                $firstErrors = $movement->firstErrors;
                                $error = "GI: " . reset($firstErrors);
                            } else {
                                $error = 'Cannot create GI';
                            }
                        }
                    }
                } else {
                    $error = "Payment can not empty";
                }
                if ($error !== false) {
                    $model->addError('related', $error);
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
            $transaction->rollBack();
        }
        return $this->render('create', [
                'model' => $model,
                'payments' => $payments
        ]);
    }

    /**
     * Updates an existing Sales model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->status != Sales::STATUS_DRAFT) {
            throw new UserException('Tidak bisa diupdate');
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->items = Yii::$app->request->post('SalesDtl', []);
                if ($model->save()) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
            $transaction->rollBack();
        }
        return $this->render('update', [
                'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sales model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->status != Sales::STATUS_DRAFT) {
            throw new UserException('Tidak bisa didelete');
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionProductList($term = '')
    {
        $response = Yii::$app->response;
        $response->format = 'json';
        return Product::find()
                ->filterWhere(['like', 'lower([[name]])', strtolower($term)])
                ->orFilterWhere(['like', 'lower([[name]])', strtolower($term)])
                ->limit(10)->asArray()->all();
    }

    public function actionVendorList($term = '')
    {
        $response = Yii::$app->response;
        $response->format = 'json';
        return Vendor::find()
                ->filterWhere(['like', 'lower([[name]])', strtolower($term)])
                ->orFilterWhere(['like', 'lower([[code]])', strtolower($term)])
                ->limit(10)->asArray()->all();
    }

    /**
     * Finds the Sales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sales::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
