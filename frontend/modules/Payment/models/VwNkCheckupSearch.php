<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwNkCheckup;

/**
 * VwNkCheckupSearch represents the model behind the search form about `app\modules\Payment\models\VwNkCheckup`.
 */
class VwNkCheckupSearch extends VwNkCheckup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nk_checkup_id', 'HN_NO', 'PT_Right', 'AGE'], 'integer'],
            [['VISIT_DATE', 'VISIT_SEQ', 'HN_ID_NO', 'FULLNAME', 'SEX', 'PROJECT_CODE', 'PROJECT_NAME', 'import_by', 'import_date'], 'safe'],
            [['NOTPAY'], 'number'],
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
        $query = VwNkCheckup::find();

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
            'nk_checkup_id' => $this->nk_checkup_id,
            'HN_NO' => $this->HN_NO,
            'VISIT_DATE' => $this->VISIT_DATE,
            'PT_Right' => $this->PT_Right,
            'AGE' => $this->AGE,
            'NOTPAY' => $this->NOTPAY,
            'import_date' => $this->import_date,
        ]);

        $query->andFilterWhere(['like', 'VISIT_SEQ', $this->VISIT_SEQ])
            ->andFilterWhere(['like', 'HN_ID_NO', $this->HN_ID_NO])
            ->andFilterWhere(['like', 'FULLNAME', $this->FULLNAME])
            ->andFilterWhere(['like', 'SEX', $this->SEX])
            ->andFilterWhere(['like', 'PROJECT_CODE', $this->PROJECT_CODE])
            ->andFilterWhere(['like', 'PROJECT_NAME', $this->PROJECT_NAME])
            ->andFilterWhere(['like', 'import_by', $this->import_by]);

        return $dataProvider;
    }
}
