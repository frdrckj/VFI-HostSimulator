<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Isomsg;

/**
 * IsomsgSearch represents the model behind the search form of `app\models\Isomsg`.
 */
class IsomsgSearch extends Isomsg
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isomsg_id', 'isomsg_isotrx_id'], 'integer'],
            [['isomsg_bit', 'isomsg_reply_exist', 'isomsg_same', 'isomsg_random', 'isomsg_hexa', 'isomsg_data', 'isomsg_feature', 'isomsg_created_by', 'isomsg_created_dt', 'isomsg_updated_by', 'isomsg_updated_dt'], 'safe'],
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
        $query = Isomsg::find();

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
            'isomsg_id' => $this->isomsg_id,
            'isomsg_isotrx_id' => $this->isomsg_isotrx_id,
            'isomsg_created_dt' => $this->isomsg_created_dt,
            'isomsg_updated_dt' => $this->isomsg_updated_dt,
        ]);

        $query->andFilterWhere(['like', 'isomsg_bit', $this->isomsg_bit])
            ->andFilterWhere(['like', 'isomsg_reply_exist', $this->isomsg_reply_exist])
            ->andFilterWhere(['like', 'isomsg_same', $this->isomsg_same])
            ->andFilterWhere(['like', 'isomsg_random', $this->isomsg_random])
            ->andFilterWhere(['like', 'isomsg_hexa', $this->isomsg_hexa])
            ->andFilterWhere(['like', 'isomsg_data', $this->isomsg_data])
            ->andFilterWhere(['like', 'isomsg_feature', $this->isomsg_feature])
            ->andFilterWhere(['like', 'isomsg_created_by', $this->isomsg_created_by])
            ->andFilterWhere(['like', 'isomsg_updated_by', $this->isomsg_updated_by]);

        return $dataProvider;
    }
}
