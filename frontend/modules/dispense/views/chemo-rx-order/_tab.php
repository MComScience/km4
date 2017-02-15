<?php

use yii\helpers\Html;
?>
<ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
    <li>
        <a style="text-align: left">
            <b class="success">Drug Allergic : </b>Drug1 Drug2 Drug3 Drug4
        </a>
    </li>
    <li>
    <div class="row">
    <div class="col-md-6">
      
    </div>
         <div class="col-md-6">
         <div style="text-align:right;margin-right:15px">
         <button class="btn btn-info btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Detail</button>
        <?=
                                Html::a('<i class="fa fa-plus"></i>' . 'Add', ['intolerance', 'vn_number' => $header['pt_vn_number']], ['role' => 'modal-remote', 'class' => 'btn btn-success btn-xs'])
                                ?>
          <!-- <button class="btn btn-info btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Detail</button>
            <button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>-->
       
         </div>

       
    </div>
    </div>
       

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
            <button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Dx</button>
        </a>

    </li>
</ul>
<ul class="nav nav-tabs tabs-flat  nav-justified bg-white" id="myTab11">
    <li class="tab-palegreen">
        <a data-toggle="tab" id="contacttab" href="#contacts">
            Patient Summary Sheet
        </a>
    </li>
    <li class="tab-yellow">
        <a data-toggle="tab" href="#settings">
            แผนการให้ยาเคมีบำบัด
        </a>
    </li>

    <li class="tab-success">
        <a data-toggle="tab" href="#timeline">
            <?= Html::encode('ประวัติการสั่งยา'); ?>
        </a>
    </li>
    <li class="active">
        <a data-toggle="tab" href="#overview">
            <i class="glyphicon glyphicon-plus"></i> <?= Html::encode('สร้างใบสั่งยา'); ?>
        </a>
    </li>
</ul>