<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwGr2ListForSt2Loan;

/**
 * VwGr2ListForSt2LondSearch represents the model behind the search form about `app\modules\Inventory\models\VwGr2ListForSt2Lond`.
 */
class VwGr2ListForSt2LoanSearch extends VwGr2ListForSt2Loan
{
    /**
     * @inheritdoc
     */
    public $q;
     
    public function rules()
    {
        return [
            [['GRID', 'GRStatusID', 'GRTypeID', 'STStatus'], 'integer'],
            [['GRNum', 'GRDate', 'GRDueDate', 'VendorID', 'VenderName', 'GRStatusDesc', 'PONum', 'GRType','q'], 'safe'],
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
        $query = VwGr2ListForSt2Loan::find();

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
            'GRID' => $this->GRID,
            'GRDate' => $this->GRDate,
            'GRDueDate' => $this->GRDueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRTypeID' => $this->GRTypeID,
            'STStatus' => $this->STStatus,
        ]);

        $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'VendorID', $this->q])
            ->orFilterWhere(['like', 'VenderName', $this->q]);

        return $dataProvider;
    }
    
    public function SearchLondSt($params)
    {
        $query = VwGr2ListForSt2Loan::find();
                //->where(['GRTypeID'=>3]);

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
            'GRID' => $this->GRID,
            'GRDate' => $this->GRDate,
            'GRDueDate' => $this->GRDueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRTypeID' => $this->GRTypeID,
            'STStatus' => $this->STStatus,
        ]);

        $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'VendorID', $this->q])
            ->orFilterWhere(['like', 'VenderName', $this->q])
            ->andFilterWhere(['GRTypeID'=>3]);

        return $dataProvider;
    }
}
