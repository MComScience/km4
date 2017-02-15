<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\Tbpritemdetail2temp;

/**
 * Tbpritemdetail2tempSearch represents the model behind the search form about `app\modules\Purchasing\models\Tbpritemdetail2temp`.
 */
class Tbpritemdetail2tempSearch extends Tbpritemdetail2temp
{
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'PRItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRItemOrderQty', 'PRApprovedOrderQtySum', 'PRItemAvalible', 'PROrderQty', 'PRApprovedUnitCost', 'PRApprovedOrderQty', 'PRItemNumStatusID', 'ItemPackID', 'PRItemOnPCPlan', 'PRCreatedBy', 'ids_PR_selected', 'PRID'], 'integer'],
            [['PRNum', 'PCPlanNum', 'ItemName', 'PRUnitCost', 'PRExtendedCost','q'], 'safe'],
            [['PRItemStdCost', 'PRItemUnitCost', 'PRVerifyUnitCost', 'PRVerifyQty', 'PRPackQty', 'ItemPackCost'], 'number'],
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
    public function search($params,$PRID)
    {
        $query = Tbpritemdetail2temp::find()->where(['PRID' => $PRID]);

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
            'ids' => $this->ids,
            'PRItemNum' => $this->PRItemNum,
            'ItemID' => $this->ItemID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'TMTID_TPU' => $this->TMTID_TPU,
            'PRItemStdCost' => $this->PRItemStdCost,
            'PRItemUnitCost' => $this->PRItemUnitCost,
            'PRItemOrderQty' => $this->PRItemOrderQty,
            'PRApprovedOrderQtySum' => $this->PRApprovedOrderQtySum,
            'PRItemAvalible' => $this->PRItemAvalible,
            'PROrderQty' => $this->PROrderQty,
            'PRVerifyUnitCost' => $this->PRVerifyUnitCost,
            'PRVerifyQty' => $this->PRVerifyQty,
            'PRApprovedUnitCost' => $this->PRApprovedUnitCost,
            'PRApprovedOrderQty' => $this->PRApprovedOrderQty,
            'PRItemNumStatusID' => $this->PRItemNumStatusID,
            'PRPackQty' => $this->PRPackQty,
            'ItemPackID' => $this->ItemPackID,
            'PRItemOnPCPlan' => $this->PRItemOnPCPlan,
            'PRCreatedBy' => $this->PRCreatedBy,
            'ItemPackCost' => $this->ItemPackCost,
            'ids_PR_selected' => $this->ids_PR_selected,
            'PRID' => $this->PRID,
        ]);

        $query->orFilterWhere(['like', 'PRNum', $this->q])
            ->orFilterWhere(['like', 'PCPlanNum', $this->q])
            ->orFilterWhere(['like', 'ItemName', $this->q])
            ->orFilterWhere(['like', 'PRUnitCost', $this->q])
            ->orFilterWhere(['like', 'PRExtendedCost', $this->q]);

        return $dataProvider;
    }
    
    public function searchdetailgpu($params,$id)
    {
        $query = Tbpritemdetail2temp::find()->where(['ids' => $id]);

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
            'ids' => $this->ids,
            'PRItemNum' => $this->PRItemNum,
            'ItemID' => $this->ItemID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'TMTID_TPU' => $this->TMTID_TPU,
            'PRItemStdCost' => $this->PRItemStdCost,
            'PRItemUnitCost' => $this->PRItemUnitCost,
            'PRItemOrderQty' => $this->PRItemOrderQty,
            'PRApprovedOrderQtySum' => $this->PRApprovedOrderQtySum,
            'PRItemAvalible' => $this->PRItemAvalible,
            'PROrderQty' => $this->PROrderQty,
            'PRVerifyUnitCost' => $this->PRVerifyUnitCost,
            'PRVerifyQty' => $this->PRVerifyQty,
            'PRApprovedUnitCost' => $this->PRApprovedUnitCost,
            'PRApprovedOrderQty' => $this->PRApprovedOrderQty,
            'PRItemNumStatusID' => $this->PRItemNumStatusID,
            'PRPackQty' => $this->PRPackQty,
            'ItemPackID' => $this->ItemPackID,
            'PRItemOnPCPlan' => $this->PRItemOnPCPlan,
            'PRCreatedBy' => $this->PRCreatedBy,
            'ItemPackCost' => $this->ItemPackCost,
            'ids_PR_selected' => $this->ids_PR_selected,
            'PRID' => $this->PRID,
        ]);

        $query->orFilterWhere(['like', 'PRNum', $this->q])
            ->orFilterWhere(['like', 'PCPlanNum', $this->q])
            ->orFilterWhere(['like', 'ItemName', $this->q])
            ->orFilterWhere(['like', 'PRUnitCost', $this->q])
            ->orFilterWhere(['like', 'PRExtendedCost', $this->q]);

        return $dataProvider;
    }
}
