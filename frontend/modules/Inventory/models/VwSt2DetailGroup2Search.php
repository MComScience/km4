<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwSt2DetailGroup2;

/**
 * Sritemdetail2Search represents the model behind the search form about `app\modules\Inventory\models\Tbsritemdetail2`.
 */
class VwSt2DetailGroup2Search extends VwSt2DetailGroup2 {
    /**
     * @inheritdoc
     */

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
    public function search($params, $id) {
        $query = VwSt2DetailGroup2::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
           
        ]);

       
//        $this->load($params);
        $query->andFilterWhere(['like', 'STID', $id]);
        return $dataProvider;
    }

}
