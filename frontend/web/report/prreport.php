<?php

if ($_GET['en'] == 'Anjkmaloodd4214') {
    include('class/tcpdf/tcpdf.php');
    include("class/PHPJasperXML.inc.php");
    include('setting.php');
    error_reporting();
    $id = $_GET['id'];
    $conn = new mysqli($server, $user, $pass, $db);
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * from vw_pr2_header2 where PRID = $id";
    $result = $conn->query($sql);
    $rs = $result->fetch_assoc();
    $xml = simplexml_load_file("prreport.jrxml");
    $PHPJasperXML = new PHPJasperXML();
    $PHPJasperXML->arrayParameter = array('SRID' => $rs['PRID'], 'PRDate' => convertMysqlToThaiDate($rs['PRDate']), 'PRNum' => $rs['PRNum'], 'PRType' => $rs['PRType']
        , 'POType' => $rs['POType'], 'PRStatus' => $rs['PRStatus'], 'DepartmentDesc' => $rs['DepartmentDesc']
        , 'SectionDecs' => $rs['SectionDecs'], 'POContactNum' => $rs['POContactNum'],
        'PRExpectDate' => convertMysqlToThaiDate($rs['PRExpectDate']), 'PRReasonNote' => $rs['PRReasonNote']);
    $PHPJasperXML->xml_dismantle($xml);
    $PHPJasperXML->transferDBtoArray($server, $user, $pass, $db);
    $PHPJasperXML->outpage("I");
}
?>