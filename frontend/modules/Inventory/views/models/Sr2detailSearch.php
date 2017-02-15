<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\Sr2detail;

/**
 * Sr2detailSearch represents the model behind the search form about `app\modules\Inventory\models\Sr2detail`.
 */
class Sr2detailSearch extends Sr2detail
{
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'SRID', 'SRQty', 'SRUnit', 'SRApproveQty', 'SRApproveUnit', 'SRItemNumStatusID', 'SRCreatedBy', 'DispUnit'], 'integer'],
            [['SRNum', 'ItemDetail'], 'safe'],
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
        $query = Sr2detail::find();

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
            'ids' => $this->ids,
            'SRID' => $this->SRID,
            'SRQty' => $this->SRQty,
            'SRUnit' => $this->SRUnit,
            'SRApproveQty' => $this->SRApproveQty,
            'SRApproveUnit' => $this->SRApproveUnit,
            'SRItemNumStatusID' => $this->SRItemNumStatusID,
            'SRCreatedBy' => $this->SRCreatedBy,
            'DispUnit' => $this->DispUnit,
        ]);

        $query->andFilterWhere(['like', 'SRNum', $this->SRNum])
            ->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail]);

        return $dataProvider;
    }
}
