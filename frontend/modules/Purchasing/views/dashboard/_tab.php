<ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
    <li id="tab_A">
        <a data-toggle="tab" href="#tab">
            สถานะสินค้าคงคลัง : ยา
        </a>
    </li>
    <li id="tab_B">
        <a  data-toggle="tab" href="#tab">
            สถานะสินค้าคงคลัง : เวชภัณฑ์
        </a>
    </li>
     <li id="tab_C">
        <a  data-toggle="tab" href="#tab">
            รายงาน
        </a>
    </li>
</ul>
<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index.php?r=Purchasing/dashboard/index");
});
$("#tab_B").click(function (e) {               
window.location.replace("index.php?r=Purchasing/dashboard/status-drug");
});
$("#tab_C").click(function (e) {               
window.location.replace("index.php?r=Purchasing/dashboard/report");
});
JS;
$this->registerJs($script);
?>
