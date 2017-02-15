<?php

use yii\helpers\Html;
use kartik\icons\Icon;

$this->title = 'รายงาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#first">
                        <?= Html::label('รายงานสินค้าคงคลัง') ?>
                    </a>
                </li>

                <li class="tab-success">
                    <a data-toggle="tab" href="#second">
                        <?= Html::label('รายงานการจัดชื้อ') ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="first" class="tab-pane in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="panel-title"><?= Html::label(Icon::show('medkit') . 'ยา') ?></h3></div>
                                <div class="panel-body">
                                    <table class="default kv-grid-table table table-hover table-condensed kv-table-wrap" width="100%">
                                        <tbody>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานยอดคงเหลือรวม') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'PrintReportStkBalancetotal(this);', 'catid' => 1]) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานยอดคงเหลือแยกตามคลังสินค้า') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานยอดคงเหลือแยกตามคลังสินค้ายา']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานยอดคงเหลือแยกตามคลังสินค้าเพื่อตรวจนับ') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานยอดคงเหลือแยกตามคลังสินค้ายาเพื่อตรวจนับ']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานปริมาณการขายสินค้า สรุปรายเดือน') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานปริมาณการขายสินค้ายา สรุปรายเดือน']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานยอดคงเหลือแยกตาม Lot') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'PrintReportStkBalancelotnumber(1)']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานเคลื่อนไหวคลังสินค้า') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานเคลื่อนไหวคลังสินค้า(ยา)']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานสินค้าที่ไม่มีการเคลื่อนไหว') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานสินค้าที่ไม่มีการเคลื่อนไหว(ยา)']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานสินค้าหมดอายุ') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'PrintReportNondrugExpired(1);']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานสินค้าต่ำกว่าจุดสั่งชื้อ') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'PrintReportReorderpoint(1);']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานสินค้าสูงกว่าระดับการเก็บ') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'PrintReportOverstock(1)']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานการโอนสินค้ารายเดือน') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานการโอนสินค้ารายเดือน(ยา)']) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="panel-title"><?= Html::label(Icon::show('stethoscope') . 'เวชภัณฑ์') ?></h3></div>
                                <div class="panel-body">
                                    <table class="default kv-grid-table table table-hover table-condensed kv-table-wrap" width="100%">
                                        <tbody>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานยอดคงเหลือรวม') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'PrintReportStkBalancetotal(this);', 'catid' => 2]) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานยอดคงเหลือแยกตามคลังสินค้า') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานยอดคงเหลือแยกตามคลังสินค้าเวชภัณฑ์']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานยอดคงเหลือแยกตามคลังสินค้าเพื่อตรวจนับ') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานยอดคงเหลือแยกตามคลังสินค้าเวชภัณฑ์เพื่อตรวจนับ']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานปริมาณการขายสินค้า สรุปรายเดือน') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานปริมาณการขายสินค้าเวชภัณฑ์ สรุปรายเดือน']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานยอดคงเหลือแยกตาม Lot') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'PrintReportStkBalancelotnumber(2)']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานเคลื่อนไหวคลังสินค้า') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานเคลื่อนไหวคลังสินค้า(เวชภัณฑ์)']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานสินค้าที่ไม่มีการเคลื่อนไหว') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานสินค้าที่ไม่มีการเคลื่อนไหว(เวชภัณฑ์)']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานสินค้าหมดอายุ') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'PrintReportNondrugExpired(2);']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานสินค้าต่ำกว่าจุดสั่งชื้อ') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'PrintReportReorderpoint(2);']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานสินค้าสูงกว่าระดับการเก็บ') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'PrintReportOverstock(2)']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานการโอนสินค้ารายเดือน') ?>
                                                </td>
                                                <td class="text-align-center">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานการโอนสินค้ารายเดือน(เวชภัณฑ์)']) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="second" class="tab-pane">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="panel-title"><?= Html::label(Icon::show('list') . '') ?></h3></div>
                                <div class="panel-body">
                                    <table class="default kv-grid-table table  table-hover table-condensed kv-table-wrap" width="100%">
                                        <tbody>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>

                                                    <?= Html::label('รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ') ?>

                                                </td>
                                                <td class="text-align-center" style="">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hover="dropdown" data-delay="100">
                                                            <i class="fa fa-print"></i> Report <span class="caret">
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><?= Html::a('ยาสามัญ', 'javascript:void(0);', ['style' => 'font-size: 12pt;', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ(ยาสามัญ)']) ?></li>
                                                            <li><?= Html::a('ยาการค้า', 'javascript:void(0);', ['style' => 'font-size: 12pt;', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ(ยาการค้า)']) ?></li>
                                                            <li><?= Html::a('เวชภัณฑ์ฯ', 'javascript:void(0);', ['style' => 'font-size: 12pt;', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ(เวชภัณฑ์ฯ)']) ?></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>

                                                    <?= Html::label('รายงานประวัติการสั่งชื้อตามรายการสินค้า ตามผู้จำหน่าย') ?>

                                                </td>
                                                <td class="text-align-center" style="">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hover="dropdown" data-delay="100">
                                                            <i class="fa fa-print"></i> Report <span class="caret">
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><?= Html::a('ยา', 'javascript:void(0);', ['style' => 'font-size: 12pt;', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานประวัติการสั่งชื้อตามรายการสินค้า ตามผู้จำหน่าย(ยา)']) ?></li>
                                                            <li><?= Html::a('เวชภัณฑ์ฯ', 'javascript:void(0);', ['style' => 'font-size: 12pt;', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานประวัติการสั่งชื้อตามรายการสินค้า ตามผู้จำหน่าย(เวชภัณฑ์)']) ?></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>

                                                    <?= Html::label('รายงานยอดสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย') ?>

                                                </td>
                                                <td class="text-align-center" style="">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hover="dropdown" data-delay="100">
                                                            <i class="fa fa-print"></i> Report <span class="caret">
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><?= Html::a('ยาการค้า', 'javascript:void(0);', ['style' => 'font-size: 12pt;', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานยอดสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย(ยา)']) ?></li>
                                                            <li><?= Html::a('เวชภัณฑ์ฯ', 'javascript:void(0);', ['style' => 'font-size: 12pt;', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานยอดสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย(เวชภัณฑ์ฯ)']) ?></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('Price List') ?>
                                                </td>
                                                <td class="text-align-center" style="">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hover="dropdown" data-delay="100">
                                                            <i class="fa fa-print"></i> Report <span class="caret">
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><?= Html::a('ราคายา', 'javascript:void(0);', ['style' => 'font-size: 12pt;','onclick' => 'PrintReportPriceList(1);']) ?></li>
                                                            <li><?= Html::a('ราคาเวชภัณฑ์ฯ', 'javascript:void(0);', ['style' => 'font-size: 12pt;','onclick' => 'PrintReportPriceList(2);']) ?></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานสถานะการสั่งชื้อ') ?>
                                                </td>
                                                <td class="text-align-center" style="">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'รายงานสถานะการสั่งชื้อ']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานสถานะการณ์ส่งเปลี่ยนคืนสินค้า') ?>
                                                </td>
                                                <td class="text-align-center" style="">
                                                    <?= Html::a(Icon::show('print') . 'Report', ['/Report/default/senditemschangescenarios'], ['class' => 'btn btn-sm btn-success', 'target' => '_blank']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('รายงานการประเมินการส่งมอบสินค้าจากผู้จำหน่าย') ?>
                                                </td>
                                                <td class="text-align-center" style="">
                                                    <?= Html::a(Icon::show('print') . 'Report', ['/Report/default/assessment-deliveredbysupplier'], ['class' => 'btn btn-sm btn-success', 'target' => '_blank']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('ประวัติการอนุมัติ ยาขอใช้นอกแผน(รายการยาใหม่)') ?>
                                                </td>
                                                <td class="text-align-center" style="">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'ประวัติการอนุมัติ ยาขอใช้นอกแผน(รายการยาใหม่)']) ?>
                                                </td>
                                            </tr>
                                            <tr class="primary">
                                                <td style="font-size: 16pt;">
                                                    <?= Icon::show('hand-right', [], Icon::BSG) ?>
                                                    <?= Html::label('ประวัติการไม่อนุมัติ ยาขอใช้นอกแผน(รายการยาใหม่)') ?>
                                                </td>
                                                <td class="text-align-center" style="">
                                                    <?= Html::a(Icon::show('print') . 'Report', false, ['class' => 'btn btn-sm btn-success', 'onclick' => 'GetfromReport(this);', 'title' => 'ประวัติการไม่อนุมัติ ยาขอใช้นอกแผน(รายการยาใหม่)']) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>
<?php echo $this->render('modal') ?>
<?php echo $this->render('script') ?>