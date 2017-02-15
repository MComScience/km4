<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\AuthenticationandFinance\models\VwArList;

/**
 * VwArListSearch represents the model behind the search form about `app\modules\AuthenticationandFinance\models\VwArList`.
 */
class VwArListSearch extends VwArList
{
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_id'], 'integer'],
            [['ar_name', 'medical_right_desc', 'medical_right_group','q'], 'safe'],
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
        $query = VwArList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

     /*   $query->andFilterWhere([
            'ar_id' => $this->ar_id,
        ]);*/

        $query->orFilterWhere(['like', 'ar_name', $this->q])
            ->orFilterWhere(['like', 'medical_right_desc', $this->q])
            ->orFilterWhere(['like', 'medical_right_group', $this->q]);

        return $dataProvider;
    }
}
