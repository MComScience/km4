<?php

namespace app\modules\Receipopdandipd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Receipopdandipd\models\KM4GETPTADMIT;

/**
 * KM4GETPTADMITSearch represents the model behind the search form about `app\modules\Receipopdandipd\models\KM4GETPTADMIT`.
 */
class KM4GETPTADMITSearch extends KM4GETPTADMIT
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PT_HOSPITAL_NUMBER', 'PT_TITLENAME_ID', 'PT_SEX_ID', 'PT_NATION_ID'], 'integer'],
            [['PT_FNAME_TH', 'PT_LNAME_TH', 'PT_DOB', 'PT_CID', 'PT_ADMISSION_NUMBER', 'PT_REGISTRY_DATE', 'PT_REGISTRY_TIME', 'PT_REGISTRY_BY', 'PT_SERVICE_SECTION_ID', 'PT_SERVICE_FROM_SECTION_ID'], 'safe'],
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
        $query = KM4GETPTADMIT::find();

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
            'PT_HOSPITAL_NUMBER' => $this->PT_HOSPITAL_NUMBER,
            'PT_TITLENAME_ID' => $this->PT_TITLENAME_ID,
            'PT_DOB' => $this->PT_DOB,
            'PT_SEX_ID' => $this->PT_SEX_ID,
            'PT_NATION_ID' => $this->PT_NATION_ID,
            'PT_REGISTRY_DATE' => $this->PT_REGISTRY_DATE,
            'PT_REGISTRY_TIME' => $this->PT_REGISTRY_TIME,
        ]);

        $query->andFilterWhere(['like', 'PT_FNAME_TH', $this->PT_FNAME_TH])
            ->andFilterWhere(['like', 'PT_LNAME_TH', $this->PT_LNAME_TH])
            ->andFilterWhere(['like', 'PT_CID', $this->PT_CID])
            ->andFilterWhere(['like', 'PT_ADMISSION_NUMBER', $this->PT_ADMISSION_NUMBER])
            ->andFilterWhere(['like', 'PT_REGISTRY_BY', $this->PT_REGISTRY_BY])
            ->andFilterWhere(['like', 'PT_SERVICE_SECTION_ID', $this->PT_SERVICE_SECTION_ID])
            ->andFilterWhere(['like', 'PT_SERVICE_FROM_SECTION_ID', $this->PT_SERVICE_FROM_SECTION_ID]);

        return $dataProvider;
    }
}
