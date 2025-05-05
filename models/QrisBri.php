<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "qris_bri".
 *
 * @property int $qris_id
 * @property string $qris_trx_dt
 * @property string|null $qris_approval_dt
 * @property string|null $qris_approval_code
 * @property string $qris_org_rrn
 * @property float|null $qris_base_amount
 * @property float|null $qris_add_amount
 * @property float|null $qris_total_amount
 */
class QrisBri extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qris_bri';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qris_trx_dt'], 'required'],
            [['qris_trx_dt', 'qris_approval_dt'], 'safe'],
            [['qris_base_amount', 'qris_add_amount', 'qris_total_amount'], 'number'],
            [['qris_approval_code'], 'string', 'max' => 6],
            [['qris_org_rrn'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'qris_id' => 'Qris ID',
            'qris_trx_dt' => 'Qris Trx Dt',
            'qris_approval_dt' => 'Qris Approval Dt',
            'qris_approval_code' => 'Qris Approval Code',
            'qris_org_rrn' => 'Qris Org Rrn',
            'qris_base_amount' => 'Qris Base Amount',
            'qris_add_amount' => 'Qris Add Amount',
            'qris_total_amount' => 'Qris Total Amount',
        ];
    }
}
