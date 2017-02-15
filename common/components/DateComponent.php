<?php

namespace common\components;

use Yii;
use yii\base\Component;

class DateComponent extends Component {

    public function convertThaiToMysqlDate($date) {//แปลงวันที่ลง mysql
        $arr = explode("/", $date);
        $y = $arr[2];
        $m = $arr[1];
        $d = $arr[0];
        return "$y-$m-$d";
    }

    public function convertThaiToMysqlDate2($date) {//แปลงวันที่ลง mysql
        $arr = explode("/", $date);
        $y = $arr[2] - 543;
        $m = $arr[1];
        $d = $arr[0];
        return "$y-$m-$d";
    }

    public function convertMysqlToThaiDate($date) {
        $arr = explode("-", $date);
        $y = $arr[0];
        $m = $arr[1];
        $d = $arr[2];
        return "$d/$m/$y";
    }
	  public function convertMysqlToThaiDate2($date) {
	   if(!empty($date)){
           $arr = explode("-", $date);
           $y = $arr[0]+543;
           $m = $arr[1];
           $d = $arr[2];
           return "$d/$m/$y";
        }else{
           return '';
		}
    }

    public function convertThaiToMysqlDateDisplay($date) {
        $arr = explode("-", $date);
        $y = $arr[0] - 543;
        $m = $arr[1];
        $d = $arr[2];
        return "$d/$m/$y";
    }

public function convertToMysql($date) {
        $arr = explode("-", $date);
        $y = $arr[0]+543;
        $m = $arr[1];
        $d = $arr[2];
        return "$y-$m-$d";
}
public function convertMysqlToThaiDate3($date) {
        $arr = explode("/", $date);
        $y = $arr[0];
        $m = $arr[1];
        $d = $arr[2]+543;
        return "$y/$m/$d";
    }
   public function layoutgridview() {
        $layout = <<< HTML
<div class="pull-right"></div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
        return $layout;
    }
 public function layoutgridview2() {
        $layout = <<< HTML
<div class="pull-right"></div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
        return $layout;
    }

    function convertnumbermonthyearthai($date) {
        $date = explode('-', $date);
        $year = $this->arabic_to_thai($date[0]);
        $month = $this->month($date[1]);
        $day = $this->arabic_to_thai($date[2]);
        return $day . ' ' . $month . ' ' . $year;
    }
    function convertmonththai($date){
        $date = explode('-', $date);
        $year = $date[0]+543;
        $month = $this->month($date[1]);
        $day = $date[2];
        return $day . ' ' . $month . ' ' . $year;
    }

    function arabic_to_thai($str_return) {
        $numthai = array("๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙", "๐");
        $numarabic = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $str_return = str_replace($numarabic, $numthai, $str_return);
        return $str_return;
    }

    function format_number($val) {
        return  str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), array("o", "๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙"), number_format($val));

    }

    function thai_to_arabic($str_return) {
        $numthai = array("๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙", "๐");
        $numarabic = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $str_return = str_replace($numthai, $numarabic, $str_return);
        return $str_return;
    }

    function month($date) {

        switch ($date) {
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
  function aes128Encrypt($key, $data) {
         $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),MCRYPT_DEV_URANDOM);

 $data = base64_encode($iv .mcrypt_encrypt(MCRYPT_RIJNDAEL_128,hash('sha256', $key, true),$data,MCRYPT_MODE_CBC,$iv));
return str_replace(array('+', '/', '='), array('-', '_', '#'),$data);
    }

    function aes128Decrypt($key, $data) {
       $data = str_replace(array('-', '_', '#'), array('+', '/', '='), $data); 
    $data = base64_decode($data);
$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
return  rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, hash('sha256', $key, true),substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),MCRYPT_MODE_CBC,$iv),"\0");
  
    }
	function encrypt($string, $key){
        $result = "";
        for($i=0; $i<strlen($string); $i++){
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key))-1, 1);
                $char = chr(ord($char)+ord($keychar));
                $result.=$char;
        }
        $salt_string = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxys0123456789~!@#$^&*()_+`-={}|:<>?[]\;',./";
        $length = rand(1, 15);
        $salt = "";
        for($i=0; $i<=$length; $i++){
                $salt .= substr($salt_string, rand(0, strlen($salt_string)), 1);
        }
        $salt_length = strlen($salt);
        $end_length = strlen(strval($salt_length));
        return base64_encode($result.$salt.$salt_length.$end_length);
}
function decrypt($string, $key){
        $result = "";
        $string = base64_decode($string);
        $end_length = intval(substr($string, -1, 1));
        $string = substr($string, 0, -1);
        $salt_length = intval(substr($string, $end_length*-1, $end_length));
        $string = substr($string, 0, $end_length*-1+$salt_length*-1);
        for($i=0; $i<strlen($string); $i++){
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key))-1, 1);
                $char = chr(ord($char)-ord($keychar));
                $result.=$char;
        }
        return $result;
}
 function datenow() {
        $d = date('d');
        $m = date('m');
        $y = date('Y') + 543;
        return $d . '/' . $m . '/' . $y;
    }
//
//    public function headertableprdarfdetail() {
//        return '<table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
//                          <thead>
//                             <tr role="row">
//                                <th width="5%">
//                                   ลำดับ
//                               </th>
//                               <th>
//                                   รหัสยาสามัญ
//                               </th>
//                               <th>
//                                   รายละเอียดยาสามัญ
//                               </th>
//                               <th>
//                                   ราคากลาง
//                               </th>
//                               <th>
//                                   ราคาต่อหน่วยตามแผน
//                               </th>
//                               <th>
//                                   ปริมาณตามแผน
//                               </th>
//                               <th>
//                                   ปริมาณขอชื้อแล้ว
//                               </th>
//                               <th>
//                                   ปริมาณที่ชื้อได้ตามแผน
//                               </th>
//                               <th>
//                                   ราคาต่อหน่วย
//                               </th>
//                               <th>
//                                   จำนวน
//                               </th>
//                               <th>
//                                   รวมเป็นเงิน
//                               </th>
//                               <th>
//                                Action
//                            </th>
//                        </tr>
//                    </thead>
//                    <tbody>';
//    }
//
//    public function headertableprvirifydetail() {
//        return ' <table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
//                          <thead>
//                             <tr role="row">
//                                <th width="5%">
//                                   ลำดับ
//                               </th>
//                               <th>
//                                   รหัสยาสามัญ
//                               </th>
//                               <th>
//                                   รายละเอียดยาสามัญ
//                               </th>
//                               <th>
//                                   ราคากลาง
//                               </th>
//                               <th>
//                                   ราคาต่อหน่วยตามแผน
//                               </th>
//                               <th>
//                                   ปริมาณชื้อตามแผน
//                               </th>
//                               <th>
//                                   ปริมาณขอชื้อแล้ว
//                               </th>
//                               <th>
//                                   ปริมาณที่ชื้อได้ตามแผน
//                               </th>
//                               <th>
//                                   ราคาต่อหน่วย
//                               </th>
//                               <th>
//                                   จำนวน
//                               </th>
//                               <th>
//                                   ราคาต่อหน่วยทวนสอบ
//                               </th>
//                               <th>
//                                   จำนวนที่ทวนสอบ
//                               </th>
//                               <th>
//                                   ราคารวม
//                               </th>
//                               <th>
//                                 <a href="" onclick="okall();" class="btn btn-success">OK All</a>
//                            </th>
//                        </tr>
//                    </thead>
//                    <tbody>';
//    }
//
//    public function headertableprapprovdetail() {
//        return ' <table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
//		<thead>
//			<tr>
//				<td>
//					ลำดับ
//				</td>
//				<td>
//					รหัสยาสามัญ
//				</td>
//				<td>
//					รายละเอียดยาสามัญ
//				</td>
//				<td>
//					ราคากลาง
//				</td>		
//				<td>
//					ราคาต่อหน่วยตามแผน
//				</td>
//                                <td>
//					ปริมาณตามแผน
//				</td>
//				<td>
//					ปริมาณขอชื้อแล้ว
//				</td>
//				<td>
//					ปริมาณที่ชื้อได้ตามแผน
//				</td>
//                                <td>
//					ราคาต่อหน่วย
//				</td>
//                                <td>
//					จำนวน
//				</td>
//                                <td>
//					ทวนสอบราคา
//				</td>
//                                <td>
//					ทวนสอบจำนวน
//				</td>
//                                 <td>
//					อนุมัติราคา
//				</td>
//                                <td>
//                                        อนุมัติจำนวน
//				</td>
//                                <td>
//					ราคารวม
//				</td>
//				<td>
//                                        <a href="" onclick="okallapprove();" class="btn btn-success">OK All</a>
//				</td>
//			</tr>
//		</thead>
//		<tbody>';
//    }

}
