<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\Vwgpuplandetailavalible;

/**
 * TbIsedSearch represents the model behind the search form about `app\models\TbIsed`.
 */
class VwgpuplandetailavalibleSearch extends Vwgpuplandetailavalible {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
//            [['ISEDID'], 'integer'],
            [['TMTID_GPU', 'FSN_GPU', 'GPUUnitCost', 'GPUOrderQty', 'GPUExtendedCost', 'DispUnit', 'PRApprovedOrderQty', 'PRGPUAvalible', 'Stkbalance', 'ItemOnPO', 'q'], 'safe'],
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
        $query = Vwgpuplandetailavalible::find();

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
            'PCPlanNum' => $this->q,
        ]);

        $query->orFilterWhere(['like', 'TMTID_GPU', $this->q])
                ->orFilterWhere(['like', 'FSN_GPU', $this->q])
                ->orFilterWhere(['like', 'GPUUnitCost', $this->q])
                ->orFilterWhere(['like', 'GPUOrderQty', $this->q])
                ->orFilterWhere(['like', 'GPUExtendedCost', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'PRApprovedOrderQty', $this->q])
                ->orFilterWhere(['like', 'PRGPUAvalible', $this->q])
                ->orFilterWhere(['like', 'Stkbalance', $this->q])
                ->orFilterWhere(['like', 'ItemOnPO', $this->q]);
        return $dataProvider;
    }

}
