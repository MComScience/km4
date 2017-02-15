<?php

namespace common\components;

use Yii;
use app\models\TbLogger;
class Logger extends yii\base\Component {
	function savelog($action,$id_action,$type=null){
           $Logger = new TbLogger();
           $Logger->action = $action;
           $Logger->dates = date('Y-m-d');
           $Logger->datetime = date('Y-m-d H:i:s');
           $Logger->user_id = Yii::$app->user->id;
           $Logger->ip = $_SERVER['REMOTE_ADDR'];
           $Logger->action_id = $id_action;
		   $Logger->type = $type;
           $Logger->save();
   }
}