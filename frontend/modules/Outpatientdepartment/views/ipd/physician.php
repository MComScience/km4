<?php

use kartik\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin([]) ?>
<div class="row">
    <div class="col-md-12">
        <div class="profile-container">
            <div class="profile-header row">
                <div class="col-lg-2 col-md-4 col-sm-12 text-center">
                    <img src="assets/img/avatars/admin.png" alt="" class="header-avatar" />
                </div>
                <div class="col-lg-5 col-md-8 col-sm-12 profile-info">
                    <div class="row">
                        <div class="header-fullname">นาย สมจิตร รักษ์ดี</div>
                        <div class="invoice-container">
                            <ul>
                                <li><b>12767</b></li>
                                <li>คลินิกเคมีบำบัด</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 profile-stats">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stats-col">
                            <div class="stats-value pink">126</div>
                            <div class="stats-title">Revise Requesting</div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stats-col">
                            <div class="stats-value pink">12</div>
                            <div class="stats-title">Outpatients</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 stats-col">
                            <div class="stats-value pink">12</div>
                            <div class="stats-title">Order Complete</div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 stats-col">
                            <div class="stats-value pink">12</div>
                            <div class="stats-title">Inpatients</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 inlinestats-col success">
                            Rx Order
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 inlinestats-col success">
                            11 เมษายน 2559
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
                            <li class="active">
                                <a data-toggle="tab" href="#overview">
                                    แผนการรักษายา
                                </a>
                            </li>
                            <li class="tab-red">
                                <a data-toggle="tab" href="#timeline">
                                    รายชื่อผู้ป่วยใน
                                </a>
                            </li>
                            <li class="tab-palegreen">
                                <a data-toggle="tab" id="contacttab" href="#contacts">
                                    รายชื่อผู้ป่วยนอก
                                </a>
                            </li>
                            <li class="tab-yellow">
                                <a data-toggle="tab" href="#settings">
                                    Simple Page
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tabs-flat">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-md-8">แผนการรักษายา</div>
                                </div>
                            </div>

                            <div id="timeline" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">รายชื่อผู้ป่วยใน</div>
                                </div>
                            </div>

                            <div id="contacts" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">รายชื่อผู้ป่วยนอก</div>
                                </div>
                            </div>

                            <div id="settings" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">Simple Page</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

