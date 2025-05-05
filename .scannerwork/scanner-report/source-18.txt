<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use app\models\CardAccount;
use app\models\PlnAccount;

/**
 * Description of BriHelper
 *
 * @author SinggihA1
 */
class VfiHelper {

    private function getCard($isoReq) {
        $card = $isoReq->getBit('35');
        if ($card) {
            $pos = strpos(strtoupper($card), 'D');
            if ($pos !== false) {
                $card = substr($card, 0, $pos);
            } else {
                $card = null;
            }
        } else {
            $card = $isoReq->getBit('2');
        }
        return $card;
    }

    private function processingBalance($isoReq, $increase) {
        $card = $this->getCard($isoReq);
        if ($card) {
            $cardAcc = CardAccount::find()->where(['cr_acc_card_no' => $card])->one();
            if ($cardAcc instanceof CardAccount) {
                $amount = intval($isoReq->getBit('4')) / 100;
                if ($amount > 0) {
                    if ($increase) {
                        $cardAcc->cr_acc_balance += $amount;
                        if ($cardAcc->save()) {
                            $data = '00';
                        } else {
                            $data = '96';
                        }
                    } else {
                        $cardAcc->cr_acc_balance -= $amount;
                        if ($cardAcc->cr_acc_balance >= 0) {
                            if ($cardAcc->save()) {
                                $data = '00';
                            } else {
                                $data = '96';
                            }
                        } else {
                            $data = '51';
                        }
                    }
                } else {
                    $data = '13';
                }
            } else {
                $data = '25';
            }
        } else {
            $data = '14';
        }
        return $data;
    }

    public function increaseBalance($isoReq, $isoRsp, $bit) {
        switch ($bit) {
            case 39:
                $data = $this->processingBalance($isoReq, true);
                break;
            default:
                $data = null;
        }
        return $data;
    }

    public function decreaseBalance($isoReq, $isoRsp, $bit) {
        switch ($bit) {
            case 39:
                $data = $this->processingBalance($isoReq, false);
                break;
            default:
                $data = null;
        }
        return $data;
    }

    public function checkBalance($isoReq, $isoRsp, $bit) {
        switch ($bit) {
            case 4:
                $card = $this->getCard($isoReq);
                if ($card) {
                    $cardAcc = CardAccount::find()->where(['cr_acc_card_no' => $card])->one();
                    if ($cardAcc instanceof CardAccount) {
                        $data = sprintf('%010.0f00', $cardAcc->cr_acc_balance);
                    } else {
                        $data = '000000000000';
                    }
                } else {
                    $data = '000000000000';
                }
                break;
            case 39:
                $card = $this->getCard($isoReq);
                if ($card) {
                    $cardAcc = CardAccount::find()->where(['cr_acc_card_no' => $card])->one();
                    if ($cardAcc instanceof CardAccount) {
                        $data = '00';
                    } else {
                        $data = '25';
                    }
                } else {
                    $data = '14';
                }
                break;
            default:
                $data = null;
        }
        return $data;
    }

    private function getIdPelanggan($isoReq) {
        $idPel = intval(hex2bin($isoReq->getBit('48')));
        if ($idPel) {
            $plnAcc = PlnAccount::find()->where(['pln_acc_id' => $idPel])->one();
            if ($plnAcc instanceof PlnAccount) {
                if ($plnAcc->pln_acc_paid == '1') {
                    $plnAcc = null;
                }
            } else {
                $plnAcc = null;
            }
        } else {
            $plnAcc = null;
        }
        return $plnAcc;
    }

    public function checkPln($isoReq, $isoRsp, $bit) {
        switch ($bit) {
            case 4:
                $plnAcc = $this->getIdPelanggan($isoReq);
                if ($plnAcc instanceof PlnAccount) {
                    $data = sprintf('%010.0f00', ($plnAcc->pln_acc_tagihan + $plnAcc->pln_acc_admin));
                } else {
                    $data = '000000000000';
                }
                break;
            case 39:
                $plnAcc = $this->getIdPelanggan($isoReq);
                if ($plnAcc instanceof PlnAccount) {
                    $data = '00';
                } else {
                    $data = '25';
                }
                break;
            case 48:
                $plnAcc = $this->getIdPelanggan($isoReq);
                if ($plnAcc instanceof PlnAccount) {
                    $data = str_pad($plnAcc->pln_acc_nama, 50, ' ') . sprintf('%010.0f00', $plnAcc->pln_acc_tagihan) . sprintf('%010.0f00', $plnAcc->pln_acc_admin);
                } else {
                    $data = '                                                                          ';
                }
                break;
            default:
                $data = null;
        }
        return $data;
    }

    public function payPln($isoReq, $isoRsp, $bit) {
        switch ($bit) {
            case 39:
                $plnAcc = $this->getIdPelanggan($isoReq);
                if ($plnAcc instanceof PlnAccount) {
                    $amount = intval($isoReq->getBit('4')) / 100;
                    if (intval($plnAcc->pln_acc_tagihan + $plnAcc->pln_acc_admin) == $amount) {
                        $plnAcc->pln_acc_paid = '1';
                        if ($plnAcc->save()) {
                            $data = $this->processingBalance($isoReq, false);
                        } else {
                            $data = '96';
                        }
                    } else {
                        $data = '13';
                    }
                } else {
                    $data = '25';
                }
                break;
            case 48:
                $plnAcc = $this->getIdPelanggan($isoReq);
                if ($plnAcc instanceof PlnAccount) {
                    $data = str_pad($plnAcc->pln_acc_nama, 50, ' ') . sprintf('%010.0f00', $plnAcc->pln_acc_tagihan) . sprintf('%010.0f00', $plnAcc->pln_acc_admin);
                } else {
                    $data = '                                                                          ';
                }
                break;
            default:
                $data = null;
        }
        return $data;
    }

}
