<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\Vwitempricelistscl;

/**
 * VwitempricelistsclSearch represents the model behind the search form about `app\modules\Inventory\models\Vwitempricelistscl`.
 */
class VwitempricelistsclSearch extends Vwitempricelistscl {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ItemID', 'ItemCatID', 'ItemPriceStatus', 'CreatedBy'], 'integer'],
            [['ItemName', 'DispUnit', 'cr_price_0', 'cr_price_1', 'cr_price_2', 'cr_price_3', 'cr_price_4', 'cr_price_5', 'cr_price_6', 'cr_price_7', 'cr_price_8', 'ItemPriceEffectiveDate', 'q'], 'safe'],
            [['ItemPrice'], 'number'],
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
    public function search($params, $catid) {
        $query = Vwitempricelistscl::find();

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
            'ItemID' => $this->ItemID,
            'ItemCatID' => $this->ItemCatID,
            'ItemPrice' => $this->ItemPrice,
            'ItemPriceEffectiveDate' => $this->ItemPriceEffectiveDate,
            'ItemPriceStatus' => $this->ItemPriceStatus,
            'CreatedBy' => $this->CreatedBy,
        ]);

        $query->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'cr_price_0', $this->q])
                ->orFilterWhere(['like', 'cr_price_1', $this->q])
                ->orFilterWhere(['like', 'cr_price_2', $this->q])
                ->orFilterWhere(['like', 'cr_price_3', $this->q])
                ->orFilterWhere(['like', 'cr_price_4', $this->q])
                ->orFilterWhere(['like', 'cr_price_5', $this->q])
                ->orFilterWhere(['like', 'cr_price_6', $this->q])
                ->orFilterWhere(['like', 'cr_price_7', $this->q])
                ->orFilterWhere(['like', 'cr_price_8', $this->q])
                ->andWhere(['ItemCatID' => 1]);

        return $dataProvider;
    }
    
    public function searchnondrug($params, $catid) {
        $query = Vwitempricelistscl::find();

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
            'ItemID' => $this->ItemID,
            'ItemCatID' => $this->ItemCatID,
            'ItemPrice' => $this->ItemPrice,
            'ItemPriceEffectiveDate' => $this->ItemPriceEffectiveDate,
            'ItemPriceStatus' => $this->ItemPriceStatus,
            'CreatedBy' => $this->CreatedBy,
        ]);

        $query->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'cr_price_0', $this->q])
                ->orFilterWhere(['like', 'cr_price_1', $this->q])
                ->orFilterWhere(['like', 'cr_price_2', $this->q])
                ->orFilterWhere(['like', 'cr_price_3', $this->q])
                ->orFilterWhere(['like', 'cr_price_4', $this->q])
                ->orFilterWhere(['like', 'cr_price_5', $this->q])
                ->orFilterWhere(['like', 'cr_price_6', $this->q])
                ->orFilterWhere(['like', 'cr_price_7', $this->q])
                ->orFilterWhere(['like', 'cr_price_8', $this->q])
                ->andWhere(['ItemCatID' => 2]);

        return $dataProvider;
    }

}
