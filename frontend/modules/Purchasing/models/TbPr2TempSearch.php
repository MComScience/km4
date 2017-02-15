<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\TbPr2Temp;

/**
 * TbPr2TempSearch represents the model behind the search form about `app\modules\Purchasing\models\TbPr2Temp`.
 */
class TbPr2TempSearch extends TbPr2Temp {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['PRID', 'DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID', 'POContactNum', 'VendorID', 'PRStatusID', 'PRApprovalID', 'PRRejectID', 'PRStatus', 'ids_PR_selected'], 'integer'],
            [['PRNum', 'PRDate', 'PRReasonNote', 'PRExpectDate', 'PRSubtotal', 'PRVat', 'PRTotal', 'PRSummitted', 'PRSummitedBy', 'PRSummitedDate', 'PRSummitedTime', 'PRCreatedBy', 'PRCreatedDate', 'PRCreatedTime', 'PRRejectDate', 'PRApprovaDate', 'PRApprovatime', 'PRRejectReason', 'PRRejectTime', 'PCPlanNum', 'q'], 'safe'],
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
        $query = TbPr2Temp::find();
        //->where(['POTypeID' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('prtype');
        $query->joinWith('potype');
        $query->joinWith('prstatus');

        $query->andFilterWhere([
            'PRID' => $this->PRID,
            'PRDate' => $this->PRDate,
            'DepartmentID' => $this->DepartmentID,
            'SectionID' => $this->SectionID,
            'PRTypeID' => $this->PRTypeID,
            'POTypeID' => $this->POTypeID,
            'POContactNum' => $this->POContactNum,
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
        ]);

        $query->orFilterWhere(['like', 'PRNum', $this->q])
                ->orFilterWhere(['like', 'PRReasonNote', $this->q])
                ->orFilterWhere(['like', 'PRSubtotal', $this->q])
                ->orFilterWhere(['like', 'PRVat', $this->q])
                ->orFilterWhere(['like', 'PRTotal', $this->q])
                ->orFilterWhere(['like', 'PRSummitted', $this->q])
                ->orFilterWhere(['like', 'PRSummitedBy', $this->q])
                ->orFilterWhere(['like', 'PRSummitedDate', $this->q])
                ->orFilterWhere(['like', 'PRSummitedTime', $this->q])
                ->orFilterWhere(['like', 'PRCreatedBy', $this->q])
                ->orFilterWhere(['like', 'PRCreatedDate', $this->q])
                ->orFilterWhere(['like', 'PRRejectReason', $this->q])
                ->orFilterWhere(['like', 'PCPlanNum', $this->q])
                ->orFilterWhere(['like', 'tb_prstatus.PRStatus', $this->q])
                ->orFilterWhere(['like', 'tb_prtype.PRType', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->andWhere(['tb_prtype.PRTypeID' => array(1,2,3,4,5)]);

        return $dataProvider;
    }

    public function SearchNewPR($params) {
        $query = TbPr2Temp::find();
        //->where(['POTypeID' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('prtype');
        $query->joinWith('potype');
        $query->joinWith('prstatus');

        $query->andFilterWhere([
            'PRID' => $this->PRID,
            'PRDate' => $this->PRDate,
            'DepartmentID' => $this->DepartmentID,
            'SectionID' => $this->SectionID,
            'PRTypeID' => $this->PRTypeID,
            'POTypeID' => $this->POTypeID,
            'POContactNum' => $this->POContactNum,
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
        ]);

        $query->orFilterWhere(['like', 'PRNum', $this->q])
                ->orFilterWhere(['like', 'PRReasonNote', $this->q])
                ->orFilterWhere(['like', 'PRSubtotal', $this->q])
                ->orFilterWhere(['like', 'PRVat', $this->q])
                ->orFilterWhere(['like', 'PRTotal', $this->q])
                ->orFilterWhere(['like', 'PRSummitted', $this->q])
                ->orFilterWhere(['like', 'PRSummitedBy', $this->q])
                ->orFilterWhere(['like', 'PRSummitedDate', $this->q])
                ->orFilterWhere(['like', 'PRSummitedTime', $this->q])
                ->orFilterWhere(['like', 'PRCreatedBy', $this->q])
                ->orFilterWhere(['like', 'PRCreatedDate', $this->q])
                ->orFilterWhere(['like', 'PRRejectReason', $this->q])
                ->orFilterWhere(['like', 'PCPlanNum', $this->q])
                ->orFilterWhere(['like', 'tb_prstatus.PRStatus', $this->q])
                ->orFilterWhere(['like', 'tb_prtype.PRType', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->andWhere(['tb_prtype.PRTypeID' => array(6,7,8)]);

        return $dataProvider;
    }

}
