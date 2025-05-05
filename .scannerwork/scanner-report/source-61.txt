<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "isomsg".
 *
 * @property int $isomsg_id
 * @property int $isomsg_isotrx_id
 * @property string $isomsg_bit
 * @property string|null $isomsg_reply_exist
 * @property string|null $isomsg_same
 * @property string|null $isomsg_random
 * @property string|null $isomsg_hexa
 * @property string|null $isomsg_data
 * @property string|null $isomsg_feature
 * @property string $isomsg_created_by
 * @property string $isomsg_created_dt
 * @property string|null $isomsg_updated_by
 * @property string|null $isomsg_updated_dt
 *
 * @property Isotrx $isomsgIsotrx
 */
class Isomsg extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'isomsg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['isomsg_isotrx_id', 'isomsg_bit'], 'required', 'message' => 'Harus di isi!'],
                [['isomsg_isotrx_id'], 'integer'],
                [['isomsg_created_dt', 'isomsg_updated_dt'], 'safe'],
                [['isomsg_bit'], 'string', 'max' => 3],
                [['isomsg_feature'], 'string', 'max' => 2],
                [['isomsg_reply_exist', 'isomsg_same', 'isomsg_random', 'isomsg_hexa'], 'string', 'max' => 1],
                [['isomsg_data'], 'string', 'max' => 2000],
                [['isomsg_created_by', 'isomsg_updated_by'], 'string', 'max' => 100],
                [['isomsg_isotrx_id'], 'exist', 'skipOnError' => true, 'targetClass' => Isotrx::className(), 'targetAttribute' => ['isomsg_isotrx_id' => 'isotrx_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'isomsg_id' => 'Isomsg ID',
            'isomsg_isotrx_id' => 'Isomsg Isotrx ID',
            'isomsg_bit' => 'Isomsg Bit',
            'isomsg_reply_exist' => 'Isomsg Reply Exist',
            'isomsg_same' => 'Isomsg Same',
            'isomsg_random' => 'Isomsg Random',
            'isomsg_hexa' => 'Isomsg Hexa',
            'isomsg_data' => 'Isomsg Data',
            'isomsg_feature' => 'Isomsg Feature',
            'isomsg_created_by' => 'Isomsg Created By',
            'isomsg_created_dt' => 'Isomsg Created Dt',
            'isomsg_updated_by' => 'Isomsg Updated By',
            'isomsg_updated_dt' => 'Isomsg Updated Dt',
        ];
    }

    /**
     * Gets query for [[IsomsgIsotrx]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIsomsgIsotrx() {
        return $this->hasOne(Isotrx::className(), ['isotrx_id' => 'isomsg_isotrx_id']);
    }

    public function beforeSave($insert) {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            //insert
            $this->isomsg_created_by = Yii::$app->user->identity->user_name;
            $this->isomsg_created_dt = date('Y-m-d H:i:s');
        } else {
            //update
            $this->isomsg_updated_by = Yii::$app->user->identity->user_name;
            $this->isomsg_updated_dt = date('Y-m-d H:i:s');
            return true;
        }
        return true;
    }

}
