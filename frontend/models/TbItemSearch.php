<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TbItem;

/**
 * TbItemSearch represents the model behind the search form about `app\models\TbItem`.
 */
class TbItemSearch extends TbItem {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ItemAutoLotNum', 'ItemID', 'ItemCatID', 'ItemNDMedSupplyCatID', 'ItemExpDateControl', 'ItemPic2', 'ItemStatusID', 'itempBarcodeNum', 'itemMinOrderLeadtime'], 'integer'],
            [['ItemName', 'TMTID_TPU', 'ItemSpecPrep', 'ItemDateUpdateStdPrice', 'ItemDateEffectiveStdPrice', 'ItemPackVal', 'ItemUpdateFlag', 'ItemDateChange', 'ItemAutoLotNum', 'ItemReorderLevel', 'ItemTargetLevel', 'itemdosageform', 'itemstmum', 'itemstrunit', 'itemstrdeno', 'itemstrdennounit', 'itemContVal', 'itemContUnit', 'itemDispUnit', 'itemPackSizeUnit', 'ref', 'q',], 'safe'],
            [['ItemStdUnitPrice', 'ItemPackPrice', 'ItemMinOrderQty'], 'number'],
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
    public function search($params) {
        //$query = TbItem::find();

        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => 'SELECT
                        tb_item.ItemID,
                        tb_item.ItemName,
                        tb_item.TMTID_TPU,
                        tb_item.TMTID_GPU,
                        tb_mastertmt.TradeName_TMT,
                        tb_item.ItemStatusID
                        FROM
                        tb_item USE INDEX (ItemID,ItemCatID) 
                        LEFT JOIN tb_mastertmt USE INDEX (TMTID_TPU) ON tb_mastertmt.TMTID_TPU = tb_item.TMTID_TPU
                        WHERE
                        tb_item.ItemCatID = 1 AND
                        tb_item.ItemStatusID IN (2,3)',
            'pagination' => [
                'pageSize' => false,
            ],
            'sort' => ['defaultOrder' => ['ItemID' => SORT_DESC]],
            'key' => 'ItemID',
        ]);

        /*
          $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'sort' => ['defaultOrder' => ['ItemID' => SORT_DESC]]
          ]); */

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        /*
          $query->orFilterWhere([
          'ItemID' => $this->q,
          ]);
          $query->joinWith('tmtdetail');

          $query->andFilterWhere([
          'ItemID' => $this->ItemID,
          'ItemCatID' => $this->ItemCatID,
          'ItemName' => $this->ItemName,
          'ItemAutoLotNum' => $this->ItemAutoLotNum,
          'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
          'ItemStdUnitPrice' => $this->ItemStdUnitPrice,
          'ItemDateUpdateStdPrice' => $this->ItemDateUpdateStdPrice,
          'ItemDateEffectiveStdPrice' => $this->ItemDateEffectiveStdPrice,
          'ItemPackPrice' => $this->ItemPackPrice,
          'ItemDateChange' => $this->ItemDateChange,
          'ItemExpDateControl' => $this->ItemExpDateControl,
          'ItemMinOrderQty' => $this->ItemMinOrderQty,
          'ItemPic2' => $this->ItemPic2,
          'ItemStatusID' => $this->ItemStatusID,
          'itempBarcodeNum' => $this->itempBarcodeNum,
          'itemMinOrderLeadtime' => $this->itemMinOrderLeadtime,
          'ref' => $this->ref,
          ]);
          $query->orFilterWhere(['like', 'ItemName', $this->q])
          ->orFilterWhere(['like', 'ItemID', $this->q])
          ->orFilterWhere(['like', 'tb_mastertmt.TradeName_TMT', $this->q])
          ->orFilterWhere(['like', 'tb_mastertmt.TMTID_TPU', $this->q])
          ->andWhere(['ItemStatusID' => array(2,3)])
          ->andWhere(['ItemCatID' => 1]);

          // $query->orFilterWhere(['like', 'ItemName', $this->q])
          //         ->orFilterWhere(['like', 'ItemStatusID', $this->q])
          //         ->orFilterWhere(['like', 'ItemID', $this->q])
          //         ->andFilterWhere(['like', 'ItemSpecPrep', $this->ItemSpecPrep])
          //         ->andFilterWhere(['like', 'ItemPackVal', $this->ItemPackVal])
          //         ->andFilterWhere(['like', 'ItemUpdateFlag', $this->ItemUpdateFlag])
          //         ->andFilterWhere(['like', 'ItemAutoLotNum', $this->ItemAutoLotNum])
          //         ->andFilterWhere(['like', 'ItemReorderLevel', $this->ItemReorderLevel])
          //         ->andFilterWhere(['like', 'ItemTargetLevel', $this->ItemTargetLevel])
          //         ->andFilterWhere(['like', 'itemdosageform', $this->itemdosageform])
          //         ->andFilterWhere(['like', 'itemstmum', $this->itemstmum])
          //         ->orFilterWhere(['like', 'TMTID_TPU', $this->q])
          //         ->andFilterWhere(['like', 'itemstrunit', $this->itemstrunit])
          //         ->andFilterWhere(['like', 'itemstrdeno', $this->itemstrdeno])
          //         ->andFilterWhere(['like', 'itemstrdennounit', $this->itemstrdennounit])
          //         ->andFilterWhere(['like', 'itemContVal', $this->itemContVal])
          //         ->andFilterWhere(['like', 'itemContUnit', $this->itemContUnit])
          //         ->andFilterWhere(['like', 'itemDispUnit', $this->itemDispUnit])
          //         ->andFilterWhere(['like', 'itemPackSizeUnit', $this->itemPackSizeUnit])
          //         ->andFilterWhere(['like', 'ref', $this->ref])
          //         ->andWhere(['ItemStatusID' => array(2,3)])
          //         ->andWhere(['ItemCatID' => 1]);
         */
        return $dataProvider;
    }

    public function searchnondrug($params) {
        $query = TbItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->orFilterWhere([
            'ItemID' => $this->q,
        ]);

        $query->andFilterWhere([
            'ItemID' => $this->ItemID,
            'ItemCatID' => $this->ItemCatID,
            'ItemName' => $this->ItemName,
            'ItemAutoLotNum' => $this->ItemAutoLotNum,
            'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
            'ItemStdUnitPrice' => $this->ItemStdUnitPrice,
            'ItemDateUpdateStdPrice' => $this->ItemDateUpdateStdPrice,
            'ItemDateEffectiveStdPrice' => $this->ItemDateEffectiveStdPrice,
            'ItemPackPrice' => $this->ItemPackPrice,
            'ItemDateChange' => $this->ItemDateChange,
            'ItemExpDateControl' => $this->ItemExpDateControl,
            'ItemMinOrderQty' => $this->ItemMinOrderQty,
            'ItemPic2' => $this->ItemPic2,
            'ItemStatusID' => $this->ItemStatusID,
            'itempBarcodeNum' => $this->itempBarcodeNum,
            'itemMinOrderLeadtime' => $this->itemMinOrderLeadtime,
            'ref' => $this->ref,
        ]);

        $query->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'ItemStatusID', $this->q])
                ->orFilterWhere(['like', 'ItemID', $this->q])
                ->andFilterWhere(['like', 'ItemSpecPrep', $this->ItemSpecPrep])
                ->andFilterWhere(['like', 'ItemPackVal', $this->ItemPackVal])
                ->andFilterWhere(['like', 'ItemUpdateFlag', $this->ItemUpdateFlag])
                ->andFilterWhere(['like', 'ItemAutoLotNum', $this->ItemAutoLotNum])
                ->andFilterWhere(['like', 'ItemReorderLevel', $this->ItemReorderLevel])
                ->andFilterWhere(['like', 'ItemTargetLevel', $this->ItemTargetLevel])
                ->andFilterWhere(['like', 'itemdosageform', $this->itemdosageform])
                ->andFilterWhere(['like', 'itemstmum', $this->itemstmum])
                ->andFilterWhere(['like', 'itemstrunit', $this->itemstrunit])
                ->andFilterWhere(['like', 'itemstrdeno', $this->itemstrdeno])
                ->andFilterWhere(['like', 'itemstrdennounit', $this->itemstrdennounit])
                ->andFilterWhere(['like', 'itemContVal', $this->itemContVal])
                ->andFilterWhere(['like', 'itemContUnit', $this->itemContUnit])
                ->andFilterWhere(['like', 'itemDispUnit', $this->itemDispUnit])
                ->andFilterWhere(['like', 'itemPackSizeUnit', $this->itemPackSizeUnit])
                ->andFilterWhere(['like', 'ref', $this->ref])
                ->andWhere(['ItemStatusID' => [2, 3]]);
        // ->andWhere(['ItemCatID' => 2]);
        $query->andWhere(' ItemID like "2%"');
        return $dataProvider;
    }

    public function SearchStocksbalance($params) {
        $query = TbItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('dataonviewbalance');

        $query->andFilterWhere([
            'ItemID' => $this->ItemID,
            'ItemCatID' => $this->ItemCatID,
            'ItemName' => $this->ItemName,
            'ItemAutoLotNum' => $this->ItemAutoLotNum,
            'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
            'ItemStdUnitPrice' => $this->ItemStdUnitPrice,
            'ItemDateUpdateStdPrice' => $this->ItemDateUpdateStdPrice,
            'ItemDateEffectiveStdPrice' => $this->ItemDateEffectiveStdPrice,
            'ItemPackPrice' => $this->ItemPackPrice,
            'ItemDateChange' => $this->ItemDateChange,
            'ItemExpDateControl' => $this->ItemExpDateControl,
            'ItemMinOrderQty' => $this->ItemMinOrderQty,
            'ItemPic2' => $this->ItemPic2,
            'ItemStatusID' => $this->ItemStatusID,
            'itempBarcodeNum' => $this->itempBarcodeNum,
            'itemMinOrderLeadtime' => $this->itemMinOrderLeadtime,
            'ref' => $this->ref,
        ]);

        $query->orFilterWhere(['like', 'vw_item_balance.ItemID', $this->q])
                ->orFilterWhere(['like', 'vw_item_balance.ItemName', $this->q])
                ->orFilterWhere(['like', 'vw_item_balance.ItemReorderLevel', $this->q])
                ->orFilterWhere(['like', 'vw_item_balance.DispUnit', $this->q])
                ->orFilterWhere(['like', 'vw_item_balance.ItemCat', $this->q])
                ->orFilterWhere(['like', 'vw_item_balance.ItemCatID', $this->q])
                ->andWhere(['vw_item_balance.ItemCatID' => 1]);

        return $dataProvider;
    }

    public function SearchStocksbalanceND($params) {
        $query = TbItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('dataonviewbalance');

        $query->andFilterWhere([
            'ItemID' => $this->ItemID,
            'ItemCatID' => $this->ItemCatID,
            'ItemName' => $this->ItemName,
            'ItemAutoLotNum' => $this->ItemAutoLotNum,
            'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
            'ItemStdUnitPrice' => $this->ItemStdUnitPrice,
            'ItemDateUpdateStdPrice' => $this->ItemDateUpdateStdPrice,
            'ItemDateEffectiveStdPrice' => $this->ItemDateEffectiveStdPrice,
            'ItemPackPrice' => $this->ItemPackPrice,
            'ItemDateChange' => $this->ItemDateChange,
            'ItemExpDateControl' => $this->ItemExpDateControl,
            'ItemMinOrderQty' => $this->ItemMinOrderQty,
            'ItemPic2' => $this->ItemPic2,
            'ItemStatusID' => $this->ItemStatusID,
            'itempBarcodeNum' => $this->itempBarcodeNum,
            'itemMinOrderLeadtime' => $this->itemMinOrderLeadtime,
            'ref' => $this->ref,
        ]);

        $query->orFilterWhere(['like', 'vw_item_balance.ItemID', $this->q])
                ->orFilterWhere(['like', 'vw_item_balance.ItemName', $this->q])
                ->orFilterWhere(['like', 'vw_item_balance.ItemReorderLevel', $this->q])
                ->orFilterWhere(['like', 'vw_item_balance.DispUnit', $this->q])
                ->orFilterWhere(['like', 'vw_item_balance.ItemCat', $this->q])
                ->orFilterWhere(['like', 'vw_item_balance.ItemCatID', $this->q])
                ->andWhere(['vw_item_balance.ItemCatID' => 2]);

        return $dataProvider;
    }

    public function searchipdopd($params) {
        $query = TbItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        /*    $query->joinWith('dataonviewbalance');

          $query->andFilterWhere([
          'ItemID' => $this->ItemID,
          'ItemCatID' => $this->ItemCatID,
          'ItemName' => $this->ItemName,
          'ItemAutoLotNum' => $this->ItemAutoLotNum,
          'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
          'ItemStdUnitPrice' => $this->ItemStdUnitPrice,
          'ItemDateUpdateStdPrice' => $this->ItemDateUpdateStdPrice,
          'ItemDateEffectiveStdPrice' => $this->ItemDateEffectiveStdPrice,
          'ItemPackPrice' => $this->ItemPackPrice,
          'ItemDateChange' => $this->ItemDateChange,
          'ItemExpDateControl' => $this->ItemExpDateControl,
          'ItemMinOrderQty' => $this->ItemMinOrderQty,
          'ItemPic2' => $this->ItemPic2,
          'ItemStatusID' => $this->ItemStatusID,
          'itempBarcodeNum' => $this->itempBarcodeNum,
          'itemMinOrderLeadtime' => $this->itemMinOrderLeadtime,
          'ref' => $this->ref,
          ]);

          $query->orFilterWhere(['like', 'vw_item_balance.ItemID', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemName', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemReorderLevel', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.DispUnit', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemCat', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemCatID', $this->q]) */
        $query->andWhere(' ItemID like "3%"');
        return $dataProvider;
    }

    public function searchcenter($params) {
        $query = TbItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        /* $query->joinWith('dataonviewbalance');

          $query->andFilterWhere([
          'ItemID' => $this->ItemID,
          'ItemCatID' => $this->ItemCatID,
          'ItemName' => $this->ItemName,
          'ItemAutoLotNum' => $this->ItemAutoLotNum,
          'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
          'ItemStdUnitPrice' => $this->ItemStdUnitPrice,
          'ItemDateUpdateStdPrice' => $this->ItemDateUpdateStdPrice,
          'ItemDateEffectiveStdPrice' => $this->ItemDateEffectiveStdPrice,
          'ItemPackPrice' => $this->ItemPackPrice,
          'ItemDateChange' => $this->ItemDateChange,
          'ItemExpDateControl' => $this->ItemExpDateControl,
          'ItemMinOrderQty' => $this->ItemMinOrderQty,
          'ItemPic2' => $this->ItemPic2,
          'ItemStatusID' => $this->ItemStatusID,
          'itempBarcodeNum' => $this->itempBarcodeNum,
          'itemMinOrderLeadtime' => $this->itemMinOrderLeadtime,
          'ref' => $this->ref,
          ]);

          $query->orFilterWhere(['like', 'vw_item_balance.ItemID', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemName', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemReorderLevel', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.DispUnit', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemCat', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemCatID', $this->q])
          ->andWhere(['vw_item_balance.ItemCatID' => 6]); */
        $query->andWhere(' ItemID like "4%"');
        return $dataProvider;
    }

    public function searchmaterialsscience($params) {
        $query = TbItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        /* $query->joinWith('dataonviewbalance');

          $query->andFilterWhere([
          'ItemID' => $this->ItemID,
          'ItemCatID' => $this->ItemCatID,
          'ItemName' => $this->ItemName,
          'ItemAutoLotNum' => $this->ItemAutoLotNum,
          'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
          'ItemStdUnitPrice' => $this->ItemStdUnitPrice,
          'ItemDateUpdateStdPrice' => $this->ItemDateUpdateStdPrice,
          'ItemDateEffectiveStdPrice' => $this->ItemDateEffectiveStdPrice,
          'ItemPackPrice' => $this->ItemPackPrice,
          'ItemDateChange' => $this->ItemDateChange,
          'ItemExpDateControl' => $this->ItemExpDateControl,
          'ItemMinOrderQty' => $this->ItemMinOrderQty,
          'ItemPic2' => $this->ItemPic2,
          'ItemStatusID' => $this->ItemStatusID,
          'itempBarcodeNum' => $this->itempBarcodeNum,
          'itemMinOrderLeadtime' => $this->itemMinOrderLeadtime,
          'ref' => $this->ref,
          ]);

          $query->orFilterWhere(['like', 'vw_item_balance.ItemID', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemName', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemReorderLevel', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.DispUnit', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemCat', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemCatID', $this->q]) */
        $query->andWhere(' ItemID like "5%"');
        return $dataProvider;
    }

    public function searchaddsupplies($params) {
        $query = TbItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //  $query->joinWith('dataonviewbalance');
        /*
          $query->andFilterWhere([
          // 'ItemID' => $this->ItemID,
          'ItemCatID' => $this->ItemCatID,
          'ItemName' => $this->ItemName,
          'ItemAutoLotNum' => $this->ItemAutoLotNum,
          'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
          'ItemStdUnitPrice' => $this->ItemStdUnitPrice,
          'ItemDateUpdateStdPrice' => $this->ItemDateUpdateStdPrice,
          'ItemDateEffectiveStdPrice' => $this->ItemDateEffectiveStdPrice,
          'ItemPackPrice' => $this->ItemPackPrice,
          'ItemDateChange' => $this->ItemDateChange,
          'ItemExpDateControl' => $this->ItemExpDateControl,
          'ItemMinOrderQty' => $this->ItemMinOrderQty,
          'ItemPic2' => $this->ItemPic2,
          'ItemStatusID' => $this->ItemStatusID,
          'itempBarcodeNum' => $this->itempBarcodeNum,
          'itemMinOrderLeadtime' => $this->itemMinOrderLeadtime,
          'ref' => $this->ref,
          ]);
         */
        /* $query//->orFilterWhere(['like', 'vw_item_balance.ItemID', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemName', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemReorderLevel', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.DispUnit', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemCat', $this->q])
          ->orFilterWhere(['like', 'vw_item_balance.ItemCatID', $this->q]) */
        $query->andWhere(' ItemID like "6%"');
        return $dataProvider;
    }

}
