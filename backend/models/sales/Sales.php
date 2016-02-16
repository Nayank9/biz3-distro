<?php

namespace backend\models\sales;

use Yii;
use backend\models\master\Branch;
use backend\models\master\Vendor;

/**
 * This is the model class for table "sales".
 *
 * @property integer $id
 * @property string $number
 * @property integer $vendor_id
 * @property integer $branch_id
 * @property string $date
 * @property double $value
 * @property double $discount
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property SalesDtl[] $items
 * @property Branch $branch 
 * @property Vendor $vendor
 */
class Sales extends \yii\db\ActiveRecord
{
    use \mdm\converter\EnumTrait,
        \mdm\behaviors\ar\RelationTrait;

    // status movement
    const STATUS_DRAFT = 10;
    const STATUS_APPLIED = 20;
    const STATUS_CLOSE = 90;

    public $vendor_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sales}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branch_id', 'Date', 'value', 'status'], 'required'],
            [['vendor_id', 'branch_id', 'status'], 'integer'],
            [['vendor_name'], 'safe'],
            [['number'], 'autonumber', 'format' => 'SA' . date('Ymd') . '.?', 'digit' => 4],
            [['items'], 'required'],
            [['items'], 'relationUnique', 'targetAttributes' => 'product_id'],
            [['value', 'discount'], 'number'],
            [['number'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'vendor_id' => 'Vendor ID',
            'branch_id' => 'Branch ID',
            'date' => 'Date',
            'value' => 'Value',
            'discount' => 'Discount',
            'status' => 'Status',
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
        return $this->hasMany(SalesDtl::className(), ['sales_id' => 'id']);
    }

    /**
     *
     * @param array $value
     */
    public function setItems($value)
    {
        $this->loadRelated('items', $value);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vendor_id']);
    }

    public function getNmStatus()
    {
        return $this->getLogical('status', 'STATUS_');
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