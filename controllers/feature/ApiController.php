<?php

namespace app\controllers\feature;

use app\components\BriHelper;
use app\components\CimbHelper;
use app\components\UtilsHelper;
use app\controllers\feature\BaseController;
use app\models\CardAccount;
use app\models\PlnAccount;
use app\models\QrisVfi;
use Yii;

class ApiController extends BaseController {

    private function getTrxRspMsg($rspCode) {
        $rspMsg = [
            0 => 'success',
            1 => 'invalid qr',
            2 => 'qr not found',
            3 => 'already paid',
            4 => 'failed to pay',
            5 => 'failed to generate',
            6 => 'invalid amount',
            7 => 'unable to locate record',
            8 => 'insufficient funds'
        ];
        return $rspMsg[$rspCode];
    }

    private function vfiQrProcess($qrTag, $pay) {
        $tag62 = UtilsHelper::parseQrString($qrTag['62']);
        if (isset($tag62['05'])) {
            $qris = QrisVfi::find()->where(['qris_id' => intval($tag62['05'])])->one();
            if ($qris instanceof QrisVfi) {
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

    private function qrProcess($pay) {
        $reqParam = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        if (!is_null($reqParam) && isset($reqParam['qrString'])) {
            $tag = UtilsHelper::parseQrString($reqParam['qrString']);
            if (isset($tag['26'])) {
                $tag26 = UtilsHelper::parseQrString($tag['26']);
                if (isset($tag26['00'])) {
                    switch ($tag26['00']) {
                        case 'ID.CO.CIMBNIAGA.WWW':
                            $cimb = new CimbHelper();
                            $ret = $cimb->apiQrProcess($tag, $pay);
                            $rspCode = $ret[0];
                            $data = $ret[1];
                            break;
                        case 'ID.CO.BRI.WWW':
                            $bri = new BriHelper();
                            $ret = $bri->apiQrProcess($tag, $pay);
                            $rspCode = $ret[0];
                            $data = $ret[1];
                            break;
                        case 'ID.CO.VFINDO.WWW':
                            $ret = $this->vfiQrProcess($tag, $pay);
                            $rspCode = $ret[0];
                            $data = $ret[1];
                            break;
                        default:
                            $rspCode = 1;
                            $data = null;
                    }
                } else {
                    $rspCode = 1;
                    $data = null;
                }
            } else {
                $rspCode = 1;
                $data = null;
            }
            return UtilsHelper::apiPackResponse($rspCode, $this->getTrxRspMsg($rspCode), $data);
        } else {
            return UtilsHelper::apiPackResponse(400, 'bad-request');
        }
    }

    public function actionCheckqr() {
        return $this->qrProcess(false);
    }

    public function actionPayqr() {
        return $this->qrProcess(true);
    }

    public function actionCreateqr() {
        $reqParam = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        if (!is_null($reqParam) && isset($reqParam['totalAmount'])) {
            $totalAmt = intval($reqParam['totalAmount']);
            if (isset($reqParam['addAmount'])) {
                $addAmt = intval($reqParam['addAmount']);
            } else {
                $addAmt = 0;
            }
            if ($addAmt > $totalAmt) {
                $rspCode = 6;
                $data = null;
            } else {
                $qris = new QrisVfi();
                $qris->qris_trx_dt = date('Y-m-d H:i:s');
                $qris->qris_base_amount = $totalAmt - $addAmt;
                $qris->qris_add_amount = $addAmt;
                $qris->qris_total_amount = $totalAmt;
                if ($qris->save()) {
                    $rspCode = 0;
                    $data['qrString'] = '0002010102120416111122223333444426680016ID.CO.VFINDO.WWW011893600022000016305402150000081585000060303UME51450015ID.OR.QRNPG.WWW0215ID10200285190610303UME52045812530336054' . sprintf('%02d', strlen(strval($totalAmt))) . $totalAmt . '5802ID5918VERIFONE INDONESIA6007JAKARTA61051022062220506' . sprintf('%06d', $qris->qris_id) . '0708123456786304';
                    $data['qrString'] .= (UtilsHelper::CRC16Normal($data['qrString']));
                } else {
                    $rspCode = 5;
                    $data = null;
                }
            }
            return UtilsHelper::apiPackResponse($rspCode, $this->getTrxRspMsg($rspCode), $data);
        } else {
            return UtilsHelper::apiPackResponse(400, 'bad-request');
        }
    }

    public function actionBalinq() {
        $reqParam = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        if (!is_null($reqParam) && isset($reqParam['cardNo']) && isset($reqParam['stan']) && isset($reqParam['terminalId']) && isset($reqParam['merchantId'])) {
            $cardAcc = CardAccount::find()->where(['cr_acc_card_no' => $reqParam['cardNo']])->one();
            if ($cardAcc instanceof CardAccount) {
                $rspCode = 0;
                $data['balance'] = intval($cardAcc->cr_acc_balance);
                $data['stan'] = $reqParam['stan'];
                $data['time'] = date('His');
                $data['date'] = date('md');
                $data['rrn'] = (string) random_int(pow(10, 11), pow(10, 12) - 1);
                $data['approval'] = (string) random_int(pow(10, 5), pow(10, 6) - 1);
                $data['terminal'] = $reqParam['terminalId'];
                $data['merchant'] = $reqParam['merchantId'];
            } else {
                $rspCode = 7;
                $data = null;
            }
            return UtilsHelper::apiPackResponse($rspCode, $this->getTrxRspMsg($rspCode), $data);
        } else {
            return UtilsHelper::apiPackResponse(400, 'bad-request');
        }
    }

    public function actionPlninq() {
        $reqParam = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        if (!is_null($reqParam) && isset($reqParam['idPelanggan'])) {
            $plnAcc = PlnAccount::find()->where(['pln_acc_id' => intval($reqParam['idPelanggan'])])->one();
            if ($plnAcc instanceof PlnAccount) {
                if ($plnAcc->pln_acc_paid == '0') {
                    $rspCode = 0;
                    $data['dataPelanggan'] = [
                        'nama' => $plnAcc->pln_acc_nama,
                        'tagihan' => intval($plnAcc->pln_acc_tagihan),
                        'admin' => intval($plnAcc->pln_acc_admin)
                    ];
                } else {
                    $rspCode = 3;
                    $data = null;
                }
            } else {
                $rspCode = 7;
                $data = null;
            }
            return UtilsHelper::apiPackResponse($rspCode, $this->getTrxRspMsg($rspCode), $data);
        } else {
            return UtilsHelper::apiPackResponse(400, 'bad-request');
        }
    }

    public function actionPlnpay() {
        $reqParam = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        if (!is_null($reqParam) && isset($reqParam['cardNo']) && isset($reqParam['stan']) && isset($reqParam['terminalId']) && isset($reqParam['merchantId']) && isset($reqParam['idPelanggan']) && isset($reqParam['totalPembayaran'])) {
            $cardAcc = CardAccount::find()->where(['cr_acc_card_no' => $reqParam['cardNo']])->one();
            if ($cardAcc instanceof CardAccount) {
                $plnAcc = PlnAccount::find()->where(['pln_acc_id' => intval($reqParam['idPelanggan'])])->one();
                if ($plnAcc instanceof PlnAccount) {
                    if ($plnAcc->pln_acc_paid == '0') {
                        $amount = intval($reqParam['totalPembayaran']);
                        if (intval($plnAcc->pln_acc_tagihan + $plnAcc->pln_acc_admin) == $amount) {
                            $cardAcc->cr_acc_balance -= $amount;
                            if ($cardAcc->cr_acc_balance >= 0) {
                                $plnAcc->pln_acc_paid = '1';
                                if (($cardAcc->save()) && ($plnAcc->save())) {
                                    $rspCode = 0;
                                    $data['stan'] = $reqParam['stan'];
                                    $data['time'] = date('His');
                                    $data['date'] = date('md');
                                    $data['rrn'] = (string) random_int(pow(10, 11), pow(10, 12) - 1);
                                    $data['approval'] = (string) random_int(pow(10, 5), pow(10, 6) - 1);
                                    $data['terminal'] = $reqParam['terminalId'];
                                    $data['merchant'] = $reqParam['merchantId'];
                                    $data['dataPelanggan'] = [
                                        'nama' => $plnAcc->pln_acc_nama,
                                        'tagihan' => intval($plnAcc->pln_acc_tagihan),
                                        'admin' => intval($plnAcc->pln_acc_admin)
                                    ];
                                } else {
                                    $rspCode = 4;
                                    $data = null;
                                }
                            } else {
                                $rspCode = 8;
                                $data = null;
                            }
                        } else {
                            $rspCode = 6;
                            $data = null;
                        }
                    } else {
                        $rspCode = 3;
                        $data = null;
                    }
                } else {
                    $rspCode = 7;
                    $data = null;
                }
            } else {
                $rspCode = 7;
                $data = null;
            }
            return UtilsHelper::apiPackResponse($rspCode, $this->getTrxRspMsg($rspCode), $data);
        } else {
            return UtilsHelper::apiPackResponse(400, 'bad-request');
        }
    }

}
