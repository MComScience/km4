<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 stats-col">
        <div class="invoice-container">
            <ul>
                <div class="row">
                    <li class="pull-right">
                        <a class="btn btn-info  btn-xs" ><i></i>Detail</a>&nbsp;
                    </li>
                    <li style="text-align: -webkit-left;margin-left: 20px;color:#53a93f;">สิทธิการรักษา</li>
                    <?php
                    $i = 1;
                    foreach ($ar_name as $name_ar) {
                        if ($name_ar != NULL) {
                            if ($i == 1) {
                                echo '<li style="text-align: -webkit-left;margin-left: 35px;margin-top:15px">' . $i . '.' . $name_ar . '</li>';
                            } else {
                                echo '<li style="text-align: -webkit-left;margin-left: 35px;">' . $i . '.' . $name_ar . '</li>';
                            }
                            $i++;
                        } else {
                            echo '<li style="text-align: -webkit-left;margin-left: 35px;margin-top:15px">ไม่พบสิทธิการรักษา</li>';
                        }
                    }
                    ?>
                </div>
            </ul>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: -webkit-left;margin-top: 20px;">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    OCPA:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    CPR:
                </div>
            </div>    
        </div>
    </div>
</div>