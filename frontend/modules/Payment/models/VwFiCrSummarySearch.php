<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwFiCrSummary;

/**
 * VwFiCrSummarySearch represents the model behind the search form about `app\modules\Payment\models\VwFiCrSummary`.
 */
class VwFiCrSummarySearch extends VwFiCrSummary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cr_summary_id', 'cr_summary_status', 'createby'], 'integer'],
            [['cr_summary_pt_visit_type', 'cr_summary_date'], 'safe'],
            [['cr_summary_sum'], 'number'],
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
        $query = VwFiCrSummary::find();

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
            'cr_summary_id' => $this->cr_summary_id,
            'cr_summary_pt_visit_type' => $this->cr_summary_pt_visit_type,
            'cr_summary_status' => $this->cr_summary_status,
            'createby' => $this->createby,
            'cr_summary_sum' => $this->cr_summary_sum,
        ]);
        $query->andFilterWhere(['like', 'cr_summary_date', $this->convertThaiSearchDate($this->cr_summary_date)]);
        return $dataProvider;
    }
    public function convertThaiSearchDate($date) {//แปลงวันที่ลง mysql
        if(!empty($date)){
          $arr = explode("/", $date);
          if(empty($arr[2])){
               return '';
          }else{
               $y = $arr[2]-543;
               $m = $arr[1];
               $d = $arr[0];
               return "$y-$m-$d"; 
          }
        }else{
           return '';
        }
    }
}
