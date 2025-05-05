<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "isotrx".
 *
 * @property int $isotrx_id
 * @property int $isotrx_host_id
 * @property string $isotrx_name
 * @property string $isotrx_msg_type
 * @property string $isotrx_proc_code
 * @property string $isotrx_created_by
 * @property string $isotrx_created_dt
 * @property string|null $isotrx_updated_by
 * @property string|null $isotrx_updated_dt
 *
 * @property Isomsg[] $isomsgs
 * @property Host $isotrxHost
 * @property Record[] $records
 */
class Isotrx extends \yii\db\ActiveRecord {

    public $status;
    public $replyExist;
    public $type;
    public $hexa;
    public $data;
    public $feature;
    public $hostOptions;
    public $typeOptions;
    public $featureOptions;
    public $bitmapData;
    public $bitmapDefine = [
        1 => '[b 64]', //NOSONAR
        2 => '[n..19]', //NOSONAR
        3 => '[n 6]', //NOSONAR
        4 => '[n 12]', //NOSONAR
        5 => '[n 12]', //NOSONAR
        6 => '[n 12]', //NOSONAR
        7 => '[n 10]', //NOSONAR
        8 => '[n 8]', //NOSONAR
        9 => '[n 8]', //NOSONAR
        10 => '[n 8]', //NOSONAR
        11 => '[n 6]', //NOSONAR
        12 => '[n 6]', //NOSONAR
        13 => '[n 4]', //NOSONAR
        14 => '[n 4]', //NOSONAR
        15 => '[n 4]', //NOSONAR
        16 => '[n 4]', //NOSONAR
        17 => '[n 4]', //NOSONAR
        18 => '[n 4]', //NOSONAR
        19 => '[n 3]', //NOSONAR
        20 => '[n 3]', //NOSONAR
        21 => '[n 3]', //NOSONAR
        22 => '[n 3]', //NOSONAR
        23 => '[n 3]', //NOSONAR
        24 => '[n 3]', //NOSONAR
        25 => '[n 2]', //NOSONAR
        26 => '[n 2]', //NOSONAR
        27 => '[n 1]', //NOSONAR
        28 => '[x+n 8]', //NOSONAR
        29 => '[x+n 8]', //NOSONAR
        30 => '[x+n 8]', //NOSONAR
        31 => '[x+n 8]', //NOSONAR
        32 => '[n ..11]', //NOSONAR
        33 => '[n ..11]', //NOSONAR
        34 => '[ns ..28]', //NOSONAR
        35 => '[z ..37]', //NOSONAR
        36 => '[n ...104]', //NOSONAR
        37 => '[an 12]', //NOSONAR
        38 => '[an 6]', //NOSONAR
        39 => '[an 2]', //NOSONAR
        40 => '[an 3]', //NOSONAR
        41 => '[ans 8]', //NOSONAR
        42 => '[ans 15]', //NOSONAR
        43 => '[ans 40]', //NOSONAR
        44 => '[an ..25]', //NOSONAR
        45 => '[an ..76]', //NOSONAR
        46 => '[an ...999]', //NOSONAR
        47 => '[an ...999]', //NOSONAR
        48 => '[an ...999]', //NOSONAR
        49 => '[a or n 3]', //NOSONAR
        50 => '[a or n 3]', //NOSONAR
        51 => '[a or n 3]', //NOSONAR
        52 => '[b 64]', //NOSONAR
        53 => '[n 16]', //NOSONAR
        54 => '[an ...120]', //NOSONAR
        55 => '[ans ...999]', //NOSONAR
        56 => '[ans ...999]', //NOSONAR
        57 => '[ans ...999]', //NOSONAR
        58 => '[ans ...999]', //NOSONAR
        59 => '[ans ...999]', //NOSONAR
        60 => '[ans ...999]', //NOSONAR
        61 => '[ans ...999]', //NOSONAR
        62 => '[ans ...999]', //NOSONAR
        63 => '[ans ...999]', //NOSONAR
        64 => '[b 64]', //NOSONAR
        65 => '[b 1]', //NOSONAR
        66 => '[n 1]', //NOSONAR
        67 => '[n 2]', //NOSONAR
        68 => '[n 3]', //NOSONAR
        69 => '[n 3]', //NOSONAR
        70 => '[n 3]', //NOSONAR
        71 => '[n 4]', //NOSONAR
        72 => '[n 4]', //NOSONAR
        73 => '[n 6]', //NOSONAR
        74 => '[n 10]', //NOSONAR
        75 => '[n 10]', //NOSONAR
        76 => '[n 10]', //NOSONAR
        77 => '[n 10]', //NOSONAR
        78 => '[n 10]', //NOSONAR
        79 => '[n 10]', //NOSONAR
        80 => '[n 10]', //NOSONAR
        81 => '[n 10]', //NOSONAR
        82 => '[n 12]', //NOSONAR
        83 => '[n 12]', //NOSONAR
        84 => '[n 12]', //NOSONAR
        85 => '[n 12]', //NOSONAR
        86 => '[n 16]', //NOSONAR
        87 => '[n 16]', //NOSONAR
        88 => '[n 16]', //NOSONAR
        89 => '[n 16]', //NOSONAR
        90 => '[n 42]', //NOSONAR
        91 => '[an 1]', //NOSONAR
        92 => '[an 2]', //NOSONAR
        93 => '[an 5]', //NOSONAR
        94 => '[an 7]', //NOSONAR
        95 => '[an 42]', //NOSONAR
        96 => '[b 64]', //NOSONAR
        97 => '[x+n 16]', //NOSONAR
        98 => '[ans 25]', //NOSONAR
        99 => '[n ..11]', //NOSONAR
        100 => '[n ..11]', //NOSONAR
        101 => '[ans ..17]', //NOSONAR
        102 => '[ans ..28]', //NOSONAR
        103 => '[ans ..28]', //NOSONAR
        104 => '[ans ...100]', //NOSONAR
        105 => '[ans ...999]', //NOSONAR
        106 => '[ans ...999]', //NOSONAR
        107 => '[ans ...999]', //NOSONAR
        108 => '[ans ...999]', //NOSONAR
        109 => '[ans ...999]', //NOSONAR
        110 => '[ans ...999]', //NOSONAR
        111 => '[ans ...999]', //NOSONAR
        112 => '[ans ...999]', //NOSONAR
        113 => '[ans ...999]', //NOSONAR
        114 => '[ans ...999]', //NOSONAR
        115 => '[ans ...999]', //NOSONAR
        116 => '[ans ...999]', //NOSONAR
        117 => '[ans ...999]', //NOSONAR
        118 => '[ans ...999]', //NOSONAR
        119 => '[ans ...999]', //NOSONAR
        120 => '[ans ...999]', //NOSONAR
        121 => '[ans ...999]', //NOSONAR
        122 => '[ans ...999]', //NOSONAR
        123 => '[ans ...999]', //NOSONAR
        124 => '[ans ...999]', //NOSONAR
        125 => '[ans ...999]', //NOSONAR
        126 => '[ans ...999]', //NOSONAR
        127 => '[ans ...999]', //NOSONAR
        128 => '[b 64]' //NOSONAR
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'isotrx';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['isotrx_host_id', 'isotrx_name', 'isotrx_msg_type', 'isotrx_proc_code'], 'required', 'message' => 'Harus di isi!'],
                [['isotrx_host_id'], 'integer'],
                [['isotrx_created_dt', 'isotrx_updated_dt'], 'safe'],
                [['isotrx_name'], 'string', 'max' => 50],
                [['isotrx_msg_type'], 'string', 'max' => 4],
                [['isotrx_proc_code'], 'string', 'max' => 6],
                [['isotrx_created_by', 'isotrx_updated_by'], 'string', 'max' => 100],
                [['isotrx_host_id'], 'exist', 'skipOnError' => true, 'targetClass' => Host::className(), 'targetAttribute' => ['isotrx_host_id' => 'host_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'isotrx_id' => 'Isotrx ID',
            'isotrx_host_id' => 'Isotrx Host ID',
            'isotrx_name' => 'Isotrx Name',
            'isotrx_msg_type' => 'Isotrx Msg Type',
            'isotrx_proc_code' => 'Isotrx Proc Code',
            'isotrx_created_by' => 'Isotrx Created By',
            'isotrx_created_dt' => 'Isotrx Created Dt',
            'isotrx_updated_by' => 'Isotrx Updated By',
            'isotrx_updated_dt' => 'Isotrx Updated Dt',
        ];
    }

    /**
     * Gets query for [[Isomsgs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIsomsgs() {
        return $this->hasMany(Isomsg::className(), ['isomsg_isotrx_id' => 'isotrx_id']);
    }

    /**
     * Gets query for [[IsotrxHost]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIsotrxHost() {
        return $this->hasOne(Host::className(), ['host_id' => 'isotrx_host_id']);
    }

    /**
     * Gets query for [[Records]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecords() {
        return $this->hasMany(Record::className(), ['record_isotrx_id' => 'isotrx_id']);
    }

    public function load($data, $formName = null) {

        if (!parent::load($data, $formName)) {
            return false;
        }

        if (isset($data['Isotrx']['status'])) {
            $this->status = $data['Isotrx']['status'];
        }
        if (isset($data['Isotrx']['replyExist'])) {
            $this->replyExist = $data['Isotrx']['replyExist'];
        }
        if (isset($data['Isotrx']['type'])) {
            $this->type = $data['Isotrx']['type'];
        }
        if (isset($data['Isotrx']['hexa'])) {
            $this->hexa = $data['Isotrx']['hexa'];
        }
        if (isset($data['Isotrx']['data'])) {
            $this->data = $data['Isotrx']['data'];
        }
        if (isset($data['Isotrx']['feature'])) {
            $this->feature = $data['Isotrx']['feature'];
        }
        return true;
    }

    public function beforeSave($insert) {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            //insert
            $this->isotrx_created_by = Yii::$app->user->identity->user_name;
            $this->isotrx_created_dt = date('Y-m-d H:i:s');
        } else {
            //update
            $this->isotrx_updated_by = Yii::$app->user->identity->user_name;
            $this->isotrx_updated_dt = date('Y-m-d H:i:s');
            return true;
        }
        return true;
    }

}
