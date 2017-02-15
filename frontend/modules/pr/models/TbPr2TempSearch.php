<?php

namespace app\modules\pr\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pr\models\TbPr2Temp;

/**
 * TbPr2TempSearch represents the model behind the search form about `app\modules\pr\models\TbPr2Temp`.
 */
class TbPr2TempSearch extends TbPr2Temp {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['PRID', 'DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID', 'PRExpectDate', 'VendorID', 'PRStatusID', 'PRApprovalID', 'PRRejectID', 'PRStatus', 'ids_PR_selected', 'PRbudgetID'], 'integer'],
                [['PRNum', 'PRDate', 'PRReasonNote', 'POContactNum', 'PRSubtotal', 'PRVat', 'PRTotal', 'PRSummitted', 'PRSummitedBy', 'PRSummitedDate', 'PRSummitedTime', 'PRCreatedBy', 'PRCreatedDate', 'PRCreatedTime', 'PRRejectDate', 'PRApprovaDate', 'PRApprovatime', 'PRRejectReason', 'PRRejectTime', 'PCPlanNum', 'PRVerifyNote', 'q'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = TbPr2Temp::find()
                ->select(['PRNum', 'PRDate', 'PRID', 'tb_pr2_temp.PRTypeID', 'tb_pr2_temp.POTypeID', 'PRExpectDate', 'PRStatusID', 'CONVERT(SUBSTRING_INDEX((SUBSTRING_INDEX(tb_pr2_temp.PRNum,"/",1)),"ย",-1), UNSIGNED INTEGER) AS N'])
                ->leftJoin('tb_potype', '`tb_potype`.`POTypeID` = `tb_pr2_temp`.`POTypeID`')
                ->leftJoin('tb_prtype', '`tb_prtype`.`PRTypeID` = `tb_pr2_temp`.`PRTypeID`')
                //->where(['in','tb_pr2_temp.PRTypeID', [1,2,3,4,5]])
                ->orderBy('N ASC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'PRID' => $this->PRID,
            'PRDate' => $this->PRDate,
            'DepartmentID' => $this->DepartmentID,
            'SectionID' => $this->SectionID,
            'PRTypeID' => $this->PRTypeID,
            'POTypeID' => $this->POTypeID,
            'PRExpectDate' => $this->PRExpectDate,
            'VendorID' => $this->VendorID,
            'PRStatusID' => $this->PRStatusID,
            'PRApprovalID' => $this->PRApprovalID,
            'PRRejectID' => $this->PRRejectID,
            'PRCreatedTime' => $this->PRCreatedTime,
            'PRRejectDate' => $this->PRRejectDate,
            'PRApprovaDate' => $this->PRApprovaDate,
            'PRApprovatime' => $this->PRApprovatime,
            'PRStatus' => $this->PRStatus,
            'PRRejectTime' => $this->PRRejectTime,
            'ids_PR_selected' => $this->ids_PR_selected,
            'PRbudgetID' => $this->PRbudgetID,
        ]);

        $query->orFilterWhere(['like', 'PRNum', $this->q])
                //->orFilterWhere(['like', 'PRDate', $this->q])
                //->orFilterWhere(['like', 'PRVerifyNote', $this->q])
                ->orFilterWhere(['like', 'PRExpectDate', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->orFilterWhere(['like', 'tb_prtype.PRType', $this->q])
                ->andWhere(['tb_pr2_temp.PRTypeID' => [1,2,3,4,5]]);

        return $dataProvider;
    }

}
