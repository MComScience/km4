<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\Vwndplandetailavalible;

/**
 * TbIsedSearch represents the model behind the search form about `app\models\TbIsed`.
 */
class VwndplandetailavalibleSearch extends Vwndplandetailavalible {

    public $q;

    /**
     * @inheritdoc
     */
//    public function rules() {
//        return [
////            [['ISEDID'], 'integer'],
//            [['PCPlanNum', 'PCitemNum','TMTID_TPU', 'q'], 'safe'],
//        ];
//    }

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
        $query = Vwndplandetailavalible::find();

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

        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'PCPlanNDUnitCost', $this->q])
                ->orFilterWhere(['like', 'PCPlanNDQty', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'PCPlanNDExtendedCost', $this->q])
                ->orFilterWhere(['like', 'PRApprovedQtySUM', $this->q])
                ->orFilterWhere(['like', 'PRNDAvalible', $this->q])
                ->orFilterWhere(['like', 'Stkbalance', $this->q])
                ->orFilterWhere(['like', 'ItemOnPO', $this->q]);

        return $dataProvider;
    }

}
