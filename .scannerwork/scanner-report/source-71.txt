<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PlnAccount;

/**
 * PlnAccountSearch represents the model behind the search form of `app\models\PlnAccount`.
 */
class PlnAccountSearch extends PlnAccount
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pln_acc_id'], 'integer'],
            [['pln_acc_nama', 'pln_acc_paid', 'pln_acc_created_by', 'pln_acc_created_dt', 'pln_acc_updated_by', 'pln_acc_updated_dt'], 'safe'],
            [['pln_acc_tagihan', 'pln_acc_admin'], 'number'],
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
        $query = PlnAccount::find();

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
            'pln_acc_id' => $this->pln_acc_id,
            'pln_acc_tagihan' => $this->pln_acc_tagihan,
            'pln_acc_admin' => $this->pln_acc_admin,
            'pln_acc_created_dt' => $this->pln_acc_created_dt,
            'pln_acc_updated_dt' => $this->pln_acc_updated_dt,
        ]);

        $query->andFilterWhere(['like', 'pln_acc_nama', $this->pln_acc_nama])
            ->andFilterWhere(['like', 'pln_acc_paid', $this->pln_acc_paid])
            ->andFilterWhere(['like', 'pln_acc_created_by', $this->pln_acc_created_by])
            ->andFilterWhere(['like', 'pln_acc_updated_by', $this->pln_acc_updated_by]);

        return $dataProvider;
    }
}
