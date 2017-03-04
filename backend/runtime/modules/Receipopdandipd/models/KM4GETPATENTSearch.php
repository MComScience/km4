<?php

namespace app\modules\Receipopdandipd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Receipopdandipd\models\KM4GETPATENT;

/**
 * KM4GETPATENTSearch represents the model behind the search form about `app\modules\Receipopdandipd\models\KM4GETPATENT`.
 */
class KM4GETPATENTSearch extends KM4GETPATENT
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PT_MAININSCL_ID', 'PT_PURCHASEPROVINCE_ID', 'PT_HOSPITAL_NUMBER'], 'integer'],
            [['PT_INSCLCARD_ID', 'PT_INSCLCARD_STARTDATE', 'PT_INSCLCARD_EXPDATE', 'PT_SCL_UPDATE_DATE', 'PT_SCL_UPDATE_TIME'], 'safe'],
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
        $query = KM4GETPATENT::find();

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
            'PT_MAININSCL_ID' => $this->PT_MAININSCL_ID,
            'PT_PURCHASEPROVINCE_ID' => $this->PT_PURCHASEPROVINCE_ID,
            'PT_SCL_UPDATE_DATE' => $this->PT_SCL_UPDATE_DATE,
            'PT_SCL_UPDATE_TIME' => $this->PT_SCL_UPDATE_TIME,
            'PT_HOSPITAL_NUMBER' => $this->PT_HOSPITAL_NUMBER,
        ]);

        $query->andFilterWhere(['like', 'PT_INSCLCARD_ID', $this->PT_INSCLCARD_ID])
            ->andFilterWhere(['like', 'PT_INSCLCARD_STARTDATE', $this->PT_INSCLCARD_STARTDATE])
            ->andFilterWhere(['like', 'PT_INSCLCARD_EXPDATE', $this->PT_INSCLCARD_EXPDATE]);

        return $dataProvider;
    }
}
