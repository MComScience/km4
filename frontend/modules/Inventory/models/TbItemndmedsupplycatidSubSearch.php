<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbItemndmedsupplycatidSub;

/**
 * TbItemndmedsupplycatidSubSearch represents the model behind the search form about `app\modules\Inventory\models\TbItemndmedsupplycatidSub`.
 */
class TbItemndmedsupplycatidSubSearch extends TbItemndmedsupplycatidSub
{
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemNDMedSupplyCatID_sub_id'], 'integer'],
            [['ItemNDMedSupplyCatID_sub_desc','q'], 'safe'],
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
        $query = TbItemndmedsupplycatidSub::find();

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
            'ItemNDMedSupplyCatID_sub_id' => $this->ItemNDMedSupplyCatID_sub_id,
        ]);

        $query->andFilterWhere(['like', 'ItemNDMedSupplyCatID_sub_desc', $this->q]);

        return $dataProvider;
    }
}
