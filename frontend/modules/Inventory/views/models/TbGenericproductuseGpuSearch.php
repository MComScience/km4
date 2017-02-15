<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbGenericproductuseGpu;

/**
 * TbGenericproductuseGpuSearch represents the model behind the search form about `app\modules\Inventory\models\TbGenericproductuseGpu`.
 */
class TbGenericproductuseGpuSearch extends TbGenericproductuseGpu {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['TMTID_GPU', 'TMTID_GP'], 'integer'],
            [['FSN_GPU', 'FNS_GPU_label', 'StrNum_GPU', 'Dosageform_GPU', 'ContVal_GPU', 'CoutUnit_GPU', 'DispUnit_GPU', 'CHANGEDATE_GPU', 'q'], 'safe'],
        ];
    }

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
    public function search($params) {
        $query = TbGenericproductuseGpu::find();

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
            'TMTID_GPU' => $this->TMTID_GPU,
            'CHANGEDATE_GPU' => $this->CHANGEDATE_GPU,
            'TMTID_GP' => $this->TMTID_GP,
        ]);

        $query->orFilterWhere(['like', 'FSN_GPU', $this->q])
                ->orFilterWhere(['like', 'FNS_GPU_label', $this->q])
                ->orFilterWhere(['like', 'StrNum_GPU', $this->q])
                ->orFilterWhere(['like', 'Dosageform_GPU', $this->q])
                ->orFilterWhere(['like', 'ContVal_GPU', $this->q])
                ->orFilterWhere(['like', 'CoutUnit_GPU', $this->q])
                ->orFilterWhere(['like', 'TMTID_GPU', $this->q])
                ->orFilterWhere(['like', 'DispUnit_GPU', $this->q]);

        return $dataProvider;
    }

}
