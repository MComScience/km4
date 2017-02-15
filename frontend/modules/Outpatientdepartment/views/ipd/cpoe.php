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
                <div class="col-lg-4 col-md-8 col-sm-12 profile-info">
                    <div class="row">
                        <div class="invoice-container">
                            <ul>
                                <li style="font-size: 20px">นาย สมจิตร รักษ์ดี</li>
                                <li><b>HN</b>&nbsp;&nbsp;&nbsp; 1280423 &nbsp;&nbsp;&nbsp;<b>อายุ</b>&nbsp;&nbsp;&nbsp; 45 &nbsp;&nbsp;&nbsp;<b>ปี</b></li>
                                <li><b>VN</b>&nbsp;&nbsp;&nbsp; 160505123 &nbsp;&nbsp;&nbsp;<b>AN</b>&nbsp;&nbsp;&nbsp; 546554</li>
                                <li><b>สิทธิ :</b>&nbsp;&nbsp;&nbsp; ชำระเงินเอง</li>
                                <li><b>OCPA :</b>&nbsp;&nbsp;&nbsp; --- <b>&nbsp;&nbsp;&nbsp;CPR :</b>&nbsp;&nbsp;&nbsp; ---</li>
                                <li>คลินิกเคมีบำบัด</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 profile-stats">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 stats-col">
                            <div class="invoice-container">
                                <ul>
                                    <div class="row">
                                        <li class="pull-left success">&nbsp;<b>Vital Sign</b></li>
                                        <li class="pull-right">
                                            <a class="btn btn-info  btn-xs" href="javascript:void(0);"><i class="glyphicon glyphicon-list-alt"></i> Detail</a>
                                            <a class="btn btn-success  btn-xs" href="javascript:void(0);"><i class="fa fa-plus"></i> Add</a>
                                            &nbsp;
                                        </li>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 stats-col">
                                            <div class="stats-value pink">80/120</div>
                                            <div class="stats-title">Blood Pressure</div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 stats-col">
                                            <div class="stats-value pink">95%</div>
                                            <div class="stats-title">SpO2</div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 stats-col">
                                            <div class="stats-value pink">54</div>
                                            <div class="stats-title">Weight(kg.)</div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 stats-col">
                                            <div class="stats-value pink">150</div>
                                            <div class="stats-title">Pulse</div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 stats-col">
                                            <div class="stats-value pink">15</div>
                                            <div class="stats-title">Respiratory Rate</div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 stats-col">
                                            <div class="stats-value pink">36.5</div>
                                            <div class="stats-title">Body Temp.(C)</div>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
                            <li>
                                <a style="text-align: left">
                                    <b class="success">Drug Allergic : </b>Drug1 Drug2 Drug3 Drug4
                                </a>
                            </li>
                            <li>
                                <a style="text-align: right">
                                    <button class="btn btn-info btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Detail</button>
                                    <button class="btn btn-success btn-xs"><i class="fa fa-check"></i> Add</button>
                                </a>
                                
                            </li>
                        </ul>
                        <ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
                            <li>
                                <a style="text-align: left">
                                    <b class="success">Last Diagnosis : </b>Dx1 Dx2 Dx3 Dx4
                                </a>
                            </li>
                            <li>
                                <a style="text-align: right">
                                    <b class="success">Last Dx Date : </b>10/04/2559 &nbsp;
                                    <button class="btn btn-info btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Detail</button>
                                    <button class="btn btn-success btn-xs"><i class="fa fa-check"></i> Dx</button>
                                </a>
                                
                            </li>
                        </ul>
                        <ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
                            <li class="active">
                                <a data-toggle="tab" href="#overview">
                                    Patient Summary Sheet
                                </a>
                            </li>
                            <li class="tab-red">
                                <a data-toggle="tab" href="#timeline">
                                    แผนการให้ยาเคมีบำบัด
                                </a>
                            </li>
                            <li class="tab-palegreen">
                                <a data-toggle="tab" id="contacttab" href="#contacts">
                                    ประวัติการสั่งยา
                                </a>
                            </li>
                            <li class="tab-yellow">
                                <a data-toggle="tab" href="#settings">
                                    สั่งยา
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tabs-flat">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-md-8">Patient Summary Sheet</div>
                                </div>
                            </div>

                            <div id="timeline" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">แผนการให้ยาเคมีบำบัด</div>
                                </div>
                            </div>

                            <div id="contacts" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">ประวัติการสั่งยา</div>
                                </div>
                            </div>

                            <div id="settings" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">สั่งยา</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>