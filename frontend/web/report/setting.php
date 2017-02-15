<?php
$server="192.168.1.52";
$db="km4";
$user="Andaman";
$pass="Andaman_4221466";
$version="0.9b";
$pgport=3306;
$pchartfolder="./class/pchart2";

function datenow(){
    $d = date('d');
    $m = date('m');
    $y = date('Y')+543;
    return $d.'/'.$m.'/'.$y;
}
function convertMysqlToThaiDate($date) {
        $arr = explode("-", $date);
        $y = $arr[0];
        $m = $arr[1];
        $d = $arr[2];
        return "$d/$m/$y";
    }
function convertMysqlToThaiDate2($date) {
        $arr = explode("-", $date);
        $y = $arr[0] + 543;
        $m = $arr[1];
        $d = $arr[2];
        return "$d/$m/$y";
    }
function convertThaiDateToMysql($date) {
    $arr = explode("/", $date);
    $y = $arr[2] - 543;
    $m = $arr[1];
    $d = $arr[0];
    return "$y-$m-$d";
}
?>
