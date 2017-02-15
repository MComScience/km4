/*
 * 2014-11-07
 * @author Prawee Wongsa <konkeanweb@gmail.com>
 * @reference http://www.yiiframework.com/wiki/654/escape-from-default-s-yii2-delete-confirm-box
 */

yii.allowAction = function ($e) {
    var message = $e.data('confirm');
    return message === underfined || yii.confirm(message, $e);
};

/*yii.confirm = function(message,$e){
 bootbox.confirm(message,function(confirmed){
 if(confirmed){
 yii.handleAction($e);
 }
 });
 return false;
 };*/

yii.confirm = function (message, ok, cancel) {
    swal({
        title: message,
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        closeOnCancel: true,
        confirmButtonText: "Confirm!",
        showLoaderOnConfirm: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    !ok || ok();
                } else {
                    !cancel || cancel();
                }
            });
    // confirm will always return false on the first call
    // to cancel click handler
    return false;
};