<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwItempriceCrList;

/**
 * VwItempriceCrListSearch represents the model behind the search form about `app\modules\Inventory\models\VwItempriceCrList`.
 */
class VwItempriceCrListSearch extends VwItempriceCrList {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['ItemID', 'ItemCatID'], 'integer'],
                [['Itemworkingcode', 'ItemPrice', 'crgrp1_op', 'crgrp1_ip', 'crgrp2_op', 'crgrp2_ip', 'crgrp3_op', 'crgrp3_ip', 'crgrp4_op', 'crgrp4_ip'], 'number'],
                [['ItemName', 'DispUnit', 'q','DrugClass','DrugSubClass'], 'safe'],
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
        $query = VwItempriceCrList::find()->indexBy('ItemID');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=> ['defaultOrder' => ['Class_GP'=>SORT_DESC]],
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
            'Itemworkingcode' => $this->Itemworkingcode,
            'ItemPrice' => $this->ItemPrice,
            'crgrp1_op' => $this->crgrp1_op,
            'crgrp1_ip' => $this->crgrp1_ip,
            'crgrp2_op' => $this->crgrp2_op,
            'crgrp2_ip' => $this->crgrp2_ip,
            'crgrp3_op' => $this->crgrp3_op,
            'crgrp3_ip' => $this->crgrp3_ip,
            'crgrp4_op' => $this->crgrp4_op,
            'crgrp4_ip' => $this->crgrp4_ip,
            'ItemCatID' => $this->ItemCatID,
            'DrugClass' => $this->DrugClass,
            'DrugSubClass' => $this->DrugSubClass,
        ]);

        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'Itemworkingcode', $this->q])
                ->orFilterWhere(['like', 'ItemPrice', $this->q])
                ->orFilterWhere(['like', 'crgrp1_op', $this->q])
                ->orFilterWhere(['like', 'crgrp1_ip', $this->q])
                ->orFilterWhere(['like', 'crgrp2_op', $this->q])
                ->orFilterWhere(['like', 'crgrp2_ip', $this->q])
                ->orFilterWhere(['like', 'crgrp3_op', $this->q])
                ->orFilterWhere(['like', 'crgrp3_ip', $this->q])
                ->orFilterWhere(['like', 'crgrp4_op', $this->q])
                ->orFilterWhere(['like', 'crgrp4_ip', $this->q])
                ->orFilterWhere(['like', 'DrugClass', $this->q])
                ->orFilterWhere(['like', 'DrugSubClass', $this->q]);

        return $dataProvider;
    }

}
