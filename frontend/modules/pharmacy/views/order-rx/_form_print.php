<?php

use kartik\grid\GridView;
use app\modules\pharmacy\models\TbMedicalRigth;
use app\modules\pharmacy\models\VwUserprofile;
use yii\helpers\Html;
use app\modules\pharmacy\models\VwCpoeRxDetail2;

$queryUser = VwUserprofile::findOne(['user_id' => $model['cpoe_order_by']]);
foreach ($ptar as $data) {
    $query1 = TbMedicalRigth::find()->where(['medical_right_id' => $data['medical_right_id']])->all();
}
$i = 1;
?>

<?php if ($type == 'A4'): ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
        <tr>
            <td width="33%" class="text-left" style="vertical-align: middle;">
                <img  height="80px" src="images/logocrop.jpg"/>
            </td>
            <td width="33%" class="text-center" style="vertical-align: middle; font-size: 18pt;">
                <p><b>ใบสรุปรายการยา</b></p>
            </td>
            <td width="33%" class="text-center" style="vertical-align: middle; ">
        <barcode code="<?php echo $model['cpoe_id']; ?>" type="C128B" size="0.8" height="1.5"/>
        <p><?php echo $model['cpoe_id']; ?></p>
    </td>
    </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td style="vertical-align: top;" width="70%">
                <table width="100%" border="" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%"  style= " text-align: left; font-size: 16pt; ">
                            <p style="font-size: 16pt;"><b><?php echo $header['pt_name']; ?></b>
                                &nbsp; <b>อายุ :</b><?= !$header->pt_age_registry_date ? '-' : ' ' . $header->pt_age_registry_date . ' '; ?> ปี </p>
                            <p style="font-size: 16pt;"> <b>HN :</b>  <?= !$header->pt_hospital_number ? '-' : $header->pt_hospital_number; ?>
                                &nbsp; <b> VN :</b>  <?= !$header->pt_visit_number ? '-' : $header->pt_visit_number; ?> </p>
                        </td>
                    </tr>
                    <tr>

                        <td width="100%" style=" text-align: left; font-size: 16pt;"><b> สิทธิการักษา :</b>
                            <?php
                            if ($query1 !== null) {
                                foreach ($query1 as $d) {
                                    echo $d['medical_right_desc'] . ',';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 16pt;">
                            <b>แพทย์ :</b>&nbsp; <?php echo empty($queryUser) ? '-' : $queryUser['User_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size: 16pt;">
                            <b>รหัสเบิกจ่าย :</b> <?php echo $model['pt_trp_regimen_paycode']; ?>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="vertical-align: top;" width="30%">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%" style="font-size: 16pt;">
                            <b>ใบสั่งยา เลขที่ :</b> <?php echo $model['cpoe_num']; ?>
                            <p><b>วันที่</b> <?php echo Yii::$app->formatter->asDatetime($model['cpoe_date'], 'dd-MM-yyyy'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size: 16pt;">
                            <b>Dx :</b> <?php echo 'xxxx'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size: 16pt;">
                            <b>Regimen : </b> <?php echo $model['pt_trp_regimen_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size: 16pt;">
                            <b>Cycle :</b> <?php echo $model['chemo_cycle_seq']; ?>
                            &nbsp;<b>Day :</b> <?php echo $model['chemo_cycle_day']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size: 16pt;">
                            <b>CPR : </b><?php echo $model['pt_cpr_number']; ?>
                            &nbsp;<b>OCPA :</b> <?php echo $model['pt_ocpa_number']; ?>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
<?php endif; ?>


<?php if ($type == 'Tabloid'): ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
        <tr>
            <td width="50%" class="text-left" style="vertical-align: top; font-size: 18pt;">
                <p><b>ใบสรุปรายการยา</b></p>
            </td>
            <td width="50%" class="text-center" style="vertical-align: middle; ">
        <barcode code="<?php echo $model['cpoe_id']; ?>" type="C128B" size="0.8" height="1.0"/>
        <p><?php echo $model['cpoe_id']; ?></p>
    </td>
    </tr>
    </table>

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td style="vertical-align: top;" width="55%">
                <table width="100%" border="" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%"  style= " text-align: left; font-size: 13pt; ">
                            <p style="font-size: 13pt;"><b><?php echo $header['pt_name']; ?></b>
                                &nbsp; <b>อายุ :</b><?= !$header->pt_age_registry_date ? '-' : ' ' . $header->pt_age_registry_date . ' '; ?> ปี </p>
                            <p style="font-size: 13pt;"> <b>HN :</b>  <?= !$header->pt_hospital_number ? '-' : $header->pt_hospital_number; ?>
                                &nbsp; <b> VN :</b>  <?= !$header->pt_visit_number ? '-' : $header->pt_visit_number; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style=" text-align: left; font-size: 13pt;"><b> สิทธิการักษา :</b>
                            <?php
                            if ($query1 !== null) {
                                foreach ($query1 as $d) {
                                    echo $d['medical_right_desc'] . ',';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 13pt;">
                            <b>แพทย์ :</b>&nbsp; <?php echo empty($queryUser) ? '-' : $queryUser['User_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size: 13pt;">
                            <b>รหัสเบิกจ่าย :</b> <?php echo $model['pt_trp_regimen_paycode']; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top;" width="45%">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%" style="font-size: 13pt;">
                            <b>ใบสั่งยา เลขที่ :</b> <?php echo $model['cpoe_num']; ?>
                            <p><b>วันที่</b> <?php echo Yii::$app->formatter->asDatetime($model['cpoe_date'], 'dd-MM-yyyy'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size: 13pt;">
                            <b>Dx :</b> <?php echo 'xxxx'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size: 13pt;">
                            <b>Regimen : </b> <?php echo $model['pt_trp_regimen_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size: 13pt;">
                            <b>Cycle :</b> <?php echo $model['chemo_cycle_seq']; ?>
                            &nbsp;<b>Day :</b> <?php echo $model['chemo_cycle_day']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size: 13pt;">
                            <b>CPR : </b><?php echo $model['pt_cpr_number']; ?>
                            &nbsp;<b>OCPA :</b> <?php echo $model['pt_ocpa_number']; ?>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

<?php endif; ?>

<?php if ($type == 'A4_content') : ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="5%" style="font-size: 16pt;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;">
                    <?= Html::label('#') ?>
                </th>
                <th width="10%" style="font-size: 16pt;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;">
                    <?= Html::label('ประเภท') ?>
                </th>
                <th width="10%" style="font-size: 16pt;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;">
                    <?= Html::label('รหัสสินค้า') ?>
                </th>
                <th width="25%" style="font-size: 16pt;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;">
                    <?= Html::label('รายการ') ?>
                </th>
                <th width="10%" style="font-size: 16pt;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;">
                    <?= Html::label('จำนวน') ?>
                </th>
                <th width="10%" style="font-size: 16pt;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;">
                    <?= Html::label('ราคา/หน่วย') ?>
                </th>
                <th width="10%" style="font-size: 16pt;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;">
                    <?= Html::label('จำนวนเงิน') ?>
                </th>
                <th width="10%" style="font-size: 16pt;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;">
                    <?= Html::label('เบิกได้') ?>
                </th>
                <th width="10%" style="font-size: 16pt;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;">
                    <?= Html::label('เบิกไม่ได้') ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($query11 as $r) : ?>
                <tr>
                    <td style="font-size: 16pt;vertical-align: top;border-top: 1px solid #ddd;">

                    </td>
                    <td style="font-size: 16pt;vertical-align: top;text-align: center;border-top: 1px solid #ddd;">
                        <strong><?php echo $r['cpoe_itemtype_decs']; ?></strong>
                    </td>
                    <td style="font-size: 16pt;vertical-align: top;padding-left: 10px;border-top: 1px solid #ddd;" colspan="7">
                        <?php echo $r['ItemDetail']; ?>
                    </td>
                </tr>
                <?php if (($r['cpoe_Itemtype'] == 40) || ($r['cpoe_Itemtype'] == 50)): ?>
                    <?php $rows = VwCpoeRxDetail2::find()->where(['cpoe_parentid' => $r['cpoe_ids']])->orderBy('ItemID')->all(); ?>
                    <?php foreach ($rows as $r1) : ?>    
                        <tr>
                            <td style="font-size: 16pt;text-align: center;vertical-align: top;">
                                <?php echo $i; ?>
                            </td>
                            <td style="font-size: 16pt;">

                            </td>
                            <td style="font-size: 16pt;text-align: center;vertical-align: top;">
                                <?php echo $r1['ItemID']; ?>
                            </td>
                            <td style="font-size: 16pt;vertical-align: top;">
                                <?php echo $r1['ItemDetail']; ?>
                            </td>
                            <td style="font-size: 16pt;text-align: center;vertical-align: top;">
                                <?php echo $r1['ItemQty1']; ?>
                            </td>
                            <td style="font-size: 16pt;text-align: right;vertical-align: top;">
                                <?php echo number_format($r1['ItemPrice'], 2); ?>
                            </td>
                            <td style="font-size: 16pt;text-align: right;vertical-align: top;">
                                <?php echo number_format($r1['Item_Amt'], 2); ?>
                            </td>
                            <td style="font-size: 16pt;text-align: right;vertical-align: top;">
                                <?php echo number_format($r1['Item_Cr_Amt_Sum'], 2); ?>
                            </td>
                            <td style="font-size: 16pt;text-align: right;vertical-align: top;">
                                <?php echo number_format($r1['Item_Pay_Amt_Sum'], 2); ?>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php $rows = VwCpoeRxDetail2::find()->where(['cpoe_Itemtype' => $r['cpoe_Itemtype'], 'cpoe_id' => $model['cpoe_id']])->all(); ?>
                    <?php foreach ($rows as $r1) : ?>    
                        <tr>
                            <td style="font-size: 16pt;text-align: center;vertical-align: top;">
                                <?php echo $i; ?>
                            </td>
                            <td style="font-size: 16pt;">

                            </td>
                            <td style="font-size: 16pt;text-align: center;vertical-align: top;">
                                <?php echo $r1['ItemID']; ?>
                            </td>
                            <td style="font-size: 16pt;vertical-align: top;">
                                <?php echo $r1['ItemDetail']; ?>
                            </td>
                            <td style="font-size: 16pt;text-align: center;vertical-align: top;">
                                <?php echo $r1['ItemQty1']; ?>
                            </td>
                            <td style="font-size: 16pt;text-align: right;vertical-align: top;">
                                <?php echo number_format($r1['ItemPrice'], 2); ?>
                            </td>
                            <td style="font-size: 16pt;text-align: right;vertical-align: top;">
                                <?php echo number_format($r1['Item_Amt'], 2); ?>
                            </td>
                            <td style="font-size: 16pt;text-align: right;vertical-align: top;">
                                <?php echo number_format($r1['Item_Cr_Amt_Sum'], 2); ?>
                            </td>
                            <td style="font-size: 16pt;text-align: right;vertical-align: top;">
                                <?php echo number_format($r1['Item_Pay_Amt_Sum'], 2); ?>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php /*
      GridView::widget([
      'dataProvider' => $dataProvider,
      'layout' => '{items}',
      'showPageSummary' => true,
      'striped' => false,
      'condensed' => true,
      'bordered' => false,
      'headerRowOptions' => [
      'class' => GridView::TYPE_DEFAULT
      ],
      'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
      'columns' => [
      [
      'class' => '\kartik\grid\SerialColumn',
      'header' => 'ลำดับ',
      'contentOptions' => ['style' => 'font-size: 12pt;text-align:center;',],
      'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt; '],
      ],
      [
      'header' => 'ประเภท',
      'attribute' => 'cpoe_itemtype_decs',
      'contentOptions' => ['style' => 'font-size: 12pt;text-align:left;'],
      'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt; '],
      'value' => function($model, $key, $index) {
      return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
      },
      ],
      [
      'header' => 'รหัสสินค้า',
      'attribute' => 'ItemID',
      'contentOptions' => ['style' => 'font-size: 12pt;text-align:center;'],
      'headerOptions' => ['style' => 'color:black; text-align:center;font-size: 14pt;'],
      'value' => function($model, $key, $index) {
      return empty($model->ItemID) ? '-' : $model->ItemID;
      },
      ],
      [
      'header' => 'รายการ',
      'attribute' => 'ItemDetail',
      'contentOptions' => ['style' => 'font-size: 12pt;text-align:left;'],
      'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
      'value' => function($model, $key, $index) {
      return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
      },
      ],
      [
      'header' => 'จำนวน',
      'attribute' => 'ItemQty1',
      'contentOptions' => ['style' => 'font-size: 12pt;text-align:center;'],
      'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
      'value' => function($model, $key, $index) {
      return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
      },
      ],
      [
      'header' => 'ราคา/หน่วย',
      'attribute' => 'ItemPrice',
      'contentOptions' => ['style' => 'font-size: 12pt;text-align:right;'],
      'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
      'pageSummary' => 'รวม',
      'format' => ['decimal', 2],
      'pageSummaryOptions' => ['style' => 'text-align:right;font-size: 12pt',],
      'value' => function($model, $key, $index) {
      return empty($model->ItemPrice) ? '' : $model->ItemPrice;
      },
      ],
      [
      'header' => 'จำนวนเงิน',
      'attribute' => 'Item_Amt',
      'contentOptions' => ['style' => 'font-size: 12pt;text-align:right;'],
      'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
      'format' => ['decimal', 2],
      'pageSummary' => true,
      'pageSummaryOptions' => ['style' => 'text-align:right;font-size: 12pt'],
      'value' => function($model, $key, $index) {
      return empty($model->Item_Amt) ? '' : $model->Item_Amt;
      },
      ],
      [
      'header' => 'เบิกได้',
      'attribute' => 'Item_Cr_Amt_Sum',
      'contentOptions' => ['style' => 'font-size: 12pt;text-align:right;'],
      'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
      'pageSummary' => true,
      'format' => ['decimal', 2],
      'pageSummaryOptions' => ['style' => 'text-align:right;font-size: 12pt'],
      'value' => function($model, $key, $index) {
      return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
      },
      ],
      [
      'header' => 'เบิกไม่ได้',
      'attribute' => 'Item_Pay_Amt_Sum',
      'contentOptions' => ['style' => 'font-size: 12pt;text-align:right;'],
      'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
      'pageSummary' => true,
      'format' => ['decimal', 2],
      'pageSummaryOptions' => ['style' => 'text-align:right;font-size: 12pt',],
      'value' => function($model, $key, $index) {
      return empty($model->Item_Pay_Amt_Sum) ? '' : $model->Item_Pay_Amt_Sum;
      },
      ],
      ],
      ]); */
    ?>
<?php endif; ?>

<?php if ($type == 'slip_content') : ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'showPageSummary' => true,
        'striped' => false,
        'condensed' => true,
        'bordered' => false,
        'headerRowOptions' => [
            'class' => GridView::TYPE_DEFAULT
        ],
        'toggleData' => false,
        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
//    'panel' => [
//        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> Details</h3>',
//        'type' => GridView::TYPE_DEFAULT,
//        'before' => false,
//        'after' => false,
//    ],
        'columns' => [
            [
                'class' => '\kartik\grid\SerialColumn',
                'header' => 'ลำดับ',
                'contentOptions' => ['style' => 'font-size: 14pt;text-align:center;',],
                'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt; '],
            ],
            [
                'header' => 'cpoe_itemtype_decs',
                'attribute' => 'cpoe_itemtype_decs',
                'contentOptions' => ['style' => 'font-size: 14pt;text-align:left;'],
                'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt; '],
                'value' => function($model, $key, $index) {
                    return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
                },
            ],
            [
                'header' => 'รหัสสินค้า',
                'attribute' => 'ItemID',
                'contentOptions' => ['style' => 'font-size: 14pt;text-align:center;'],
                'headerOptions' => ['style' => 'color:black; text-align:center;font-size: 14pt;'],
                'value' => function($model, $key, $index) {
                    return empty($model->ItemID) ? '-' : $model->ItemID;
                },
            ],
            [
                'header' => 'รายการ',
                'attribute' => 'ItemDetail',
                'contentOptions' => ['style' => 'font-size: 14pt;text-align:left;'],
                'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
                'value' => function($model, $key, $index) {
                    return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
                },
            ],
            [
                'header' => 'จำนวน',
                'attribute' => 'ItemQty1',
                'contentOptions' => ['style' => 'font-size: 14pt;text-align:center;white-space: nowrap',],
                'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
                'value' => function($model, $key, $index) {
                    return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
                },
            ],
            [
                'header' => 'ราคา/หน่วย',
                'attribute' => 'ItemPrice',
                'contentOptions' => ['style' => 'font-size: 14pt;text-align:right;'],
                'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
                'pageSummary' => 'รวม',
                'format' => ['decimal', 2],
                'noWrap' => true,
                'pageSummaryOptions' => ['style' => 'text-align:right;font-size: 14pt'],
                'value' => function($model, $key, $index) {
                    return empty($model->ItemPrice) ? '' : $model->ItemPrice;
                },
            ],
            [
                'header' => 'จำนวนเงิน',
                'attribute' => 'Item_Amt',
                'contentOptions' => ['style' => 'font-size: 14pt;text-align:right;'],
                'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
                'format' => ['decimal', 2],
                'pageSummary' => true,
                'noWrap' => true,
                'pageSummaryOptions' => ['style' => 'text-align:right;font-size: 14pt'],
                'value' => function($model, $key, $index) {
                    return empty($model->Item_Amt) ? '' : $model->Item_Amt;
                },
            ],
            [
                'header' => 'เบิกได้',
                'attribute' => 'Item_Cr_Amt_Sum',
                'contentOptions' => ['style' => 'font-size: 14pt;text-align:right;'],
                'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
                'pageSummary' => true,
                'noWrap' => true,
                'format' => ['decimal', 2],
                'pageSummaryOptions' => ['style' => 'text-align:right;font-size: 14pt'],
                'value' => function($model, $key, $index) {
                    return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
                },
            ],
            [
                'header' => 'เบิกไม่ได้',
                'attribute' => 'Item_Pay_Amt_Sum',
                'contentOptions' => ['style' => 'font-size: 14pt;text-align:right;'],
                'headerOptions' => ['style' => 'color:black;text-align:center;font-size: 14pt;'],
                'pageSummary' => true,
                'noWrap' => true,
                'format' => ['decimal', 2],
                'pageSummaryOptions' => ['style' => 'text-align:right;font-size: 14pt'],
                'value' => function($model, $key, $index) {
                    return empty($model->Item_Pay_Amt_Sum) ? '' : $model->Item_Pay_Amt_Sum;
                },
            ],
        ],
    ]);
    ?>

<?php endif; ?>


<?php if ($type == 'footer') : ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td width="50%" style="font-size: 12pt; text-align: left;">
                <b>KM4</b> medical software
            </td>
            <td width="50%" style="font-size: 12pt;text-align: right;">
                <?php
                $y = date('Y') + 543;
                $t = date('H:i:s');
                echo 'Print :' . date("d/m/") . $y . ' ' . $t;
                ?> 
                By <?= Yii::$app->user->identity->username; ?>
            </td>
        </tr>
    </table>
<?php endif; ?>
<div style='page-break-after:avoid'></div>