<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwStkBalancetotalItemID;

/**
 * VwStkBalancetotalItemIDSearch represents the model behind the search form about `app\modules\Inventory\models\VwStkBalancetotalItemID`.
 */
class VwStkBalancetotalItemIDSearch extends VwStkBalancetotalItemID {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ItemID', 'ItemCatID'], 'integer'],
            [['ItemID', 'ItemCatID', 'ItemName', 'DispUnit', 'ItemQtyBalance', 'Reorderpoint', 'TargetLevel', 'ItemROPDiff', 'q'], 'safe'],
            [['ItemQtyBalance', 'Reorderpoint', 'TargetLevel', 'ItemROPDiff'], 'number'],
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
        $query = VwStkBalancetotalItemID::find(); //->where(['ItemCatID' => '1']);

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
            'ItemID' => $this->ItemID,
            //   'ItemCatID' => $this->ItemCatID,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'Reorderpoint' => $this->Reorderpoint,
            'TargetLevel' => $this->TargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
        ]);

        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'ItemQtyBalance', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'ItemROPDiff', $this->q])
                ->orFilterWhere(['like', 'ItemOnPO', $this->q])
                ->orFilterWhere(['like', 'PODueDate', $this->q])
                ->andFilterWhere(['like', 'ItemCatID', 1]);

        return $dataProvider;
    }

    public function search2($params) {
        $query = VwStkBalancetotalItemID::find(); //->where(['ItemCatID' => '2']);

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
            'ItemID' => $this->ItemID,
            // 'ItemCatID' => $this->ItemCatID,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'Reorderpoint' => $this->Reorderpoint,
            'TargetLevel' => $this->TargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
        ]);

        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'ItemQtyBalance', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'ItemROPDiff', $this->q])
                ->orFilterWhere(['like', 'ItemOnPO', $this->q])
                ->orFilterWhere(['like', 'PODueDate', $this->q])
                ->andFilterWhere(['like', 'ItemCatID', 2]);

        return $dataProvider;
    }

}
