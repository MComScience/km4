<?php

use firdows\menu\assets\MenuAsset;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

MenuAsset::register($this);

$this->title = Yii::t('menu', 'Sort Menus');
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-palegreen">
                <div class="widget-caption"><div class="panel-title"><i class="widget-icon fa fa-sort themeprimary"></i>Sort Menus</div></div>
            </div>
            <div class="widget-body">

                <div id="nestable-menu">
                    <?= Html::button('<i class="glyphicon glyphicon-plus"></i>Add', ['value' => Url::to(['create']), 'title' => 'เพิ่มเมนู', 'class' => 'btn btn-white btn-sm', 'id' => 'activity-create-link']); ?>
                    <button type="button" data-action="expand-all" class="btn btn-white btn-sm">Expand All</button>
                    <button type="button" data-action="collapse-all" class="btn btn-white btn-sm">Collapse All</button>
                </div>
                <p></p>
                <div class="well">
                    <div class="dd dd-draghandle bordered">
                        <?php mainlist($mainlist); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

function mainlist($mainlist) {
    ?>

    <ol class="dd-list">
        <?php foreach ($mainlist as $item): ?>
            <li class="dd-item dd2-item" data-id="<?php echo $item["id"]; ?>">
                <div class="dd-handle dd2-handle <?= $item['router'] == '#' ? 'bg-info' : ''; ?>">
                    <i class="normal-icon fa <?php echo $item["icon"]; ?>"></i>

                    <i class="drag-icon fa fa-arrows-alt "></i>
                </div>
                <div class="dd2-content <?= $item['router'] == '#' ? 'bg-azure' : ''; ?>" >
                    <?php echo $item["title"]; ?> <span class="red"><?php echo $item['status'] == '2' ? ' <i class="glyphicon glyphicon-eye-close"></i>' : '' ?></span>
                    <small class="pull-right">
                        <?php echo $item["router"]; ?> 
                        <div class="btn-group">
                            <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                Action <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:void(0);" class="btnview" data-id="<?= $item["id"]; ?>" ><i class="glyphicon glyphicon-eye-open"></i> View</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="btnedit" data-id="<?= $item["id"]; ?>" ><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="btndelete" data-id="<?= $item["id"]; ?>" ><i class="glyphicon glyphicon-trash"></i> Delete</a>
                                </li>
                            </ul>
                        </div>
                    </small>
                </div>     
                <?php if (array_key_exists("children", $item)): ?>
                    <?php mainlist($item["children"]); ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>

    <?php
}
?>
<?php
Modal::begin([
    'id' => 'activity-modal',
    'header' => '<h4 class="modal-title"></h4>',
    'size' => 'modal-lg',
    'footer' => '',
    'options' => [
        'tabindex' => false,
    ]
]);
Modal::end();
?>

<?php
$script = <<< JS
$(document).ready(function () {
        $('.dd').nestable('collapseAll');

        $('#nestable-menu').on('click', function (e) {
            var target = $(e.target),
                    action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });


        $('.btnedit').on('click', function (e) {
            var id = ($(this).attr('data-id'));
            $.get(
                    "index.php?r=menu/default/update",
                    {
                        id: id
                    },
                    function (data)
                    {
                        $("#activity-modal").find(".modal-body").html(data);
                        $(".modal-body").html(data);
                        $(".modal-title").html("Update");
                        $("#activity-modal").modal("show");
                    }
            );
        });

        $('.btndelete').on('click', function (e) {
            var id = ($(this).attr('data-id'));
            swal({
                title: "ยืนยันการลบ?",
                text: "",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                closeOnCancel: true,
                confirmButtonText: "Confirm",
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post(
                                    "index.php?r=menu/default/delete-menu",
                                    {
                                        id: id
                                    },
                                    function (data)
                                    {
                                        location.reload();
                                    }
                            );
                        }
                    });
        });

        $("#activity-create-link").click(function (e) {
            $.get(
                    "index.php?r=menu/default/create",
                    function (data)
                    {
                        $("#activity-modal").find(".modal-body").html(data);
                        $(".modal-body").html(data);
                        $(".modal-title").html("Create");
                        $("#activity-modal").modal("show");
                    }
            );
        });

        $(".btnview").click(function (e) {
            var id = ($(this).attr('data-id'));
            $.get(
                    "index.php?r=menu/default/view",
                    {
                        id: id
                    },
                    function (data)
                    {
                        $("#activity-modal").find(".modal-body").html(data);
                        $(".modal-body").html(data);
                        $(".modal-title").html("View");
                        $("#activity-modal").modal("show");
                    }
            );
        });
    });
JS;
$this->registerJs($script);
?>