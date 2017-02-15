<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\TbGritemdetail2Temp;

/**
 * TbGritemdetail2TempSearch represents the model behind the search form about `app\modules\Purchasing\models\TbGritemdetail2Temp`.
 */
class TbGritemdetail2TempSearch extends TbGritemdetail2Temp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_gr', 'GRID', 'GRItemNum', 'ItemID', 'POItemType', 'TMTID_GPU', 'TMTID_TPU', 'POItemPackID', 'GRItemPackID', 'GRCreatedBy', 'GRItemStatusID'], 'integer'],
            [['PONum', 'GRNum', 'ItemName'], 'safe'],
            [['POPackQtyApprove', 'POPackCostApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'GRPackQty', 'GRPackUnitCost', 'GRItemQty', 'GRItemUnitCost', 'GRLeftItemQty', 'GRLeftPackQty'], 'number'],
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
    public function search($params,$ponum)
    {
        $query = TbGritemdetail2Temp::find()->where(['PONum' => $ponum]);

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
            'ids_gr' => $this->ids_gr,
            'GRID' => $this->GRID,
            'GRItemNum' => $this->GRItemNum,
            'ItemID' => $this->ItemID,
            'POItemType' => $this->POItemType,
            'TMTID_GPU' => $this->TMTID_GPU,
            'TMTID_TPU' => $this->TMTID_TPU,
            'POPackQtyApprove' => $this->POPackQtyApprove,
            'POPackCostApprove' => $this->POPackCostApprove,
            'POItemPackID' => $this->POItemPackID,
            'POApprovedUnitCost' => $this->POApprovedUnitCost,
            'POApprovedOrderQty' => $this->POApprovedOrderQty,
            'GRPackQty' => $this->GRPackQty,
            'GRPackUnitCost' => $this->GRPackUnitCost,
            'GRItemPackID' => $this->GRItemPackID,
            'GRItemQty' => $this->GRItemQty,
            'GRItemUnitCost' => $this->GRItemUnitCost,
            'GRLeftItemQty' => $this->GRLeftItemQty,
            'GRLeftPackQty' => $this->GRLeftPackQty,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRItemStatusID' => $this->GRItemStatusID,
        ]);

        $query->andFilterWhere(['like', 'PONum', $this->PONum])
            ->andFilterWhere(['like', 'GRNum', $this->GRNum])
            ->andFilterWhere(['like', 'ItemName', $this->ItemName]);

        return $dataProvider;
    }
}
