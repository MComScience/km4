<?php

namespace app\modules\pr\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pr\models\TbPr2;

/**
 * TbPr2Search represents the model behind the search form about `app\modules\pr\models\TbPr2`.
 */
class TbPr2Search extends TbPr2 {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['PRID', 'DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID', 'PRExpectDate', 'VendorID', 'PRStatusID', 'PRApprovalID', 'PRRejectID', 'PRStatus', 'ids_PR_selected', 'PRbudgetID'], 'integer'],
            [['PRNum', 'PRDate', 'PRReasonNote', 'POContactNum', 'PRSubtotal', 'PRVat', 'PRTotal', 'PRSummitted', 'PRSummitedBy', 'PRSummitedDate', 'PRSummitedTime', 'PRCreatedBy', 'PRCreatedDate', 'PRCreatedTime', 'PRRejectDate', 'PRApprovaDate', 'PRApprovatime', 'PRRejectReason', 'PRRejectTime', 'PCPlanNum', 'PRVerifyNote', 'q','N'], 'safe'],
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
    public function search($params, $Status) {
        $query = TbPr2::find()
                ->select(['PRNum', 'PRDate', 'PRID', 'tb_pr2.PRTypeID', 'tb_pr2.POTypeID', 'PRExpectDate', 'PRStatusID', 'CONVERT(SUBSTRING_INDEX((SUBSTRING_INDEX(tb_pr2.PRNum,"/",1)),"ย",-1), UNSIGNED INTEGER) AS N'])
                ->leftJoin('tb_potype', '`tb_potype`.`POTypeID` = `tb_pr2`.`POTypeID`')
                ->leftJoin('tb_prtype', '`tb_prtype`.`PRTypeID` = `tb_pr2`.`PRTypeID`')
                ->orderBy('N ASC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            /*'sort' => [
                'defaultOrder' => [
                    'N' => SORT_DESC,
                ]
            ],*/
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->orFilterWhere([
            'PRID' => $this->PRID,
            'PRDate' => $this->PRDate,
            //'DepartmentID' => $this->DepartmentID,
            //'SectionID' => $this->SectionID,
            'PRTypeID' => $this->PRTypeID,
            'POTypeID' => $this->POTypeID,
            'PRExpectDate' => $this->PRExpectDate,
            //'VendorID' => $this->VendorID,
            'PRStatusID' => $this->PRStatusID,
                //'PRApprovalID' => $this->PRApprovalID,
                //'PRRejectID' => $this->PRRejectID,
                //'PRCreatedTime' => $this->PRCreatedTime,
                //'PRRejectDate' => $this->PRRejectDate,
                //'PRApprovaDate' => $this->PRApprovaDate,
                //'PRApprovatime' => $this->PRApprovatime,
                //'PRStatus' => $this->PRStatus,
                //'PRRejectTime' => $this->PRRejectTime,
                //'ids_PR_selected' => $this->ids_PR_selected,
                //'PRbudgetID' => $this->PRbudgetID,
        ]);

        $query->orFilterWhere(['like', 'PRNum', $this->q])
                // ->orFilterWhere(['like', 'PRStatusID', $this->q])
                //->orFilterWhere(['like', 'POContactNum', $this->q])
                //->orFilterWhere(['like', 'PRSubtotal', $this->q])
                //->orFilterWhere(['like', 'PRVat', $this->q])
                //->orFilterWhere(['like', 'PRTotal', $this->q])
                //->orFilterWhere(['like', 'PRSummitted', $this->q])
                //->orFilterWhere(['like', 'PRSummitedBy', $this->q])
                //->orFilterWhere(['like', 'PRSummitedDate', $this->q])
                //->orFilterWhere(['like', 'PRSummitedTime', $this->q])
                //->orFilterWhere(['like', 'PRCreatedBy', $this->q])
                //->orFilterWhere(['like', 'PRCreatedDate', $this->q])
                //->orFilterWhere(['like', 'PRRejectReason', $this->q])
                //->orFilterWhere(['like', 'PCPlanNum', $this->q])
                //->orFilterWhere(['like', 'PRDate', $this->q])
                //->orFilterWhere(['like', 'PRVerifyNote', $this->q])
                ->orFilterWhere(['like', 'PRExpectDate', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->orFilterWhere(['like', 'tb_prtype.PRType', $this->q])
                ->andWhere(['PRStatusID' => $Status]);

        return $dataProvider;
    }

}
