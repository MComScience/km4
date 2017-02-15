<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwStkbalanceStatus;

/**
 * VwStkbalanceStatusSearch represents the model behind the search form about `app\modules\Inventory\models\VwStkbalanceStatus`.
 */
class VwStkbalanceStatusSearch extends VwStkbalanceStatus {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ItemID', 'stk_main_balance', 'stk_sub_balance', 'stk_main_rop', 'ItemCatID', 'pr_wip', 'StkID'], 'integer'],
            [['ItemName', 'TMTID_TPU', 'TMTID_GPU', 'DispUnit', 'q'], 'safe'],
            [['po_wip', 'ItemQtyBalance', 'Reorderpoint', 'ItemTargetLevel', 'ItemROPDiff', 'target_stk_diff'], 'number'],
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
    public function search($params, $SectionID) {
        $post = Yii::$app->request->post();
        $query = VwStkbalanceStatus::find();

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
            'ItemID' => $this->ItemID,
            'stk_main_balance' => $this->stk_main_balance,
            'stk_sub_balance' => $this->stk_sub_balance,
            'stk_main_rop' => $this->stk_main_rop,
            'ItemCatID' => $this->ItemCatID,
            'pr_wip' => $this->pr_wip,
            'po_wip' => $this->po_wip,
            'StkID' => $this->StkID,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            //'Reorderpoint' => $this->Reorderpoint,
            // 'ItemTargetLevel' => $this->ItemTargetLevel,
             'ItemROPDiff' => $this->ItemROPDiff,
            'target_stk_diff' => $this->target_stk_diff,
        ]);

        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'ItemQtyBalance', $this->q])
                //->orFilterWhere(['like', 'Reorderpoint', $this->q])
                //->orFilterWhere(['like', 'ItemTargetLevel', $this->q])
                ->orFilterWhere(['like', 'ItemROPDiff', $this->q])
                ->orFilterWhere(['like', 'target_stk_diff', $this->q])
                ->orFilterWhere(['like', 'pr_wip', $this->q])
                ->orFilterWhere(['like', 'po_wip', $this->q])
                ->andWhere(['ItemCatID' => array(1)])
                ->andWhere(['StkID' => '1001']);
        if (($post) && (!$post['VwStkbalanceStatusSearch']['Reorderpoint'] == 0)) {
            $query->andWhere('Reorderpoint < :Reorderpoint', [':Reorderpoint' => 0]);
        }
        if (($post) && (!$post['VwStkbalanceStatusSearch']['ItemTargetLevel'] == 0)) {
            $query->andWhere('ItemTargetLevel < :ItemTargetLevel', [':ItemTargetLevel' => 0]);
        }

        return $dataProvider;
    }

    public function searchDrug($params) {
        $post = Yii::$app->request->post();
        $query = VwStkbalanceStatus::find();

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
            'ItemID' => $this->ItemID,
            'stk_main_balance' => $this->stk_main_balance,
            'stk_sub_balance' => $this->stk_sub_balance,
            'stk_main_rop' => $this->stk_main_rop,
            'ItemCatID' => $this->ItemCatID,
            'pr_wip' => $this->pr_wip,
            'po_wip' => $this->po_wip,
            'StkID' => $this->StkID,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            //'Reorderpoint' => $this->Reorderpoint,
            //'ItemTargetLevel' => $this->ItemTargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
            'target_stk_diff' => $this->target_stk_diff,
        ]);

        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'ItemQtyBalance', $this->q])
                //->orFilterWhere(['like', 'Reorderpoint', $this->q])
                //->orFilterWhere(['like', 'ItemTargetLevel', $this->q])
                ->orFilterWhere(['like', 'ItemROPDiff', $this->q])
                ->orFilterWhere(['like', 'target_stk_diff', $this->q])
                ->orFilterWhere(['like', 'pr_wip', $this->q])
                ->orFilterWhere(['like', 'po_wip', $this->q])
                ->andWhere(['ItemCatID' => array(2)]);
                //->andFilterWhere(['like', 'StkID', $SectionID]);
        if (($post) && (!$post['VwStkbalanceStatusSearch']['Reorderpoint'] == 0)) {
            $query->andWhere('Reorderpoint < :Reorderpoint', [':Reorderpoint' => 0]);
        }
        if (($post) && (!$post['VwStkbalanceStatusSearch']['ItemTargetLevel'] == 0)) {
            $query->andWhere('ItemTargetLevel < :ItemTargetLevel', [':ItemTargetLevel' => 0]);
        }

        return $dataProvider;
    }

}
