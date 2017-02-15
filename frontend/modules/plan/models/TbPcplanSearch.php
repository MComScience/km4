<?php

namespace app\modules\plan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\plan\models\TbPcplan;

/**
 * TbPcplanSearch represents the model behind the search form about `app\modules\plan\models\TbPcplan`.
 */
class TbPcplanSearch extends TbPcplan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCPlanNum', 'PCPOContactID', 'PCPlanDate', 'DepartmentID', 'SectionID', 'PCPlanBeginDate', 'PCPlanEndDate', 'PCPlanCreatedDate', 'PCPlanCreatedTime', 'PCVendorID', 'PCPlanApproveDate', 'PCPlanApproveTime', 'PCPlanManagerApproveDate', 'PCPlanManagerApproveTime'], 'safe'],
            [['PCPlanTypeID', 'PCPlanStatusID', 'PCPlanCreatedBy', 'Pcplandrugandnondrug', 'PCPlanApproveBy', 'PCPlanManagerApproveBy'], 'integer'],
            [['PCPlanTotal'], 'number'],
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
        $query = TbPcplan::find();

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
            'PCPlanDate' => $this->PCPlanDate,
            'PCPlanTypeID' => $this->PCPlanTypeID,
            'PCPlanBeginDate' => $this->PCPlanBeginDate,
            'PCPlanEndDate' => $this->PCPlanEndDate,
            'PCPlanStatusID' => $this->PCPlanStatusID,
            'PCPlanCreatedBy' => $this->PCPlanCreatedBy,
            'PCPlanCreatedDate' => $this->PCPlanCreatedDate,
            'PCPlanCreatedTime' => $this->PCPlanCreatedTime,
            'Pcplandrugandnondrug' => $this->Pcplandrugandnondrug,
            'PCPlanTotal' => $this->PCPlanTotal,
            'PCPlanApproveBy' => $this->PCPlanApproveBy,
            'PCPlanApproveDate' => $this->PCPlanApproveDate,
            'PCPlanApproveTime' => $this->PCPlanApproveTime,
            'PCPlanManagerApproveBy' => $this->PCPlanManagerApproveBy,
            'PCPlanManagerApproveDate' => $this->PCPlanManagerApproveDate,
            'PCPlanManagerApproveTime' => $this->PCPlanManagerApproveTime,
        ]);

        $query->andFilterWhere(['like', 'PCPlanNum', $this->PCPlanNum])
            ->andFilterWhere(['like', 'PCPOContactID', $this->PCPOContactID])
            ->andFilterWhere(['like', 'DepartmentID', $this->DepartmentID])
            ->andFilterWhere(['like', 'SectionID', $this->SectionID])
            ->andFilterWhere(['like', 'PCVendorID', $this->PCVendorID]);

        return $dataProvider;
    }
}
