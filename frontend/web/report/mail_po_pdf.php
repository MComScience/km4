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

    $xml1 = simplexml_load_file("poreport.jrxml");
    $PHPJasperXML1 = new PHPJasperXML();
    $PHPJasperXML1->arrayParameter = array('POID' => $rs['POID'], 'PODate' => convertMysqlToThaiDate($rs['PODate']), 'PONum' => $rs['PONum'], 'PRType' => $rs['PRType']
        , 'POType' => $rs['POType'], 'POStatus' => $rs['POStatusDes'], 'POContID' => $rs['POContID'], 'PODueDate' => convertMysqlToThaiDate($rs['PODueDate']),
        'PRExpectDate' => $rs['PRExpectDate'], 'VendorID' => $rs['VendorID'], 'VenderName' => $rs['VenderName']);
    $PHPJasperXML1->xml_dismantle($xml1);
    $PHPJasperXML1->transferDBtoArray($server, $user, $pass, $db);
    //$PHPJasperXML->outpage("I", "PO");
    //$filenames = "../uploads/PO.pdf";
    $PHPJasperXML1->outpage("F", "../uploads/PO.pdf");
    //$PHPJasperXML->pdf->Output($filenames, 'F');

    $xml2 = simplexml_load_file("poreport2.jrxml");
    $PHPJasperXML2 = new PHPJasperXML();
    $PHPJasperXML2->arrayParameter = array('POID' => $rs['POID'], 'PODate' => convertMysqlToThaiDate($rs['PODate']), 'PONum' => $rs['PONum'], 'PRType' => $rs['PRType']
        , 'POType' => $rs['POType'], 'POStatus' => $rs['POStatusDes'], 'POContID' => $rs['POContID'], 'PODueDate' => convertMysqlToThaiDate($rs['PODueDate']),
        'PRExpectDate' => $rs['PRExpectDate'], 'VendorID' => $rs['VendorID'], 'VenderName' => $rs['VenderName']);
    $PHPJasperXML2->xml_dismantle($xml2);
    $PHPJasperXML2->transferDBtoArray($server, $user, $pass, $db);
    $PHPJasperXML2->outpage("F", "../uploads/PO1.pdf");
}
?>

