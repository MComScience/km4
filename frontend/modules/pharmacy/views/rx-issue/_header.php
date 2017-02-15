<?php

use yii\helpers\Html;

//$avatar = ($userAvatar = $header->getAvatar($header->pt_visit_number)) ? $userAvatar : $header->getAvatar('');
?>
<style>
    .profile-container .profile-header {
        height: 50px;
        min-height: 100px;
    }
    .profile-info {
        height: 50px;
    }
</style>
<div class="profile-header row bg-white">
    <!-- Profile Detail -->
    <div class="col-lg-7 col-md-8 col-sm-12 text-center">
        <div class="row">
            <div class="invoice-container">
                <ul>
                    <li>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 25px" class="success"><?= $header->pt_name; ?></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?= Html::encode('อายุ'); ?></b>&nbsp;&nbsp;&nbsp; <?= !$header->pt_age_registry_date ? '-' : $header->pt_age_registry_date; ?> &nbsp;&nbsp;&nbsp;<b><?= Html::encode('ปี'); ?></b>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?= Html::encode('HN'); ?></b>&nbsp;&nbsp;&nbsp; <?= !$header->pt_hospital_number ? '-' : $header->pt_hospital_number; ?> &nbsp;&nbsp;&nbsp;
                        <b><?= Html::encode('VN'); ?></b>&nbsp;&nbsp;&nbsp; <?= !$header->pt_vn_number ? '-' : $header->pt_vn_number; ?> &nbsp;&nbsp;&nbsp;
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Profile Detail -->

    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <!-- /สิทธิการรักษา -->

            <!-- Drug Allergic -->
            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 stats-col" style="border-left: 1px solid #ddd">
                <div class="invoice-container">
                    <ul>
                        <div class="row">
                            <li class="pull-left success">&nbsp;<b><?= Html::encode('สิทธิการรักษา'); ?></b></li>
                            <li class="pull-right">
                                <?=
                                Html::a('<i class="glyphicon glyphicon-list-alt"></i>' . 'Detail', ['ardetail', 'vn' => $header['pt_vn_number']], ['role' => 'modal-remote', 'class' => 'btn btn-info  btn-xs'])
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
                                            //$no = 1;
                                            //foreach ($ptar as $arlist):
                                            ?>
                                            <tr>
                                                <td class="text-left"><?= 1; ?>. <?= $ptar['ar_name1']; ?></td>
                                            </tr>
                                            <?php
                                            //$no++;
                                            //endforeach;
                                            ?>
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

