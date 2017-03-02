<?php

use yii\helpers\Html;
use yii\helpers\Url;
use dektrium\user\assets\AvatarAsset;
use common\themes\beyond\assets\DeleteButtonAsset;

DeleteButtonAsset::register($this);

AvatarAsset::register($this);
$avatar = ($userAvatar = Yii::$app->user->identity->getAvatar('large', Yii::$app->user->getId())) ? $userAvatar : AvatarAsset::getDefaultAvatar('admin');
?>
<?php $this->registerCssFile(Yii::getAlias('@web') . '/css/bootstrap-dropdownhover.min.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]); ?>
<!-- Navbar -->
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="navbar-container">
            <!-- Navbar Barnd -->
            <div class="navbar-header pull-left">
                <a href="/km4" class="navbar-brand">
                    <small>
                        <img src="<?= $directoryAsset ?>/img/rsz_logokm4-2.png?v=1.0" alt="" />
                    </small>
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
                            <a class="login-area dropdown-toggle" data-toggle="dropdown" title="Mails" href="#">
                                <section>
                                    <h2>
                                        <span class="profile">
                                            <span id="time">
                                                <i class="fa fa-calendar"></i> 
                                                <?php
                                                echo Yii::$app->thaiYearformat->asDate('full');
                                                ?>
                                                &nbsp;
                                                <i class="fa fa-clock-o"></i>
                                                &nbsp;
                                                <text id="hours"></text> :
                                                <text id="min"></text> :
                                                <text id="sec"></text>
                                            </span>
                                        </span>
                                    </h2>
                                </section>
                            </a>
                        </li>
                        <?php if (Yii::$app->user->can('MenuPhamasup')) : ?>
                        <?php 
                        $Count1 = Yii::$app->countstatus->CountPr(2);
                        $Count2 = Yii::$app->countstatus->CountPo(2);
                        $Count3 = Yii::$app->countstatus->CountSalist([2, 6]);
                        $Count4 = Yii::$app->countstatus->CountPlan(4);
                        ?>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" title="Tasks" href="#">
                                    <i class="icon fa fa-tasks"></i>
                                    <span class="badge">4</span>
                                </a>
                                <!--Tasks Dropdown-->
                                <ul class="pull-right dropdown-menu dropdown-tasks dropdown-arrow ">
                                    <li class="dropdown-header bordered-success">
                                        <i class="fa fa-tasks"></i>
                                        4 Tasks In Progress
                                    </li>

                                    <li>
                                        <a href="<?= Url::to(['/pr/default/list-verify']); ?>">
                                            <div class="clearfix">
                                                <span class="pull-left" style="font-size: 11pt;">ใบขอซื้อรอการทวนสอบ</span>
                                                <span class="pull-right" style="font-size: 11pt;"><?php echo $Count1; ?></span>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= Url::to(['/po/default/list-verify']); ?>">
                                            <div class="clearfix">
                                                <span class="pull-left" style="font-size: 11pt;">ใบสั่งซื้อรอการทวนสอบ</span>
                                                <span class="pull-right" style="font-size: 11pt;"><?php echo $Count2; ?></span>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= Url::to(['/Inventory/sa-list/wait-approve-prarmacy']); ?>">
                                            <div class="clearfix">
                                                <span class="pull-left" style="font-size: 11pt;">อนุมัติการปรับปรุงสินค้า</span>
                                                <span class="pull-right" style="font-size: 11pt;"><?php echo $Count3; ?></span>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= Url::to(['/Purchasing/tbpcplan/wailt-approve']); ?>">
                                            <div class="clearfix">
                                                <span class="pull-left" style="font-size: 11pt;">อนุมัติแผนจัดซื้อ</span>
                                                <span class="pull-right" style="font-size: 11pt;"><?php echo $Count4; ?></span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <!--/Tasks Dropdown-->
                            </li>
                        <?php endif; ?>
                        <li>
                            <a class="login-area dropdown-toggle dropdown" data-toggle="dropdown" data-hover="dropdown" data-delay="100">
                                <div class="avatar" title="View your public profile">
                                    <img src="<?= $avatar ?>">
                                </div>
                                <section>
                                    <h2><span class="profile"><span><?= $username; ?></span></span></h2>
                                </section>
                            </a>
                            <!--Login Area Dropdown-->
                            <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                <li class="username"><a><?= $username; ?></a></li>
                                <li class="email"><a><?= Yii::$app->user->identity->email; ?></a></li>
                                <!--Avatar Area-->
                                <li>
                                    <div class="avatar-area">
                                        <img src="<?= $avatar ?>" class="avatar">
                                        <a href="<?= Url::to(['/user/settings/profile']); ?>" class="caption">Change Photo</a>
                                    </div>
                                </li>
                                <!--Avatar Area-->
                                <li class="edit">
                                    <a href="<?= Url::to(['/user/settings/profile']); ?>" class="pull-left">Profile</a>
                                    <a href="#" class="pull-right">Setting</a>
                                </li>
                                <!--Theme Selector Area-->
                                <li class="theme-area">
                                    <ul class="colorpicker" id="skin-changer">
                                        <li><a class="colorpick-btn" href="#" style="background-color:#5DB2FF;" rel="<?= $directoryAsset ?>/css/skins/skin-blue.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#2dc3e8;" rel="<?= $directoryAsset ?>/css/skins/skin-azure.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#03B3B2;" rel="<?= $directoryAsset ?>/css/skins/skin-teal.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#53a93f;" rel="<?= $directoryAsset ?>/css/skins/skin-green.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#FF8F32;" rel="<?= $directoryAsset ?>/css/skins/skin-orange.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#cc324b;" rel="<?= $directoryAsset ?>/css/skins/skin-pink.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#AC193D;" rel="<?= $directoryAsset ?>/css/skins/skin-darkred.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#8C0095;" rel="<?= $directoryAsset ?>/css/skins/skin-purple.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#0072C6;" rel="<?= $directoryAsset ?>/css/skins/skin-darkblue.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#585858;" rel="<?= $directoryAsset ?>/css/skins/skin-gray.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#474544;" rel="<?= $directoryAsset ?>/css/skins/skin-black.min.css"></a></li>
                                        <li><a class="colorpick-btn" href="#" style="background-color:#001940;" rel="<?= $directoryAsset ?>/css/skins/skin-deepblue.min.css"></a></li>
                                    </ul>
                                </li>
                                <!--/Theme Selector Area-->
                                <li class="dropdown-footer">
                                    <?=
                                    Html::a(
                                            'Sign out', ['/user/security/logout'], ['data-method' => 'post']
                                    )
                                    ?>
                                </li>
                            </ul>
                            <!--/Login Area Dropdown-->
                        </li>
                        <?php /*
                          <li>
                          <a class=" dropdown-toggle" data-toggle="dropdown" title="Help" href="#">
                          <i class="icon fa fa-warning"></i>
                          </a>
                          <!--Notification Dropdown-->
                          <ul class="pull-right dropdown-menu dropdown-arrow dropdown-notifications">
                          <li>
                          <a href="<?= Url::to(['/notify/create']); ?>">
                          <div class="clearfix">
                          <div class="notification-icon">
                          <i class="fa fa-exclamation bg-warning white"></i>
                          </div>
                          <div class="notification-body">
                          <span class="title">แจ้งปัญหาการใช้งานระบบ</span>
                          <span class="description"><?= date('Y-m-d'); ?></span>
                          </div>
                          <div class="notification-extra">
                          <i class="fa fa-clock-o themeprimary"></i>
                          <span class="description"></span>
                          </div>
                          </div>
                          </a>
                          </li>
                          <?php // if (Yii::$app->user->identity->username == 'webmaster' || Yii::$app->user->identity->username == 'admin') : ?>
                          <li>
                          <a href="<?= Url::to(['/notify/index']); ?>">
                          <div class="clearfix">
                          <div class="notification-icon">
                          <i class="fa fa-file-text-o bg-warning white"></i>
                          </div>
                          <div class="notification-body">
                          <span class="title">รายการแจ้งปัญหา</span>
                          <span class="description"></span>
                          </div>
                          <div class="notification-extra">
                          <?php echo app\models\TbProblem::find()->count('id'); ?>
                          </div>
                          </div>
                          </a>
                          </li>
                          <?php // endif; ?>
                          </ul>
                          <!--/Notification Dropdown-->
                          </li> */ ?>
                        <!-- /Account Area -->
                        <!--Note: notice that setting div must start right after account area list.
                        no space must be between these elements-->
                        <!-- Settings -->
                    </ul>
                    <!--                    <div class="setting">
                                            <a id="btn-setting" title="Setting" href="#">
                                                <i class="icon glyphicon glyphicon-cog"></i>
                                            </a>
                                        </div>
                                        <div class="setting-container">
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
                                        </div>-->
                    <div class="setting">
                        <?=
                        Html::a('<i class="icon glyphicon glyphicon-log-out"></i>', ['/user/security/logout'], [
                            'class' => 'profile-link',
                            'data-confirm' => Yii::t('yii', 'Logout Now?'),
                            'data-method' => 'post',
                        ])
                        ?>
                    </div>
                    <!-- Settings -->
                </div>
            </div>
            <!-- /Account Area and Settings -->
        </div>
    </div>
</div>
<!-- /Navbar -->
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/bootstrap-dropdownhover.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>