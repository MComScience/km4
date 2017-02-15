<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwSaItemdetailGroup;

/**
 * VwSaItemdetailGroupSearch represents the model behind the search form about `app\modules\Inventory\models\VwSaItemdetailGroup`.
 */
class VwSaItemdetailGroupSearch extends VwSaItemdetailGroup {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['SANum', 'ItemName', 'DispUnit'], 'safe'],
            [['SAID', 'ItemID', 'SAItemNumStatus', 'SACreatedBy'], 'integer'],
                // [['Sum(vw_sa_itemdetail.OnhandLotItemQty)', 'Sum(vw_sa_itemdetail.ActualLotItemQty)', 'Sum(vw_sa_itemdetail.AdjLotItemQty)', 'Sum(vw_sa_itemdetail.BalanceAdjLotItemQty)'], 'number'],
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
    public function search($params,$id) {
        $query = VwSaItemdetailGroup::find();

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
            'SAID' => $this->SAID,
            'ItemID' => $this->ItemID,
            'SAItemNumStatus' => $this->SAItemNumStatus,
            'SACreatedBy' => $this->SACreatedBy,
        ]);

        $query->andFilterWhere(['like', 'SANum', $this->SANum])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
                ->andFilterWhere(['like', 'SAID', $id]);

        return $dataProvider;
    }

}
