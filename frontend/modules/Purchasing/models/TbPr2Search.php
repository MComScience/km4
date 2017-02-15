<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\TbPr2;

/**
 * TbPr2Search represents the model behind the search form about `app\modules\Purchasing\models\TbPr2`.
 */
class TbPr2Search extends TbPr2 {

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
        $query = TbPr2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['PRID'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('prtype');

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
                ->orFilterWhere(['like', 'tb_prtype.PRType', $this->q]);

        return $dataProvider;
    }

    public function SearchDetailVerify($params) {
        $query = TbPr2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['PRID'=>SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('prtype');
        $query->joinWith('potype');

//        $query->andFilterWhere([
//            'PRID' => $this->PRID,
//            'PRDate' => $this->PRDate,
//            'DepartmentID' => $this->DepartmentID,
//            'SectionID' => $this->SectionID,
//            'PRTypeID' => $this->PRTypeID,
//            'POTypeID' => $this->POTypeID,
//            'POContactNum' => $this->POContactNum,
//            'PRExpectDate' => $this->PRExpectDate,
//            'VendorID' => $this->VendorID,
//            'PRStatusID' => $this->PRStatusID,
//            'PRApprovalID' => $this->PRApprovalID,
//            'PRRejectID' => $this->PRRejectID,
//            'PRCreatedTime' => $this->PRCreatedTime,
//            'PRRejectDate' => $this->PRRejectDate,
//            'PRApprovaDate' => $this->PRApprovaDate,
//            'PRApprovatime' => $this->PRApprovatime,
//            'PRStatus' => $this->PRStatus,
//            'PRRejectTime' => $this->PRRejectTime,
//            'ids_PR_selected' => $this->ids_PR_selected,
//        ]);

        $query->orFilterWhere(['like', 'PRNum', $this->q])
                ->orFilterWhere(['like', 'PRReasonNote', $this->q])
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
                ->orFilterWhere(['like', 'tb_prtype.PRType', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->andWhere(['PRStatusID' =>array(2)]);

        return $dataProvider;
    }
    
    public function SearchDetailApprove($params) {
        $query = TbPr2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['PRID'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('prtype');
        $query->joinWith('potype');

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
                ->orFilterWhere(['like', 'tb_prtype.PRType', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->andWhere(['PRStatusID' => array(10)]);

        return $dataProvider;
    }
    
    public function SearchListApprove($params) {
        $query = TbPr2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['PRID'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //$query->joinWith('prtype');
        $query->joinWith('potype');

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
                //->orFilterWhere(['like', 'tb_prtype.PRType', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->andWhere(['PRStatusID' => array(11)]);

        return $dataProvider;
    }
    
    public function SearchListVerify($params) {
        $query = TbPr2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['PRID'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('prtype');
        $query->joinWith('potype');

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
                ->orFilterWhere(['like', 'tb_prtype.PRType', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->andWhere(['PRStatusID' => array(2)]);

        return $dataProvider;
    }
    
    public function SearchListWaitingApprove($params) {
        $query = TbPr2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['PRID'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('prtype');
        $query->joinWith('potype');

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
                ->orFilterWhere(['like', 'tb_prtype.PRType', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->andWhere(['PRStatusID' => array(10)]);

        return $dataProvider;
    }
    
    public function SearchListRejectVerify($params) {
        $query = TbPr2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['PRID'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('prtype');
        $query->joinWith('potype');

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
                ->orFilterWhere(['like', 'tb_prtype.PRType', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->andWhere(['PRStatusID' => array(4)]);

        return $dataProvider;
    }
    
    public function SearchListRejectApprove($params) {
        $query = TbPr2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['PRID'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('prtype');
        $query->joinWith('potype');

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
                ->orFilterWhere(['like', 'tb_prtype.PRType', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->andWhere(['PRStatusID' => array(6)]);

        return $dataProvider;
    }

}
