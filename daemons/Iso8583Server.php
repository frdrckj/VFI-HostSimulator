<?php

namespace app\daemons;

use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Server;
use Yii;

class Iso8583Server {

    public function start($port) {
        $loop = Factory::create();
        $socket = new Server('127.0.0.1:' . $port, $loop, ['so_reuseport' => true]);

        $socket->on('connection', function (ConnectionInterface $connection) use ($socket) {
            $socket->pause();
            echo 'Connected from ' . $socket->getAddress() . "\n";
            $dtIn = date('Y-m-d H:i:s');

            $connection->on('data', function ($recvIso) use ($connection, $socket, $dtIn) {
                $recvIso = strtoupper(bin2hex($recvIso));
                exec('/usr/bin/php74 ' . Yii::$app->basePath . '/yii iso8583/process "' . $recvIso . '" "' . $dtIn . '"', $retVal);
                if (substr($retVal[0], 0, 3) == 'OKE') {
                    $sendIso = hex2bin(substr($retVal[0], 3));
                    $connection->write($sendIso);
                }
                if (substr($retVal[0], 0, 3) != 'RTO') {
                    $connection->end();
                    $socket->resume();
                }
            });

            $connection->on('close', function () use ($socket) {
                echo "Closed connection\n";
                $socket->resume();
            });

            $connection->on('error', function (Exception $e) use ($socket) {
                echo $e->getMessage();
                $socket->resume();
            });
        });

        $socket->on('error', function (Exception $error) {
            echo $error->getMessage();
        });

        $loop->run();
    }

    public function startSecure($port) {
        $loop = Factory::create();
        $socket = new Server('tls://127.0.0.1:' . $port, $loop, [
            'so_reuseport' => true,
//           SSL context options
            'tls' => [
                'allow_self_signed' => true,
                'local_cert' => Yii::$app->basePath . '/assets/cacert.pem'
            ]
        ]);

        $socket->on('connection', function (ConnectionInterface $connection) use ($socket) {
            $socket->pause();
            echo 'Connected from ' . $socket->getAddress() . "\n";
            $dtIn = date('Y-m-d H:i:s');

            $connection->on('data', function ($recvIso) use ($connection, $socket, $dtIn) {
                $recvIso = strtoupper(bin2hex($recvIso));
                exec('/usr/bin/php74 ' . Yii::$app->basePath . '/yii iso8583/process "' . $recvIso . '" "' . $dtIn . '"', $retVal);
                if (substr($retVal[0], 0, 3) == 'OKE') {
                    $sendIso = hex2bin(substr($retVal[0], 3));
                    $connection->write($sendIso);
                }
                if (substr($retVal[0], 0, 3) != 'RTO') {
                    $connection->end();
                    $socket->resume();
                }
            });

            $connection->on('close', function () use ($socket) {
                echo "Closed connection\n";
                $socket->resume();
            });

            $connection->on('error', function (Exception $e) use ($socket) {
                echo $e->getMessage();
                $socket->resume();
            });
        });

        $socket->on('error', function (Exception $error) {
            echo $error->getMessage();
        });

        $loop->run();
    }

}
