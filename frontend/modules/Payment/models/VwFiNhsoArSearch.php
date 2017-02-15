<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwFiNhsoAr;

/**
 * VwFiNhsoArSearch represents the model behind the search form about `app\modules\Payment\models\VwFiNhsoAr`.
 */
class VwFiNhsoArSearch extends VwFiNhsoAr
{
    /**
     * @inheritdoc
     */
    public $q;

    public function rules()
    {
        return [
            [['ar_ids', 'rep', 'pt_hospital_number', 'pt_admission_number'], 'integer'],
            [['ar_itemtype', 'pid', 'pt_name', 'pt_visit_type', 'pt_registry_datetime', 'pt_discharge_datetime', 'paid_by', 'hmain', 'itemstatus','q'], 'safe'],
            [['fpnhso_piad', 'affiliation_piad', 'ar_amt'], 'number'],
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
        $query = VwFiNhsoAr::find();

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
            'ar_ids' => $this->ar_ids,
            'rep' => $this->rep,
            'pt_hospital_number' => $this->pt_hospital_number,
            'pt_admission_number' => $this->pt_admission_number,
            'pt_registry_datetime' => $this->pt_registry_datetime,
            'pt_discharge_datetime' => $this->pt_discharge_datetime,
            'fpnhso_piad' => $this->fpnhso_piad,
            'affiliation_piad' => $this->affiliation_piad,
            'ar_amt' => $this->ar_amt,
        ]);

        $query->orFilterWhere(['like', 'rep', $this->q])
            ->orFilterWhere(['like', 'pt_hospital_number', $this->q])
            ->orFilterWhere(['like', 'pt_admission_number', $this->q])
            ->orFilterWhere(['like', 'pt_name', $this->q])
            ->orFilterWhere(['like', 'fpnhso_piad', $this->q])
            ->orFilterWhere(['like', 'affiliation_piad', $this->q])
            ->orFilterWhere(['like', 'pt_visit_type', $this->q])
            ->orFilterWhere(['like', 'paid_by', $this->q]);
        if(empty($this->ar_itemtype)){
           $query->orFilterWhere(['like', 'ar_itemtype', $this->q]);
        }else{
           $query->andFilterWhere(['like', 'ar_itemtype', $this->ar_itemtype]);
        }
        if(empty($this->hmain)){
          $query ->orFilterWhere(['like', 'hmain', $this->q]);
        }else{
           $query ->andFilterWhere(['like', 'hmain', $this->hmain]);
        }
        if(empty($this->itemstatus)){
           $query->orFilterWhere(['like', 'itemstatus', $this->q]);
        }else{
           $query->andFilterWhere(['like', 'itemstatus', $this->itemstatus]);
        }    
        return $dataProvider;
    }
}
