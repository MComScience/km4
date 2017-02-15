<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\VwPurchasingplanStatus2;

/**
 * VwPurchasingplanStatus2Search represents the model behind the search form about `app\modules\Purchasing\models\VwPurchasingplanStatus2`.
 */
class VwPurchasingplanStatus2Search extends VwPurchasingplanStatus2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'GPUOrderQty', 'po_wip'], 'integer'],
            [['pr_qty_cum', 'pr_qty_avalible', 'pr_wip', 'consume_rate'], 'number'],
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
        $query = VwPurchasingplanStatus2::find();

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
            'TMTID_GPU' => $this->TMTID_GPU,
            'GPUOrderQty' => $this->GPUOrderQty,
            'pr_qty_cum' => $this->pr_qty_cum,
            'pr_qty_avalible' => $this->pr_qty_avalible,
            'pr_wip' => $this->pr_wip,
            'po_wip' => $this->po_wip,
            'consume_rate' => $this->consume_rate,
        ]);

        return $dataProvider;
    }
    
    public function searchDetailsPR($params,$gpu,$prid)
    {
        $query = VwPurchasingplanStatus2::find()->where(['TMTID_GPU' => $gpu,'PRID' => $prid]);

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
            'TMTID_GPU' => $this->TMTID_GPU,
            'GPUOrderQty' => $this->GPUOrderQty,
            'pr_qty_cum' => $this->pr_qty_cum,
            'pr_qty_avalible' => $this->pr_qty_avalible,
            'pr_wip' => $this->pr_wip,
            'po_wip' => $this->po_wip,
            'consume_rate' => $this->consume_rate,
        ]);

        return $dataProvider;
    }
}
