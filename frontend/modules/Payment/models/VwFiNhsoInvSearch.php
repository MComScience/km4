<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwFiNhsoInv;

/**
 * VwFiNhsoInvSearch represents the model behind the search form about `app\modules\Payment\models\VwFiNhsoInv`.
 */
class VwFiNhsoInvSearch extends VwFiNhsoInv
{
    /**
     * @inheritdoc
     */
    public $q;

    public function rules()
    {
        return [
            [['nhso_inv_id', 'hmain', 'nhso_inv_crdays', 'nhso_inv_createby'], 'integer'],
            [['nhso_inv_num', 'nhso_inv_hdoc', 'nhso_inv_date', 'doc_type', 'nhso_inv_attnname', 'itemstatus','q'], 'safe'],
            [['nhso_inv_cramt'], 'number'],
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
        $query = VwFiNhsoInv::find();

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
            'nhso_inv_id' => $this->nhso_inv_id,
            'nhso_inv_date' => $this->nhso_inv_date,
            'hmain' => $this->hmain,
            'nhso_inv_crdays' => $this->nhso_inv_crdays,
            'nhso_inv_cramt' => $this->nhso_inv_cramt,
            'nhso_inv_createby' => $this->nhso_inv_createby,
        ]);

        $query->orFilterWhere(['like', 'nhso_inv_num', $this->q])
            ->orFilterWhere(['like', 'nhso_inv_hdoc', $this->q])
            ->orFilterWhere(['like', 'doc_type', $this->q])
            ->orFilterWhere(['like', 'hmain', $this->q])
            ->orFilterWhere(['like', 'nhso_inv_crdays', $this->q])
            ->orFilterWhere(['like', 'nhso_inv_cramt', $this->q])
            ->orFilterWhere(['like', 'nhso_inv_attnname', $this->q]);
            if(empty($this->itemstatus)){
                $query->orFilterWhere(['like', 'itemstatus', $this->q]);
            }else{
                $query->andFilterWhere(['like', 'itemstatus', $this->itemstatus]);
            } 
           

        return $dataProvider;
    }
}
