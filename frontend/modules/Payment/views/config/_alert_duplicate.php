<?php 
	Yii::$app->getSession()->setFlash('alert1', [
        'type' => 'warning',
        'title' => 'Duplicate!',
        'message' => 'ไฟล์นี้ถูกนำเข้าแล้ว',
    ]);
?>