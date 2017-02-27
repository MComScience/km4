<?php

use common\themes\beyond\widgets\BeyondMenu;
use yii\helpers\Url;

$template = '<a href="{url}" class="menu-dropdown">{icon} {label} <i class="menu-expand"></i></a>';
$ctrl = Yii::$app->controller;
$url = '/' . $ctrl->module->id . '/' . $ctrl->id . '/' . $ctrl->action->id;
?>
<div class="page-sidebar menu-compact sidebar-fixed" id="sidebar">
    <!-- Page Sidebar Header-->
    <!--    <div class="sidebar-header-wrapper">
            <input type="text" class="searchinput" />
            <i class="searchicon"></i>
            <div class="searchhelper">Search</div>
        </div>-->
    <!-- /Page Sidebar Header -->
    <?=
    BeyondMenu::widget(
            [
                'options' => ['class' => 'nav sidebar-menu'],
                'items' => [
                    #Dashboard
                    [
                        'label' => 'Dashboard', 'icon' => 'fa fa-home', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('MenuDashboard'), #สิทธิ์ Dashboard
                        'items' => [
                            #Physician
                            [
                                'label' => 'Physician', 'icon' => 'fa fa-circle-thin',
                                'url' => Url::to(['/Purchasing/dashboard/physician']), 'active' => $url == '/Purchasing/dashboard/physician',
                                'visible' => Yii::$app->user->can('menuleft')
                            ],
                            #CPOE สั่งยา
                            [
                                'label' => 'CPOE สั่งยา', 'icon' => 'fa fa-circle-thin',
                                'url' => Url::to(['/Purchasing/dashboard/cpoe']), 'active' => $url == '/Purchasing/dashboard/cpoe',
                                'visible' => Yii::$app->user->can('menuleft')
                            ],
                            #IPD OPD
                            [
                                'label' => 'IPD OPD', 'icon' => 'fa fa-circle-thin',
                                'url' => Url::to(['/Purchasing/dashboard/ipd']), 'active' => $url == '/Purchasing/dashboard/ipd',
                                'visible' => Yii::$app->user->can('menuleft')
                            ],
                        ],
                    ],
                    #Inventory
                    [
                        'label' => 'Inventory', 'icon' => 'fa fa-cubes', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('MenuInventory'), #สิทธิ์ Inventory
                        'items' => [
                            #dash board inventory
                            // [
                            //     'label' => 'dash board inventory ', 'icon' => '',
                            //     'url' => Url::to(['/Inventory/dashboard/ivstatus']), 'active' => $url == '/Inventory/dashboard/ivstatus',
                            //     'visible' => Yii::$app->user->can('MenuStocksBalance')
                            // ],
                            [
                                'label' => 'dash board inventory ', 'icon' => '',
                                'url' => Url::to(['/Inventory/dashboard-sub/list-drugnew']), 'active' => $url == '/Inventory/dashboard-sub/list-drugnew',
                                'visible' => Yii::$app->user->can('MenuStocksBalance')
                            ],
                            #สถานะสินค้าคงคลัง
                            // [
                            //     'label' => 'สถานะสินค้าคงคลัง', 'icon' => '',
                            //     'url' => Url::to(['/Inventory/treasury-drug-sub/list-drugnew']), 'active' => $url == '/Inventory/treasury-drug-sub/list-drugnew',
                            //     'visible' => Yii::$app->user->can('MenuStocksBalance')
                            // ],
                            [
                                'label' => 'สถานะสินค้าคงคลัง', 'icon' => '',
                                'url' => Url::to(['/Inventory/dashboard-sub/list-drugnew']), 'active' => $url == '/Inventory/dashboard-sub/list-drugnew',
                                'visible' => Yii::$app->user->can('MenuStocksBalance')
                            ],
                            #เบิกจ่ายระหว่างคลัง
                            [
                                'label' => 'เบิกจ่ายระหว่างคลัง', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuStocksBalance'), #สิทธิ์ เบิกจ่ายระหว่างคลัง
                                'items' => [
                                    #ขอเบิกสินค้า
                                    [
                                        'label' => 'ขอเบิกสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/stock-request/index']), 'active' => $url == '/Inventory/stock-request/index',
                                        'visible' => Yii::$app->user->can('Menuwithdraw')
                                    ],
                                    #โอนสินค้า
                                    [
                                        'label' => 'โอนสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/tb-st2-temp/spicking']), 'active' => $url == '/Inventory/tb-st2-temp/spicking',
                                        'visible' => Yii::$app->user->can('Menutransfer')
                                    ],
                                    #รับสินค้า
                                    [
                                        'label' => 'รับสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/tbst2/stock-receive']), 'active' => $url == '/Inventory/tbst2/stock-receive',
                                        'visible' => Yii::$app->user->can('Menureceive')
                                    ],
                                    #จ่ายสินค้ารายวัน
                                    [
                                        'label' => 'จ่ายสินค้ารายวัน', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/daily-issue/index']), 'active' => $url == '/Inventory/daily-issue/index',
                                        'visible' => Yii::$app->user->can('MenuDailyissue')
                                    ],
                                ],
                            ],
                            #รับสินค้า
                            [
                                'label' => 'รับสินค้า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuInventory'), #สิทธิ์ รับสินค้า
                                'items' => [
                                    #รับสินค้าสั่งซื้อ
                                    [
                                        'label' => 'รับสินค้าสั่งซื้อ', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/gr-po/index']), 'active' => $url == '/Inventory/gr-po/index',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                    #อื่นๆ
                                    [
                                        'label' => 'อื่นๆ', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/gr-donation/index']), 'active' => $url == '/Inventory/gr-donation/index',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                ],
                            ],
                            #การเคลมสินค้า
                            [
                                'label' => 'การเคลมสินค้า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuInventory'), #สิทธิ์ การเคลมสินค้า
                                'items' => [
                                    #ส่งเคลมสินค้า
                                    [
                                        'label' => 'ส่งเคลมสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/claim-product/index']), 'active' => $url == '/Inventory/claim-product/index',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                    #รับสินค้าเคลม
                                    [
                                        'label' => 'รับสินค้าเคลม', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/claim-product-gr/index']), 'active' => $url == '/Inventory/claim-product-gr/index',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                ],
                            ],
                            #ขอยืมสินค้า
                            [
                                'label' => 'ขอยืมสินค้า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuInventory'), #สิทธิ์ ขอยืมสินค้า
                                'items' => [
                                    #รับสินค้ายืม
                                    [
                                        'label' => 'รับสินค้ายืม', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/lond-product/index']), 'active' => $url == '/Inventory/lond-product/index',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                    #ส่งคืนสินค้าขอยืม
                                    [
                                        'label' => 'ส่งคืนสินค้าขอยืม', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/lond-product-st/index']), 'active' => $url == '/Inventory/lond-product-st/index',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                    #ข้อมูลผู้ให้ยืมสินค้า
                                    [
                                        'label' => 'ข้อมูลผู้ให้ยืมสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/user/registration/register']), 'active' => $url == '/user/registration/register',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                ],
                            ],
                            #ให้ยืมสินค้า
                            [
                                'label' => 'ให้ยืมสินค้า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuInventory') && Yii::$app->user->can('MenuLending'), #สิทธิ์ ให้ยืมสินค้า
                                'items' => [
                                    #ให้ยืมสินค้า
                                    [
                                        'label' => 'ให้ยืมสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/lend-product/index']), 'active' => $url == '/Inventory/lend-product/index',
                                        'visible' => Yii::$app->user->can('MenuLending')
                                    ],
                                    #รับคืนสินค้า
                                    [
                                        'label' => 'รับคืนสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/lend-product-gr/index']), 'active' => $url == '/Inventory/lend-product-gr/index',
                                        'visible' => Yii::$app->user->can('MenuReturns')
                                    ],
                                    #ข้อมูลผู้ขอยืมสินค้า
                                    [
                                        'label' => 'ข้อมูลผู้ขอยืมสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/user/registration/register']), 'active' => $url == '/user/registration/register',
                                        'visible' => Yii::$app->user->can('MenuInformationborrowitems')
                                    ],
                                ],
                            ],
                            #ตั้งต้นยอดสินค้าคงคลัง
                            [
                                'label' => 'ตั้งต้นยอดสินค้าคงคลัง', 'icon' => '',
                                'url' => Url::to(['/Inventory/stock-initail/index']), 'active' => $url == '/Inventory/stock-initail/index',
                                'visible' => Yii::$app->user->can('MenuInitial')
                            ],
                            #ปรับปรุงยอดสินค้าคงคลัง
                            [
                                'label' => 'ปรับปรุงยอดสินค้าคงคลัง', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuStockAdjact'), #สิทธิ์ ปรับปรุงยอดสินค้าคงคลัง
                                'items' => [
                                    #สั่งพิมพ์ใบนับสินค้า
                                    [
                                        'label' => 'สั่งพิมพ์ใบนับสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/sa-list/leaves-stock-forum']), 'active' => $url == '/Inventory/sa-list/leaves-stock-forum',
                                        'visible' => Yii::$app->user->can('MenuPrintCountProduct')
                                    ],
                                    #บันทึกปรับปรุงยอดฯ
                                    [
                                        'label' => 'บันทึกปรับปรุงยอดฯ', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/sa-list/index']), 'active' => $url == '/Inventory/sa-list/index',
                                        'visible' => Yii::$app->user->can('MenuStockAdjact')
                                    ],
                                ],
                            ],
                            #จัดการข้อมูลยา
                            [
                                'label' => 'จัดการข้อมูลยา', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('จัดการข้อมุลยา'), #สิทธิ์ จัดการข้อมูลยา
                                'items' => [
                                    #ข้อมูลยาสามัญ
                                    [
                                        'label' => 'ข้อมูลยาสามัญ', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/additem/managegpu']), 'active' => $url == '/Inventory/additem/managegpu',
                                        'visible' => Yii::$app->user->can('จัดการข้อมุลยา')
                                    ],
                                    #ความไม่เข้ากันทางยา
                                    [
                                        'label' => 'ความไม่เข้ากันทางยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/druginterac/index']), 'active' => $url == '/Inventory/druginterac/index',
                                        'visible' => Yii::$app->user->can('จัดการข้อมุลยา')
                                    ],
                                ],
                            ],
                            #จัดการรายการสินค้า
                            [
                                'label' => 'จัดการรายการสินค้า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuInventory') && Yii::$app->user->can('จัดการรายการสินค้า'), #สิทธิ์ จัดการรายการสินค้า
                                'items' => [
                                    #ยาการค้า
                                    [
                                        'label' => 'ยาการค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/additem/index']), 'active' => $url == '/Inventory/additem/index',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                    #เวชภัณฑ์มิใช่ยา
                                    [
                                        'label' => 'เวชภัณฑ์มิใช่ยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/addnondrug/index']), 'active' => $url == '/Inventory/addnondrug/index',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                ],
                            ],
                            #จัดการราคาสินค้า
                            [
                                'label' => 'จัดการราคาสินค้า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuInventory'), #สิทธิ์ จัดการราคาสินค้า
                                'items' => [
                                    #ยาการค้า
                                    [
                                        'label' => 'ยาการค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/additem/pricelist']), 'active' => $url == '/Inventory/additem/pricelist',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                    #เวชภัณฑ์มิใช่ยา
                                    [
                                        'label' => 'เวชภัณฑ์', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/addnondrug/pricelistnondrug']), 'active' => $url == '/Inventory/addnondrug/pricelistnondrug',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                    #ราคากลางยาสามัญ
                                    [
                                        'label' => 'ราคากลางยาสามัญ', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/additem/stdgpu']), 'active' => $url == '/Inventory/additem/stdgpu',
                                        'visible' => Yii::$app->user->can('MenuInventory')
                                    ],
                                ],
                            ],
                            #ตั้งค่า
                            [
                                'label' => 'ตั้งค่า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('menuleft'), #สิทธิ์ ตั้งค่า
                                'items' => [
                                    #หมวดยาหลัก
                                    [
                                        'label' => 'หมวดยาหลัก', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/drugclass/index']), 'active' => $url == '/Inventory/drugclass/index',
                                        'visible' => Yii::$app->user->can('menuleft')
                                    ],
                                    #หมวดยาย่อย
                                    [
                                        'label' => 'หมวดยาย่อย', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/drugsubclass/index']), 'active' => $url == '/Inventory/drugsubclass/index',
                                        'visible' => Yii::$app->user->can('menuleft')
                                    ],
                                    #หมวดเวซภัณฑ์หลัก
                                    [
                                        'label' => 'หมวดเวซภัณฑ์หลัก', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/item-ndmed-supply-catid-sub/index']), 'active' => $url == '/Inventory/item-ndmed-supply-catid-sub/index',
                                        'visible' => Yii::$app->user->can('menuleft')
                                    ],
                                    #หมวดเวซภัณฑ์ย่อย
                                    [
                                        'label' => 'หมวดเวซภัณฑ์ย่อย', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/itemndmedsupply/index']), 'active' => $url == '/Inventory/itemndmedsupply/index',
                                        'visible' => Yii::$app->user->can('menuleft')
                                    ],
                                ],
                            ],
                        ],
                    ],
                    #ระบบคลังสินค้า
                    [
                        'label' => 'ระบบคลังสินค้า', 'icon' => 'fa fa-cube', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('menuleft'), #สิทธิ์ ระบบคลังสินค้า
                        'items' => [
                            #Dash Board
                            [
                                'label' => 'รายงาน', 'icon' => '',
                                'url' => Url::to(['/Report/default/index']), 'active' => $url == '/Report/default/index',
                                'visible' => Yii::$app->user->can('MenuSubInventory')
                            ],
                            [
                                'label' => 'Dash Board V.2', 'icon' => '',
                                'url' => Url::to(['/Inventory/dashboard-v2/cmd-listdrugnew']), /* 'active' => $url == '/Inventory/dashboard-sub/list-drugnew', */
                                'visible' => Yii::$app->user->can('MenuSubInventory')
                            ],
                            #เบิกจ่ายสินค้าระหว่างคลัง
                            [
                                'label' => 'เบิกจ่ายสินค้าระหว่างคลัง', 'icon' => '',
                                'url' => Url::to(['/Inventory/stock-request/index']), 'active' => $url == '/Inventory/stock-request/index',
                                'visible' => Yii::$app->user->can('MenuSubInventory')
                            ],
                            #รายการเติมสินค้า
                            [
                                'label' => 'รายการเติมสินค้า', 'icon' => '',
                                'url' => Url::to(['/Inventory/vw-stkrefill-status/index']), 'active' => $url == '/Inventory/vw-stkrefill-status/index',
                                'visible' => Yii::$app->user->can('MenuSubInventory')
                            ],
                            // [
                            //     'label' => 'รายการเติมสินค้า V.2', 'icon' => '',
                            //     'url' => Url::to(['/Inventory/vw-stkrefill-status2/index']), 'active' => $url == '/Inventory/vw-stkrefill-status2/index',
                            //     'visible' => Yii::$app->user->can('MenuSubInventory')
                            // ],
                            #จ่ายสินค้ารายวัน
                            [
                                'label' => 'จ่ายสินค้ารายวัน', 'icon' => '',
                                'url' => Url::to(['/Inventory/daily-issue/index']), 'active' => $url == '/Inventory/daily-issue/index',
                                'visible' => Yii::$app->user->can('MenuSubInventory')
                            ],
                            #รับสินค้า
                            [
                                'label' => 'รับสินค้า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuSubInventory'), #สิทธิ์ รับสินค้า
                                'items' => [
                                    #รับสินค้าสั่งซื้อ
                                    [
                                        'label' => 'รับสินค้าสั่งซื้อ', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/gr-po/index']), 'active' => $url == '/Inventory/gr-po/index',
                                        'visible' => Yii::$app->user->can('MenuGrPo')
                                    ],
                                    #อื่นๆ
                                    [
                                        'label' => 'อื่นๆ', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/gr-donation/index']), 'active' => $url == '/Inventory/gr-donation/index',
                                        'visible' => Yii::$app->user->can('MenuSubInventory')
                                    ],
                                ],
                            ],
                            // #รับสินค้า
                            // [
                            //     'label' => 'รับสินค้า', 'icon' => '',
                            //     'url' => Url::to(['/Inventory/gr-donation/index']), 'active' => $url == '/Inventory/gr-donation/index',
                            //     'visible' => Yii::$app->user->can('MenuSubInventory')
                            // ],
                            // #รับสินค้าสั่งซื้อ
                            // [
                            //     'label' => 'รับสินค้า(จากการสั่งซื้อ)', 'icon' => '',
                            //     'url' => Url::to(['/Inventory/gr-po/index']), 'active' => $url == '/Inventory/gr-po/index',
                            //     'visible' => Yii::$app->user->can('MenuGrPo')
                            // ],
                            #จัดการข้อมูลผู้ขาย
                            [
                                'label' => 'จัดการข้อมูลผู้ขาย', 'icon' => '',
                                'url' => Url::to(['/user/registration/index']), 'active' => $url == '/user/registration/index',
                                'visible' => Yii::$app->user->can('MenuAuthenVender')
                            ],
                            #ตั้งต้นสินค้าคงคลัง
                            [
                                'label' => 'ตั้งต้นสินค้าคงคลัง', 'icon' => '',
                                'url' => Url::to(['/Inventory/stock-initail/index']), 'active' => $url == '/Inventory/stock-initail/index',
                                'visible' => Yii::$app->user->can('MenuSubInventory')
                            ],
                            #การเคลมสินค้า
                            [
                                'label' => 'การเคลมสินค้า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuInventoryExternal'), #สิทธิ์ การเคลมสินค้า
                                'items' => [
                                    #ส่งเคลมสินค้า
                                    [
                                        'label' => 'ส่งเคลมสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/claim-product/index']), 'active' => $url == '/Inventory/claim-product/index',
                                        'visible' => Yii::$app->user->can('MenuInventoryExternal')
                                    ],
                                    #รับสินค้าเคลม
                                    [
                                        'label' => 'รับสินค้าเคลม', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/claim-product-gr/index']), 'active' => $url == '/Inventory/claim-product-gr/index',
                                        'visible' => Yii::$app->user->can('MenuInventoryExternal')
                                    ],
                                ],
                            ],
                            #ขอยืมสินค้า
                            [
                                'label' => 'ขอยืมสินค้า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuInventoryExternal'), #สิทธิ์ ขอยืมสินค้า
                                'items' => [
                                    #รับสินค้ายืม
                                    [
                                        'label' => 'รับสินค้ายืม', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/lond-product/index']), 'active' => $url == '/Inventory/lond-product/index',
                                        'visible' => Yii::$app->user->can('MenuInventoryExternal')
                                    ],
                                    #ส่งคืนสินค้าขอยืม
                                    [
                                        'label' => 'ส่งคืนสินค้าขอยืม', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/lond-product-st/index']), 'active' => $url == '/Inventory/lond-product-st/index',
                                        'visible' => Yii::$app->user->can('MenuInventoryExternal')
                                    ],
                                    #ข้อมูลผู้ให้ยืมสินค้า
                                    [
                                        'label' => 'ข้อมูลผู้ให้ยืมสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/user/registration/register']), 'active' => $url == '/user/registration/register',
                                        'visible' => Yii::$app->user->can('MenuInventoryExternal')
                                    ],
                                ],
                            ],
                            #ให้ยืมสินค้า
                            [
                                'label' => 'ให้ยืมสินค้า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuInventoryExternal') && Yii::$app->user->can('MenuLending'), #สิทธิ์ ให้ยืมสินค้า
                                'items' => [
                                    #ให้ยืมสินค้า
                                    [
                                        'label' => 'ให้ยืมสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/lend-product/index']), 'active' => $url == '/Inventory/lend-product/index',
                                        'visible' => Yii::$app->user->can('MenuInventoryExternal')
                                    ],
                                    #รับคืนสินค้า
                                    [
                                        'label' => 'รับคืนสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/lend-product-gr/index']), 'active' => $url == '/Inventory/lend-product-gr/index',
                                        'visible' => Yii::$app->user->can('MenuInventoryExternal')
                                    ],
                                    #ข้อมูลผู้ขอยืมสินค้า
                                    [
                                        'label' => 'ข้อมูลผู้ขอยืมสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/user/registration/register']), 'active' => $url == '/user/registration/register',
                                        'visible' => Yii::$app->user->can('MenuInventoryExternal')
                                    ],
                                ],
                            ],
                            #ปรับปรุงยอดฯ
                            [
                                'label' => 'ปรับปรุงยอดฯ', 'icon' => '',
                                'url' => Url::to(['/Inventory/sa-list/index']), 'active' => $url == '/Inventory/sa-list/index',
                                'visible' => Yii::$app->user->can('MenuSubInventory')
                            ],
                            #จัดการรายการสินค้า
                            [
                                'label' => 'จัดการรายการสินค้า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuAddDrug') || Yii::$app->user->can('MenuAddNonDrug'), #สิทธิ์ จัดการรายการสินค้า
                                'items' => [
                                    #ยาการค้า
                                    [
                                        'label' => 'รายการยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/additem/index']), 'active' => $url == '/Inventory/additem/index',
                                        'visible' => Yii::$app->user->can('MenuAddDrug')
                                    ],
                                    #เวชภัณฑ์มิใช่ยา
                                    [
                                        'label' => 'เวชภัณฑ์มิใช่ยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/addnondrug/index']), 'active' => $url == '/Inventory/addnondrug/index',
                                        'visible' => Yii::$app->user->can('MenuAddNonDrug')
                                    ],
                                ],
                            ],
                        // #บันทึกเวชภัณฑ์
                        // [
                        //     'label' => 'บันทึกเวชภัณฑ์', 'icon' => '',
                        //     'url' => Url::to(['/Inventory/addnondrug/index']), 'active' => $url == '/Inventory/addnondrug/index',
                        //     'visible' => Yii::$app->user->can('MenuAddNonDrug')
                        // ],
                        // #ตั้งค่าหมวด
                        // [
                        //     'label' => 'ตั้งค่าหมวด', 'icon' => '', 'url' => '#', 'template' => $template,
                        //     'visible' => Yii::$app->user->can('MenuSettingDrug'), #สิทธิ์ ตั้งค่าหมวด
                        //     'items' => [
                        //         #หมวดยาหลัก
                        //             [
                        //             'label' => 'หมวดยาหลัก', 'icon' => 'fa fa-circle-thin',
                        //             'url' => Url::to(['/Inventory/drugclass/index']), 'active' => $url == '/Inventory/drugclass/index',
                        //             'visible' => Yii::$app->user->can('MenuSettingDrug')
                        //         ],
                        //         #หมวดยาย่อย
                        //         [
                        //             'label' => 'หมวดยาย่อย', 'icon' => 'fa fa-circle-thin',
                        //             'url' => Url::to(['/Inventory/drugsubclass/index']), 'active' => $url == '/Inventory/drugsubclass/index',
                        //             'visible' => Yii::$app->user->can('MenuSettingDrug')
                        //         ],
                        //         #หมวดเวชภัณฑ์หลัก
                        //         [
                        //             'label' => 'หมวดเวชภัณฑ์หลัก', 'icon' => 'fa fa-circle-thin',
                        //             'url' => Url::to(['/Inventory/item-ndmed-supply-catid-sub/index']), 'active' => $url == '/Inventory/item-ndmed-supply-catid-sub/index',
                        //             'visible' => Yii::$app->user->can('MenuSettingDrug')
                        //         ],
                        //         #หมวดเวชภัณฑ์ย่อย
                        //         [
                        //             'label' => 'หมวดเวชภัณฑ์ย่อย', 'icon' => 'fa fa-circle-thin',
                        //             'url' => Url::to(['/Inventory/itemndmedsupply/index']), 'active' => $url == '/Inventory/itemndmedsupply/index',
                        //             'visible' => Yii::$app->user->can('MenuSettingDrug')
                        //         ],
                        //     ],
                        // ],
                        ],
                    ],
                    #งานเรียกเก็บ
                    [
                        'label' => 'งานเรียกเก็บ', 'icon' => 'fa fa-exchange', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('MenuCharge'), #สิทธิ์ งานเรียกเก็บ
                        'items' => [
                            #Dash Board
                            [
                                'label' => 'Dash Board', 'icon' => '',
                                'url' => Url::to(['/']), /* 'active' => $url == '/Inventory/dashboard-sub/list-drugnew', */
                                'visible' => Yii::$app->user->can('MenuCharge')
                            ],
                            #นำเข้าข้อมูล
                            [
                                'label' => 'นำเข้าข้อมูล', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuCharge'), #สิทธิ์ นำเข้าข้อมูล
                                'items' => [
                                    #REP สปสช.
                                    [
                                        'label' => 'REP สปสช.', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Payment/import-excel-ipop/index']), 'active' => $url == '/Payment/import-excel-ipop/index',
                                        'visible' => Yii::$app->user->can('MenuCharge'),
                                    ],
                                    #STATEMENT สปสช.
                                    [
                                        'label' => 'STATEMENT สปสช.', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Payment/import-excel-stm/index']), 'active' => $url == '/Payment/import-excel-stm/index',
                                        'visible' => Yii::$app->user->can('MenuCharge'),
                                    ],
                                ],
                            ],
                            #ออกหนังสือเรียกเก็บ
                            [
                                'label' => 'ออกหนังสือเรียกเก็บ', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuCharge'), #สิทธิ์ การเงินผู้ป่วยนอก
                                'items' => [
                                    #รพ.หลัก(OPREFER)
                                    [
                                        'label' => 'รพ.หลัก(OPREFER)', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Payment/nhso-ar/index']), 'active' => $url == '/Payment/nhso-ar/index',
                                        'visible' => Yii::$app->user->can('MenuCharge'),
                                    ],
                                    #ต้นสังกัด
                                    [
                                        'label' => 'ต้นสังกัด', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Payment/nhso-ar/index']), 'active' => $url == '/Payment/nhso-ar/index',
                                        'visible' => Yii::$app->user->can('MenuCharge'),
                                    ],
                                ],
                            ],
                            #รับหนังสือแจ้งการชำระเงิน
                            [
                                'label' => 'รับหนังสือแจ้งการชำระเงิน', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuCharge'), #สิทธิ์ การเงินผู้ป่วยนอก
                                'items' => [
                                    #รพ.หลัก(OPREFER)
                                    [
                                        'label' => 'รพ.หลัก(OPREFER)', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/']), 'active' => $url == '/',
                                        'visible' => Yii::$app->user->can('MenuCharge'),
                                    ],
                                    #ต้นสังกัด
                                    [
                                        'label' => 'ต้นสังกัด', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/']), 'active' => $url == '/',
                                        'visible' => Yii::$app->user->can('MenuCharge'),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    #Purchasing
                    [
                        'label' => 'Purchasing', 'icon' => 'fa fa-shopping-cart', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('MenuPurchasing'),
                        'items' => [
                            #dash board purchasing
                            [
                                'label' => 'dash board purchasing', 'icon' => '',
                                'template' => '<a href="{url}" class="dashboardpr">{icon} {label}</a>',
                                'url' => Url::to(['/Purchasing/dashboard/prstatus']), 'active' => $url == '/Purchasing/dashboard/prstatus',
                                'visible' => Yii::$app->user->can('DashboardPR')
                            ],
                            [
                                'label' => 'PO Status', 'icon' => '',
                                'template' => '<a href="{url}">{icon} {label}</a>',
                                'url' => Url::to(['/po/default/order-status']), 'active' => $url == '/po/default/order-status',
                                'visible' => Yii::$app->user->can('menuleft')
                            ],
                            [
                                'label' => 'แผนการจัดซื้อ(New)', 'icon' => '',
                                'template' => '<a href="{url}">{icon} {label}</a>',
                                'url' => Url::to(['/plan/default/index']), 'active' => $url == '/plan/default/index',
                                'visible' => Yii::$app->user->can('menuleft')
                            ],
                            [
                                'label' => 'สัญญาจะซื้อจะขาย(New)', 'icon' => '',
                                'template' => '<a href="{url}">{icon} {label}</a>',
                                'url' => Url::to(['/plan/default/plansale']), 'active' => $url == '/plan/default/plansale',
                                'visible' => Yii::$app->user->can('menuleft')
                            ],
                            #แผนการจัดซื้อ
                            [
                                'label' => 'แผนการจัดซื้อ', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuPlan') && Yii::$app->user->can('MenuPurchasing'), #สิทธิ์ แผนการจัดซื้อ
                                'items' => [
                                    #ยาสามัญ
                                    [
                                        'label' => 'ยาสามัญ', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Purchasing/plan-gpu/index']), 'active' => $url == '/Purchasing/plan-gpu/index',
                                        'visible' => Yii::$app->user->can('menuleft') && Yii::$app->user->can('MenuPlanGenerics') && Yii::$app->user->can('MenuPurchasing'),
                                    ],
                                    #ยาการค้า
                                    [
                                        'label' => 'ยาการค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Purchasing/plan-tpu/index']), 'active' => $url == '/Purchasing/plan-tpu/index',
                                        'visible' => Yii::$app->user->can('menuleft') && Yii::$app->user->can('MenuPlanTradeDrug') && Yii::$app->user->can('MenuPurchasing'),
                                    ],
                                    #เวชภัณฑ์มิใช่ยา
                                    [
                                        'label' => 'เวชภัณฑ์มิใช่ยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Purchasing/plan-nd/index']), 'active' => $url == '/Purchasing/plan-nd/index',
                                        'visible' => Yii::$app->user->can('menuleft') && Yii::$app->user->can('MenuPlanNonDrug') && Yii::$app->user->can('MenuPurchasing')
                                    ],
                                ],
                            ],
                            #สัญญาจะชื้อจะขาย
                            [
                                'label' => 'สัญญาจะชื้อจะขาย', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuPurchaseAndSale') && Yii::$app->user->can('MenuPurchasing'), #สิทธิ์ สัญญาจะชื้อจะขาย
                                'items' => [
                                    #ยาการค้า
                                    [
                                        'label' => 'ยาการค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Purchasing/plansale-tpu/index']), 'active' => $url == '/Purchasing/plansale-tpu/index',
                                        'visible' => Yii::$app->user->can('MenuPurchaseAndSaleDrug') && Yii::$app->user->can('MenuPurchasing'),
                                    ],
                                    #เวชภัณฑ์มิใช่ยา
                                    [
                                        'label' => 'เวชภัณฑ์มิใช่ยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Purchasing/plansale-nd/index']), 'active' => $url == '/Purchasing/plansale-nd/index',
                                        'visible' => Yii::$app->user->can('MenuPurchaseAndSaleNonDrug') && Yii::$app->user->can('MenuPurchasing')
                                    ],
                                ],
                            ],
                            #ขอซื้อรายการบัญชี รพ.
                            [
                                'label' => 'ขอซื้อรายการบัญชี รพ.', 'icon' => '',
                                'url' => Url::to(['/pr/default/index']), 'active' => $url == '/pr/default/index',
                                'visible' => Yii::$app->user->can('menuleft') && Yii::$app->user->can('MenuPurchasing')
                            ],
                            #ขอซื้อนอกแผน
                            [
                                'label' => 'ขอซื้อนอกแผน', 'icon' => '',
                                'url' => Url::to(['/Purchasing/new-pr-gpu/index']), 'active' => $url == '/Purchasing/new-pr-gpu/index',
                                'visible' => Yii::$app->user->can('menuleft') && Yii::$app->user->can('MenuPurchasing')
                            ],
                            #สั่งซื้อ
                            [
                                'label' => 'สั่งซื้อ', 'icon' => '',
                                'url' => Url::to(['/po/default/index']), 'active' => $url == '/po/default/index',
                                'visible' => Yii::$app->user->can('menuleft') && Yii::$app->user->can('MenuPurchasing')
                            ],
                            #จัดการข้อมูลผู้ขาย
                            [
                                'label' => 'จัดการข้อมูลผู้ขาย', 'icon' => '',
                                'url' => Url::to(['/user/registration/index']), 'active' => $url == '/user/registration/index',
                                'visible' => Yii::$app->user->can('MenuPurchasing')
                            ],
                            #ใบสืบราคาผู้ขาย
                            [
                                'label' => 'ใบสืบราคาผู้ขาย', 'icon' => '',
                                'url' => Url::to(['/purqr/qr/index']), 'active' => $url == '/purqr/qr/index',
                                'visible' => Yii::$app->user->can('MenuPurchasing')
                            ],
                            #Pricelist
                            [
                                'label' => 'Pricelist', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('MenuPurchasing'), #สิทธิ์ Pricelist
                                'items' => [
                                    #ยาการค้า
                                    [
                                        'label' => 'ยาการค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/price-list/index']), 'active' => $url == '/Inventory/price-list/index',
                                        'visible' => Yii::$app->user->can('MenuPurchasing'),
                                    ],
                                    #เวชภัณฑ์มิใช่ยา
                                    [
                                        'label' => 'เวชภัณฑ์มิใช่ยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/price-list-nd/index']), 'active' => $url == '/Inventory/price-list-nd/index',
                                        'visible' => Yii::$app->user->can('MenuPurchasing')
                                    ],
                                ],
                            ],
                        ],
                    ],
                    #หัวหน้าเภสัชกรรม
                    [
                        'label' => 'หัวหน้าเภสัชกรรม', 'icon' => 'fa  fa-user-md', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('MenuPhamasup'), #สิทธิ์ หัวหน้าเภสัชกรรม
                        'items' => [
                            #ทวนสอบใบขอซื้อ
                            [
                                'label' => 'ทวนสอบใบขอซื้อ', 'icon' => '',
                                'url' => Url::to(['/pr/default/list-verify']), 'active' => $url == '/pr/default/list-verify',
                                'visible' => Yii::$app->user->can('MenuPhamasup'),
                            ],
                            #ทวนสอบใบสั่งซื้อ
                            [
                                'label' => 'ทวนสอบใบสั่งซื้อ', 'icon' => '',
                                'url' => Url::to(['/po/default/list-verify']), 'active' => $url == '/po/default/list-verify',
                                'visible' => Yii::$app->user->can('MenuPhamasup')
                            ],
                            #อนุมัติการขอเบิก
                            [
                                'label' => 'อนุมัติการขอเบิก', 'icon' => '',
                                'url' => Url::to(['/Inventory/stock-request/wait-approve-pharmacys']), 'active' => $url == '/Inventory/stock-request/wait-approve-pharmacys',
                                'visible' => Yii::$app->user->can('MenuPhamasup')
                            ],
                            #อนุมัติปรับปรุงยอดฯ
                            [
                                'label' => 'อนุมัติปรับปรุงยอดฯ', 'icon' => '',
                                'url' => Url::to(['/Inventory/sa-list/wait-approve-prarmacy']), 'active' => $url == '/Inventory/sa-list/wait-approve-prarmacy',
                                'visible' => Yii::$app->user->can('MenuPhamasup')
                            ],
                            #อนุมัติแผน
                            [
                                'label' => 'อนุมัติแผน', 'icon' => '',
                                'url' => Url::to(['/Purchasing/tbpcplan/wailt-approve']), 'active' => $url == '/Purchasing/tbpcplan/wailt-approve',
                                'visible' => Yii::$app->user->can('MenuPhamasup')
                            ],
                        ],
                    ],
                    #ผู้บริหาร
                    [
                        'label' => 'ผู้บริหาร', 'icon' => 'fa  fa-user-md', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('MenuDirector'), #สิทธิ์ ผู้บริหาร
                        'items' => [
                            #อนุมัติใบขอซื้อ
                            [
                                'label' => 'อนุมัติใบขอซื้อ', 'icon' => '',
                                'url' => Url::to(['/pr/default/list-approve']), 'active' => $url == '/pr/default/list-approve',
                                'visible' => Yii::$app->user->can('MenuDirector'),
                            ],
                            #อนุมัติใบสั่งซื้อ
                            [
                                'label' => 'อนุมัติใบสั่งซื้อ', 'icon' => '',
                                'url' => Url::to(['/po/default/list-approve']), 'active' => $url == '/po/default/list-approve',
                                'visible' => Yii::$app->user->can('MenuDirector')
                            ],
                            #อนุมัติแผนจัดชื้อ
                            [
                                'label' => 'อนุมัติแผนจัดชื้อ', 'icon' => '',
                                'url' => Url::to(['/Purchasing/tbpcplan/wailt-manager-approve']), 'active' => $url == '/Purchasing/tbpcplan/wailt-manager-approve',
                                'visible' => Yii::$app->user->can('MenuDirector')
                            ],
                        ],
                    ],
                    #งานเภสัชกรรม
                    [
                        'label' => 'งานเภสัชกรรม', 'icon' => 'fa fa-hospital-o', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('menuadmin'), #สิทธิ์ งานเภสัชกรรม
                        'items' => [
                            #ห้องจ่ายยาผู้ป่วยนอก
                            [
                                'label' => 'ห้องจ่ายยาผู้ป่วยนอก', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('ห้องจ่ายยาผู้ป่วยนอก'), #สิทธิ์ ห้องจ่ายยาผู้ป่วยนอก
                                'items' => [
                                    #บันทึกใบสั่งยา
                                    [
                                        'label' => 'บันทึกใบสั่งยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/cpoe']), 'active' => $url == '/cpoe',
                                        'visible' => Yii::$app->user->can('ห้องจ่ายยาผู้ป่วยนอก'),
                                    ],
                                    #บันทึกใบสั่งยา V.2
                                    [
                                        'label' => 'บันทึกใบสั่งยา V.6', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/pharmacy/order-rx/index']), 'active' => $url == '/pharmacy/order-rx/index',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #สั่งจัดยาใบสั่งยา
                                    [
                                        'label' => 'สั่งจัดยาใบสั่งยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/pharmacy/rx-issue/verify-list']), 'active' => $url == '/pharmacy/rx-issue/verify-list',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #ตรวจสอบการจัดยา
                                    [
                                        'label' => 'ตรวจสอบการจัดยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/pharmacy/rx-issue/check-list']), 'active' => $url == '/pharmacy/rx-issue/check-list',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #จ่ายยา
                                    [
                                        'label' => 'จ่ายยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/pharmacy/rx-issue/issue-list']), 'active' => $url == '/pharmacy/rx-issue/issue-list',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                ],
                            ],
                            #ห้องจ่ายยาผู้ป่วยใน
                            [
                                'label' => 'ห้องจ่ายยาผู้ป่วยใน', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('ห้องจ่ายยาผู้ป่วยใน'), #สิทธิ์ ห้องจ่ายยาผู้ป่วยใน
                                'items' => [
                                    #บันทึกใบสั่งยา
                                    [
                                        'label' => 'บันทึกใบสั่งยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/']), 'active' => $url == '/',
                                        'visible' => Yii::$app->user->can('ห้องจ่ายยาผู้ป่วยใน'),
                                    ],
                                    #สั่งจัดยาใบสั่งยา
                                    [
                                        'label' => 'สั่งจัดยาใบสั่งยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/']), 'active' => $url == '/',
                                        'visible' => Yii::$app->user->can('ห้องจ่ายยาผู้ป่วยใน'),
                                    ],
                                    #ตรวจสอบการจัดยา
                                    [
                                        'label' => 'ตรวจสอบการจัดยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/']), 'active' => $url == '/',
                                        'visible' => Yii::$app->user->can('ห้องจ่ายยาผู้ป่วยใน'),
                                    ],
                                    #จ่ายยา
                                    [
                                        'label' => 'จ่ายยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/']), 'active' => $url == '/',
                                        'visible' => Yii::$app->user->can('ห้องจ่ายยาผู้ป่วยใน'),
                                    ],
                                ],
                            ],
                            #ห้องผสมยาเคมีบำบัด
                            [
                                'label' => 'ห้องผสมยาเคมีบำบัด', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('ห้องผสมยาเคมีบำบัด'), #สิทธิ์ ห้องผสมยาเคมีบำบัด
                                'items' => [
                                    #สั่งผสมยาเคมีบำบัด
                                    [
                                        'label' => 'สั่งผสมยาเคมีบำบัด', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/']), 'active' => $url == '/',
                                        'visible' => Yii::$app->user->can('ห้องผสมยาเคมีบำบัด'),
                                    ],
                                    #ตรวจสอบการจัดยา
                                    [
                                        'label' => 'ตรวจสอบการจัดยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/']), 'active' => $url == '/',
                                        'visible' => Yii::$app->user->can('ห้องผสมยาเคมีบำบัด'),
                                    ],
                                    #จ่ายยา
                                    [
                                        'label' => 'จ่ายยา', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/']), 'active' => $url == '/',
                                        'visible' => Yii::$app->user->can('ห้องผสมยาเคมีบำบัด'),
                                    ],
                                ],
                            ],
                            #คลังห้องจ่ายผู้ป่วยใน 
                            [
                                'label' => 'คลังห้องจ่ายผู้ป่วยใน', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('menuleft'), #สิทธิ์ คลังห้องจ่ายผู้ป่วยใน
                                'items' => [
                                    #Dash Board 
                                    [
                                        'label' => 'Dash Board', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/treasury-drug-sub/list-drugnew']), 'active' => $url == '/Inventory/treasury-drug-sub/list-drugnew',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #ขอเบิกสินค้า
                                    [
                                        'label' => '    ขอเบิกสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/stock-request/ipd']), 'active' => $url == '/Inventory/stock-request/ipd',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #โอนสินค้า
                                    [
                                        'label' => 'โอนสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/tb-st2-temp/ipd']), 'active' => $url == '/Inventory/tb-st2-temp/ipd',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #รับสินค้า
                                    [
                                        'label' => 'รับสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/tbst2/ipd']), 'active' => $url == '/Inventory/tbst2/ipd',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #จ่ายสินค้ารายวัน
                                    [
                                        'label' => 'จ่ายสินค้ารายวัน', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/daily-issue/ipd']), 'active' => $url == '/Inventory/daily-issue/ipd',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #ตั้งต้นสินค้าคงคลัง
                                    [
                                        'label' => 'ตั้งต้นสินค้าคงคลัง', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/stock-initail/ipd']), 'active' => $url == '/Inventory/stock-initail/ipd',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #ปรับปรุงยอดสินค้าคงคลัง
                                    [
                                        'label' => 'ปรับปรุงยอดสินค้าคงคลัง', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/sa-list']), 'active' => $url == '/Inventory/sa-list',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                ],
                            ],
                            #คลังห้องจ่ายผู้ป่วยนอก 
                            [
                                'label' => 'คลังห้องจ่ายผู้ป่วยนอก', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('menuleft'), #สิทธิ์ คลังห้องจ่ายผู้ป่วยนอก
                                'items' => [
                                    #Dash Board 
                                    [
                                        'label' => 'Dash Board', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/treasury-drug-sub/list-drugnew']), 'active' => $url == '/Inventory/treasury-drug-sub/list-drugnew',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #ขอเบิกสินค้า
                                    [
                                        'label' => '    ขอเบิกสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/stock-request/opd']), 'active' => $url == '/Inventory/stock-request/opd',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #โอนสินค้า
                                    [
                                        'label' => 'โอนสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/tb-st2-temp/opd']), 'active' => $url == '/Inventory/tb-st2-temp/opd',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #รับสินค้า
                                    [
                                        'label' => 'รับสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/tbst2/opd']), 'active' => $url == '/Inventory/tbst2/opd',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #จ่ายสินค้ารายวัน
                                    [
                                        'label' => 'จ่ายสินค้ารายวัน', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/daily-issue/opd']), 'active' => $url == '/Inventory/daily-issue/opd',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #ตั้งต้นสินค้าคงคลัง
                                    [
                                        'label' => 'ตั้งต้นสินค้าคงคลัง', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/stock-initail/opd']), 'active' => $url == '/Inventory/stock-initail/opd',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #ปรับปรุงยอดสินค้าคงคลัง
                                    [
                                        'label' => 'ปรับปรุงยอดสินค้าคงคลัง', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/sa-list']), 'active' => $url == '/Inventory/sa-list',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                ],
                            ],
                            #คลังห้องผสมยาเคมีฯ 
                            [
                                'label' => 'คลังห้องผสมยาเคมีฯ', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('menuleft'), #สิทธิ์ คลังห้องผสมยาเคมีฯ
                                'items' => [
                                    #Dash Board 
                                    [
                                        'label' => 'Dash Board', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/treasury-drug-sub/list-drugnew']), 'active' => $url == '/Inventory/treasury-drug-sub/list-drugnew',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #ขอเบิกสินค้า
                                    [
                                        'label' => '    ขอเบิกสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/stock-request/opd-chemical']), 'active' => $url == '/Inventory/stock-request/opd-chemical',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #โอนสินค้า
                                    [
                                        'label' => 'โอนสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/tb-st2-temp/opd-chemical']), 'active' => $url == '/Inventory/tb-st2-temp/opd-chemical',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #รับสินค้า
                                    [
                                        'label' => 'รับสินค้า', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/tbst2/opd-chemical']), 'active' => $url == '/Inventory/tbst2/opd-chemical',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #จ่ายสินค้ารายวัน
                                    [
                                        'label' => 'จ่ายสินค้ารายวัน', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/daily-issue/opd-chemical']), 'active' => $url == '/Inventory/daily-issue/opd-chemical',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #ตั้งต้นสินค้าคงคลัง
                                    [
                                        'label' => 'ตั้งต้นสินค้าคงคลัง', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/stock-initail/opd-chemical']), 'active' => $url == '/Inventory/stock-initail/opd-chemical',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #ปรับปรุงยอดสินค้าคงคลัง
                                    [
                                        'label' => 'ปรับปรุงยอดสินค้าคงคลัง', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Inventory/sa-list']), 'active' => $url == '/Inventory/sa-list',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                ],
                            ],
                            #ตั้งค่า 
                            [
                                'label' => 'ตั้งค่า', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('menuleft'), #สิทธิ์ ตั้งค่า
                                'items' => [
                                    #Dash Board 
                                    [
                                        'label' => 'Standard Regimen', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/chemos/standard/index']), 'active' => $url == '/chemos/standard/index',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    #งานผู้ป่วยนอก
                    [
                        'label' => 'งานผู้ป่วยนอก', 'icon' => 'fa  fa-user-md', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('MenuOPD'), #สิทธิ์ งานผู้ป่วยนอก
                        'items' => [
                            #เคมีบำบัด
                            [
                                'label' => 'เคมีบำบัด', 'icon' => '',
                                'url' => Url::to(['/Outpatientdepartment/ipd/opd']), 'active' => $url == '/Outpatientdepartment/ipd/opd',
                                'visible' => Yii::$app->user->can('MenuOPD'),
                            ],
                            #รังสีรักษา
                            [
                                'label' => 'รังสีรักษา', 'icon' => '',
                                'url' => Url::to(['/']), 'active' => $url == '/',
                                'visible' => Yii::$app->user->can('MenuOPD')
                            ],
                            #ศัลยกรรม
                            [
                                'label' => 'ศัลยกรรม', 'icon' => '',
                                'url' => Url::to(['/']), 'active' => $url == '/',
                                'visible' => Yii::$app->user->can('MenuOPD')
                            ],
                            #ทันตกรรม
                            [
                                'label' => 'ทันตกรรม', 'icon' => '',
                                'url' => Url::to(['/']), 'active' => $url == '/',
                                'visible' => Yii::$app->user->can('MenuOPD')
                            ],
                        ],
                    ],
                    #งานผู้ป่วยใน
                    [
                        'label' => 'งานผู้ป่วยใน', 'icon' => 'fa  fa-user-md', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('MenuIPD'), #สิทธิ์ งานผู้ป่วยใน
                        'items' => [
                            #หอผู้ป่วยสามัญชาย
                            [
                                'label' => 'หอผู้ป่วยสามัญชาย', 'icon' => '',
                                'url' => Url::to(['/']), 'active' => $url == '/',
                                'visible' => Yii::$app->user->can('MenuIPD'),
                            ],
                            #หอผู้ป่วยสามัญหญิง
                            [
                                'label' => 'หอผู้ป่วยสามัญหญิง', 'icon' => '',
                                'url' => Url::to(['/']), 'active' => $url == '/',
                                'visible' => Yii::$app->user->can('MenuIPD')
                            ],
                            #หอผู้ป่วยพิเศษชาย
                            [
                                'label' => 'หอผู้ป่วยพิเศษชาย', 'icon' => '',
                                'url' => Url::to(['/']), 'active' => $url == '/',
                                'visible' => Yii::$app->user->can('MenuIPD')
                            ],
                            #หอผู้ป่วยพิเศษหญิง
                            [
                                'label' => 'หอผู้ป่วยพิเศษหญิง', 'icon' => '',
                                'url' => Url::to(['/']), 'active' => $url == '/',
                                'visible' => Yii::$app->user->can('MenuIPD')
                            ],
                        ],
                    ],
                    #ลงทะเบียนผู้ป่วย
                    [
                        'label' => 'ลงทะเบียนผู้ป่วย', 'icon' => 'fa  fa-user-md', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('menuadmin'), #สิทธิ์ ลงทะเบียนผู้ป่วย
                        'items' => [
                            #ลงทะเบียนผู้ป่วย
                            [
                                'label' => 'ลงทะเบียนผู้ป่วย', 'icon' => '',
                                'url' => Url::to(['/AuthenticationandFinance/authentication/index']), 'active' => $url == '/AuthenticationandFinance/authentication/index',
                                'visible' => Yii::$app->user->can('menuleft'),
                            ],
                            #ลงทะเบียนผู้ป่วยNew
                            [
                                'label' => 'ลงทะเบียนผู้ป่วยNew', 'icon' => '',
                                'url' => Url::to(['/AuthenticationandFinance/authentication/list-opd-wait-register']), 'active' => $url == '/AuthenticationandFinance/authentication/list-opd-wait-register',
                                'visible' => Yii::$app->user->can('menuleft')
                            ],
                            #บันทึกสิทธิการรักษา
                            [
                                'label' => 'บันทึกสิทธิการรักษา', 'icon' => '',
                                'url' => Url::to(['/AuthenticationandFinance/ar/index']), 'active' => $url == '/AuthenticationandFinance/ar/index',
                                'visible' => Yii::$app->user->can('menuleft')
                            ],
                        ],
                    ],
                    #Financial
                    [
                        'label' => 'Financial', 'icon' => 'fa fa-dollar', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('menuadmin'), #สิทธิ์ Financial
                        'items' => [
                            #การเงินผู้ป่วยใน
                            [
                                'label' => 'การเงินผู้ป่วยใน', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('menuleft'), #สิทธิ์ การเงินผู้ป่วยใน
                                'items' => [
                                    #รับชำระเงินผู้ป่วย
                                    [
                                        'label' => 'รับชำระเงินผู้ป่วย', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Payment/payment/in-patient']), 'active' => $url == '/Payment/payment/in-patient',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #นำส่งเงินสด
                                    [
                                        'label' => 'นำส่งเงินสด', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Payment/send-cash/in-patient']), 'active' => $url == '/Payment/send-cash/in-patient',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #นำส่งเรียกเก็บ
                                    [
                                        'label' => 'นำส่งเรียกเก็บ', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Payment/cr-payment/index']), 'active' => $url == '/Payment/cr-payment/index',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                ],
                            ],
                            #การเงินผู้ป่วยนอก
                            [
                                'label' => 'การเงินผู้ป่วยนอก', 'icon' => '', 'url' => '#', 'template' => $template,
                                'visible' => Yii::$app->user->can('menuleft'), #สิทธิ์ การเงินผู้ป่วยนอก
                                'items' => [
                                    #รับชำระเงินผู้ป่วย
                                    [
                                        'label' => 'รับชำระเงินผู้ป่วย', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Payment/payment/out-patient']), 'active' => $url == '/Payment/payment/out-patient',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #นำส่งเงินสด
                                    [
                                        'label' => 'นำส่งเงินสด', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Payment/send-cash/out-patient']), 'active' => $url == '/Payment/send-cash/out-patient',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                    #นำส่งเรียกเก็บ
                                    [
                                        'label' => 'นำส่งเรียกเก็บ', 'icon' => 'fa fa-circle-thin',
                                        'url' => Url::to(['/Payment/cr-payment/index']), 'active' => $url == '/Payment/cr-payment/index',
                                        'visible' => Yii::$app->user->can('menuleft'),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    #Settings
                    [
                        'label' => 'Settings', 'icon' => 'fa fa-gears', 'url' => '#', 'template' => $template,
                        'visible' => Yii::$app->user->can('MenuSetting'), #สิทธิ์ Settings
                        'items' => [
                            #Users
                            [
                                'label' => 'Users', 'icon' => 'fa fa-circle-thin',
                                'url' => Url::to(['/user/admin/index']), 'active' => $url == '/user/admin/index',
                                'visible' => Yii::$app->user->can('ManageUser'),
                            ],
                            #Permissions
                            [
                                'label' => 'Permissions', 'icon' => 'fa fa-circle-thin',
                                'url' => Url::to(['/admin/assignment']), 'active' => $url == '/admin/assignment',
                                'visible' => Yii::$app->user->can('MenuPermission'),
                            ],
                            #Menus
                            [
                                'label' => 'Menus', 'icon' => 'fa fa-circle-thin',
                                'url' => Url::to(['/menu/default/sorts']), 'active' => $url == '/menu/default/sorts',
                                'visible' => Yii::$app->user->can('จัดการเมนู'),
                            ],
                        ],
                    ],
                    #Logdata
                    [
                        'label' => 'Logdata', 'icon' => 'fa  fa-history',
                        'url' => Url::to(['/logger']), 'active' => $url == '/logger',
                        'visible' => Yii::$app->user->can('ManageUser'),
                    ],
                ], //End Items
            ]
    )
    ?>
</div>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/menu/left.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>