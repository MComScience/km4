<?php 
$avatar = ($userAvatar = $profile->getAvatar($profile->pt_visit_number)) ? $userAvatar : $profile->getAvatar(NULL);
?>
<style>
    table#details thead th{
        text-align: center;
    }
    table#details thead tr th{
        background-color: #ddd;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-1 text-center">
        <br/>
        <img src="<?= $avatar;?>" class="img-circle" alt="Avatar" width="50" height="50">
    </div>
    <div class="col-xs-12 col-sm-12 col-md-11">
        <br/>
        <table id="details" class="table table-hover table-bordered table-striped table-condensed kv-table-wrap">
            <thead>
                <tr>
                    <th>ลำดับสิทธิ</th>
                    <th>สิทธิการรักษา</th>
                    <th>เลขที่ใบส่งตัว</th>
                    <th>วันเริ่มใบส่งตัว</th>
                    <th>วันสิ้นสุดใบส่งตัว</th>
                    <th>ใช้สิทธิ</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($ardetails as $items) : ?>
                    <tr>
                        <td class="text-center">
                            <?= $no; ?>
                        </td>
                        <td class="text-left"> 
                            <?= $items->ar_name; ?>
                        </td>
                        
                        <td class="text-center">
                            <?= $items->refer_hsender_doc_id; ?>
                        </td>
                        <td class="text-center">
                            <?= empty($items->refer_hsender_doc_start) ? '-' : Yii::$app->componentdate->convertMysqlToThaiDate($items->refer_hsender_doc_start); ?>
                        </td>
                        <td class="text-center">
                            <?= empty($items->refer_hsender_doc_expdate) ? '-' : Yii::$app->componentdate->convertMysqlToThaiDate($items->refer_hsender_doc_expdate); ?>
                        </td>
                        <td class="text-center">
                            <?= $items->pt_ar_usage; ?>
                        </td>
                    </tr>
                <?php $no++; endforeach;
                ;
                ?>
            </tbody>
        </table>
        <br/>
    </div>
</div>