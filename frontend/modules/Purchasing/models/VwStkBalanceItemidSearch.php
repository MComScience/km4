<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\VwStkBalanceItemid;

/**
 * VwStkBalanceItemidSearch represents the model behind the search form about `app\modules\Purchasing\models\VwStkBalanceItemid`.
 */
class VwStkBalanceItemidSearch extends VwStkBalanceItemid
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'StkTransID', 'StkID', 'ItemID', 'ItemCatID'], 'integer'],
            [['StkTransDateTime', 'StkName', 'ItemName', 'DispUnit', 'ROPStatus'], 'safe'],
            [['ItemQtyBalance', 'Reorderpoint', 'ItemTargetLevel', 'ItemROPDiff'], 'number'],
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
    public function search($params,$ItemID)
    {
        $query = VwStkBalanceItemid::find()->where(['ItemID' => $ItemID]);

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
            'ids' => $this->ids,
            'StkTransID' => $this->StkTransID,
            'StkTransDateTime' => $this->StkTransDateTime,
            'StkID' => $this->StkID,
            'ItemID' => $this->ItemID,
            'ItemCatID' => $this->ItemCatID,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'Reorderpoint' => $this->Reorderpoint,
            'ItemTargetLevel' => $this->ItemTargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
        ]);

        $query->andFilterWhere(['like', 'StkName', $this->StkName])
            ->andFilterWhere(['like', 'ItemName', $this->ItemName])
            ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
            ->andFilterWhere(['like', 'ROPStatus', $this->ROPStatus]);

        return $dataProvider;
    }
}
