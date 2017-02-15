<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\bootstrap\Html;

class FinddataComponent extends Component {

 function setmessage($data) {
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode('Submission')),
            'message' => Yii::t('app', Html::encode($data)),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
    }
    function alertsave(){
        foreach (Yii::$app->session->getAllFlashes() as $message):; 
    
    echo \kartik\widgets\Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
        'showSeparator' => true,
        'delay' => 1, //This delay is how long before the message shows
        'pluginOptions' => [
            'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
            'placement' => [
                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
            ]
        ]
    ]);
    
 endforeach;
    }

    function finddatadetailpcplan($r) {
        $no = 1;
        $htl = "";
        $cost = 0;
        foreach ($r as $result) {
            $htl .='<tr>';
            $htl .= '<td align="center">' . $no . '</td>';
            $htl .= '<td align="center">' . $result['TMTID_GPU'] . '</td>';
            $htl .= '<td>' . $result['FSN_GPU'] . '</td>';
            $htl .= '<td align="right">' . number_format($result['GPUUnitCost'], 2) . '</td>';
            $htl .= '<td align="right">' . number_format($result['GPUOrderQty'], 2) . '</td>';
            $htl .= '<td align="center">' . $result['DispUnit'] . '</td>';
            $htl .= '<td align="right">' . number_format($result['GPUExtendedCost'], 2) . '</td>';
            $htl .='<td style="text-align:center"><a href="javascript:editlistdrugpcplan(' . $result['ids'] . ')"  class="btn btn-info btn-xs edit"> Edit</a> <a href="javascript:deletelistdrug(' . $result['ids'] . ')"  class="btn btn-danger btn-xs delete"> Delete</a></td>';
            $htl .='</tr>';
            $no++;
            $cost = $cost + ($result['GPUUnitCost'] * $result['GPUOrderQty']);
        }
        $htl .='</tbody><tfoot>
                            <tr>
                                <td colspan="3" style="background-color: #ddd;"></td>
                                <td colspan="3" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                               <td></td>
                            </tr>
                        </tfoot>
                    </table>';
        return $htl;
    }

    function finddatadetailplan($r) {
        $htl = "";
        $no = 1;
        $cost = 0;
        foreach ($r as $result) {
            $htl .='<tr>';
            $htl .= '<td align="center">' . $no . '</td>';
            //$htl .= '<td>' . $result['PCPlanNum'] . '</td>';
            $htl .= '<td align="center">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td align="right">' . number_format($result['PCPlanNDUnitCost'], 2) . '</td>';
            $htl .= '<td align="right">' . number_format($result['PCPlanNDQty'], 2) . '</td>';
            $htl .= '<td align="center">' . $result['DispUnit'] . '</td>';
            $htl .= '<td align="right">' . number_format($result['PCPlanNDExtendedCost'], 2) . '</td>';
            // $htl .= '<td>' . Yii::$app->componentdate->convertMysqlToThaiDate($result['PCPlanNonDrugItemEffectDate']) . '</td>';
            $htl .='<td align="center"><a href="javascript:editlistnondrug(' . $result['ids'] . ')"  class="btn btn-info btn-xs edit"> Edit</a> <a href="javascript:deletedetailnondrug(' . $result['ids'] . ')"  class="btn btn-danger btn-xs delete"> Delete</a></td>';
            $htl .='</tr>';
            $no++;
            $cost = $cost + ($result['PCPlanNDExtendedCost']);
        }
        $htl .='</tr></tbody><tfoot>
                            <tr>
                                <td colspan="4" style="background-color: #ddd;"></td>
                                <td colspan="2" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                               <td>
                               </td>
                            </tr>
                        </tfoot>
                    </table>';
        return $htl;
    }

    function finddatadetailplandrug($r) {
        $htl = "";
        $no = 1;
        $cost = 0;
        foreach ($r as $result) {
            $htl .='<tr>';
            $htl .= '<td align="center">' . $no . '</td>';
            $htl .= '<td align="center">' . $result['TMTID_TPU'] . '</td>';
            $htl .= '<td>' . $result['FSN_TMT'] . '</td>';
            $htl .= '<td align="right">' . number_format($result['TPUUnitCost'], 2) . '</td>';

            $htl .= '<td align="right">' . number_format($result['TPUOrderQty'], 2) . '</td>';
            $htl .= '<td align="center">' . $result['DispUnit'] . '</td>';
            $htl .= '<td align="right">' . number_format($result['TPUUnitCost'] * $result['TPUOrderQty'], 2) . '</td>';
            /// $htl .= '<td>' . Yii::$app->componentdate->convertMysqlToThaiDate($result['PCPlanItemEffectDate']) . '</td>';
            //  $htl .= '<td>' . $result['PCPlanGPUItemStatusID'] . '</td>';
            $htl .='<td style="text-align:center"><a href="javascript:editlistdrugpcplan(' . $result['ids'] . ')" class="btn btn-info btn-xs edit"> Edit</a> <a href="javascript:deletelistdrug(' . $result['ids'] . ')"  class="btn btn-danger btn-xs delete"> Delete</a></td>';
            $htl .='</tr>';
            $no++;
            $cost = $cost + ($result['TPUUnitCost'] * $result['TPUOrderQty']);
        }
        $htl .='</tbody><tfoot>
                            <tr>
                                <td colspan="3" style="background-color: #ddd;"></td>
                                <td colspan="3" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                               <td></td>
                            </tr>
                        </tfoot>
                    </table>';
        return $htl;
    }
 function statusplan($palnstatusid) {
        if ($palnstatusid == 1) {
            return 'Draft';
        } else if ($palnstatusid == 2) {
            return 'Active';
        } else if ($palnstatusid == 3) {
            return 'Delete';
        } else if ($palnstatusid == 4) {
            return 'Wait Approve';
        } else if ($palnstatusid== 5) {
            return 'Approve';
        }
    }
}
