<?php

namespace app\modules\drugorder\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\drugorder\models\Vwcpoerxdetail;

/**
 * VwcpoerxdetailSearch represents the model behind the search form about `app\modules\drugorder\models\Vwcpoerxdetail`.
 */
class VwcpoerxdetailSearch extends Vwcpoerxdetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_ids', 'cpoe_seq', 'cpoe_id', 'cpoe_Itemtype', 'ItemID', 'ised_reason', 'cpoe_ItemStatus'], 'integer'],
            [['ItemDetail', 'ItemQty1', 'Item_Cr_Amt_Sum', 'Item_Pay_Amt_Sum', 'ised_reason_decs', 'Item_comment1', 'Item_comment2', 'Item_comment3', 'Item_comment4', 'schedule_period', 'schedule_begin2end'], 'safe'],
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
    public function search($params,$id)
    {
        $query = Vwcpoerxdetail::find()
                ->where(['cpoe_id' => $id]);

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
        $query->orFilterWhere([
            'cpoe_ids' => $this->cpoe_ids,
            'cpoe_seq' => $this->cpoe_seq,
            'cpoe_id' => $this->cpoe_id,
            'cpoe_Itemtype' => $this->cpoe_Itemtype,
            'ItemID' => $this->ItemID,
            'ItemPrice' => $this->ItemPrice,
            'Item_Amt' => $this->Item_Amt,
            'ised_reason' => $this->ised_reason,
            'cpoe_ItemStatus' => $this->cpoe_ItemStatus,
        ]);

        $query->orFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
            ->orFilterWhere(['like', 'ItemQty1', $this->ItemQty1])
            ->orFilterWhere(['like', 'Item_Cr_Amt_Sum', $this->Item_Cr_Amt_Sum])
            ->orFilterWhere(['like', 'Item_Pay_Amt_Sum', $this->Item_Pay_Amt_Sum])
            ->orFilterWhere(['like', 'ised_reason_decs', $this->ised_reason_decs])
            ->orFilterWhere(['like', 'Item_comment1', $this->Item_comment1])
            ->orFilterWhere(['like', 'Item_comment2', $this->Item_comment2])
            ->orFilterWhere(['like', 'Item_comment3', $this->Item_comment3])
            ->orFilterWhere(['like', 'Item_comment4', $this->Item_comment4])
            ->orFilterWhere(['like', 'schedule_period', $this->schedule_period])
            ->orFilterWhere(['like', 'schedule_begin2end', $this->schedule_begin2end]);

        return $dataProvider;
    }
}
