<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\Vwtpuplandetailavalible;

/**
 * TbIsedSearch represents the model behind the search form about `app\models\TbIsed`.
 */
class VwtpuplandetailavalibleSearch extends Vwtpuplandetailavalible {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
//            [['ISEDID'], 'integer'],
            [['TMTID_TPU', 'ItemName', 'TPUUnitCost', 'TPUOrderQty', 'DispUnit', 'TPUExtendedCost', 'PRApprovedOrderQty', 'PRGPUAvalible', 'Stkbalance', 'ItemOnPO', 'q'], 'safe'],
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
        $query = Vwtpuplandetailavalible::find();

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

        $query->orFilterWhere(['like', 'TMTID_TPU', $this->q])
                ->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'TPUUnitCost', $this->q])
                ->orFilterWhere(['like', 'TPUOrderQty', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
//                ->orFilterWhere(['like', 'TPUExtendedCost', $this->q])
                ->orFilterWhere(['like', 'PRApprovedOrderQty', $this->q])
                ->orFilterWhere(['like', 'PRGPUAvalible', $this->q])
                ->orFilterWhere(['like', 'Stkbalance', $this->q])
                ->orFilterWhere(['like', 'ItemOnPO', $this->q]);

        return $dataProvider;
    }

}
