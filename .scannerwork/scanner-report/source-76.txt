<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Record;

/**
 * RecordSearch represents the model behind the search form of `app\models\Record`.
 */
class RecordSearch extends Record {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['record_id', 'record_host_id', 'record_isotrx_id'], 'integer'],
                [['record_msg_type', 'record_proc_code', 'record_tid', 'record_mid', 'record_data', 'record_dt', 'record_deleted'], 'safe'],
                [['record_base_amount', 'record_add_amount', 'record_total_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Record::find();

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
            'record_id' => $this->record_id,
            'record_host_id' => $this->record_host_id,
            'record_isotrx_id' => $this->record_isotrx_id,
            'record_base_amount' => $this->record_base_amount,
            'record_add_amount' => $this->record_add_amount,
            'record_total_amount' => $this->record_total_amount,
//            'record_dt' => $this->record_dt,
        ]);

        $query->andFilterWhere(['like', 'record_msg_type', $this->record_msg_type])
                ->andFilterWhere(['like', 'record_proc_code', $this->record_proc_code])
                ->andFilterWhere(['like', 'record_tid', $this->record_tid])
                ->andFilterWhere(['like', 'record_mid', $this->record_mid])
                ->andFilterWhere(['like', 'record_data', $this->record_data])
                ->andFilterWhere(['like', 'record_dt', $this->record_dt . '%', false])
                ->andFilterWhere(['like', 'record_deleted', $this->record_deleted]);

        $query->orderBy(['record_id' => SORT_DESC]);
        return $dataProvider;
    }

}
