<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TbPcplan;

/**
 * TbPcplanSearch represents the model behind the search form about `app\models\TbPcplan`.
 */
class TbPcplanSearch2 extends TbPcplan2 {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['PCPlanNum', 'PCPlanDate', 'PCPlanBeginDate', 'PCPlanEndDate', 'PCPlanCreatedDate', 'PCPlanCreatedTime', 'Pcplandrugandnondrug', 'q'], 'safe'],
            [['DepartmentID', 'SectionID', 'PCPlanTypeID', 'PCPlanStatusID', 'PCPlanCreatedBy'], 'integer'],
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
        $query = TbPcplan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        /* $query->andFilterWhere([
          'PCPlanDate' => $this->PCPlanDate,
          'DepartmentID' => $this->DepartmentID,
          'SectionID' => $this->SectionID,
          'PCPlanTypeID' => $this->PCPlanTypeID,
          'PCPlanBeginDate' => $this->PCPlanBeginDate,
          'PCPlanEndDate' => $this->PCPlanEndDate,
          'PCPlanStatusID' => $this->PCPlanStatusID,
          'PCPlanCreatedBy' => $this->PCPlanCreatedBy,
          'PCPlanCreatedDate' => $this->PCPlanCreatedDate,
          'PCPlanCreatedTime' => $this->PCPlanCreatedTime,
          ]); */

        $query->orFilterWhere(['PCPlanNum' => $this->q])->andWhere(['Pcplandrugandnondrug' => '4'])->andWhere(['PCPlanStatusID' => ['1', '2', '4', '5','6']]);

        return $dataProvider;
    }

    public function search2($params) {
        $query = TbPcplan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        /* $query->andFilterWhere([
          'PCPlanDate' => $this->PCPlanDate,
          'DepartmentID' => $this->DepartmentID,
          'SectionID' => $this->SectionID,
          'PCPlanTypeID' => $this->PCPlanTypeID,
          'PCPlanBeginDate' => $this->PCPlanBeginDate,
          'PCPlanEndDate' => $this->PCPlanEndDate,
          'PCPlanStatusID' => $this->PCPlanStatusID,
          'PCPlanCreatedBy' => $this->PCPlanCreatedBy,
          'PCPlanCreatedDate' => $this->PCPlanCreatedDate,
          'PCPlanCreatedTime' => $this->PCPlanCreatedTime,
          ]); */

        $query->orFilterWhere(['PCPlanNum' => $this->q])->andWhere(['Pcplandrugandnondrug' => '5'])->andWhere(['PCPlanStatusID' => ['1', '2', '4', '5']]);

        return $dataProvider;
    }

}
