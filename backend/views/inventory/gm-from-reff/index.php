<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\inventory\GoodsMovement;
use backend\models\master\Warehouse;

/* @var $this yii\web\View */
/* @var $searchModel GoodsMovement */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Movement';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12">
    <div class='btn-group pull-right'>
        <?= Html::button('New Good Movement', ['class' => 'btn bg-aqua', 'type' => 'button']) ?>        
        <?= Html::button('<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>', ['class' => 'btn btn-default dropdown-toggle', 'aria-expanded' => false, 'type' => 'button', 'data-toggle' => 'dropdown']) ?>
        <ul class="dropdown-menu" role="menu">
            <li><?= Html::a('Receive', ['create', 'type' => $searchModel::TYPE_RECEIVE]) ?></li>
            <li><?= Html::a('Issue', ['create', 'type' => $searchModel::TYPE_ISSUE]) ?></li>
        </ul>        
    </div>
</div>
<br><br>
<div class="col-lg-12 goods-movement-index">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-hover'],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'number',
            'nmReffType',
            [
                'attribute' => 'warehouse_id',
                'value' => 'warehouse.name',
                'filter' => Warehouse::selectOptions(),
            ],
            [
                'attribute' => 'vendor_id',
                'value' => 'vendor.name',
            ],
            'Date',
            [
                'attribute' => 'type',
                'value' => 'nmType',
                'filter' => GoodsMovement::enums('TYPE_')
            ],
            [
                'attribute' => 'status',
                'value' => 'nmStatus',
                'filter' => GoodsMovement::enums('STATUS_')
            ],
            // 'reff_type',
            // 'reff_id',
            // 'vendor_id',
            // 'description',
            // 'status',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
