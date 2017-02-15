<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwSt2LotnumberAvalible;

/**
 * Sritemdetail2Search represents the model behind the search form about `app\modules\Inventory\models\Tbsritemdetail2`.
 */
class VwSt2LotnumberAvalibleSearch extends VwSt2LotnumberAvalible {
    /**
     * @inheritdoc
     */
    public $q;
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
    public function search($StkID, $ItemID) {
        $query = VwSt2LotnumberAvalible::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->orderBy('ItemExpdate ASC');

         // $this->load($params);
        $query->Where(['StkID'=> $StkID,'ItemID'=>$ItemID]);
        return $dataProvider;
    }
public function searchinternallot($StkID,$internalid) {
        $query = VwSt2LotnumberAvalible::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->orderBy('ItemExpdate ASC');

         // $this->load($params);
        $query->Where(['StkID'=> $StkID,'ItemInternalLotNum'=>$internalid]);
        return $dataProvider;
    }
    public function SearchType1($params,$ItemID,$stkid) {
        $query = VwSt2LotnumberAvalible::find()
        ->where(['ItemID'=>$ItemID,'StkID' => $stkid]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['ItemExpdate' => SORT_DESC]],
    ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'StkID'=> $this->StkID,
            'ItemID' => $this->ItemID,
            'ItemInternalLotNum'=> $this->ItemInternalLotNum, 
            'ItemExternalLotNum'=> $this->ItemExternalLotNum, 
            'ItemExpdate'=> $this->ItemExpdate, 
            'ItemQty'=> $this->ItemQty, 
            'ItemUnitCost'=> $this->ItemUnitCost, 
            'PackQTY'=> $this->PackQTY, 
            'PackItemUnitCost'=> $this->PackItemUnitCost, 
            'ItemPackID'=> $this->ItemPackID, 
            'DispUnit'=> $this->DispUnit, 
            'PackUnit'=> $this->PackUnit, 
        ]);

        $query->orFilterWhere(['like', 'StkID', $this->q])
                ->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemInternalLotNum', $this->q])
                ->orFilterWhere(['like', 'ItemExternalLotNum', $this->q])
                ->orFilterWhere(['like', 'ItemExpdate', $this->q])
                ->orFilterWhere(['like', 'ItemQty', $this->q])
                ->orFilterWhere(['like', 'ItemUnitCost', $this->q])
                ->orFilterWhere(['like', 'PackQTY', $this->q])
                ->orFilterWhere(['like', 'PackItemUnitCost', $this->q])
                ->orFilterWhere(['like', 'ItemPackID', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'PackUnit', $this->q]);
        return $dataProvider;
    }
     public function SearchType2($params,$ItemID,$stkid,$Internal) {
        $query = VwSt2LotnumberAvalible::find()
        ->where(['ItemID'=>$ItemID,'StkID' => $stkid,'ItemInternalLotNum'=>$Internal]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['ItemExpdate' => SORT_DESC]],
    ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'StkID'=> $this->StkID,
            'ItemID' => $this->ItemID,
            'ItemInternalLotNum'=> $this->ItemInternalLotNum, 
            'ItemExternalLotNum'=> $this->ItemExternalLotNum, 
            'ItemExpdate'=> $this->ItemExpdate, 
            'ItemQty'=> $this->ItemQty, 
            'ItemUnitCost'=> $this->ItemUnitCost, 
            'PackQTY'=> $this->PackQTY, 
            'PackItemUnitCost'=> $this->PackItemUnitCost, 
            'ItemPackID'=> $this->ItemPackID, 
            'DispUnit'=> $this->DispUnit, 
            'PackUnit'=> $this->PackUnit, 
        ]);

        $query->orFilterWhere(['like', 'StkID', $this->q])
                ->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemInternalLotNum', $this->q])
                ->orFilterWhere(['like', 'ItemExternalLotNum', $this->q])
                ->orFilterWhere(['like', 'ItemExpdate', $this->q])
                ->orFilterWhere(['like', 'ItemQty', $this->q])
                ->orFilterWhere(['like', 'ItemUnitCost', $this->q])
                ->orFilterWhere(['like', 'PackQTY', $this->q])
                ->orFilterWhere(['like', 'PackItemUnitCost', $this->q])
                ->orFilterWhere(['like', 'ItemPackID', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'PackUnit', $this->q]);
        return $dataProvider;
    }
}
