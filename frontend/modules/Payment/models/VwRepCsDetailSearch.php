<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwRepCsDetail;

/**
 * VwRepCsDetailSearch represents the model behind the search form about `app\modules\Payment\models\VwRepCsDetail`.
 */
class VwRepCsDetailSearch extends VwRepCsDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Line', 'HN', 'cs_rep_id', 'ids'], 'integer'],
            [['BillNo', 'InvNo', 'pt_name', 'DTTran'], 'safe'],
            [['Amount_Paid'], 'number'],
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
    public function search($params,$key)
    {
        $query = VwRepCsDetail::find();

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
            'Line' => $this->Line,
            'HN' => $this->HN,
            'DTTran' => $this->DTTran,
            'Amount_Paid' => $this->Amount_Paid,
            'cs_rep_id' => $this->cs_rep_id,
            'ids' => $this->ids,
        ]);

        $query->orFilterWhere(['like', 'BillNo', $this->BillNo])
            ->orFilterWhere(['like', 'InvNo', $this->InvNo])
            ->orFilterWhere(['like', 'pt_name', $this->pt_name])
            ->andWhere(['cs_rep_id'=>$key]);

        return $dataProvider;
    }
}
