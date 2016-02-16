<?php

namespace backend\models\accounting;

use Yii;
use backend\models\master\Vendor;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property integer $type
 * @property integer $payment_type
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property PaymentDtl[] $items
 * @property Invoice[] $invoices
 * @property Vendor $vendor
 */
class Payment extends \yii\db\ActiveRecord
{

    use \mdm\converter\EnumTrait,
        \mdm\behaviors\ar\RelationTrait;
    // status payment
    const STATUS_DRAFT = 10;
    const STATUS_APPLIED = 20;
    const STATUS_CLOSE = 90;
    // type payment
    const TYPE_IN = 10;
    const TYPE_OUT = 20;
    // payment method
    const METHOD_CASH = 10;
    const METHOD_BANK = 20;

    public $vendor_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Date', 'type', 'payment_type', 'vendor_id', 'status'], 'required'],
            [['number'], 'autonumber', 'format' => 'PY' . date('Ymd') . '.?', 'digit' => 4],
            [['vendor_name'], 'safe'],
            [['items'], 'required'],
            [['items'], 'checkVendorAndType'],
            [['items'], 'relationUnique', 'targetAttributes' => 'invoice_id'],
            [['type', 'vendor_id', 'payment_type', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['number'], 'string', 'max' => 16],
        ];
    }

    public function checkVendorAndType()
    {
        foreach ($this->items as $item) {
            if ($item->invoice->vendor_id != $this->vendor_id || $item->invoice->vendor_id != $this->vendor_id) {
                $this->addError('items', 'Vendor atau type invoice tidak sama dengan vendor atau type payment');
                break;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'date' => 'Date',
            'type' => 'Type',
            'payment_type' => 'Payment Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(PaymentDtl::className(), ['payment_id' => 'id']);
    }

    /**
     *
     * @param array $value
     */
    public function setItems($value)
    {
        $this->loadRelated('items', $value);
    }

    public function getNmType()
    {
        return $this->getLogical('type', 'TYPE_');
    }

    public function getNmStatus()
    {
        return $this->getLogical('type', 'STATUS_');
    }

    public function getNmMethod()
    {
        return $this->getLogical('payment_type', 'METHOD_');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['id' => 'invoice_id'])->viaTable('{{%payment_dtl}}', ['payment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vendor_id']);
    }

    public function behaviors()
    {
        return[
            [
                'class' => 'mdm\converter\DateConverter',
                'type' => 'date', // 'date', 'time', 'datetime'
                'logicalFormat' => 'php:d-m-Y',
                'attributes' => [
                    'Date' => 'date', // date is original attribute
                ]
            ],
            'yii\behaviors\BlameableBehavior',
            'yii\behaviors\TimestampBehavior',
        ];
    }
}