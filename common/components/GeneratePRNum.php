<?php

namespace common\components;

use Yii;
use yii\base\Component;
use app\modules\pr\models\TbPr2;
use app\modules\pr\models\TbPr2Temp;

class GeneratePRNum extends Component {

    public function generatePRNum($PRTypeID) {
        //sleep(1);#sleep for 1 seconds
        $Y = substr((Yii::$app->formatter->asDate('now', 'yyyy') + 543), 2); #Now year + 543 and substr

        $modelPr2 = TbPr2::find()
                ->select(['PRNum'])
                ->where('PRNum LIKE :query')
                ->addParams([':query' => $this->getStrLike($PRTypeID)])
                ->all(); #select PRNum from tb_pr2 
        $modelPr2temp = TbPr2Temp::find()
                ->select(['PRNum'])
                ->where('PRNum LIKE :query')
                ->addParams([':query' => $this->getStrLike($PRTypeID)])
                ->all(); #select PRNum from tb_pr2_temp
        #loop tb_pr2
        foreach ($modelPr2 as $value) {
            $CountStr = strlen(substr($value['PRNum'], $this->getStr1($PRTypeID)));
            $maxPRNum[] = substr($value['PRNum'], $this->getStr1($PRTypeID), $this->getStr2($CountStr)); # จาก ย.1/59 เหลือ 1/59
        }
        #loop tb_st2_temp
        foreach ($modelPr2temp as $value) {
            $CountStr = strlen(substr($value['PRNum'], $this->getStr1($PRTypeID)));
            $maxPRNumtmp[] = substr($value['PRNum'], $this->getStr1($PRTypeID), $this->getStr2($CountStr));
        }

        $PRNumMax = empty($maxPRNum) ? '' : max($maxPRNum); #get max value in array
        $PRNumMaxtmp = empty($maxPRNumtmp) ? '' : max($maxPRNumtmp); #get max value in array

        $PRNum = null;
        if ($PRNumMax > $PRNumMaxtmp) {
            $PRNum = $this->CerrentTitle($PRTypeID) . ($PRNumMax + 1) . '/' . $Y;
        }
        if ($PRNumMaxtmp > $PRNumMax) {
            $PRNum = $this->CerrentTitle($PRTypeID) . ($PRNumMaxtmp + 1) . '/' . $Y;
        }
        if ($PRNumMax == $PRNumMaxtmp) {
            $PRNum = $this->CerrentTitle($PRTypeID) . '1' . '/' . $Y;
        }
        return $PRNum;
    }

    function CerrentTitle($PRTypeID) {
        switch (true) {
            case $PRTypeID == "1" || $PRTypeID == "2":
                $title = 'ย.';
                break;
            case $PRTypeID == '3':
                $title = "วชย.";
                break;
            case $PRTypeID == "4" || $PRTypeID == "5":
                $title = "ส.";
                break;
            case $PRTypeID == "6" || $PRTypeID == "7" || $PRTypeID == "8":
                $title = "ขอ.";
                break;
            default:
                $title = "";
        }
        return $title;
    }

    function getStr1($PRTypeID) {
        switch (true) {
            case $PRTypeID == "1" || $PRTypeID == "2" || $PRTypeID == "4" || $PRTypeID == "5":
                $Num = '4';
                break;
            case $PRTypeID == "3":
                $Num = '10';
                break;
            case $PRTypeID == "6" || $PRTypeID == "7" || $PRTypeID == "8":
                $Num = '7';
                break;
        }
        return $Num;
    }

    function getStr2($CountStr) {
        $Num = null;
        switch (true) {
            case $CountStr == "4":
                $Num = '1';
                break;
            case $CountStr == '5':
                $Num = '2';
                break;
            case $CountStr == '6':
                $Num = '3';
                break;
            case $CountStr == '7':
                $Num = '4';
                break;
            case $CountStr == '8':
                $Num = '5';
                break;
            case $CountStr == '9':
                $Num = '6';
                break;
            case $CountStr == '10':
                $Num = '7';
                break;
        }
        return $Num;
    }

    function getStrLike($PRTypeID) {
        switch (true) {
            case $PRTypeID == "1" || $PRTypeID == "2":
                $str = 'ย.%';
                break;
            case $PRTypeID == "3":
                $str = 'วชย.%';
                break;
            case $PRTypeID == "4" || $PRTypeID == "5":
                $str = 'ส.%';
                break;
            case $PRTypeID == "6" || $PRTypeID == "7" || $PRTypeID == "8":
                $str = 'ขอ.%';
                break;
        }
        return $str;
    }

}
