<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwQuPricelist;

/**
 * VwQuPricelistSearch represents the model behind the search form about `app\modules\Inventory\models\VwQuPricelist`.
 */
class VwQuPricelistSearch extends VwQuPricelist
{
    /**
     * @inheritdoc
     */
    public $q;

    public function rules()
    {
        return [
            [['ids_qu', 'VendorID', 'ItemCatID', 'ItemNDMedSupplyCatID'], 'integer'],
            [['TMTID_TPU', 'ItemName', 'itemContVal', 'itemContUnit', 'itemDispUnit', 'QUValidDate', 'QUUnit','QULeadtime','VenderName','q','QUItemNumStatusID','Itemstatus'], 'safe'],
            [['QUMQO', 'QUPackQty', 'QUPackCost', 'QUOrderQty', 'QUUnitCost', 'QUQty', 'QUUnitCost2'], 'number'],
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
    public function search($params)
    {
        $query = VwQuPricelist::find();

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
            'ids_qu' => $this->ids_qu,
            'VendorID' => $this->VendorID,
            'VenderName'=>$this->VenderName,
            'ItemCatID' => $this->ItemCatID,
            'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
            'QUMQO' => $this->QUMQO,
            'QUPackQty' => $this->QUPackQty,
            'QUPackCost' => $this->QUPackCost,
            'QUOrderQty' => $this->QUOrderQty,
            'QUUnitCost' => $this->QUUnitCost,
            'QULeadtime' => $this->QULeadtime,
            'QUValidDate' => $this->QUValidDate,
            'QUQty' => $this->QUQty,
            'QUUnitCost2' => $this->QUUnitCost2,
            'QUItemNumStatusID' =>$this->QUItemNumStatusID,
            'Itemstatus'=>$this->Itemstatus,
        ]);

        $query->orFilterWhere(['like', 'TMTID_TPU', $this->q])
            ->orFilterWhere(['like', 'VenderName', $this->q])
            ->orFilterWhere(['like', 'ItemName', $this->q]);

        return $dataProvider;
    }
    public function SearchPriceList($params)
    {
        $query = VwQuPricelist::find();
                

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
            'ids_qu' => $this->ids_qu,
            'VendorID' => $this->VendorID,
            'VenderName'=>$this->VenderName,
            'ItemCatID' => $this->ItemCatID,
            'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
            'QUMQO' => $this->QUMQO,
            'QUPackQty' => $this->QUPackQty,
            'QUPackCost' => $this->QUPackCost,
            'QUOrderQty' => $this->QUOrderQty,
            'QUUnitCost' => $this->QUUnitCost,
            'QULeadtime' => $this->QULeadtime,
            'QUValidDate' => $this->QUValidDate,
            'QUQty' => $this->QUQty,
            'QUUnitCost2' => $this->QUUnitCost2,
            'QUItemNumStatusID' =>$this->QUItemNumStatusID,
            'Itemstatus'=>$this->Itemstatus,
        ]);

       $query->orFilterWhere(['like', 'TMTID_TPU', $this->q])
            ->orFilterWhere(['like', 'VenderName', $this->q])
            ->orFilterWhere(['like', 'ItemName', $this->q])
            ->andFilterWhere(['ItemCatID' => 1]);
            
        return $dataProvider;
    }
     public function SearchPriceListND($params)
    {
        $query = VwQuPricelist::find();
                

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
            'ids_qu' => $this->ids_qu,
            'VendorID' => $this->VendorID,
            'VenderName'=>$this->VenderName,
            'ItemCatID' => $this->ItemCatID,
            'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
            'QUMQO' => $this->QUMQO,
            'QUPackQty' => $this->QUPackQty,
            'QUPackCost' => $this->QUPackCost,
            'QUOrderQty' => $this->QUOrderQty,
            'QUUnitCost' => $this->QUUnitCost,
            'QULeadtime' => $this->QULeadtime,
            'QUValidDate' => $this->QUValidDate,
            'QUQty' => $this->QUQty,
            'QUUnitCost2' => $this->QUUnitCost2,
            'QUItemNumStatusID' =>$this->QUItemNumStatusID,
            'Itemstatus'=>$this->Itemstatus,
        ]);

        $query->orFilterWhere(['like', 'TMTID_TPU', $this->q])
            ->orFilterWhere(['like', 'VenderName', $this->q])
            ->orFilterWhere(['like', 'ItemName', $this->q])
            ->andFilterWhere(['ItemCatID' => 2]);

        return $dataProvider;
    }
}
