<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
//use yii\helpers\Url;
//use dektrium\user\models\User;
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
   
    <?php $this->beginBody() ?>
<?php if (Yii::$app->user->can('menu1')) { ?>
        <!-- Loading Container -->
        <div class="loading-container">
            <div class="loader"></div>
        </div>
        <!--  /Loading Container -->
        <!-- Navbar -->
        <div class="navbar">
            <div class="navbar-inner">
                <div class="navbar-container">
                    <!-- Navbar Barnd -->
                    <div class="navbar-header pull-left">
                        <a href="#" class="navbar-brand">          
                            <img src="<?php echo Yii::$app->request->baseUrl; ?>/images/logo/KM4_Logo.png" alt="" width="100" />
                        </a>
                    </div>
                    <!-- /Navbar Barnd -->
                    <!-- Sidebar Collapse -->

                    <div class="sidebar-collapse" id="sidebar-collapse">
                        <i class="collapse-icon fa fa-bars"></i>
                    </div>
                    <!-- /Sidebar Collapse -->
                    <!-- Account Area and Settings --->

                    <div class="navbar-header pull-right">
                        <div class="navbar-account">
                            <ul class="account-area">
                                <li>
                                    <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                        <div class="avatar" title="View your public profile">
                                            <img src="<?php echo Yii::$app->request->baseUrl; ?>/uploads/<?= Yii::$app->user->identity->profile->image ?>">
                                        </div>
                                        <section>
                                            <h2><span class="profile"><span><?= Yii::$app->user->identity->profile->name ?></span></span></h2>
                                        </section>
                                    </a>
                                    <!--Login Area Dropdown-->
                                    <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                        <li class="username"><a><?= Yii::$app->user->identity->profile->name ?></a></li>
                                        <li class="email"><a><?= Yii::$app->user->identity->email ?></a></li>
                                        <!--Avatar Area-->
                                        <li>
                                            <div class="avatar-area">
                                                <img src="<?php echo Yii::$app->request->baseUrl; ?>/uploads/<?= Yii::$app->user->identity->profile->image ?>" class="avatar">
<!--                                                <span class="caption">Change Photo</span>-->
                                            </div>
                                        </li>
                                        <!--Avatar Area-->
                                        <li class="edit">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>index.php?r=/user/settings/profile" class="pull-left">Profile</a>
<!--                                            <a href="#" class="pull-right">Setting</a>-->
                                        </li>
                                        <!--Theme Selector Area-->
                                        <li class="theme-area">
                                            <ul class="colorpicker" id="skin-changer">
                                                <li><a class="colorpick-btn" href="#" style="background-color:#5DB2FF;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/blue.min.css"></a></li>
                                                <li><a class="colorpick-btn" href="#" style="background-color:#2dc3e8;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/azure.min.css"></a></li>
                                                <li><a class="colorpick-btn" href="#" style="background-color:#03B3B2;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/teal.min.css"></a></li>
                                                <li><a class="colorpick-btn" href="#" style="background-color:#53a93f;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/green.min.css"></a></li>
                                                <li><a class="colorpick-btn" href="#" style="background-color:#FF8F32;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/orange.min.css"></a></li>
                                                <li><a class="colorpick-btn" href="#" style="background-color:#cc324b;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/pink.min.css"></a></li>
                                                <li><a class="colorpick-btn" href="#" style="background-color:#AC193D;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/darkred.min.css"></a></li>
                                                <li><a class="colorpick-btn" href="#" style="background-color:#8C0095;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/purple.min.css"></a></li>
                                                <li><a class="colorpick-btn" href="#" style="background-color:#0072C6;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/darkblue.min.css"></a></li>
                                                <li><a class="colorpick-btn" href="#" style="background-color:#585858;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/gray.min.css"></a></li>
                                                <li><a class="colorpick-btn" href="#" style="background-color:#474544;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/black.min.css"></a></li>
                                                <li><a class="colorpick-btn" href="#" style="background-color:#001940;" rel="<?php echo Yii::$app->request->baseUrl; ?>/assets/css/skins/deepblue.min.css"></a></li>
                                            </ul>
                                        </li>
                                        <!--/Theme Selector Area-->
                                        <li class="dropdown-footer">
                                            <a href="login.html">
                                                Sign out
                                            </a>
                                        </li>
                                    </ul>
                                    <!--/Login Area Dropdown-->
                                </li>
                                <!-- /Account Area -->
                                <!--Note: notice that setting div must start right after account area list.
                                no space must be between these elements-->
                                <!-- Settings -->
                            </ul><div class="setting">
                                <a id="btn-setting" title="Setting" href="#">
                                    <i class="icon glyphicon glyphicon-cog"></i>
                                </a>
                            </div><div class="setting-container">
                                <label>
                                    <input type="checkbox" id="checkbox_fixednavbar">
                                    <span class="text">Fixed Navbar</span>
                                </label>
                                <label>
                                    <input type="checkbox" id="checkbox_fixedsidebar">
                                    <span class="text">Fixed SideBar</span>
                                </label>
                                <label>
                                    <input type="checkbox" id="checkbox_fixedbreadcrumbs">
                                    <span class="text">Fixed BreadCrumbs</span>
                                </label>
                                <label>
                                    <input type="checkbox" id="checkbox_fixedheader">
                                    <span class="text">Fixed Header</span>
                                </label>
                            </div>
                            <!-- Settings -->
                        </div>
                    </div>
                    <!-- /Account Area and Settings -->
                </div>
            </div>
        </div>
        <!-- /Navbar -->
        <!-- Main Container -->
        <div class="main-container container-fluid">
            <!-- Page Container -->
            <div class="page-container">

                <div class="page-sidebar" id="sidebar">

                    <!-- Sidebar Menu -->
                    <ul class="nav sidebar-menu">
    <?php if (Yii::$app->user->can('Purchasingmenu')) { ?>
                            <li id="Purchasing">
                                <a href="<?php Yii::$app->urlManager->createUrl("purchasing/home") ?>" class="menu-dropdown">
                                    <i class="menu-icon glyphicon glyphicon-shopping-cart"></i>
                                    <span class="menu-text">
                                        Purchasing
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                <ul class="submenu">
                                    <li id="Purchasing1">
                                        <a href="#" class="menu-dropdown">
                                            <span class="menu-text">
                                                แผนการจัดซื้อ
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <!-- <li>
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/site/test">
                                                    <i class="menu-icon fa fa-bug"></i>
                                                    <span class="menu-text">สถานะแผนการจัดซื้อ</span>
                                                </a>
                                            </li> -->
                                            <li id="pcplanbydrug">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpcplan">
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    <span class="menu-text">บันทึกแผนจัดซื้อยาสามัญ</span>
                                                </a>
                                            </li>

                                            <li id="tbplandrug">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbplandrug" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    <span class="menu-text">บันทึกแผนจัดซื้อยาการค้า</span>
                                                </a>
                                            </li>

                                            <li id="addnondrugms">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbplan" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    <span class="menu-text">บันทึกแผนจัดซื้อเวชภัณฑ์ฯ</span>
                                                </a>
                                            </li>

                                            <?php /*
                                              <li>
                                              <a href="#" >
                                              <!--<i class="menu-icon fa fa-bolt"></i>-->
                                              <span class="menu-text">บันทึกสัญญาจะซื้อจะขาย</span>
                                              </a>
                                              </li>
                                             */ ?>

                                            <!-- <li>
                                                <a href="#">
                                                    <i class="menu-icon fa fa-bug"></i>
                                                    <span class="menu-text">ปรับปรุงแผนการจัดซื้อ</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#">
                                                    <i class="menu-icon fa fa-bug"></i>
                                                    <span class="menu-text">เพิ่มรายการในแผนจัดซื้อ</span>
                                                </a>
                                            </li> -->
                                        </ul>
                                    </li>
                                    <li id="#">
                                        <a href="#" class="menu-dropdown">
                                            <!--<i class="menu-icon fa fa-asterisk"></i>-->

                                            <span class="menu-text">
                                                ขอซื้อยาสามัญ
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li id="#">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpr" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    บันทึกใบขอซื้อ

                                                </a>
                                            </li>
                                            <li id="#">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpr/index2">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">ทวนสอบใบขอซื้อ</span>
                                                </a>
                                            </li>
                                            <li id="#">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpr/index3">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">ใบขอซื้อไม่ผ่านการทวนสอบ</span>
                                                </a>
                                            </li>
                                            <li id="#">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpr/index4">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">อนุมัติใบขอซื้อ</span>
                                                </a>
                                            </li>
                                            <li id="#">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpr/index5">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">ใบขอซื้อไม่ผ่านการอนุมัติ</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li id="pr">
                                        <a href="#" class="menu-dropdown">
                                            <!--<i class="menu-icon fa fa-asterisk"></i>-->

                                            <span class="menu-text">
                                                ขอซื้อยาการค้า
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li id="addpr">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpr" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    บันทึกใบขอซื้อ

                                                </a>
                                            </li>
                                            <li id="index2">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpr/index2">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">ทวนสอบใบขอซื้อ</span>
                                                </a>
                                            </li>
                                            <li id="index3">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpr/index3">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">ใบขอซื้อไม่ผ่านการทวนสอบ</span>
                                                </a>
                                            </li>
                                            <li id="index4">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpr/index4">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">อนุมัติใบขอซื้อ</span>
                                                </a>
                                            </li>
                                            <li id="index5">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpr/index5">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">ใบขอซื้อไม่ผ่านการอนุมัติ</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#" class="menu-dropdown">
                                            <!--<i class="menu-icon fa fa-asterisk"></i>-->

                                            <span class="menu-text">
                                                ขอซื้อยารายการใหม่
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    บันทึกใบขอซื้อ

                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    ทวนสอบใบขอซื้อ

                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    ใบขอซื้อไม่ผ่านการทวนสอบ

                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    อนุมัติใบขอซื้อ
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    ใบขอซื้อไม่ผ่านการอนุมัติ

                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#" class="menu-dropdown">
                                            <!--<i class="menu-icon fa fa-asterisk"></i>-->

                                            <span class="menu-text">
                                                ขอซื้อเวชภัณฑ์ฯ
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    บันทึกใบขอซื้อ

                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    ทวนสอบใบขอซื้อ

                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    ใบขอซื้อไม่ผ่านการทวนสอบ

                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    อนุมัติใบขอซื้อ
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    ใบขอซื้อไม่ผ่านการอนุมัติ

                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#" class="menu-dropdown">
                                            <!--<i class="menu-icon fa fa-asterisk"></i>-->
                                            <span class="menu-text">
                                                Price List
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    กำหนดราคากลาง
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    จัดการข้อมูลผู้ขาย
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    ข้อมูล Price List
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    แจ้งผู้ขายเสนอราคาเพื่อตกลงราคา
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="#" class="menu-dropdown">
                                            <!--<i class="menu-icon fa fa-asterisk"></i>-->
                                            <span class="menu-text">
                                                ใบสั่งซื้อ
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    บันทึกใบสั่งซื้อแบบตกลงราคา
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    บันทึกใบสั่งซื้อสัญญาจะซื้อจะขาย
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    ทวนสอบใบสั่งซื้อ
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    ใบสั่งซื้อไม่ผ่านการทวนสอบ
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    อนุมัติใบสั่งซื้อ
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    ใบสั่งซื้อไม่ผ่านการอนุมติ
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    บันทึกใบสั่งซื้อจากการประกวดราคา
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

    <?php if (Yii::$app->user->can('inventorymenu')) { ?>
                            <li id="Inventory">
                                <a href="<?php Yii::$app->urlManager->createUrl("inventory/home") ?>" class="menu-dropdown">
                                    <i class="menu-icon fa fa-ambulance"></i>
                                    <span class="menu-text">
                                        Inventory
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                <ul class="submenu">
                                    <li>
                                        <a href="#" class="menu-dropdown">
                                            <!--<i class="menu-icon fa fa-asterisk"></i>-->
                                            <span class="menu-text">
                                                บันทึกข้อมูลยา
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    <span class="menu-text">บันทึกสารตั้งต้น</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">บันทึกสารที่ออกฤทธิ์ทางยา</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">บันทึกยาชื่อสามัญ (GP)</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">บันทึกยาชื่อการค้า (TP)</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">บันทึกยาชื่อสามัญ (GPU)</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">บันทึกยาชื่อการค้า (TPU)</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li id="item">
                                        <a href="#" class="menu-dropdown">
                                            <span class="menu-text">
                                                การจัดการรายการสินค้า
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <?php /*
                                              <li id="viewitemsnondrug">
                                              <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/additem/index">
                                              <!--<i class="menu-icon fa fa-bug"></i>-->
                                              <span class="menu-text">ข้อมูลรายการสินค้า</span>
                                              </a>
                                              </li>
                                              <li id="viewitemsdrug">
                                              <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/additemnondrug/index">
                                              <!--<i class="menu-icon fa fa-bug"></i>-->
                                              <span class="menu-text">ข้อมูลรายการสินค้าเวชภัณฑ์</span>
                                              </a>
                                              </li>
                                             */ ?>
                                            <li id="additemgp">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/additem/index">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">บันทึกสินค้ายา</span>
                                                </a>
                                            </li>
                                            <li id="additemsnondrug">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/additemnondrug/index">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">บันทึกสินค้าเวชภัณฑ์</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="#" class="menu-dropdown">
                                            <!--<i class="menu-icon fa fa-asterisk"></i>-->
                                            <span class="menu-text">
                                                การบันทึกรับสินค้า
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    บันทึกรับจากการสั่งซื้อ
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">บันทึกรับจากการยืม</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">บันทึกรับจากการบริจาค</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">บันทึกรับจากการเปลี่ยนสินค้า</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#" class="menu-dropdown">
                                            <!--<i class="menu-icon fa fa-asterisk"></i>-->

                                            <span class="menu-text">
                                                การบันทึกส่งคืนสินค้า
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    บันทึกส่งคืนสินค้าจากการซื้อ

                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    บันทึกส่งคืนจากการยืม
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#" class="menu-dropdown">
                                            <!--<i class="menu-icon fa fa-asterisk"></i>-->

                                            <span class="menu-text">
                                                เบิกจ่ายสินค้าระหว่างคลัง
                                            </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    บันทึกขอเบิกสินค้า

                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    บันทึกจ่ายสินค้า
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    บันทึกรับเข้าจากการโอน
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
    <?php if (Yii::$app->user->can('kamnodmenu')) { ?>
                            <li>
                                <a href="#" class="menu-dropdown">
                                    <i class="menu-icon fa fa-medkit"></i>
                                    <span class="menu-text">
                                        กำหนดราคาขายยา
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                <ul class="submenu">
                                    <li>
                                        <a href="#" >
                                            <!--<i class="menu-icon fa fa-bolt"></i>-->
                                            บันทึกราคาขายยา
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php } ?>
                        <?php /*
                          <li id="Dashboard">
                          <a href="<?php Yii::$app->urlManager->createUrl("inventory/home") ?>" class="menu-dropdown">
                          <i class="menu-icon fa fa-home"></i>
                          <span class="menu-text">
                          Dashboard
                          </span>
                          <i class="menu-expand"></i>
                          </a>
                          <ul class="submenu">
                          <li id="stocks_out">
                          <a href="<?php Yii::$app->urlManager->createUrl("stocksout/home") ?>">
                          <i class="menu-icon fa fa-medkit"></i>
                          <span class="menu-text"> คลังยาผู้ป่วยนอก </span>
                          </a>
                          </li>
                          <li id="stocks_in">
                          <a href="<?php Yii::$app->urlManager->createUrl("stocksin/home") ?>">
                          <i class="menu-icon fa fa-medkit"></i>
                          <span class="menu-text"> คลังยาผู้ป่วยใน </span>
                          </a>
                          </li>
                          <li id="pharmaceutical">
                          <a href="<?php Yii::$app->urlManager->createUrl("pharmaceutical/home") ?>">
                          <i class="menu-icon fa fa-user-md"></i>
                          <span class="menu-text"> หัวหน้ากลุ่มงานเภสัชฯ </span>
                          </a>
                          </li>
                          <li id="director">
                          <a href="<?php Yii::$app->urlManager->createUrl("director/home") ?>">
                          <i class="menu-icon fa fa-user"></i>
                          <span class="menu-text"> ผู้อำนวยการ </span>
                          </a>
                          </li>
                          </ul>
                          </li>
                         */ ?>
    <?php if (Yii::$app->user->can('settingmenu')) { ?>
                            <li id="setting">
                                <a href="<?php Yii::$app->urlManager->createUrl("inventory/home") ?>" class="menu-dropdown">
                                    <i class="menu-icon fa fa-cog"></i>
                                    <span class="menu-text">
                                        ตั้งค่า
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                <ul class="submenu">
                                    <li id="setting1">
                                        <a href="<?php Yii::$app->urlManager->createUrl("/ConfigInventory/config/") ?>">
        <!--                                        <i  class="menu-icon fa fa-gear"></i>-->
                                            <span class="menu-text"> ตั้งค่า Purchasing </span>
                                        </a>
                                    </li>
                                    <li id="settingitem">
                                        <a href="#" class="menu-dropdown">
        <!--                                         <i  class="menu-icon fa fa-gear"></i>-->
                                            <span class="menu-text"> ตั้งค่า Inventory </span>
                                            <i class="menu-expand"></i>
                                        </a>
                                        <ul class="submenu">
                                            <li>
                                                <a href="#" >
                                                    <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                    ตั้งค่าคลังสินค้า
                                                </a>
                                            </li>

                                            <li id="setting2">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=/Config/drugclass/index">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">ตั้งค่ารายการยา</span>
                                                </a>
                                            </li>
                                            <li id="itemnd">
                                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=/Config/itemnd/index">
                                                    <!--<i class="menu-icon fa fa-bug"></i>-->
                                                    <span class="menu-text">ตั้งค่ารายการเวชภัณฑ์</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>

                                    <li id="setting3">
                                        <a href="<?php Yii::$app->urlManager->createUrl("pharmaceutical/home") ?>">
        <!--                                        <i  class="menu-icon fa fa-gear"></i>-->
                                            <span class="menu-text"> ตั้งค่า Dashboard </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
    <?php if (Yii::$app->user->can('logoutmenu')) { ?>
                            <li id="director">
                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=site/logout" data-method="post">
                                    <i class="menu-icon fa fa-power-off"></i>
                                    <span class="menu-text">ออกจากระบบ</span>
                                </a>
                            </li>
    <?php } ?>
                    </ul>
                    <!-- /Sidebar Menu -->
                </div>
                <?php } ?>
            <div class="page-content">
<?php if (Yii::$app->user->can('menu1')) { ?>
                    <div class="page-header position-relative">
                        <div class="header-title">
                            <h1>
                                <?=
                                Breadcrumbs::widget([

                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ])
                                ?>

                            </h1>
                        </div>
                        <!--Header Buttons-->
                        <div class="header-buttons">
                            <a class="sidebar-toggler" href="#">
                                <i class="fa fa-arrows-h"></i>
                            </a>
                            <a class="refresh" id="refresh-toggler" href="">
                                <i class="glyphicon glyphicon-refresh"></i>
                            </a>
                            <a class="fullscreen" id="fullscreen-toggler" href="#">
                                <i class="glyphicon glyphicon-fullscreen"></i>
                            </a>
                        </div>
                        <!--Header Buttons End-->
                    </div>
                    <?php } ?>
                <div class="page-body">
                    <?= Alert::widget() ?>
<?= $content ?>

                </div>
            </div>
        </div>
    </div>

<?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>
