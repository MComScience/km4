<?php
#ใบขอซื้อรอการทวนสอบ
if ($type == 'view' && $status == '2') :
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchasing'), 'url' => ['/pr/default/index']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อรายการบัญชี รพ.', 'url' => ['/pr/default/waiting-verify']];
    $this->params['breadcrumbs'][] = $this->title;
endif;
#ทวนสอบใบขอซื้อ
if ($type == 'verify' && $status == '2') :
    $this->params['breadcrumbs'][] = ['label' => 'หัวหน้าเภสัชกรรม', 'url' => ['/pr/default/list-verify']];
    $this->params['breadcrumbs'][] = $this->title;
endif;
#อนุมัติใบขอซื้อ
if ($type == 'approve' && $status == '10') :
    $this->params['breadcrumbs'][] = ['label' => 'ผู้บริหาร', 'url' => ['/pr/default/list-approve']];
    $this->params['breadcrumbs'][] = 'อนุมัติใบขอซื้อ';
endif;
#ใบขอซื้อรอการอนุมัติ
if ($type == 'view' && $status == '10') :
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchasing'), 'url' => ['/pr/default/index']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อรายการบัญชี รพ.', 'url' => ['/pr/default/waiting-approve']];
    $this->params['breadcrumbs'][] = $this->title;
endif;
#ใบขอซื้อไม่ผ่านการอนุมัติ
if ($type == 'reject' && $status == '6') :
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchasing'), 'url' => ['/pr/default/index']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อรายการบัญชี รพ.', 'url' => ['/pr/default/reject-approve']];
    $this->params['breadcrumbs'][] = $this->title;
endif;
#ใบขอซื้อผ่านการอนุมัติ
if ($type == 'approve' && $status == '11') :
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchasing'), 'url' => ['/pr/default/index']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อรายการบัญชี รพ.', 'url' => ['/pr/default/approve']];
    $this->params['breadcrumbs'][] = $this->title;
endif;
?>