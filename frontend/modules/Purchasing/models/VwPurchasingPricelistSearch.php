<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\VwPurchasingPricelist;

/**
 * VwPurchasingPricelistSearch represents the model behind the search form about `app\modules\Purchasing\models\VwPurchasingPricelist`.
 */
class VwPurchasingPricelistSearch extends VwPurchasingPricelist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VendorID'], 'integer'],
            [['ItemName', 'VenderName', 'DispUnit', 'TMTID_GPU', 'QUValidDate'], 'safe'],
            [['QUUnitCost'], 'number'],
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
    public function search($params,$gpu)
    {
        $query = VwPurchasingPricelist::find();

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
            'VendorID' => $this->VendorID,
            'QUUnitCost' => $this->QUUnitCost,
            'QUValidDate' => $this->QUValidDate,
        ]);

        $query->andFilterWhere(['like', 'ItemName', $this->ItemName])
            ->andFilterWhere(['like', 'VenderName', $this->VenderName])
            ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
            ->andWhere(['TMTID_GPU' => $gpu]);
            //->andFilterWhere(['like', 'TMTID_GPU', $this->TMTID_GPU]);

        return $dataProvider;
    }
}
