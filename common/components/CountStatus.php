<?php

namespace common\components;
use app\modules\pr\models\TbPr2Temp;
use app\modules\pr\models\TbPr2;
use app\modules\po\models\TbPo2;
use app\modules\po\models\TbPo2Temp;
use app\modules\Inventory\models\VwSaList;
use app\modules\pr\models\TbPcplan;

use yii\base\Component;

class CountStatus extends Component {

    public function CountPrTemp($StatusID) {
        return TbPr2Temp::find()->where(['PRStatusID' => $StatusID])->andWhere(['in','PRTypeID',[1,2,3,4,5]])->count('PRID');
    }
    
    public function CountPr($StatusID){
        return TbPr2::find()->where(['PRStatusID' => $StatusID])->count('PRID');
    }
    
    public function CountPoTemp($StatusID){
        return TbPo2Temp::find()->where(['POStatus' => $StatusID])->count('POID');
    }
    
    public function CountPo($StatusID){
        return TbPo2::find()->where(['POStatus' => $StatusID])->count('POID');
    }
    
    public function CountSalist($StatusID){
        return VwSaList::find()->where(['SAStatus' => $StatusID])->count('SAID');
    }
    
    public function CountPlan($StatusID){
        return TbPcplan::find()->where(['PCPlanStatusID' => $StatusID])->count('PCPlanStatusID');
    }

}

?>
