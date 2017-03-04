<?php

namespace app\modules\Receipopdandipd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Receipopdandipd\models\KM4GETREFER;

/**
 * KM4GETREFERSearch represents the model behind the search form about `app\modules\Receipopdandipd\models\KM4GETREFER`.
 */
class KM4GETREFERSearch extends KM4GETREFER
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['REFER_HRECIEVE_DOC_ID', 'REFER_HRECIEVE_DOC_DATE', 'REFER_HSENDER_DOC_ID', 'DISEASE_CONDITION_CODE', 'REFER_HSENDER_DOC_START', 'REFER_HSENDER_DOC_EXPDATE'], 'safe'],
            [['REFER_HSENDER_CODE', 'REFER_HSENDER_SENT_TYPEID', 'PT_HOSPITAL_NUMBER'], 'integer'],
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
        $query = KM4GETREFER::find();

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
            'REFER_HRECIEVE_DOC_DATE' => $this->REFER_HRECIEVE_DOC_DATE,
            'REFER_HSENDER_CODE' => $this->REFER_HSENDER_CODE,
            'REFER_HSENDER_SENT_TYPEID' => $this->REFER_HSENDER_SENT_TYPEID,
            'REFER_HSENDER_DOC_START' => $this->REFER_HSENDER_DOC_START,
            'REFER_HSENDER_DOC_EXPDATE' => $this->REFER_HSENDER_DOC_EXPDATE,
            'PT_HOSPITAL_NUMBER' => $this->PT_HOSPITAL_NUMBER,
        ]);

        $query->andFilterWhere(['like', 'REFER_HRECIEVE_DOC_ID', $this->REFER_HRECIEVE_DOC_ID])
            ->andFilterWhere(['like', 'REFER_HSENDER_DOC_ID', $this->REFER_HSENDER_DOC_ID])
            ->andFilterWhere(['like', 'DISEASE_CONDITION_CODE', $this->DISEASE_CONDITION_CODE]);

        return $dataProvider;
    }
}
