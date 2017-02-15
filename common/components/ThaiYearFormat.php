<?php

namespace common\components;

use Yii;
use yii\base\Component;

class ThaiYearFormat extends Component {

    public function asDate($format) {
        $year = date('Y') + 543;
        if ($format == 'sort') {
            return date('d/m/') . $year;
        }
        if ($format == 'medium') {
            $Msort = $this->MonthEngSorttoMonthThaiSort(date('M'));
            return date('d').' '.$Msort.' '.$year;
        }
        if ($format == 'long') {
            $Mlong = $this->MonthEngLongToMonthThai(date('F'));
            return date('d').' '.$Mlong.' '.$year;
        }
        if ($format == 'full') {
            return $this->LongdayEngToThaiday(date('l')).' ที่ '.date('d').' '.$this->MonthEngLongToMonthThai(date('F')).' '.'พ.ศ. '.$year;
        }
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

    function MonthEngLongToMonthThai($month) {
        switch ($month) {
            case 'January' : return 'มกราคม';
                break;
            case 'February' : return 'กุมภาพันธ์';
                break;
            case 'March' : return 'มีนาคม';
                break;
            case 'April' : return 'เมษายน';
                break;
            case 'May' : return 'พฤษภาคม';
                break;
            case 'June' : return 'มิถุนายน';
                break;
            case 'July' : return 'กรกฎาคม';
                break;
            case 'August' : return 'สิงหาคม';
                break;
            case 'September' : return 'กันยายน';
                break;
            case 'October' : return 'ตุลาคม';
                break;
            case 'November' : return 'พฤศจิกายน';
                break;
            case 'December' : return 'ธันวาคม';
                break;
        }
    }

    function MonthEngSorttoMonthThaiSort($month) {

        switch ($month) {
            case 'Jan' : return 'ม.ค.';
                break;
            case 'Feb' : return 'ก.พ.';
                break;
            case 'Mar' : return 'มี.ค.';
                break;
            case 'Apr' : return 'เม.ย.';
                break;
            case 'May' : return 'พ.ค.';
                break;
            case 'Jun' : return 'มิ.ย.';
                break;
            case 'Jul' : return 'ก.ค.';
                break;
            case 'Aug' : return 'ส.ค.';
                break;
            case 'Sep' : return 'ก.ย.';
                break;
            case 'Oct' : return 'ต.ค.';
                break;
            case 'Nov' : return 'พ.ย.';
                break;
            case 'Dec' : return 'ธ.ค';
                break;
        }
    }

    function LongdayEngToThaiday($day) {

        switch ($day) {
            case 'Sunday' : return 'วันอาทิตย์';
                break;
            case 'Monday' : return 'วันจันทร์';
                break;
            case 'Tuesday' : return 'วันอังคาร';
                break;
            case 'Wednesday' : return 'วันพุธ';
                break;
            case 'Thursday' : return 'วันพฤหัสบดี';
                break;
            case 'Friday' : return 'วันศุกร์';
                break;
            case 'Saturday' : return 'วันเสาร์';
                break;
        }
    }

    function ShortDayEngToThaidaySort($day) {

        switch ($day) {
            case 'Sun' : return 'อ.';
                break;
            case 'Mon' : return 'จ.';
                break;
            case 'Tue' : return 'อ.';
                break;
            case 'Wed' : return 'พ.';
                break;
            case 'Thu' : return 'พฤ.';
                break;
            case 'Fri' : return 'ศ.';
                break;
            case 'Sat' : return 'ส.';
                break;
        }
    }

    function NumericdayToThaiday($day) {

        switch ($day) {
            case '1' : return 'จันทร์';
                break;
            case '2' : return 'อังคาร';
                break;
            case '3' : return 'พุธ';
                break;
            case '4' : return 'พฤหัสบดี';
                break;
            case '5' : return 'ศุกร์';
                break;
            case '6' : return 'เสาร์';
                break;
            case '7' : return 'อาทิตย์';
                break;
        }
    }

}
