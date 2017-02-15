<div class="row">
    <div class="invoice-container">
        <ul>
            <div class="row">
                <!-- <li class="pull-right">
                    <a class="btn btn-success  btn-sm" ><i></i> Detail</a>
                    <a class="btn btn-info  btn-sm"><i></i> Edit</a>
                    &nbsp;
                </li> -->
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:5px">
                <div class="header-fullname">
                    <?php echo $modelHD['pt_name'];?>
                </div>
                <div class="header-information">
                    HN:<?php echo $modelHD['pt_hospital_number']; ?> 
                    อายุ <?php echo $modelHD['pt_age_registry_date']; ?> ปี
                </div>
                <div class="header-information">
                    VN:<?php echo $modelHD['pt_visit_number']; ?> 
                    AN:<?php echo ($modelHD['pt_admission_number']==null? 
                    'ยังไม่มี AN' : $modelHD['pt_admission_number']); ?>
                </div>
                
            </div>
<!--            <div class="col-sm-6">
                <div class="header-information"></div>
                <div class="header-information"></div>
                <div class="header-information"></div>
                <div class="header-information"></div>
            </div>-->
        </ul>
    </div>
</div>
