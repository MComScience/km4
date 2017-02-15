<?php

namespace common\components;

use Yii;

class Mailing extends yii\base\Component {

    public function sendMail($name, $mail, $subject, $makrup, $id, $result) {
        $sql1 = "SELECT * From vw_po2_detail2_new where POID = $id and POItemType = 1";
        $query1 = Yii::$app->db->createCommand($sql1)->execute();

        $sql2 = "SELECT * From vw_po2_detail2_new where POID = $id and POItemType = 2";
        $query2 = Yii::$app->db->createCommand($sql2)->execute();

        if ($query1 == 0 && $query2 == 0) {
            return $this->error;
        } elseif ($query1 != 0 && $query2 == 0) {
            $files = [Yii::getAlias('@webroot') . '/uploads/' . $result . '.pdf'];
        } elseif ($query1 == 0 && $query2 != 0) {
            $files = [Yii::getAlias('@webroot') . '/uploads/' . $result.'(สินค้าบริจาค)' . '.pdf'];
        } else {
            $files = [Yii::getAlias('@webroot') . '/uploads/' . $result . '.pdf', Yii::getAlias('@webroot') . '/uploads/' . $result.'(สินค้าบริจาค)' . '.pdf'];
        }
        //$files = [Yii::getAlias('@webroot') . '/uploads/' . 'PO.pdf', Yii::getAlias('@webroot') . '/uploads/' . 'PO1.pdf'];

        $message = Yii::$app->mailer->compose('@app/mail/layouts/register', [
                    'fullname' => $name,
                    'makrup' => $makrup
                ])
                ->setFrom([Yii::$app->user->identity->email => 'UDCANCER'])
                ->setTo($mail)
                ->setSubject($subject);
        foreach ($files as $filespdf) {
            $message->attach($filespdf);
        }

        $message->send();

        foreach ($files as $deletefile) {
            if (!unlink($deletefile)) {
                //return true;
            }
        }
        return true;
    }

}
