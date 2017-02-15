<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbPcplantpudetail;

/**
 * TbPcplantpudetailSearch represents the model behind the search form about `app\modules\Inventory\models\TbPcplantpudetail`.
 */
class TbPcplantpudetailSearch extends TbPcplantpudetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'PCPlanNum', 'PCitemNum', 'TMTID_TPU', 'TPUOrderQty', 'PCPlanItemStatusID'], 'integer'],
            [['TPUUnitCost', 'TPUExtendedCost'], 'number'],
            [['PCPlanItemEffectDate', 'FNSTMT'], 'safe'],
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
        $query = TbPcplantpudetail::find();

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
            'PCPlanNum' => $this->PCPlanNum,
            'PCitemNum' => $this->PCitemNum,
            'TMTID_TPU' => $this->TMTID_TPU,
            'TPUUnitCost' => $this->TPUUnitCost,
            'TPUOrderQty' => $this->TPUOrderQty,
            'TPUExtendedCost' => $this->TPUExtendedCost,
            'PCPlanItemEffectDate' => $this->PCPlanItemEffectDate,
            'PCPlanItemStatusID' => $this->PCPlanItemStatusID,
        ]);

        $query->andFilterWhere(['like', 'FNSTMT', $this->FNSTMT])
                ->andWhere(['tb_pcplan.PCPlanTypeID' => array(7,8)]);

        return $dataProvider;
    }
    public function search2($params)
    {
        $query = TbPcplantpudetail::find();

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
            'PCPlanNum' => $this->PCPlanNum,
            'PCitemNum' => $this->PCitemNum,
            'TMTID_TPU' => $this->TMTID_TPU,
            'TPUUnitCost' => $this->TPUUnitCost,
            'TPUOrderQty' => $this->TPUOrderQty,
            'TPUExtendedCost' => $this->TPUExtendedCost,
            'PCPlanItemEffectDate' => $this->PCPlanItemEffectDate,
            'PCPlanItemStatusID' => $this->PCPlanItemStatusID,
        ]);

        $query->andFilterWhere(['like', 'FNSTMT', $this->FNSTMT])
                ->andWhere(['tb_pcplan.PCPlanTypeID' => array(5)]);

        return $dataProvider;
    }
}
