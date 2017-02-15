<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwStkrefillStatus;

/**
 * VwStkrefillStatusSearch represents the model behind the search form about `app\modules\Inventory\models\VwStkrefillStatus`.
 */
class VwStkrefillStatusSearch extends VwStkrefillStatus
{
    /**
     * @inheritdoc
     */
    public $q;
    public function rules()
    {
        return [
            [['StkID', 'ItemID'], 'integer'],
            [['StkName', 'ItemNDMedSupply', 'ItemName', 'DispUnit','q'], 'safe'],
            [['ItemQtyBalance', 'ItemTargetLevel', 'target_stk_diff'], 'number'],
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
    public function search($params)
    {
        $query = VwStkrefillStatus::find();

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
            'StkID' => $this->StkID,
            'StkName' => $this->StkName,
            'ItemNDMedSupply' => $this->ItemNDMedSupply,
            'ItemID' => $this->ItemID,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'ItemTargetLevel' => $this->ItemTargetLevel,
            'target_stk_diff' => $this->target_stk_diff,
        ]);

        $query->orFilterWhere(['like', 'StkName', $this->q])
            ->orFilterWhere(['like', 'ItemNDMedSupply', $this->q])
            ->orFilterWhere(['like', 'ItemID', $this->q])
            ->orFilterWhere(['like', 'ItemName', $this->q])
            ->orFilterWhere(['like', 'DispUnit', $this->q]);

        return $dataProvider;
    }
}
