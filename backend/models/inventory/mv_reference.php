<?php
return [
    // purchase
    10 => [
        'name' => 'Purchase',
        'class' => 'backend\models\purchase\Purchase',
        'action' => '/purcahse/purchase/view',
        'type' => 10,
        'onlyStatus' => 20,
        'items' => 'items',
        'itemField' => [
            'product_id' => 'product_id',
            'uom_id' => 'uom_id',
            'value' => 'price'
        ],
    ],
    // sales
    60 => [
        'name' => 'Sales',
        'class' => 'backend\models\sales\Sales',
        'action' => '/sales/sales/view',
        'type' => 20,
        'onlyStatus' => 20,
        'items' => 'items',
        'itemField' => [
            'product_id' => 'product_id',
            'uom_id' => 'uom_id',
            'value' => 'price',
            'cogs' => 'cogs'
        ],
    ],
];