<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwFiItemPayment;

/**
 * VwFiItemPaymentSearch represents the model behind the search form about `app\modules\Payment\models\VwFiItemPayment`.
 */
class VwFiItemPaymentSearch extends VwFiItemPayment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_id', 'rep_id', 'creditcard_number', 'creditcard_type', 'bankaccount_number', 'cheque_number', 'payment_status', 'userid'], 'integer'],
            [['paid_cash', 'paid_creditcard', 'piad_banktransfer', 'paid_amt'], 'number'],
            [['creditcard_issueby', 'creditcard_expdate', 'creditcard_approvedcode', 'paid_banktransfer_date', 'piad_banktransfer_bankname', 'piad_Cheque', 'cheque_date', 'cheque_bankname', 'payment_comment', 'piad_type'], 'safe'],
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
    public function search($params,$rep_id)
    {
        $query = VwFiItemPayment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'payment_id' => $this->payment_id,
            'rep_id' => $this->rep_id,
            'paid_cash' => $this->paid_cash,
            'paid_creditcard' => $this->paid_creditcard,
            'creditcard_number' => $this->creditcard_number,
            'creditcard_type' => $this->creditcard_type,
            'creditcard_expdate' => $this->creditcard_expdate,
            'piad_banktransfer' => $this->piad_banktransfer,
            'paid_banktransfer_date' => $this->paid_banktransfer_date,
            'bankaccount_number' => $this->bankaccount_number,
            'cheque_number' => $this->cheque_number,
            'cheque_date' => $this->cheque_date,
            'payment_status' => $this->payment_status,
            'userid' => $this->userid,
            'paid_amt' => $this->paid_amt,
        ]);

        $query->orFilterWhere(['like', 'creditcard_issueby', $this->creditcard_issueby])
            ->orFilterWhere(['like', 'creditcard_approvedcode', $this->creditcard_approvedcode])
            ->orFilterWhere(['like', 'piad_banktransfer_bankname', $this->piad_banktransfer_bankname])
            ->orFilterWhere(['like', 'piad_Cheque', $this->piad_Cheque])
            ->orFilterWhere(['like', 'cheque_bankname', $this->cheque_bankname])
            ->orFilterWhere(['like', 'payment_comment', $this->payment_comment])
            ->orFilterWhere(['like', 'piad_type', $this->piad_type])
            ->andFilterWhere(['rep_id'=>$rep_id]);

        return $dataProvider;
    }
}
