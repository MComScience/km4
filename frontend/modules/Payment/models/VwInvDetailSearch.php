<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwInvDetail;

/**
 * VwInvDetailSearch represents the model behind the search form about `app\modules\Payment\models\VwInvDetail`.
 */
class VwInvDetailSearch extends VwInvDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_id', 'cpoe_ids', 'pt_ar_seq', 'inv_id', 'ids_inv'], 'integer'],
            [['ar_name1', 'pt_ar_usage'], 'safe'],
            [['Item_Amt'], 'number'],
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
    public function search($params,$cpoe_ids)
    {
        $query = VwInvDetail::find();

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
            'cpoe_id' => $this->cpoe_id,
            'cpoe_ids' => $this->cpoe_ids,
            'pt_ar_seq' => $this->pt_ar_seq,
            'Item_Amt' => $this->Item_Amt,
            'inv_id' => $this->inv_id,
            'ids_inv' => $this->ids_inv,
        ]);

        $query->orFilterWhere(['like', 'ar_name1', $this->ar_name1])
              ->orFilterWhere(['like', 'pt_ar_usage', $this->pt_ar_usage])
              ->andFilterWhere(['cpoe_ids'=>$cpoe_ids]);

        return $dataProvider;
    }
}
