<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\Html;

class Report extends Component {

    public function footer($size) {
        $size = empty($size) ? '12' : $size;
        $year = date('Y') + 543;
        $table = '<table width="100%">
                    <tr>
                        <td class="text-left" width="50%" style="font-size:' . $size . 'pt;">
                        ' . \Yii::$app->name . '
                        </td>
                        <td class="text-right" width="50%" style="font-size:' . $size . 'pt;">
                        ' . 'Print: ' . Yii::$app->formatter->asDate('now', 'dd/MM/') . $year . ' By ' . \Yii::$app->user->identity->profile->User_fname . ' ' . \Yii::$app->user->identity->profile->User_lname . '
                        </td>
                    </tr>
                  </table>';
        return $table;
    }

    function Genndsp($v) {
        for ($x = 0; $x < $v; $x++) {
            echo "&nbsp;";
        }
    }

    public function logo($type, $width, $height) {
        if ($type == 'ครุฑ') {
            echo Html::img('images/logo_iop_doc.jpg', ['width' => $width, 'height' => $height]);
        }
        if ($type == 'แนวนอน') {
            echo Html::img('images/logocrop.png', ['width' => $width, 'height' => $height]);
        }
        if ($type == 'แนวตั้ง') {
            
        }
    }

}
