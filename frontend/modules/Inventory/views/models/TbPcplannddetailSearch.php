<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbPcplannddetail;

/**
 * TbPcplannddetailSearch represents the model behind the search form about `app\models\TbPcplannddetail`.
 */
class TbPcplannddetailSearch extends TbPcplannddetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'PCPlanNum', 'PCItemNum', 'ItemID', 'PCPlanNDQty', 'PCPlanItemStatusID'], 'integer'],
            [['PCPlanNDUnitCost', 'PCPlanNDExtendedCost'], 'number'],
            [['PCPlanNDItemEffectDate'], 'safe'],
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
        $query = TbPcplannddetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('data');
        //$query->joinWith('data');

        $query->andFilterWhere([
            'ids' => $this->ids,
            'PCPlanNum' => $this->PCPlanNum,
            'PCItemNum' => $this->PCItemNum,
            'ItemID' => $this->ItemID,
            'PCPlanNDUnitCost' => $this->PCPlanNDUnitCost,
            'PCPlanNDQty' => $this->PCPlanNDQty,
            'PCPlanNDExtendedCost' => $this->PCPlanNDExtendedCost,
            'PCPlanNDItemEffectDate' => $this->PCPlanNDItemEffectDate,
            'PCPlanItemStatusID' => $this->PCPlanItemStatusID,
        ]);
        
        $query->orFilterWhere(['like', 'PCPlanNum', $this->PCPlanNum])
                //->orFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andWhere(['tb_pcplan.PCPlanTypeID' => array(3, 4)]);

        return $dataProvider;
    }
    
    public function searchplannd($params)
    {
        $query = TbPcplannddetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
       $query->joinWith('data');

        $query->andFilterWhere([
            'ids' => $this->ids,
            'PCPlanNum' => $this->PCPlanNum,
            'PCItemNum' => $this->PCItemNum,
            //'ItemID' => $this->ItemID,
            'PCPlanNDUnitCost' => $this->PCPlanNDUnitCost,
            'PCPlanNDQty' => $this->PCPlanNDQty,
            'PCPlanNDExtendedCost' => $this->PCPlanNDExtendedCost,
            'PCPlanNDItemEffectDate' => $this->PCPlanNDItemEffectDate,
            'PCPlanItemStatusID' => $this->PCPlanItemStatusID,
        ]);
        
        $query->orFilterWhere(['like', 'PCPlanNum', $this->PCPlanNum])
                ->andWhere(['tb_pcplan.PCPlanTypeID' => array(6)]);
                //->orFilterWhere(['like', 'ItemID', $this->ItemID]);
                //->andWhere(['vw_ndplan_detail_avalible.PCPlanTypeID' => array(6)]);

        return $dataProvider;
    }
}
