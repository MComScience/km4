<?php

use yii\helpers\Html;

$avatar = ($userAvatar = $header->getAvatar($header->pt_visit_number)) ? $userAvatar : $header->getAvatar('');
?>
<div class="profile-header row bg-white">
    <!-- Profile Images -->
    <div class="col-lg-2 col-md-4 col-sm-12 text-center">
        <img src="<?= $avatar; ?>" class="header-avatar"/>
    </div>

    <!-- Profile Detail -->
    <div class="col-lg-3 col-md-8 col-sm-12 profile-info">
        <div class="row">
            <div class="invoice-container">
                <ul>
                    <li style="font-size: 25px"><?= $header->pt_name; ?></li>
                    <p></p>
                    <li>
                        <b><?= Html::encode('HN'); ?></b>&nbsp;&nbsp;&nbsp; <?= !$header->pt_hospital_number ? '-' : $header->pt_hospital_number; ?> &nbsp;&nbsp;&nbsp;
                        <b><?= Html::encode('อายุ'); ?></b>&nbsp;&nbsp;&nbsp; <?= !$header->pt_age_registry_date ? '-' : $header->pt_age_registry_date; ?> &nbsp;&nbsp;&nbsp;<b><?= Html::encode('ปี'); ?></b>
                    </li>
                    <li>
                        <b><?= Html::encode('VN'); ?></b>&nbsp;&nbsp;&nbsp; <?= !$header->pt_visit_number ? '-' : $header->pt_visit_number; ?> &nbsp;&nbsp;&nbsp;
                        <b><?= Html::encode('AN'); ?></b>&nbsp;&nbsp;&nbsp; <?= !$header->pt_admission_number ? '-' : $header->pt_admission_number; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Profile Detail -->

    <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 profile-stats">
        <div class="row">

            <!-- สิทธิการรักษา -->
            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 stats-col">
                <div class="invoice-container">
                    <ul>
                        <div class="row">
                            <li class="pull-left success">&nbsp;<b><?= Html::encode('สิทธิการรักษา'); ?></b></li>
                            <li class="pull-right">
                                <?=
                                Html::a('<i class="glyphicon glyphicon-list-alt"></i>' . 'Detail', ['ardetail', 'vn' => $header['pt_visit_number']], ['role' => 'modal-remote', 'class' => 'btn btn-info  btn-xs'])
                                ?>
                                &nbsp;
                            </li>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 stats-col">
                                <div class="">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($ptar as $arlist):
                                                ?>
                                                <tr>
                                                    <td class="text-left"><?= $no; ?>. <?= $arlist['ar_name']; ?></td>
                                                </tr>
                                                <?php
                                                $no++;
                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
            <!-- /สิทธิการรักษา -->

            <!-- Drug Allergic -->
            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 stats-col">
                <div class="invoice-container">
                    <ul>
                        <div class="row">
                            <li class="pull-left success">&nbsp;<b><?= Html::encode('Vital Sign'); ?></b></li>
                            <li class="pull-right">
                                <?=
                                Html::a('<i class="glyphicon glyphicon-list-alt"></i>' . 'Detail', 'javascript:void(0);', ['onclick' => 'return false;', 'class' => 'btn btn-info btn-xs'])
                                ?>
                                <?=
                                Html::a('<i class="fa fa-plus"></i>' . 'Add', 'javascript:void(0);', ['onclick' => 'return false;', 'class' => 'btn btn-success btn-xs'])
                                ?>
                                &nbsp;
                            </li>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 stats-col">
                                <div class="">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr width="33.3%" style="height: 40px;">
                                                <td class="text-center">BP:</td>
                                                <td>
                                                    <b class="pink" style="font-size: 14pt;">0</b>
                                                </td>
                                                <td class="text-center">Pulse:</td>
                                                <td>
                                                    <b class="pink" style="font-size: 14pt;">0</b>
                                                </td>
                                                <td class="text-center">BT(C):</td>
                                                <td>
                                                    <b class="pink" style="font-size: 14pt;">0.00</b>
                                                </td>
                                            </tr>
                                            <tr width="33.3%" style="height: 40px">
                                                <td class="text-center">Wt(kg.):</td>
                                                <td>
                                                    <b class="pink" style="font-size: 14pt;">0</b>
                                                </td>
                                                <td class="text-center">Ht(cm.):</td>
                                                <td>
                                                    <b class="pink" style="font-size: 14pt;">0</b>
                                                </td>
                                                <td class="text-center">SpO2(%):</td>
                                                <td>
                                                    <b class="pink" style="font-size: 14pt;">0</b>
                                                </td>
                                            </tr>
                                            <tr width="33.3%" style="height: 40px">
                                                <td class="text-center">BSA</td>
                                                <td>
                                                    <b class="pink" style="font-size: 14pt;">0</b>
                                                </td>
                                                <td class="text-center">BMI</td>
                                                <td>
                                                    <b class="pink" style="font-size: 14pt;">0</b>
                                                </td>
                                                <td class="text-center">RR</td>
                                                <td>
                                                    <b class="pink" style="font-size: 14pt;">0</b>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
            <!-- /Drug Allergic -->

        </div>
    </div>
</div>

