<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\TbPo2Temp;

/**
 * TbPo2TempSearch represents the model behind the search form about `app\modules\Purchasing\models\TbPo2Temp`.
 */
class TbPo2TempSearch extends TbPo2Temp
{
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POID', 'DepartmentID', 'SectionID', 'POContID', 'POTypeID', 'POStatus', 'POCreateBy', 'POVerifyBy', 'PORejectVerifyBy', 'PORejectApproveBy', 'PRTypeID'], 'integer'],
            [['PONum', 'PRNum', 'PODate', 'PODueDate', 'VendorID', 'POSubtotal', 'POVat', 'POTotal', 'POCreateDate', 'POCreateTime', 'POVerifyDate', 'POApproveBy', 'POApproveDate', 'PORejectVerifyDate', 'PORejectApproveDate', 'PCPlanNum','q'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = TbPo2Temp::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'POID' => $this->POID,
            'PODate' => $this->PODate,
            'DepartmentID' => $this->DepartmentID,
            'SectionID' => $this->SectionID,
            'POContID' => $this->POContID,
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

        $query->orFilterWhere(['like', 'PONum', $this->PONum])
            ->orFilterWhere(['like', 'PRNum', $this->PRNum])
            ->orFilterWhere(['like', 'VendorID', $this->VendorID])
            ->orFilterWhere(['like', 'POSubtotal', $this->POSubtotal])
            ->orFilterWhere(['like', 'POVat', $this->POVat])
            ->orFilterWhere(['like', 'POTotal', $this->POTotal])
            ->orFilterWhere(['like', 'POApproveBy', $this->POApproveBy])
            ->orFilterWhere(['like', 'PCPlanNum', $this->PCPlanNum]);

        return $dataProvider;
    }
    
    public function searchdetaildraft($params)
    {
        $query = TbPo2Temp::find()->where(['POStatus' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'POID' => $this->POID,
            'PODate' => $this->PODate,
            'DepartmentID' => $this->DepartmentID,
            'SectionID' => $this->SectionID,
            'POContID' => $this->POContID,
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
            ->orFilterWhere(['like', 'PRNum', $this->q])
            ->orFilterWhere(['like', 'VendorID', $this->q])
            ->orFilterWhere(['like', 'POSubtotal', $this->q])
            ->orFilterWhere(['like', 'POVat', $this->q])
            ->orFilterWhere(['like', 'POTotal', $this->q])
            ->orFilterWhere(['like', 'POApproveBy', $this->q])
            ->orFilterWhere(['like', 'PCPlanNum', $this->q]);

        return $dataProvider;
    }
}
