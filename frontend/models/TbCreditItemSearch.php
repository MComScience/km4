<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TbCreditItem;

/**
 * TbCreditItemSearch represents the model behind the search form about `app\models\TbCreditItem`.
 */
class TbCreditItemSearch extends TbCreditItem {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ids', 'ItemID', 'maininscl_id', 'cr_status', 'CreatedBy'], 'integer'],
            [['medical_right_group_id', 'cr_effectiveDate'], 'safe'],
            [['cr_price'], 'number'],
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
    public function search($params, $itemid) {
        $query = TbCreditItem::find()->where(['ItemID' => $itemid])->indexBy('ids');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'pagination' => [
//                'pagesize' => 5
//            ]
                // 'sort'=> ['defaultOrder' => ['ids'=>SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ids' => $this->ids,
            'ItemID' => $this->ItemID,
            'maininscl_id' => $this->maininscl_id,
            'cr_price' => $this->cr_price,
            'cr_status' => $this->cr_status,
            'cr_effectiveDate' => $this->cr_effectiveDate,
            'CreatedBy' => $this->CreatedBy,
        ]);

        $query->andFilterWhere(['like', 'medical_right_group_id', $this->medical_right_group_id])
                ->andWhere(['cr_status' => 2]);

        return $dataProvider;
    }

}
