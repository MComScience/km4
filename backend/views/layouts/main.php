 <div id="step1Content">
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/assets/img/favicon.png" type="image/x-icon">
        <?= Html::csrfMetaTags() ?>
        <title>KM4</title>
        <?php $this->head() ?>
    </head>
   
    <body  class="fixed-navbar fixed-sidebar">
        <?php $this->beginBody() ?>
        <?php if (Yii::$app->user->can('SuperAdmin')) { ?>

            <!-- Header -->
            <div id="header">
                <div class="color-line">
                </div>
                <div id="logo" class="light-version">
                    <span>
                        KM4 Project
                    </span>
                </div>
                <nav role="navigation">
                    <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
                    <div class="small-logo">
                        <span class="text-primary">HOMER APP</span>
                    </div>
                   
                
                    <div class="navbar-right">
                        <ul class="nav navbar-nav no-borders">
                            <li class="dropdown">
                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=site/logout" data-method="post">
                                    <i class="pe-7s-upload pe-rotate-90"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- end Header -->
            <!-- Main Container -->
            <div class="main-container container-fluid">
                <!-- Page Container -->
                <div class="page-container">
                    <!-- Navigation -->
                    <aside id="menu">
                        <div id="navigation">
                            <div class="profile-picture">
                                <a href="index.html">
                                    <img src="<?php echo Yii::$app->request->baseUrl; ?>/newcss/images/profile.png" class="img-circle m-b" alt="logo">
                                </a>

                                <div class="stats-label text-color">
                                    <span class="font-extra-bold font-uppercase">Andaman</span>

<!--                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                            <small class="text-muted">Founder of App <b class="caret"></b></small>
                                        </a>
                                        <ul class="dropdown-menu animated flipInX m-t-xs">
                                            <li><a href="contacts.html">Contacts</a></li>
                                            <li><a href="profile.html">Profile</a></li>
                                            <li><a href="analytics.html">Analytics</a></li>
                                            <li class="divider"></li>
                                            <li><a href="login.html">Logout</a></li>
                                        </ul>
                                    </div>-->



                                </div>
                            </div>

                            <ul class="nav" id="side-menu">
                                <li>
                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Opdandipd/km4getptopd"><span class="nav-label">ลงทะเบียนผู้ป่วยนอก</span> </a>
                                </li>
                                <li>
                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Opdandipd/km4getptadmit"><span class="nav-label">ลงทะเบียนผู้ป่วยใน</span> </a>
                                </li>
                                <!--                                <li>
                                                                    <a href="<?php // echo Yii::$app->request->baseUrl;  ?>/index.php?r=Opdandipd/km4getpatent"><span class="nav-label">PATENT</span> </a>
                                                                </li>
                                                                <li>
                                                                    <a href="<?php // echo Yii::$app->request->baseUrl;  ?>/index.php?r=Opdandipd/km4getrefer"><span class="nav-label">REFER</span> </a>
                                                                </li>-->
                                <li id="opd">
                                    <a href="#"><span class="nav-label">งานบริการผู้ป่วยนอก</span><span class="fa arrow"></span> </a>
                                    <ul id="opd_chemistryin" class="nav nav-second-level">
                                        <li id="opd_chemistry" ><a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Opdandipd/km4getptopd">OPD เคมีบำบัด</a></li>
                                        <li><a href="#">OPD รังสีรักษา</a></li>
                                        <li><a href="#">OPD ศัลยกรรม</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><span class="nav-label">งานบริการผู้ป่วยใน</span><span class="fa arrow"></span> </a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="#">หอผู้ป่วยพิเศษ 1</a></li>
                                        <li><a href="#">หอผู้ป่วยพิเศษ 2</a></li>
                                        <li><a href="#">หอผู้ป่วยสามัญชาย</a></li>
                                        <li><a href="#">หอผู้ป่วยสามัญหญิง</a></li>
                                        <li><a href="#">ICU</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><span class="nav-label">แพทย์</span><span class="fa arrow"></span> </a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="#">สร้างสูตรยาเคมีบำบัด</a></li>
                                        <li><a href="#">วางแผนการรักษา</a></li>
                                        <li><a href="#">สั่งยา</a></li>

                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><span class="nav-label">ห้องจ่ายยาผู้ป่วยนอก</span><span class="fa arrow"></span> </a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="#">ห้องจ่ายยาผู้ป่วยนอก</a></li> 
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><span class="nav-label">ห้องจ่ายยาผู้ป่วยใน</span><span class="fa arrow"></span> </a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="#">ห้องจ่ายยาผู้ป่วยใน</a></li> 
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><span class="nav-label">การเงิน</span><span class="fa arrow"></span> </a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="#">การเงินผู้ป่วยนอก</a></li> 
                                        <li><a href="#">การเงินผู้ป่วยใน</a></li> 
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><span class="nav-label">ห้องผสมยาเคมีบำบัด</span><span class="fa arrow"></span> </a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="#">ห้องผสมยาเคมี</a></li> 
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </aside>
                    <div id="wrapper">

                        <div class="content animate-panel">
                            <div class="row">
                                <div class="col-lg-12 text-center m-t-md">
                                    <?= Alert::widget() ?>
                                    <?= $content ?>
                                </div>
                            </div>
                        </div>
                        <!-- Footer-->
                        <footer class="footer">
                            <span class="pull-right">
                                Testing Stage
                            </span>
                            KM4 Project
                        </footer>
                    </div>
                <?php } ?>
                <?php if (Yii::$app->user->isGuest) { ?>
                    <div class="page-content">

                        <div class="page-body">
                            <?= Alert::widget() ?>
                            <?= $content ?>

                        </div>
                    </div>
                    
                <?php } ?>
                <?php $this->endBody() ?>
                </body>
                
                </html>
                <?php $this->endPage() ?>
</div>