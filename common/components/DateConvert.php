<?php

namespace common\components;

use yii\base\Component;

class DateConvert extends Component {

    public function ThaiToMysqlDate($date) {//แปลงวันที่ลง mysql
        $arr = explode("/", $date);
        $y = $arr[2];
        $m = $arr[1];
        $d = $arr[0];
        return "$y-$m-$d";
    }

    public function convertThaiToMysqlDate2($date) {//แปลงวันที่ลง mysql
        $arr = explode("/", $date);
        $y = $arr[2] == date('Y') ? $arr[2] : ($arr[2] - 543);
        $m = $arr[1];
        $d = $arr[0];
        return "$y-$m-$d";
    }

    public function convertThaiToMysqlDate3($date) {//แปลงวันที่ลง
        $arr = explode("-", $date);
        $y = $arr[0] - 543;
        $m = $arr[1];
        $d = $arr[2];
        return "$d/$m/$y";
    }
    
    public function convertThaiToMysqlDate4($date) {//แปลงวันที่ลง
        $arr = explode("-", $date);
        $y = $arr[0] + 543;
        $m = $arr[1];
        $d = $arr[2];
        return "$d/$m/$y";
    }

    public function convertMysqlToThaiDate($date) {
        $arr = explode("-", $date);
        $y = $arr[0];
        $m = $arr[1];
        $d = $arr[2];
        return "$d/$m/$y";
    }
    
    public function FullMonth($date) {
        $arr = explode("-", $date);
        $y = $arr[0];
        $m = $this->MonthNumerictoMonthThai($arr[1]);
        $d = $arr[2];
        return "$d $m $y";
    }
    public function FullMonth2($date) {
        $arr = explode("/", $date);
        $y = $arr[2] + 543;
        $m = $this->MonthNumerictoMonthThai($arr[1]);
        $d = $arr[0];
        return "$d $m $y";
    }
    
    function MonthNumerictoMonthThai($month) {

        switch ($month) {
            case '01' : return 'มกราคม';
                break;
            case '02' : return 'กุมภาพันธ์';
                break;
            case '03' : return 'มีนาคม';
                break;
            case '04' : return 'เมษายน';
                break;
            case '05' : return 'พฤษภาคม';
                break;
            case '06' : return 'มิถุนายน';
                break;
            case '07' : return 'กรกฎาคม';
                break;
            case '08' : return 'สิงหาคม';
                break;
            case '09' : return 'กันยายน';
                break;
            case '10' : return 'ตุลาคม';
                break;
            case '11' : return 'พฤศจิกายน';
                break;
            case '12' : return 'ธันวาคม';
                break;
        }
    }

}

?>
