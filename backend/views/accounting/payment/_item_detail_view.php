<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<td>
    <span class="serial"></span>
    <a data-action="delete" title="Delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
        <?= Html::activeHiddenInput($model, "[$key]invoice_id", ['data-field' => 'invoice_id', 'id' => false]) ?>
</td>
<td><span data-field="invoice"><?= Html::getAttributeValue($model, "[$key]invoice[number]") ?></span></td>
<td><span data-field="date"><?= Html::getAttributeValue($model, "[$key]invoice[Date]") ?></span></td>
<td><span data-field="time_to_due">
        <?php
        $d1 = new \DateTime(Html::getAttributeValue($model, "[$key]invoice[due_date]"));
        $d2 = new \DateTime(date('Y-m-d'));
        echo Html::encode($d1->diff($d2)->days . ' Days')
        ?>
    </span>
</td>
<?php
$val = Html::getAttributeValue($model, "[$key]invoice[value]");
$paid = Html::getAttributeValue($model, "[$key]value");
$sisa = $val - $paid
?>
<td ><span data-field="date"><?= number_format($val, 0) ?></span></td>
<td ><span data-field="date"><?= number_format($paid, 0) ?></span></td>
<td ><span data-field="date"><?= number_format($sisa, 0) ?></span></td>

