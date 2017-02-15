<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\Tbsritemdetail2;

/**
 * Sritemdetail2Search represents the model behind the search form about `app\modules\Inventory\models\Tbsritemdetail2`.
 */
class Sritemdetail2Search extends Tbsritemdetail2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'SRID', 'ItemID', 'TMTID_GPU', 'SRItemPackID', 'SRItemPackIDApprove', 'SRItemNumStatusID', 'SRCreatedBy'], 'integer'],
            [['SRNum', 'ItemName'], 'safe'],
            [['SRPackQty', 'SRItemOrderQty', 'SRPackQtyApprove', 'SRItemOrderQtyApprove'], 'number'],
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
    public function search($params,$id)
    {
        $query = Tbsritemdetail2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ids' => $this->ids,
            'SRID' => $this->SRID,
            'ItemID' => $this->ItemID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'SRPackQty' => $this->SRPackQty,
            'SRItemPackID' => $this->SRItemPackID,
            'SRItemOrderQty' => $this->SRItemOrderQty,
            'SRPackQtyApprove' => $this->SRPackQtyApprove,
            'SRItemPackIDApprove' => $this->SRItemPackIDApprove,
            'SRItemOrderQtyApprove' => $this->SRItemOrderQtyApprove,
            'SRItemNumStatusID' => $this->SRItemNumStatusID,
            'SRCreatedBy' => $this->SRCreatedBy,
        ]);

        $query->andFilterWhere(['like', 'SRNum', $this->SRNum])
            ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                  ->andFilterWhere(['like', 'SRID', $id])
                 ;

        return $dataProvider;
    }
}
