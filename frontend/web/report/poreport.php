<?php

if ($_GET['en'] == 'Anjkmaloodd4214') {
    include('class/tcpdf/tcpdf.php');
    include("class/PHPJasperXML.inc.php");
    include('setting.php');
    error_reporting();
    $id = $_GET['id'];
    $conn = new mysqli($server, $user, $pass, $db);
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * from vw_po2_header2 where POID = $id";
    $result = $conn->query($sql);
    $rs = $result->fetch_assoc();
    $xml = simplexml_load_file("poreport.jrxml");
    $PHPJasperXML = new PHPJasperXML();
    $PHPJasperXML->arrayParameter = array('POID' => $rs['POID'], 'PODate' => convertMysqlToThaiDate($rs['PODate']), 'PONum' => $rs['PONum'], 'PRType' => $rs['PRType']
        , 'POType' => $rs['POType'], 'POStatus' => $rs['POStatusDes'],'POContID' => $rs['POContID'], 'PODueDate' => convertMysqlToThaiDate($rs['PODueDate']),
        'PRExpectDate' => $rs['PRExpectDate'], 'VendorID' => $rs['VendorID'], 'VenderName' => $rs['VenderName']);
    $PHPJasperXML->xml_dismantle($xml);
    $PHPJasperXML->transferDBtoArray($server, $user, $pass, $db);
    $PHPJasperXML->outpage("D",'PO.pdf');
}
?>