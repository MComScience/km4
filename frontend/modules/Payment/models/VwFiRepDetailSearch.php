<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwFiRepDetail;

/**
 * VwFiRepDetailSearch represents the model behind the search form about `app\modules\Payment\models\VwFiRepDetail`.
 */
class VwFiRepDetailSearch extends VwFiRepDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_rep', 'rep_id', 'cpoe_Itemtype', 'ItemID', 'ItemStatus', 'ids_inv'], 'integer'],
            [['ItemDetail', 'ItemQty1', 'Item_Cr_Amt_Sum', 'Item_PayAmt'], 'safe'],
            [['ItemPrice', 'Item_Amt'], 'number'],
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
    public function search($params, $rep_id)
    {
        $query = VwFiRepDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ids_rep' => $this->ids_rep,
            'rep_id' => $this->rep_id,
            'cpoe_Itemtype' => $this->cpoe_Itemtype,
            'ItemID' => $this->ItemID,
            'ItemPrice' => $this->ItemPrice,
            'Item_Amt' => $this->Item_Amt,
            'ItemStatus' => $this->ItemStatus,
            'ids_inv' => $this->ids_inv,
        ]);

        $query->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
            ->andFilterWhere(['like', 'ItemQty1', $this->ItemQty1])
            ->andFilterWhere(['like', 'Item_Cr_Amt_Sum', $this->Item_Cr_Amt_Sum])
            ->andFilterWhere(['like', 'Item_PayAmt', $this->Item_PayAmt])
            ->andFilterWhere(['rep_id'=>$rep_id]);    

        return $dataProvider;
    }
}
