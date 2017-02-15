<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\TbGr2;

/**
 * TbGr2Search represents the model behind the search form about `app\modules\Purchasing\models\TbGr2`.
 */
class TbGr2Search extends TbGr2
{
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'GRTypeID', 'VenderID', 'GRStatusID', 'GRCreatedBy'], 'integer'],
            [['GRNum', 'GRDate', 'PONum', 'PODate', 'POType', 'PRNum', 'PODueDate', 'GRSubtotal', 'GRVat', 'GRTotal', 'GRCreatedDate', 'GRCreatedTime', 'VenderInvoiceNum','q'], 'safe'],
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
        $query = TbGr2::find();

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

        $query->joinWith('detailhistory');

        // grid filtering conditions
        $query->andFilterWhere([
            'GRID' => $this->GRID,
            'GRDate' => $this->GRDate,
            'GRTypeID' => $this->GRTypeID,
            'PODate' => $this->PODate,
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
        ]);

        $query->andFilterWhere(['like', 'GRNum', $this->GRNum])
            ->andFilterWhere(['like', 'PONum', $this->PONum])
            ->andFilterWhere(['like', 'POType', $this->POType])
            ->andFilterWhere(['like', 'PRNum', $this->PRNum])
            ->andFilterWhere(['like', 'GRSubtotal', $this->GRSubtotal])
            ->andFilterWhere(['like', 'GRVat', $this->GRVat])
            ->andFilterWhere(['like', 'GRTotal', $this->GRTotal])
            ->andFilterWhere(['like', 'VenderInvoiceNum', $this->VenderInvoiceNum]);

        return $dataProvider;
    }
}
