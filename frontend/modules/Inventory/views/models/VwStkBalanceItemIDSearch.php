<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwStkBalanceItemid;

/**
 * VwStkBalanceItemIDSearch represents the model behind the search form about `app\modules\Inventory\models\VwStkBalanceItemID`.
 */
class VwStkBalanceItemIDSearch extends VwStkBalanceItemid {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ids', 'StkTransID', 'StkID', 'ItemID', 'ItemCatID'], 'integer'],
            [['StkTransDateTime', 'StkName','StkID', 'ItemName','ROPStatus', 'DispUnit', 'q'], 'safe'],
            [['ItemQtyBalance', 'Reorderpoint', 'ItemTargetLevel', 'ItemROPDiff'], 'number'],
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
    public function search($params, $catid) {
        $query = VwStkBalanceItemID::find();

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
            'StkTransID' => $this->StkTransID,
            'StkTransDateTime' => $this->StkTransDateTime,
            'StkID' => $this->StkID,
          //  'ItemID' => $this->ItemID,
            //  'ItemCatID' => $this->ItemCatID,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'Reorderpoint' => $this->Reorderpoint,
            'ItemTargetLevel' => $this->ItemTargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
				'ROPStatus' => $this->ROPStatus,
        ]);

        $query->andFilterWhere(['like', 'StkName', $this->q])
                ->andFilterWhere(['like', 'ItemName', $this->q])
                ->andFilterWhere(['like', 'StkID', $this->StkID])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
                 ->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andwhere(['ItemCatID' => $catid]);

		  /*if (!empty($params['ItemQtyBalance'])) {
            if ($params['ItemQtyBalance'] == 1) {
                $query->andwhere(["<", "ItemQtyBalance", 1]);
            }
        }
          if (!empty($params['ItemROPDiff'])) {
            if ($params['ItemROPDiff'] == 1) {
                $query->andwhere(["<", "ItemROPDiff", 1]);
            }
        }*/
        return $dataProvider;
    }

}
