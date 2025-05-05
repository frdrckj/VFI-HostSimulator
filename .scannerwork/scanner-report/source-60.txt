<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Host;

/**
 * HostSearch represents the model behind the search form of `app\models\Host`.
 */
class HostSearch extends Host
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['host_id'], 'integer'],
            [['host_name', 'host_nii', 'host_reply', 'host_created_by', 'host_created_dt', 'host_updated_by', 'host_updated_dt'], 'safe'],
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
        $query = Host::find();

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
            'host_id' => $this->host_id,
            'host_created_dt' => $this->host_created_dt,
            'host_updated_dt' => $this->host_updated_dt,
        ]);

        $query->andFilterWhere(['like', 'host_name', $this->host_name])
            ->andFilterWhere(['like', 'host_nii', $this->host_nii])
            ->andFilterWhere(['like', 'host_reply', $this->host_reply])
            ->andFilterWhere(['like', 'host_created_by', $this->host_created_by])
            ->andFilterWhere(['like', 'host_updated_by', $this->host_updated_by]);

        return $dataProvider;
    }
}
