<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\Vwsr2detail2;

/**
 * Tbsr2tempSearch represents the model behind the search form about `app\modules\Inventory\models\Tbsr2temp`.
 */
class Vwsr2detail2Search extends Vwsr2detail2
{
    
    /**
     * @inheritdoc
     */
  

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
    public function search($params,$SRID)
    {
        $query = Vwsr2detail2::find();

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
            'SRNum' => $this->SRNum,
            'SRID' => $this->SRID,
            'ItemID' => $this->ItemID,
            'ItemDetail' => $this->ItemDetail,
            'SRQty' => $this->SRQty,
            'SRUnit' => $this->SRUnit,
            'SRApproveQty' => $this->SRApproveQty,
            'SRApproveUnit' => $this->SRApproveUnit,
            'SRItemNumStatusID' => $this->SRItemNumStatusID,
            'SRCreatedBy' => $this->SRCreatedBy,
            'DispUnit' => $this->DispUnit,
        ]);

        $query->andFilterWhere(['like', 'SRID', $SRID]);

        return $dataProvider;
    }
}
