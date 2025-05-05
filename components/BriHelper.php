<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use app\models\QrisBri;
use yii\db\Expression;

/**
 * Description of BriHelper
 *
 * @author SinggihA1
 */
class BriHelper {

    public function apiQrProcess($qrTag, $pay) {
        $tag62 = UtilsHelper::parseQrString($qrTag['62']);
        if (isset($tag62['01'])) {
            $qris = QrisBri::find()->where([
                'qris_id' => intval(substr($tag62['01'], 0, 6)),
                'qris_org_rrn' => substr($tag62['01'], 6)
                ])->one();
            if ($qris instanceof QrisBri) {
                if ($qris->qris_approval_code) {
                    return [3, null];
                } else {
                    $data = [
                        'trxDateTime' => $qris->qris_trx_dt,
                        'baseAmount' => $qris->qris_base_amount,
                        'addAmount' => $qris->qris_add_amount,
                        'totalAmount' => $qris->qris_total_amount
                    ];
                    if ($pay) {
                        $qris->qris_approval_dt = date('Y-m-d H:i:s');
                        $qris->qris_approval_code = (string) random_int(pow(10, 5), pow(10, 6) - 1);
                        if (!$qris->save()) {
                            return [4, null];
                        }
                        $data['payDateTime'] = $qris->qris_approval_dt;
                        $data['approvalCode'] = $qris->qris_approval_code;
                    }
                    return [0, $data];
                }
            } else {
                return [2, null];
            }
        }
        return [1, null];
    }

    private function getAmount($isoBit4, $isoBit54) {
        if ($isoBit4) {
            $total = intval($isoBit4);
        } else {
            $total = 0;
        }
        if ($isoBit54) {
            $add = intval(hex2bin($isoBit54));
        } else {
            $add = 0;
        }
        return [$add, $total];
    }

    private function getDateTime($isoDate, $isoTime) {
        return date('Y') . '-' . substr($isoDate, 0, 2) . '-' . substr($isoDate, 2, 2) . ' ' . substr($isoTime, 0, 2) . ':' . substr($isoTime, 2, 2) . ':' . substr($isoTime, 4, 2);
    }

    public function qrisMpmCreate($isoReq, $isoRsp, $bit) {
        switch ($bit) {
            case 37:
                $isoDate = $isoRsp->getBit('13');
                $isoTime = $isoRsp->getBit('12');
                $qris = new QrisBri();
                $qris->qris_trx_dt = $this->getDateTime($isoDate, $isoTime);
                $qris->qris_org_rrn = (string) random_int(0, 9) . $isoDate . $isoTime . (string) random_int(0, 9);
                $amount = $this->getAmount($isoReq->getBit('4'), $isoReq->getBit('48'));
                $qris->qris_base_amount = $amount[1] - $amount[0];
                $qris->qris_add_amount = $amount[0];
                $qris->qris_total_amount = $amount[1];
                if ($qris->save()) {
                    $data = $qris->qris_org_rrn;
                } else {
                    $data = null;
                }
                break;
            case 39:
                $qris = QrisBri::find()->where(['qris_org_rrn' => hex2bin($isoRsp->getBit('37'))])->one();
                if ($qris instanceof QrisBri) {
                    $data = '00';
                } else {
                    $data = '12';
                }
                break;
            case 48:
                $qris = QrisBri::find()->where(['qris_org_rrn' => hex2bin($isoRsp->getBit('37'))])->one();
                if ($qris instanceof QrisBri) {
                    $data = '00020101021226650013ID.CO.BRI.WWW011893600002011067409602150000010033400000303UME52045021530336054';
                    $amount = strval(intval($qris->qris_total_amount));
                    $data .= (sprintf('%02d', strlen($amount)) . $amount);
                    if ($qris->qris_add_amount > 0) {
                        $data .= ('55020256015');
                    } else {
                        $data .= ('55020256010');
                    }
                    $data .= ('5802ID5918VERIFONE INDONESIA6007JAKARTA61051022062220118' . sprintf('%06d', $qris->qris_id) . sprintf('%012s', $qris->qris_org_rrn) . '6304');
                    $data .= (UtilsHelper::CRC16Normal($data));
                } else {
                    $data = null;
                }
                break;
            default:
                $data = null;
        }
        return $data;
    }

    public function qrisMpmCheck($isoReq, $isoRsp, $bit) {
        switch ($bit) {
            case 39:
                $qris = QrisBri::find()->where(['and',
                                ['qris_org_rrn' => hex2bin($isoReq->getBit('48'))],
                                ['IS NOT', 'qris_approval_code', new Expression('NULL')]
                        ])->one();
                if ($qris instanceof QrisBri) {
                    $data = '00';
                } else {
                    $data = '21';
                }
                break;
            case 48:
                $qris = QrisBri::find()->where(['and',
                                ['qris_org_rrn' => hex2bin($isoReq->getBit('48'))],
                                ['IS NOT', 'qris_approval_code', new Expression('NULL')]
                        ])->one();
                if ($qris instanceof QrisBri) {
                    $data = '9360000201007074240000' . substr($qris->qris_approval_dt, 5, 2) . substr($qris->qris_approval_dt, 8, 2) . substr($qris->qris_approval_dt, 11, 2) . substr($qris->qris_approval_dt, 14, 2) . substr($qris->qris_approval_dt, 17, 2) . sprintf('%010d', $qris->qris_id) . sprintf('%012d', intval($qris->qris_add_amount));
                    $data .= ('Bogel Ganteng            ****************7494VERIFONE INDONESIA  ');
                } else {
                    $data = null;
                }
                break;
            default:
                $data = null;
        }
        return $data;
    }

    public function qrisMpmRefund($isoReq, $isoRsp, $bit) {
        switch ($bit) {
            case 39:
                $qris = QrisBri::find()->where(['and',
                                ['qris_id' => intval(hex2bin($isoReq->getBit('48')))],
                                ['IS NOT', 'qris_approval_code', new Expression('NULL')]
                        ])->one();
                if ($qris instanceof QrisBri) {
                    $data = '00';
                } else {
                    $data = '12';
                }
                break;
            case 48:
                $qris = QrisBri::find()->where(['and',
                                ['qris_id' => intval(hex2bin($isoReq->getBit('48')))],
                                ['IS NOT', 'qris_approval_code', new Expression('NULL')]
                        ])->one();
                if ($qris instanceof QrisBri) {
                    $data = '9360000201007074240000' . substr($qris->qris_approval_dt, 5, 2) . substr($qris->qris_approval_dt, 8, 2) . substr($qris->qris_approval_dt, 11, 2) . substr($qris->qris_approval_dt, 14, 2) . substr($qris->qris_approval_dt, 17, 2) . sprintf('%010d', $qris->qris_id) . sprintf('%012d', intval($qris->qris_add_amount));
                    $data .= ('Bogel Ganteng            ****************7494VERIFONE INDONESIA  ');
                    $qris->delete();
                } else {
                    $data = null;
                }
                break;
            default:
                $data = null;
        }
        return $data;
    }

}
