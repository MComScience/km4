<?php 
    Yii::$app->getSession()->setFlash('alert1', [
    'type' => 'success',
    'title' => 'Success!',
    'message' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
    ]);
?>