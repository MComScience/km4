<?php

namespace app\modules\pr\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pr\models\VwStkStatus;

/**
 * VwStkStatusSearch represents the model behind the search form about `app\modules\pr\models\VwStkStatus`.
 */
class VwStkStatusSearch extends VwStkStatus {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['ItemID'], 'integer'],
                [['ItemName', 'TMTID_TPU', 'TMTID_GPU', 'DispUnit'], 'safe'],
                [['stk_main_balance', 'stk_sub_balance', 'stk_main_rop'], 'number'],
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
        $query = VwStkStatus::find();

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
        ]);

        $query->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'TMTID_TPU', $this->TMTID_TPU])
                ->andFilterWhere(['like', 'TMTID_GPU', $this->TMTID_GPU])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit]);

        return $dataProvider;
    }

    public function searchDetailsPR1($params, $gpu) {
        $query = VwStkStatus::find()->where(['TMTID_GPU' => $gpu]);

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
        ]);

        $query->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'TMTID_TPU', $this->TMTID_TPU])
                ->andFilterWhere(['like', 'TMTID_GPU', $this->TMTID_GPU])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit]);

        return $dataProvider;
    }

    public function searchDetailsPR2($params, $ItemID) {
        $query = VwStkStatus::find()->where(['ItemID' => $ItemID]);

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
        ]);

        $query->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'TMTID_TPU', $this->TMTID_TPU])
                ->andFilterWhere(['like', 'TMTID_GPU', $this->TMTID_GPU])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit]);

        return $dataProvider;
    }
    
    public function searchDetailsTPU($params, $TPU) {
        $query = VwStkStatus::find()->where(['TMTID_TPU' => $TPU]);

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
        ]);

        $query->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'TMTID_TPU', $this->TMTID_TPU])
                ->andFilterWhere(['like', 'TMTID_GPU', $this->TMTID_GPU])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit]);

        return $dataProvider;
    }

}
