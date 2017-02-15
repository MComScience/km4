<?php

namespace app\modules\pr\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pr\models\VwPurchasingHistory;

/**
 * VwPurchasingHistorySearch represents the model behind the search form about `app\modules\pr\models\VwPurchasingHistory`.
 */
class VwPurchasingHistorySearch extends VwPurchasingHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PONum', 'PODate', 'ItemName', 'DispUnit', 'VenderName'], 'safe'],
            [['ItemID', 'TMTID_GPU'], 'integer'],
            [['POApprovedUnitCost', 'POApprovedOrderQty', 'POextcost'], 'number'],
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
        $query = VwPurchasingHistory::find()->where(['TMTID_GPU' => $gpu]);

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
            'PODate' => $this->PODate,
            'ItemID' => $this->ItemID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'POApprovedUnitCost' => $this->POApprovedUnitCost,
            'POApprovedOrderQty' => $this->POApprovedOrderQty,
            'POextcost' => $this->POextcost,
        ]);

        $query->andFilterWhere(['like', 'PONum', $this->PONum])
            ->andFilterWhere(['like', 'ItemName', $this->ItemName])
            ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
            ->andFilterWhere(['like', 'VenderName', $this->VenderName]);

        return $dataProvider;
    }

    public function search_nd($params,$ItemID)
    {
        $query = VwPurchasingHistory::find()->where(['ItemID' => $ItemID]);

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
            'PODate' => $this->PODate,
            'ItemID' => $this->ItemID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'POApprovedUnitCost' => $this->POApprovedUnitCost,
            'POApprovedOrderQty' => $this->POApprovedOrderQty,
            'POextcost' => $this->POextcost,
        ]);

        $query->andFilterWhere(['like', 'PONum', $this->PONum])
            ->andFilterWhere(['like', 'ItemName', $this->ItemName])
            ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
            ->andFilterWhere(['like', 'VenderName', $this->VenderName]);

        return $dataProvider;
    }
}
