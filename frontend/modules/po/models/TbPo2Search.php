<?php

namespace app\modules\po\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\po\models\TbPo2;

/**
 * TbPo2Search represents the model behind the search form about `app\modules\po\models\TbPo2`.
 */
class TbPo2Search extends TbPo2 {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['POID', 'DepartmentID', 'SectionID', 'POTypeID', 'POStatus', 'POCreateBy', 'POVerifyBy', 'PORejectVerifyBy', 'PORejectApproveBy', 'PRTypeID'], 'integer'],
                [['PONum', 'PRNum', 'PODate', 'POContID', 'PODueDate', 'VendorID', 'POSubtotal', 'POVat', 'POTotal', 'POCreateDate', 'POCreateTime', 'POVerifyDate', 'POApproveBy', 'POApproveDate', 'PORejectVerifyDate', 'PORejectApproveDate', 'PCPlanNum', 'PORejectReason', 'PORejfromAppNote', 'Menu_VendorID', 'q'], 'safe'],
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
    public function search($params, $status) {
        $query = TbPo2::find()
                ->select(['PONum', 'PODate', 'POID', 'tb_po2.POTypeID', 'tb_po2.POStatus', 'PODueDate','CONVERT(SUBSTRING_INDEX((SUBSTRING_INDEX(tb_po2.PONum,"/",1)),"ย",-1), UNSIGNED INTEGER) AS N'])
                ->leftJoin('tb_potype', '`tb_potype`.`POTypeID` = `tb_po2`.`POTypeID`')
                ->leftJoin('tb_postatus', '`tb_postatus`.`POStatusID` = `tb_po2`.`POStatus`')
                ->orderBy('N ASC');
        ;

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
            'POID' => $this->POID,
            'PODate' => $this->PODate,
            'DepartmentID' => $this->DepartmentID,
            'SectionID' => $this->SectionID,
            'POTypeID' => $this->POTypeID,
            'PODueDate' => $this->PODueDate,
            'POStatus' => $this->POStatus,
            'POCreateBy' => $this->POCreateBy,
            'POCreateDate' => $this->POCreateDate,
            'POCreateTime' => $this->POCreateTime,
            'POVerifyBy' => $this->POVerifyBy,
            'POVerifyDate' => $this->POVerifyDate,
            'POApproveDate' => $this->POApproveDate,
            'PORejectVerifyBy' => $this->PORejectVerifyBy,
            'PORejectVerifyDate' => $this->PORejectVerifyDate,
            'PORejectApproveBy' => $this->PORejectApproveBy,
            'PORejectApproveDate' => $this->PORejectApproveDate,
            'PRTypeID' => $this->PRTypeID,
        ]);

        $query->orFilterWhere(['like', 'PONum', $this->q])
                //->orFilterWhere(['like', 'PODueDate', $this->q])
                ->orFilterWhere(['like', 'tb_potype.POType', $this->q])
                ->orFilterWhere(['like', 'tb_postatus.POStatusDes', $this->q])
                ->andWhere(['POStatus' => $status]);

        return $dataProvider;
    }

}
