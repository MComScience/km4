<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
        <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
        <link id="skin-link" href="" rel="stylesheet" type="text/css" />
        <?= Html::csrfMetaTags() ?>
        <title><?php echo Html::encode(!empty($this->title) ? strtoupper($this->title) . ' | ' : null); ?>KM4</title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?php if (Yii::$app->user->can('menuleft')) { ?>
            <!-- Loading Container -->
            <div class="loading-container">
                <div class="loader"></div>
            </div> 
            <!--            /Loading Container -->
            <!-- Navbar -->
            <div class="navbar navbar-fixed-top">
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
                                        <a class="dropdown-toggle" data-toggle="dropdown" title="Mails" href="#">
                                            <i class="icon fa fa-envelope"></i>
                                            <span class="badge">3</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                            <div class="avatar" title="View your public profile">
                                                <img src="<?php echo Yii::$app->request->baseUrl; ?>/assets/img/avatars/adam-jansen.jpg">
                                            </div>
                                            <section>
                                                <h2><span class="profile"><span><?php echo Yii::$app->user->identity->profile->VenderName ?></span></span></h2>
                                            </section>
                                        </a>
                                        <!--Login Area Dropdown-->
                                        <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                            <li class="username"><a></a></li>
                                            <li class="email"><a><?php // echo Yii::$app->user->identity->email                                 ?></a></li>
                                            <!--Avatar Area-->
                                            <li>
                                                <div class="avatar-area">
                                                    <img src="<?php echo Yii::$app->request->baseUrl; ?>/assets/img/avatars/adam-jansen.jpg" class="avatar">
                                                    <span class="caption">Change Photo</span>
                                                </div>
                                            </li>
                                            <!--Avatar Area-->
                                            <li class="edit">
                                                <a href="profile.html" class="pull-left">Profile</a>
                                                <a href="#" class="pull-right">Setting</a>
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
                                </ul>
                                <div class="setting">
                                    <a id="Logout" title="Logout" href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=user/security/logout" data-method="post">
                                        <i class="icon glyphicon glyphicon-off"></i>
                                    </a>
                                </div>
                                <!--                                <div class="setting">
                                                                    <a id="btn-setting" title="Setting" href="#">
                                                                        <i class="icon glyphicon glyphicon-cog"></i>
                                                                    </a>
                                                                </div>-->
                                <!--                                <div class="setting-container">
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
                                                                </div>-->
                                <!-- Settings -->
                            </div>
                        </div>
                        <!-- /Account Area and Settings -->
                    </div>
                </div>
            </div>
            <!-- /Navbar -->
            <!-- Main Container -->
            <div class="main-container container-fluid" >
                <!-- Page Container -->
                <div class="page-container">
                    <div class="page-sidebar sidebar-fixed menu-compact " id="sidebar" >
                        <?php if (Yii::$app->user->can('MenuPurchasing')) { ?>
                            <!-- Sidebar Menu -->
                            <ul class="nav sidebar-menu">

                                <li id="Purchasing">
                                    <a href="<?php Yii::$app->urlManager->createUrl("Purchasing/home") ?>" class="menu-dropdown">
                                        <i class="menu-icon glyphicon glyphicon-shopping-cart"></i>
                                        <span class="menu-text">
                                            <b>Purchasing</b>
                                        </span>
                                        <i class="menu-expand"></i>
                                    </a>
                                    <ul class="submenu">
                                        <!---------------------------------เมนู แผนการจัดซื้อ------------------------------>
                                        <li id="Purchasing1">
                                            <a href="#" class="menu-dropdown">
                                                <span class="menu-text">
                                                    แผนการจัดซื้อ
                                                </span>
                                                <i class="menu-expand"></i>
                                            </a>
                                            <ul class="submenu">

                                                <li>
                                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbpcplan">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        <span class="menu-text">
                                                            แผนจัดซื้อยาสามัญ
                                                        </span>
                                                    </a>
                                                </li>

                                                <li id="pcplanbydrug">
                                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbplandrug" >
                                                        <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                        <span class="menu-text">
                                                            แผนจัดซื้อยาการค้า
                                                        </span>
                                                    </a>
                                                </li>

                                                <li id="addnondrugms">
                                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbplan" >
                                                        <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                        <span class="menu-text">แผนจัดซื้อเวชภัณฑ์ฯ</span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>
                                        <li id="tbplandrugsale">
                                            <a href="#" class="menu-dropdown">
                                                <span class="menu-text">
                                                    สัญญาจะชื้อจะขาย
                                                </span>
                                                <i class="menu-expand"></i>
                                            </a>
                                            <ul class="submenu">                                             
                                                <li id="drugsale">
                                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbplandrugsale">
                                                        <span class="menu-text">ยา</span>
                                                    </a>
                                                </li>

                                                <li id="sale">
                                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/tbplansale" >
                                                        <span class="menu-text">เวชภัณฑ์</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <!---------------------------------End Menu------------------------------>

                                        <li id="">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/addpr-gpu/index">
                                                <span class="menu-text"> ขอซื้อ(New) </span>
                                            </a>
                                        </li>
                                        <li id="">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/po/index">

                                                <span class="menu-text"> สั่งซื้อ(New) </span>
                                            </a>
                                        </li>
                                        <!---------------------------------End Menu------------------------------>
                                        <li id="Price_List">
                                            <a href="#" class="menu-dropdown">
                                                <span class="menu-text">
                                                    Price List
                                                </span>
                                                <i class="menu-expand"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li>
                                                    <a href="#">
            <!--                                            <i class="menu-icon fa fa-camera"></i>-->
                                                        <span class="menu-text">กำหนดราคากลาง</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
            <!--                                            <i class="menu-icon fa fa-camera"></i>-->
                                                        <span class="menu-text">จัดการข้อมูลผู้ขาย</span>
                                                    </a>
                                                </li>
                                                <li id="Price_List1">
                                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/Purchasing/createqr/index">
            <!--                                            <i class="menu-icon fa fa-camera"></i>-->
                                                        <span class="menu-text">สอบถามราคาผู้ขาย</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="menu-dropdown">
                                                        <i class="menu-icon fa fa-asterisk"></i>

                                                        <span class="menu-text">
                                                            Level 4
                                                        </span>
                                                        <i class="menu-expand"></i>
                                                    </a>

                                                    <ul class="submenu">
                                                        <li>
                                                            <a href="#">
                                                                <i class="menu-icon fa fa-bolt"></i>
                                                                <span class="menu-text">Some Item</span>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#">
                                                                <i class="menu-icon fa fa-bug"></i>
                                                                <span class="menu-text">Another Item</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>

                            <?php if (Yii::$app->user->can('MenuInventory')) { ?>
                                <!---------------------------------Inventory------------------------------>
                                <li id="Inventory">
                                    <a href="<?php Yii::$app->urlManager->createUrl("inventory/home") ?>" class="menu-dropdown">
                                        <i class="menu-icon fa fa-ambulance"></i>
                                        <span class="menu-text">
                                            <b>Inventory</b>
                                        </span>
                                        <i class="menu-expand"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li id="permiss1">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/stocks-balance/index">
        <!--                                                <i  class="menu-icon fa fa-users"></i>-->
                                                <span class="menu-text"> สถานะสินค้าคงคลัง </span>
                                            </a>
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
                                                    <a href="index.php?r=Inventory/stock-request/index" >
                                                        <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                        <span class="menu-text">ขอเบิกสินค้า</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="index.php?r=Inventory/tb-st2-temp/spicking">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        <span class="menu-text">โอนสินค้า</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="index.php?r=Inventory/tbst2/stock-receive">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        <span class="menu-text">รับสินค้า</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="permiss1">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/gr/index">
        <!--                                                <i  class="menu-icon fa fa-users"></i>-->
                                                <span class="menu-text"> รับสินค้าจากการสั่งซื้อ </span>
                                            </a>
                                        </li>
                                        <li id="">
                                            <a href="#" class="menu-dropdown">
                                                <!--<i class="menu-icon fa fa-asterisk"></i>-->
                                                <span class="menu-text">
                                                    การเคลมสินค้า
                                                </span>
                                                <i class="menu-expand"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li id="">
                                                    <a href="" >
                                                        <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                        บันทึกการส่งเคลมสินค้า
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        <span class="menu-text">บันทึกการรับเคลมสินค้า</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#" class="menu-dropdown">
                                                <!--<i class="menu-icon fa fa-asterisk"></i>-->

                                                <span class="menu-text">
                                                    หน่วยงานยืมสินค้า
                                                </span>
                                                <i class="menu-expand"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li>
                                                    <a href="#" >
                                                        <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                        บันทึกรับสินค้ายืม

                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        บันทึกส่งคืนสินค้ายืม
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        บันทึกข้อมุลผู้ให้ยืมสินค้า
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#" class="menu-dropdown">
                                                <!--<i class="menu-icon fa fa-asterisk"></i>-->

                                                <span class="menu-text">
                                                    หน่วยงานภายนอกยืมสินค้า
                                                </span>
                                                <i class="menu-expand"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li>
                                                    <a href="index.php?r=Inventory/vwsr2listdraf" >
                                                        <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                        บันทึกขอยืมสินค้า

                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        บันทึกคืนสินค้า
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        บันทึกข้อมูลผู้ยืมสินค้า
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#" class="menu-dropdown">
                                                <!--<i class="menu-icon fa fa-asterisk"></i>-->

                                                <span class="menu-text">
                                                    การบริจาคสินค้า
                                                </span>
                                                <i class="menu-expand"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li>
                                                    <a href="index.php?r=Inventory/vwsr2listdraf" >
                                                        <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                        บันทึกรับจากการบริจาค

                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        บันทึกข้อมูลผู้บริจาค
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#" class="menu-dropdown">
                                                <!--<i class="menu-icon fa fa-asterisk"></i>-->
                                                <span class="menu-text">
                                                    ปรับปรุงยอดสินค้าคงคลัง
                                                </span>
                                                <i class="menu-expand"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li>
                                                    <a href="index.php?r=Inventory/vwsr2listdraf" >
                                                        <!--<i class="menu-icon fa fa-bolt"></i>-->
                                                        บันทึกปรับปรุงยอดฯ
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="item">
                                            <a href="#" class="menu-dropdown">
                                                <span class="menu-text">
                                                    จัดการรายการสินค้า
                                                </span>
                                                <i class="menu-expand"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li id="additemgp">
                                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/additem/index">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        <span class="menu-text">ยา</span>
                                                    </a>
                                                </li>
                                                <li id="additemsnondrug">
                                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/additemnondrug/index">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        <span class="menu-text">เวชภัณฑ์มิใช่ยา</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="">
                                            <a href="#" class="menu-dropdown">
                                                <span class="menu-text">
                                                    ตั้งต้นยอดสินค้าคงคลัง
                                                </span>
                                                <i class="menu-expand"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li id="">
                                                    <a href="#">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        <span class="menu-text">บันทึกข้อมูลการตั้งต้นสินค้า</span>
                                                    </a>
                                                </li>
                                               
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if (Yii::$app->user->can('MenuPhamasup')) { ?>
                                <li id="หัวหน้าเภสัชกรรม">
                                    <a href="<?php Yii::$app->urlManager->createUrl("inventory/home") ?>" class="menu-dropdown">
                                        <i class="menu-icon fa fa-users"></i>
                                        <span class="menu-text">
                                           <b>หัวหน้าเภสัชกรรม</b>
                                        </span>
                                        <i class="menu-expand"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li id="">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/addpr-gpu/detail-verify">
        <!--                                                <i class="menu-icon fa fa-medkit"></i>-->
                                                <span class="menu-text"> ทวนสอบใบขอซื้อ(New) </span>
                                            </a>
                                        </li>
                                        <li id="">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/po/detail-verify">
        <!--                                                <i class="menu-icon fa fa-medkit"></i>-->
                                                <span class="menu-text"> ทวนสอบใบสั่งซื้อ(New) </span>
                                            </a>
                                        </li>
										     <li id="">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/stock-request/wait-approve-pharmacy">
        <!--                                                <i class="menu-icon fa fa-medkit"></i>-->
                                                <span class="menu-text"> อนุมัติการขอเบิก</span>
                                            </a>
                                        </li>
										     <li id="">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/po/detail-verify">
        <!--                                                <i class="menu-icon fa fa-medkit"></i>-->
                                                <span class="menu-text"> อนุมัติการปรับปรุงสินค้าคงคลัง</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if (Yii::$app->user->can('MenuDirector')) { ?>
                                <li id="ผู้อำนวยการ">
                                    <a href="<?php Yii::$app->urlManager->createUrl("inventory/home") ?>" class="menu-dropdown">
                                        <i class="menu-icon fa fa-user"></i>
                                        <span class="menu-text">
                                            <b>ผู้อำนวยการ</b>
                                        </span>
                                        <i class="menu-expand"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li id="">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/addpr-gpu/detail-approve">
        <!--                                                <i class="menu-icon fa fa-medkit"></i>-->
                                                <span class="menu-text"> อนุมัติใบขอซื้อ(new) </span>
                                            </a>
                                        </li>
                                        <li id="">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/po/detail-wating-approve">
        <!--                                                <i class="menu-icon fa fa-medkit"></i>-->
                                                <span class="menu-text"> อนุมัติใบสั่งซื้อซื้อ(new) </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <li id="">
                                <a href="<?php Yii::$app->urlManager->createUrl("inventory/home") ?>" class="menu-dropdown">
                                    <i class="menu-icon fa fa-medkit"></i>
                                    <span class="menu-text">
                                        <b>กำหนดราคาขายยา</b>
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                                <ul class="submenu">
                                    <li id="">
                                        <a href="<?php Yii::$app->urlManager->createUrl("stocksout/home") ?>">
    <!--                                                <i class="menu-icon fa fa-medkit"></i>-->
                                            <span class="menu-text"> บันทึกราคาขายยา </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php if (Yii::$app->user->can('MenuSetting')) { ?>
                                <li id="setting">
                                    <a href="<?php Yii::$app->urlManager->createUrl("inventory/home") ?>" class="menu-dropdown">
                                        <i class="menu-icon fa fa-cog"></i>
                                        <span class="menu-text">
                                            <b>ตั้งค่า</b>
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
                                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/Config/drugclass/index">
                                                        <!--<i class="menu-icon fa fa-bug"></i>-->
                                                        <span class="menu-text">ตั้งค่ารายการยา</span>
                                                    </a>
                                                </li>
                                                <li id="itemnd">
                                                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/Config/itemnd/index">
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
                            <?php if (Yii::$app->user->can('MenuPermission')) { ?>
                                <li id="permiss">
                                    <a href="#" class="menu-dropdown">
                                        <i class="menu-icon fa fa-user-times"></i>
                                        <span class="menu-text">
                                            <b>กำหนดสิทธิ์การใช้งาน</b>
                                        </span>
                                        <i class="menu-expand"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li id="permiss1">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=user/admin/index">
                                                <i  class="menu-icon fa fa-users"></i>
                                                <span class="menu-text"> จัดการข้อมูล User </span>
                                            </a>
                                        </li>
                                        <li id="permiss2">
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=admin">
                                                <i class="menu-icon fa fa-user"></i>
                                                <span class="menu-text"> จัดการสิทธิ์การเข้าใช้ </span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            <?php } ?>

                            <li id="director">
                                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=user/security/logout" data-method="post">
                                    <i class="menu-icon fa fa-power-off"></i>
                                    <span class="menu-text"><b>ออกจากระบบ</b></span>
                                </a>
                            </li>
                        </ul>
                        <!-- /Sidebar Menu -->
                    </div>
                    <div class="page-content">
                        <div class="page-header position-relative ">
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
    </body>
</html>
<?php $this->endPage() ?>
