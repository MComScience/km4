<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwSaLotnumberAvalible;

/**
 * VwSaLotnumberAvalibleSearch represents the model behind the search form about `app\modules\Inventory\models\VwSaLotnumberAvalible`.
 */
class VwSaLotnumberAvalibleSearch extends VwSaLotnumberAvalible {
    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//            [['StkID', 'ItemID', 'ItemInternalLotNum', 'ItemPackID'], 'integer'],
//            [['ItemName', 'ItemExternalLotNum', 'ItemExpdate', 'DispUnit', 'PackUnit', 'Sum(tb_stk_trans.ItemQtyOut)', 'Sum(tb_stk_trans.PackQtyOut)'], 'safe'],
//            [['ItemUnitCost', 'PackItemUnitCost', 'Sum(tb_stk_trans.ItemQtyIn)', 'ItemQty', 'Sum(tb_stk_trans.PackQtyIn)', 'PackQTY'], 'number'],
//        ];
//    }

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
    public function search($params, $StkID, $ItemID) {
        $query = VwSaLotnumberAvalible::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        $query->andFilterWhere([
//            'StkID' => $this->StkID,
//            'ItemID' => $this->ItemID,
//            'ItemInternalLotNum' => $this->ItemInternalLotNum,
//            'ItemExpdate' => $this->ItemExpdate,
//            'ItemUnitCost' => $this->ItemUnitCost,
//            'PackItemUnitCost' => $this->PackItemUnitCost,
//            'ItemPackID' => $this->ItemPackID,
//            'Sum(tb_stk_trans.ItemQtyIn)' => $this->Sum(tb_stk_trans.ItemQtyIn),
//            'ItemQty' => $this->ItemQty,
//            'Sum(tb_stk_trans.PackQtyIn)' => $this->Sum(tb_stk_trans.PackQtyIn),
//            'PackQTY' => $this->PackQTY,
//        ]);

       $query->Where(['StkID'=> $StkID,'ItemID'=>$ItemID]);
//                ->andFilterWhere(['like', 'StkID', $StkID]);
//            ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
//            ->andFilterWhere(['like', 'PackUnit', $this->PackUnit]);
        // ->andFilterWhere(['like', 'Sum(tb_stk_trans.ItemQtyOut)', $this->Sum(tb_stk_trans.ItemQtyOut)])
        // ->andFilterWhere(['like', 'Sum(tb_stk_trans.PackQtyOut)', $this->Sum(tb_stk_trans.PackQtyOut)]);

        return $dataProvider;
    }
     public function searchinternallot($params, $StkID, $ItemID,$internallot) {
        $query = VwSaLotnumberAvalible::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        $query->andFilterWhere([
//            'StkID' => $this->StkID,
//            'ItemID' => $this->ItemID,
//            'ItemInternalLotNum' => $this->ItemInternalLotNum,
//            'ItemExpdate' => $this->ItemExpdate,
//            'ItemUnitCost' => $this->ItemUnitCost,
//            'PackItemUnitCost' => $this->PackItemUnitCost,
//            'ItemPackID' => $this->ItemPackID,
//            'Sum(tb_stk_trans.ItemQtyIn)' => $this->Sum(tb_stk_trans.ItemQtyIn),
//            'ItemQty' => $this->ItemQty,
//            'Sum(tb_stk_trans.PackQtyIn)' => $this->Sum(tb_stk_trans.PackQtyIn),
//            'PackQTY' => $this->PackQTY,
//        ]);

       $query->Where(['StkID'=> $StkID,'ItemID'=>$ItemID,'ItemInternalLotNum'=>$internallot]);
//                ->andFilterWhere(['like', 'StkID', $StkID]);
//            ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
//            ->andFilterWhere(['like', 'PackUnit', $this->PackUnit]);
        // ->andFilterWhere(['like', 'Sum(tb_stk_trans.ItemQtyOut)', $this->Sum(tb_stk_trans.ItemQtyOut)])
        // ->andFilterWhere(['like', 'Sum(tb_stk_trans.PackQtyOut)', $this->Sum(tb_stk_trans.PackQtyOut)]);

        return $dataProvider;
    }

}
