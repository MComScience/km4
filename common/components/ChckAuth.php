<?php

namespace common\components;
use Yii;
use yii\base\Component;

class ChckAuth extends Component {

    public function AuthUpdate() {
        $session = Yii::$app->session;
        $sessionid = Yii::$app->user->getId();
        $ipaddress = $_SERVER['REMOTE_ADDR']; //Get user IP

        $sql = "UPDATE user SET LoginStatus = '0',LastUpdate = '0000-00-00 00:00:00'  WHERE DATE_ADD(LastUpdate, INTERVAL 180 MINUTE) <= NOW()";
        Yii::$app->db->createCommand($sql)->execute();

//*** Update Last Stay in Login System
        if (!Yii::$app->user->isGuest) {
            $LoginStatus = Yii::$app->user->identity->LoginStatus;
            $LastLoginIP = Yii::$app->user->identity->LastLoginIP;
            if ($LoginStatus == 1) {
                $sql1 = "UPDATE user SET LoginStatus = '1',LastUpdate = NOW() WHERE id = $sessionid ";
                Yii::$app->db->createCommand($sql1)->execute();
            } else if ($LoginStatus == 0 && $LastLoginIP == $ipaddress) {
                $session->destroy();
                Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
            }
            if ($LastLoginIP != $ipaddress) {
                $session->destroy();
                Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
            }
        }
    }

}
