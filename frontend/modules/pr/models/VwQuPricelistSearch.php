<?php

namespace app\modules\pr\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pr\models\VwQuPricelist;

/**
 * VwQuPricelistSearch represents the model behind the search form about `app\modules\pr\models\VwQuPricelist`.
 */
class VwQuPricelistSearch extends VwQuPricelist {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['ItemID', 'ids_qu', 'ItemCatID', 'ItemNDMedSupplyCatID', 'TMTID_GPU', 'QULeadtime', 'QUItemNumStatusID', 'QUPackUnit', 'QUStatusID'], 'integer'],
                [['VendorID', 'VenderName', 'VenderEmail', 'TMTID_TPU', 'ItemName', 'itemContVal', 'itemContUnit', 'itemDispUnit', 'distributor_id', 'QUComment', 'QUdate', 'QUValidDate', 'PackUnit', 'Price_change', 'DistributorName', 'Itemstatus2', 'Itemstatus', 'QUUnit'], 'safe'],
                [['QUMQO', 'QUPackQty', 'QUPackCost', 'QUOrderQty', 'QUUnitCost', 'QUQty', 'QUUnitCost2'], 'number'],
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
        $query = VwQuPricelist::find();

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
            'ids_qu' => $this->ids_qu,
            'ItemCatID' => $this->ItemCatID,
            'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'QUMQO' => $this->QUMQO,
            'QUPackQty' => $this->QUPackQty,
            'QUPackCost' => $this->QUPackCost,
            'QUOrderQty' => $this->QUOrderQty,
            'QUdate' => $this->QUdate,
            'QUUnitCost' => $this->QUUnitCost,
            'QUValidDate' => $this->QUValidDate,
            'QULeadtime' => $this->QULeadtime,
            'QUItemNumStatusID' => $this->QUItemNumStatusID,
            'QUPackUnit' => $this->QUPackUnit,
            'QUStatusID' => $this->QUStatusID,
            'QUQty' => $this->QUQty,
            'QUUnitCost2' => $this->QUUnitCost2,
        ]);

        $query->andFilterWhere(['like', 'VendorID', $this->VendorID])
                ->andFilterWhere(['like', 'VenderName', $this->VenderName])
                ->andFilterWhere(['like', 'VenderEmail', $this->VenderEmail])
                ->andFilterWhere(['like', 'TMTID_TPU', $this->TMTID_TPU])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'itemContVal', $this->itemContVal])
                ->andFilterWhere(['like', 'itemContUnit', $this->itemContUnit])
                ->andFilterWhere(['like', 'itemDispUnit', $this->itemDispUnit])
                ->andFilterWhere(['like', 'distributor_id', $this->distributor_id])
                ->andFilterWhere(['like', 'QUComment', $this->QUComment])
                ->andFilterWhere(['like', 'PackUnit', $this->PackUnit])
                ->andFilterWhere(['like', 'Price_change', $this->Price_change])
                ->andFilterWhere(['like', 'DistributorName', $this->DistributorName])
                ->andFilterWhere(['like', 'Itemstatus2', $this->Itemstatus2])
                ->andFilterWhere(['like', 'Itemstatus', $this->Itemstatus])
                ->andFilterWhere(['like', 'QUUnit', $this->QUUnit]);

        return $dataProvider;
    }

    public function search_gpu($params, $gpu) {
        $query = VwQuPricelist::find()->where(['TMTID_GPU' => $gpu]);

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
            'ids_qu' => $this->ids_qu,
            'ItemCatID' => $this->ItemCatID,
            'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'QUMQO' => $this->QUMQO,
            'QUPackQty' => $this->QUPackQty,
            'QUPackCost' => $this->QUPackCost,
            'QUOrderQty' => $this->QUOrderQty,
            'QUdate' => $this->QUdate,
            'QUUnitCost' => $this->QUUnitCost,
            'QUValidDate' => $this->QUValidDate,
            'QULeadtime' => $this->QULeadtime,
            'QUItemNumStatusID' => $this->QUItemNumStatusID,
            'QUPackUnit' => $this->QUPackUnit,
            'QUStatusID' => $this->QUStatusID,
            'QUQty' => $this->QUQty,
            'QUUnitCost2' => $this->QUUnitCost2,
        ]);

        $query->andFilterWhere(['like', 'VendorID', $this->VendorID])
                ->andFilterWhere(['like', 'VenderName', $this->VenderName])
                ->andFilterWhere(['like', 'VenderEmail', $this->VenderEmail])
                ->andFilterWhere(['like', 'TMTID_TPU', $this->TMTID_TPU])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'itemContVal', $this->itemContVal])
                ->andFilterWhere(['like', 'itemContUnit', $this->itemContUnit])
                ->andFilterWhere(['like', 'itemDispUnit', $this->itemDispUnit])
                ->andFilterWhere(['like', 'distributor_id', $this->distributor_id])
                ->andFilterWhere(['like', 'QUComment', $this->QUComment])
                ->andFilterWhere(['like', 'PackUnit', $this->PackUnit])
                ->andFilterWhere(['like', 'Price_change', $this->Price_change])
                ->andFilterWhere(['like', 'DistributorName', $this->DistributorName])
                ->andFilterWhere(['like', 'Itemstatus2', $this->Itemstatus2])
                ->andFilterWhere(['like', 'Itemstatus', $this->Itemstatus])
                ->andFilterWhere(['like', 'QUUnit', $this->QUUnit]);

        return $dataProvider;
    }

    public function search_nd($params, $tpu) {
        $query = VwQuPricelist::find()->where(['TMTID_TPU' => $tpu, 'ItemCatID' => 2]);

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
            'ids_qu' => $this->ids_qu,
            'ItemCatID' => $this->ItemCatID,
            'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'QUMQO' => $this->QUMQO,
            'QUPackQty' => $this->QUPackQty,
            'QUPackCost' => $this->QUPackCost,
            'QUOrderQty' => $this->QUOrderQty,
            'QUdate' => $this->QUdate,
            'QUUnitCost' => $this->QUUnitCost,
            'QUValidDate' => $this->QUValidDate,
            'QULeadtime' => $this->QULeadtime,
            'QUItemNumStatusID' => $this->QUItemNumStatusID,
            'QUPackUnit' => $this->QUPackUnit,
            'QUStatusID' => $this->QUStatusID,
            'QUQty' => $this->QUQty,
            'QUUnitCost2' => $this->QUUnitCost2,
        ]);

        $query->andFilterWhere(['like', 'VendorID', $this->VendorID])
                ->andFilterWhere(['like', 'VenderName', $this->VenderName])
                ->andFilterWhere(['like', 'VenderEmail', $this->VenderEmail])
                ->andFilterWhere(['like', 'TMTID_TPU', $this->TMTID_TPU])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'itemContVal', $this->itemContVal])
                ->andFilterWhere(['like', 'itemContUnit', $this->itemContUnit])
                ->andFilterWhere(['like', 'itemDispUnit', $this->itemDispUnit])
                ->andFilterWhere(['like', 'distributor_id', $this->distributor_id])
                ->andFilterWhere(['like', 'QUComment', $this->QUComment])
                ->andFilterWhere(['like', 'PackUnit', $this->PackUnit])
                ->andFilterWhere(['like', 'Price_change', $this->Price_change])
                ->andFilterWhere(['like', 'DistributorName', $this->DistributorName])
                ->andFilterWhere(['like', 'Itemstatus2', $this->Itemstatus2])
                ->andFilterWhere(['like', 'Itemstatus', $this->Itemstatus])
                ->andFilterWhere(['like', 'QUUnit', $this->QUUnit]);

        return $dataProvider;
    }
    
    public function search_tpu($params, $tpu) {
        $query = VwQuPricelist::find()->where(['TMTID_TPU' => $tpu, 'ItemCatID' => 2]);

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
            'ids_qu' => $this->ids_qu,
            'ItemCatID' => $this->ItemCatID,
            'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'QUMQO' => $this->QUMQO,
            'QUPackQty' => $this->QUPackQty,
            'QUPackCost' => $this->QUPackCost,
            'QUOrderQty' => $this->QUOrderQty,
            'QUdate' => $this->QUdate,
            'QUUnitCost' => $this->QUUnitCost,
            'QUValidDate' => $this->QUValidDate,
            'QULeadtime' => $this->QULeadtime,
            'QUItemNumStatusID' => $this->QUItemNumStatusID,
            'QUPackUnit' => $this->QUPackUnit,
            'QUStatusID' => $this->QUStatusID,
            'QUQty' => $this->QUQty,
            'QUUnitCost2' => $this->QUUnitCost2,
        ]);

        $query->andFilterWhere(['like', 'VendorID', $this->VendorID])
                ->andFilterWhere(['like', 'VenderName', $this->VenderName])
                ->andFilterWhere(['like', 'VenderEmail', $this->VenderEmail])
                ->andFilterWhere(['like', 'TMTID_TPU', $this->TMTID_TPU])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'itemContVal', $this->itemContVal])
                ->andFilterWhere(['like', 'itemContUnit', $this->itemContUnit])
                ->andFilterWhere(['like', 'itemDispUnit', $this->itemDispUnit])
                ->andFilterWhere(['like', 'distributor_id', $this->distributor_id])
                ->andFilterWhere(['like', 'QUComment', $this->QUComment])
                ->andFilterWhere(['like', 'PackUnit', $this->PackUnit])
                ->andFilterWhere(['like', 'Price_change', $this->Price_change])
                ->andFilterWhere(['like', 'DistributorName', $this->DistributorName])
                ->andFilterWhere(['like', 'Itemstatus2', $this->Itemstatus2])
                ->andFilterWhere(['like', 'Itemstatus', $this->Itemstatus])
                ->andFilterWhere(['like', 'QUUnit', $this->QUUnit]);

        return $dataProvider;
    }

}
