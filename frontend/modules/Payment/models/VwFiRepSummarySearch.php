<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwFiRepSummary;

/**
 * VwFiRepSummarySearch represents the model behind the search form about `app\modules\Payment\models\VwFiRepSummary`.
 */
class VwFiRepSummarySearch extends VwFiRepSummary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_summary_id', 'rep_summary_section', 'rep_summary_status', 'createby', 'banknote1000', 'banknote500', 'banknote100', 'banknote50', 'banknote20', 'banknote10', 'coin10bt', 'coin5bt', 'coin2bt', 'coin1bt', 'coin50cn', 'coin25cn'], 'integer'],
            [['SectionDecs', 'rep_summary_date', 'rep_summary_remark'], 'safe'],
            [['rep_summary_sum'], 'number'],
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
        $query = VwFiRepSummary::find();

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
            'rep_summary_id' => $this->rep_summary_id,
            'rep_summary_section' => $this->rep_summary_section,
            //'rep_summary_date' => (!empty($this->rep_summary_date)? $this->rep_summary_date:''),
            'rep_summary_status' => $this->rep_summary_status,
            'createby' => $this->createby,
            'banknote1000' => $this->banknote1000,
            'banknote500' => $this->banknote500,
            'banknote100' => $this->banknote100,
            'banknote50' => $this->banknote50,
            'banknote20' => $this->banknote20,
            'banknote10' => $this->banknote10,
            'coin10bt' => $this->coin10bt,
            'coin5bt' => $this->coin5bt,
            'coin2bt' => $this->coin2bt,
            'coin1bt' => $this->coin1bt,
            'coin50cn' => $this->coin50cn,
            'coin25cn' => $this->coin25cn,
            'rep_summary_sum' => $this->rep_summary_sum,
        ]);
        $query->andFilterWhere(['like', 'rep_summary_date', $this->convertThaiSearchDate($this->rep_summary_date)]);
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
