<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "record".
 *
 * @property int $record_id
 * @property int $record_host_id
 * @property int $record_isotrx_id
 * @property string $record_msg_type
 * @property string $record_proc_code
 * @property string|null $record_tid
 * @property string|null $record_mid
 * @property float|null $record_base_amount
 * @property float|null $record_add_amount
 * @property float|null $record_total_amount
 * @property string $record_data
 * @property string $record_dt
 * @property string|null $record_deleted
 *
 * @property Host $recordHost
 * @property Isotrx $recordIsotrx
 */
class Record extends \yii\db\ActiveRecord {

    public $hostOptions;
    public $trxOptions;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['record_host_id', 'record_isotrx_id', 'record_msg_type', 'record_proc_code', 'record_data'], 'required'],
                [['record_host_id', 'record_isotrx_id'], 'integer'],
                [['record_base_amount', 'record_add_amount', 'record_total_amount'], 'number'],
                [['record_data'], 'string'],
                [['record_dt'], 'safe'],
                [['record_msg_type'], 'string', 'max' => 4],
                [['record_proc_code'], 'string', 'max' => 6],
                [['record_tid'], 'string', 'max' => 8],
                [['record_mid'], 'string', 'max' => 15],
                [['record_deleted'], 'string', 'max' => 1],
                [['record_host_id'], 'exist', 'skipOnError' => true, 'targetClass' => Host::className(), 'targetAttribute' => ['record_host_id' => 'host_id']],
                [['record_isotrx_id'], 'exist', 'skipOnError' => true, 'targetClass' => Isotrx::className(), 'targetAttribute' => ['record_isotrx_id' => 'isotrx_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'record_id' => 'Record ID',
            'record_host_id' => 'Record Host ID',
            'record_isotrx_id' => 'Record Isotrx ID',
            'record_msg_type' => 'Record Msg Type',
            'record_proc_code' => 'Record Proc Code',
            'record_tid' => 'Record Tid',
            'record_mid' => 'Record Mid',
            'record_base_amount' => 'Record Base Amount',
            'record_add_amount' => 'Record Add Amount',
            'record_total_amount' => 'Record Total Amount',
            'record_data' => 'Record Data',
            'record_dt' => 'Record Dt',
            'record_deleted' => 'Record Deleted',
        ];
    }

    /**
     * Gets query for [[RecordHost]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecordHost() {
        return $this->hasOne(Host::className(), ['host_id' => 'record_host_id']);
    }

    /**
     * Gets query for [[RecordIsotrx]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecordIsotrx() {
        return $this->hasOne(Isotrx::className(), ['isotrx_id' => 'record_isotrx_id']);
    }

    public function beforeSave($insert) {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            //insert
            $this->record_dt = date('Y-m-d H:i:s');
        } else {
            //update
            $this->record_dt = date('Y-m-d H:i:s');
            return true;
        }
        return true;
    }

}
