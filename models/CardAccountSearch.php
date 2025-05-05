<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CardAccount;

/**
 * CardAccountSearch represents the model behind the search form of `app\models\CardAccount`.
 */
class CardAccountSearch extends CardAccount
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cr_acc_id'], 'integer'],
            [['cr_acc_card_no', 'cr_acc_created_by', 'cr_acc_created_dt', 'cr_acc_updated_by', 'cr_acc_updated_dt'], 'safe'],
            [['cr_acc_balance'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = CardAccount::find();

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
            'cr_acc_id' => $this->cr_acc_id,
            'cr_acc_balance' => $this->cr_acc_balance,
            'cr_acc_created_dt' => $this->cr_acc_created_dt,
            'cr_acc_updated_dt' => $this->cr_acc_updated_dt,
        ]);

        $query->andFilterWhere(['like', 'cr_acc_card_no', $this->cr_acc_card_no])
            ->andFilterWhere(['like', 'cr_acc_created_by', $this->cr_acc_created_by])
            ->andFilterWhere(['like', 'cr_acc_updated_by', $this->cr_acc_updated_by]);

        return $dataProvider;
    }
}
