<?php ?>
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
        <img src="profiles/default_avatar.jpg" class="img-circle" alt="Avatar" width="50" height="50">
    </div>
    <div class="col-xs-12 col-sm-12 col-md-8">
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
                <?php foreach ($details as $items) : ?>
                    <tr>
                        <td class="text-center">
                            <?= $items->pt_ar_seq; ?>
                        </td>
                        <td class="text-center"> 
                            <?= $items->ar_name1; ?>
                        </td>
                        <td class="text-center">
                            <?= $items->refer_hrecieve_doc_id; ?>
                        </td>
                        <td class="text-center">
                            <?= $items->refer_hsender_doc_start; ?>
                        </td>
                        <td class="text-center">
                            <?= $items->refer_hsender_doc_expdate; ?>
                        </td>
                        <td class="text-center">
                            <?= $items->pt_ar_usage; ?>
                        </td>
                    </tr>
                <?php endforeach;
                ;
                ?>
            </tbody>
        </table>
        <br/>
    </div>
</div>