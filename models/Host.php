<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "host".
 *
 * @property int $host_id
 * @property string $host_name
 * @property string $host_nii
 * @property string|null $host_reply
 * @property string $host_created_by
 * @property string $host_created_dt
 * @property string|null $host_updated_by
 * @property string|null $host_updated_dt
 *
 * @property Isotrx[] $isotrxes
 * @property Record[] $records
 */
class Host extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'host';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['host_name', 'host_nii', 'host_reply'], 'required', 'message' => 'Harus di isi!'],
                [['host_created_dt', 'host_updated_dt'], 'safe'],
                [['host_name'], 'string', 'max' => 50],
                [['host_nii'], 'string', 'max' => 10],
                [['host_reply'], 'string', 'max' => 1],
                [['host_created_by', 'host_updated_by'], 'string', 'max' => 100],
//                [['host_nii'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'host_id' => 'Host ID',
            'host_name' => 'Host Name',
            'host_nii' => 'Host Nii',
            'host_reply' => 'Host Reply',
            'host_created_by' => 'Host Created By',
            'host_created_dt' => 'Host Created Dt',
            'host_updated_by' => 'Host Updated By',
            'host_updated_dt' => 'Host Updated Dt',
        ];
    }

    /**
     * Gets query for [[Isotrxes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIsotrxes() {
        return $this->hasMany(Isotrx::className(), ['isotrx_host_id' => 'host_id']);
    }

    /**
     * Gets query for [[Records]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecords() {
        return $this->hasMany(Record::className(), ['record_host_id' => 'host_id']);
    }

    public function beforeSave($insert) {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            //insert
            $this->host_created_by = Yii::$app->user->identity->user_name;
            $this->host_created_dt = date('Y-m-d H:i:s');
        } else {
            //update
            $this->host_updated_by = Yii::$app->user->identity->user_name;
            $this->host_updated_dt = date('Y-m-d H:i:s');
            return true;
        }
        return true;
    }

}
