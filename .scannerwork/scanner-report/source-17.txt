<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use Yii;

/**
 * Description of UtilsHelper
 *
 * @author SinggihA1
 */
define('CRC16POLYN', 0x1021);

class UtilsHelper {

    public function arrayMerge($array1, $array2) {
        $result = [];
        foreach ($array1 as $key => $value) {
            $result[$key] = $value;
        }
        foreach ($array2 as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    public function CRC16Normal($buffer) {
        $result = 0xFFFF;
        if (($length = strlen($buffer)) > 0) {
            for ($offset = 0; $offset < $length; $offset++) {
                $result ^= (ord($buffer[$offset]) << 8);
                for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                    if (($result <<= 1) & 0x10000)
                        $result ^= CRC16POLYN;
                    $result &= 0xFFFF; /* gut the overflow as php has no 16 bit types */
                }
            }
        }
        return strtoupper(dechex($result));
    }
    
    public function parseQrString($qrString) {
        $result = [];
        $idx = 0;
        while ($idx < strlen($qrString)) {
            $key = substr($qrString, $idx, 2); $idx += 2;
            $length = intval(substr($qrString, $idx, 2)); $idx += 2;
            $data = substr($qrString, $idx, $length); $idx += $length;
            $result[$key] = $data;
        }
        return $result;
    }

    public function apiPackResponse($responseCode, $responseDesc, $data = null) {
        if (is_null($data)) {
            $retVal = [
                'rspCode' => (int) $responseCode,
                'rspMsg' => (string) str_replace([' ', '.'], ['-', ''], strtolower($responseDesc))
            ];
        } else {
            $retVal = array_merge(['rspData' => $data], [
                'rspCode' => (int) $responseCode,
                'rspMsg' => (string) str_replace([' ', '.'], ['-', ''], strtolower($responseDesc))
            ]);
        }
        Yii::$app->response->headers->add('content-length', strlen(json_encode($retVal)));
        return $retVal;
    }

}
