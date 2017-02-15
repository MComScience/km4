<?php

use yii\helpers\Html;
?>
<style>
    tr th{
        text-align: center;
    }
</style>
<br/>
<!-- Begin Row -->
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <table class="default kv-grid-table table table-hover table-bordered table-condensed kv-table-wrap">
            <thead>
                <tr>
                    <th><?= Html::encode('ลำดับ'); ?></th>
                    <th><?= Html::encode('สิทธิ์การรักษา'); ?></th>
                    <th><?= Html::encode('ใช้สิทธิ์'); ?></th>
                    <th><?= Html::encode('เป็นเงิน'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($model)) : ?>
                    <?php $no = 1; foreach ($model as $data) : ?>
                        <tr>
                            <td class="text-center"><?= $no; ?></td>
                            <td><?= $data['ar_name1']; ?></td>
                            <td class="text-center"><?= $data['pt_ar_usage']; ?></td>
                            <td class="text-right"><?= $data['Item_Amt']; ?></td>
                        </tr>
                    <?php $no++; endforeach; ?>
                <?php endif; ?>
                <?php if (empty($model)) : ?>
                        <tr>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                        </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="col-md-8 col-md-offset-2">
        <br/>
        <div class="invoice-container">
            <div class="panel panel-success">
                <div class="panel-body">
                    <ul>
                        <li>
                            <a class="btn btn-block disabled" style="text-align: left;background-color: #f9f9f9">
                                <span class="text"><b><?= Html::encode('เหตุผลการใช้ยานอกบัญชี : '); ?></b><?= $rxdetail['ised_reason']; ?> </span>
                            </a>
                        </li>
                        <p></p>
                        <li>
                            <a class="btn btn-block  disabled" style="text-align: left;background-color: #f9f9f9">
                                <span class="text"><b><?= Html::encode('ประเภทคำสั่ง : '); ?></b> <?= $rxdetail['cpoe_Itemtype']; ?></span>
                            </a>
                        </li>
                        <p></p>
                        <li>
                            <a class="btn btn-block  disabled" style="text-align: left;background-color: #f9f9f9">
                                <span class="text"><?= $rxdetail['schedule_period']; ?> (ระยะเวลา 60 วัน)</span>
                            </a>
                        </li>
                        <p></p>
                        <li>
                            <a class="btn btn-block  disabled" style="text-align: left;background-color: #f9f9f9">
                                <span class="text"><?= $rxdetail['schedule_begin2end']; ?></span>
                            </a>
                        </li>
                        <p></p>
                        <li>
                            <a class="btn btn-block  disabled" style="text-align: left;background-color: #f9f9f9">
                                <span class="text"><?= $rxdetail['Item_comment4']; ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>                
        </div>
    </div>
</div><!-- End Row -->