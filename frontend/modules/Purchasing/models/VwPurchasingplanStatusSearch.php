<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\VwPurchasingplanStatus;

/**
 * VwPurchasingplanStatusSearch represents the model behind the search form about `app\modules\Purchasing\models\VwPurchasingplanStatus`.
 */
class VwPurchasingplanStatusSearch extends VwPurchasingplanStatus {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ItemID', 'plan_qty', 'consume_rate'], 'integer'],
            [['ItemName', 'TMTID_TPU', 'TMTID_GPU', 'DispUnit', 'q','ItemCatID'], 'safe'],
            [['stk_main_balance', 'stk_sub_balance', 'pr_qty_cum', 'pr_qty_avalible', 'gpustd_cost', 'stk_main_rop'], 'number'],
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
        $query = VwPurchasingplanStatus::find();

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
            'plan_qty' => $this->plan_qty,
            'pr_qty_cum' => $this->pr_qty_cum,
            'pr_qty_avalible' => $this->pr_qty_avalible,
            'gpustd_cost' => $this->gpustd_cost,
            'stk_main_rop' => $this->stk_main_rop,
            'consume_rate' => $this->consume_rate,
        ]);

        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'stk_main_balance', $this->q])
                ->orFilterWhere(['like', 'stk_sub_balance', $this->q])
                ->orFilterWhere(['like', 'plan_qty', $this->q])
                ->orFilterWhere(['like', 'pr_qty_cum', $this->q])
                ->orFilterWhere(['like', 'pr_qty_avalible', $this->q])
                ->orFilterWhere(['like', 'gpustd_cost', $this->q])
                ->orFilterWhere(['like', 'stk_main_rop', $this->q])
                ->orFilterWhere(['like', 'consume_rate', $this->q])
                ->andWhere(['ItemCatID' => array(1)]);

        return $dataProvider;
    }

    public function searchAll($params) {
        $post = Yii::$app->request->post();
        $query = VwPurchasingplanStatus::find();


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
            //'plan_qty' => $this->plan_qty,
            'pr_qty_cum' => $this->pr_qty_cum,
            'pr_qty_avalible' => $this->pr_qty_avalible,
            'gpustd_cost' => $this->gpustd_cost,
            //'stk_main_rop' => $this->stk_main_rop,
            'consume_rate' => $this->consume_rate,
        ]);


        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'stk_main_balance', $this->q])
                ->orFilterWhere(['like', 'stk_sub_balance', $this->q])
                //->orFilterWhere(['like', 'plan_qty', $this->q])
                ->orFilterWhere(['like', 'pr_qty_cum', $this->q])
                ->orFilterWhere(['like', 'pr_qty_avalible', $this->q])
                ->orFilterWhere(['like', 'gpustd_cost', $this->q])
                //->orFilterWhere(['like', 'stk_main_rop', $this->q])
                ->orFilterWhere(['like', 'consume_rate', $this->q])
                ->andWhere(['ItemCatID' => array(1)]);
        if (($post) && (!$post['VwPurchasingplanStatusSearch']['plan_qty'] == 0)) {
            $query->andWhere('plan_qty < :plan_qty', [':plan_qty' => 0]);
        }
        if (($post) && (!$post['VwPurchasingplanStatusSearch']['stk_main_rop'] == 0)) {
            $query->andWhere('stk_main_rop > :stk_main_rop', [':stk_main_rop' => 0]);
        }

        return $dataProvider;
    }

    public function searchDetailsPR($params,$gpu) {
        $query = VwPurchasingplanStatus::find()->where(['TMTID_GPU' => $gpu]);
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
            //'plan_qty' => $this->plan_qty,
            'pr_qty_cum' => $this->pr_qty_cum,
            'pr_qty_avalible' => $this->pr_qty_avalible,
            'gpustd_cost' => $this->gpustd_cost,
            //'stk_main_rop' => $this->stk_main_rop,
            'consume_rate' => $this->consume_rate,
        ]);

        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'stk_main_balance', $this->q])
                ->orFilterWhere(['like', 'stk_sub_balance', $this->q])
                //->orFilterWhere(['like', 'plan_qty', $this->q])
                ->orFilterWhere(['like', 'pr_qty_cum', $this->q])
                ->orFilterWhere(['like', 'pr_qty_avalible', $this->q])
                ->orFilterWhere(['like', 'gpustd_cost', $this->q])
                //->orFilterWhere(['like', 'stk_main_rop', $this->q])
                ->orFilterWhere(['like', 'consume_rate', $this->q]);

        return $dataProvider;
    }

    public function searchDetailsPR1($params,$gpu) {
        $query = VwPurchasingplanStatus::find()->where(['TMTID_GPU' => $gpu])->groupBy('TMTID_GPU');
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
            //'plan_qty' => $this->plan_qty,
            'pr_qty_cum' => $this->pr_qty_cum,
            'pr_qty_avalible' => $this->pr_qty_avalible,
            'gpustd_cost' => $this->gpustd_cost,
            //'stk_main_rop' => $this->stk_main_rop,
            'consume_rate' => $this->consume_rate,
        ]);

        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemName', $this->q])
                ->orFilterWhere(['like', 'DispUnit', $this->q])
                ->orFilterWhere(['like', 'stk_main_balance', $this->q])
                ->orFilterWhere(['like', 'stk_sub_balance', $this->q])
                //->orFilterWhere(['like', 'plan_qty', $this->q])
                ->orFilterWhere(['like', 'pr_qty_cum', $this->q])
                ->orFilterWhere(['like', 'pr_qty_avalible', $this->q])
                ->orFilterWhere(['like', 'gpustd_cost', $this->q])
                //->orFilterWhere(['like', 'stk_main_rop', $this->q])
                ->orFilterWhere(['like', 'consume_rate', $this->q]);

        return $dataProvider;
    }

}
