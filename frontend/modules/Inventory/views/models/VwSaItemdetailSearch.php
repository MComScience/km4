<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwSaItemdetail;

/**
 * VwSaItemdetailSearch represents the model behind the search form about `app\modules\Inventory\models\VwSaItemdetail`.
 */
class VwSaItemdetailSearch extends VwSaItemdetail {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ids', 'SAID', 'ItemID', 'ItemInternalLotNum', 'SAItemNumStatus', 'SACreatedBy'], 'integer'],
            [['SANum', 'ItemExternalLotNum', 'ItemExpDate', 'ItemName', 'DispUnit'], 'safe'],
            [['OnhandLotItemQty', 'ActualLotItemQty', 'AdjLotItemQty', 'BalanceAdjLotItemQty'], 'number'],
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
    public function search($params,$SAID,$ItemID) {
        $query = VwSaItemdetail::find();

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
            'ids' => $this->ids,
            'SAID' => $this->SAID,
            'ItemID' => $this->ItemID,
            'ItemInternalLotNum' => $this->ItemInternalLotNum,
            'ItemExpDate' => $this->ItemExpDate,
            'OnhandLotItemQty' => $this->OnhandLotItemQty,
            'ActualLotItemQty' => $this->ActualLotItemQty,
            'AdjLotItemQty' => $this->AdjLotItemQty,
            'BalanceAdjLotItemQty' => $this->BalanceAdjLotItemQty,
            'SAItemNumStatus' => $this->SAItemNumStatus,
            'SACreatedBy' => $this->SACreatedBy,
        ]);

        $query->andFilterWhere(['like', 'SANum', $this->SANum])
                ->andFilterWhere(['like', 'ItemExternalLotNum', $this->ItemExternalLotNum])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'ItemID', $ItemID])
                ->andFilterWhere(['like', 'SAID', $SAID]);

        return $dataProvider;
    }

}
