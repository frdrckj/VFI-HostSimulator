<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pln_account".
 *
 * @property int $pln_acc_id
 * @property string $pln_acc_nama
 * @property float|null $pln_acc_tagihan
 * @property float|null $pln_acc_admin
 * @property string|null $pln_acc_paid
 * @property string $pln_acc_created_by
 * @property string $pln_acc_created_dt
 * @property string|null $pln_acc_updated_by
 * @property string|null $pln_acc_updated_dt
 */
class PlnAccount extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'pln_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['pln_acc_nama', 'pln_acc_tagihan'], 'required', 'message' => 'Harus di isi!'],
                [['pln_acc_tagihan', 'pln_acc_admin'], 'number'],
                [['pln_acc_created_dt', 'pln_acc_updated_dt'], 'safe'],
                [['pln_acc_nama', 'pln_acc_created_by', 'pln_acc_updated_by'], 'string', 'max' => 100],
                [['pln_acc_paid'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'pln_acc_id' => 'Pln Acc ID',
            'pln_acc_nama' => 'Pln Acc Nama',
            'pln_acc_tagihan' => 'Pln Acc Tagihan',
            'pln_acc_admin' => 'Pln Acc Admin',
            'pln_acc_paid' => 'Pln Acc Paid',
            'pln_acc_created_by' => 'Pln Acc Created By',
            'pln_acc_created_dt' => 'Pln Acc Created Dt',
            'pln_acc_updated_by' => 'Pln Acc Updated By',
            'pln_acc_updated_dt' => 'Pln Acc Updated Dt',
        ];
    }

    public function beforeSave($insert) {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            //insert
            if (!$this->pln_acc_admin) {
                $this->pln_acc_admin = 0.00;
            }
            if (isset(Yii::$app->user->identity->user_name)) {
                $this->pln_acc_created_by = Yii::$app->user->identity->user_name;
                $this->pln_acc_created_dt = date('Y-m-d H:i:s');
            }
        } else {
            //update
            if (isset(Yii::$app->user->identity->user_name)) {
                if (!$this->pln_acc_admin) {
                    $this->pln_acc_admin = 0.00;
                }
                $this->pln_acc_paid = '0';
                $this->pln_acc_updated_by = Yii::$app->user->identity->user_name;
                $this->pln_acc_updated_dt = date('Y-m-d H:i:s');
            }
            return true;
        }
        return true;
    }

}
