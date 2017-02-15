<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbPcplangpudetail;

/**
 * TbPcplangpudetailSearch represents the model behind the search form about `app\modules\Inventory\models\TbPcplangpudetail`.
 */
class TbPcplangpudetailSearch extends TbPcplangpudetail {

    public $DispUnit;
    public $FSN_GPU;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ids', 'TMTID_GPU', 'GPUOrderQty', 'PCPlanGPUItemStatusID'], 'integer'],
            [['fsngpu', 'PCPlanNum', 'PCPlanGPUItemEffectDate', 'DispUnit', 'FSN_GPU'], 'safe'],
            [['GPUUnitCost', 'GPUExtendedCost'], 'number'],
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
        $query = TbPcplangpudetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('plantype');

        $query->andFilterWhere([
            'ids' => $this->ids,
            'TMTID_GPU' => $this->TMTID_GPU,
            'GPUUnitCost' => $this->GPUUnitCost,
            'GPUOrderQty' => $this->GPUOrderQty,
            'GPUExtendedCost' => $this->GPUExtendedCost,
            'PCPlanGPUItemEffectDate' => $this->PCPlanGPUItemEffectDate,
            'PCPlanGPUItemStatusID' => $this->PCPlanGPUItemStatusID,
        ]);

        $query->orFilterWhere(['like', 'fsngpu', $this->fsngpu])
                ->orFilterWhere(['like', 'PCPlanNum', $this->PCPlanNum])
                ->andWhere(['tb_pcplan.PCPlanTypeID' => array(1, 2)]);

        return $dataProvider;
    }

}
