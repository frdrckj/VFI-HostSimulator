<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "card_account".
 *
 * @property int $cr_acc_id
 * @property string $cr_acc_card_no
 * @property float|null $cr_acc_balance
 * @property string $cr_acc_created_by
 * @property string $cr_acc_created_dt
 * @property string|null $cr_acc_updated_by
 * @property string|null $cr_acc_updated_dt
 */
class CardAccount extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'card_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['cr_acc_card_no', 'cr_acc_balance'], 'required', 'message' => 'Harus di isi!'],
                [['cr_acc_balance'], 'number'],
                [['cr_acc_created_dt', 'cr_acc_updated_dt'], 'safe'],
                [['cr_acc_card_no'], 'string', 'max' => 20],
                [['cr_acc_created_by', 'cr_acc_updated_by'], 'string', 'max' => 100],
                [['cr_acc_card_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'cr_acc_id' => 'Cr Acc ID',
            'cr_acc_card_no' => 'Cr Acc Card No',
            'cr_acc_balance' => 'Cr Acc Balance',
            'cr_acc_created_by' => 'Cr Acc Created By',
            'cr_acc_created_dt' => 'Cr Acc Created Dt',
            'cr_acc_updated_by' => 'Cr Acc Updated By',
            'cr_acc_updated_dt' => 'Cr Acc Updated Dt',
        ];
    }

    public function beforeSave($insert) {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            //insert
            if (isset(Yii::$app->user->identity->user_name)) {
                $this->cr_acc_created_by = Yii::$app->user->identity->user_name;
                $this->cr_acc_created_dt = date('Y-m-d H:i:s');
            }
        } else {
            //update
            if (isset(Yii::$app->user->identity->user_name)) {
                $this->cr_acc_updated_by = Yii::$app->user->identity->user_name;
                $this->cr_acc_updated_dt = date('Y-m-d H:i:s');
            }
            return true;
        }
        return true;
    }

}
