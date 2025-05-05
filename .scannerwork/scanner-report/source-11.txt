<?php

namespace app\commands;

use app\daemons\Iso8583Server;
use yii\console\Controller;

class ServerController extends Controller {

    public function actionStart_iso8583($port) {
        Iso8583Server::start($port);
    }

    public function actionStart_secure_iso8583($port) {
        Iso8583Server::startSecure($port);
    }

}
