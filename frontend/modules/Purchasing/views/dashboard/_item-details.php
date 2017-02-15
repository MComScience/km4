<?php

use kartik\grid\GridView;
use yii\helpers\Html;

?>

<div class="row">
    <div class="col-lg-1 col-sm-12 col-xs-12">

    </div>
    <div class="col-lg-10 col-sm-12 col-xs-12">
        <p>
            <?= Html::button('Expand All', ['class' => 'btn btn-white btn-sm expand-all', 'data-action' => 'expand-all']); ?>
            <?= Html::button('Collapse All', ['class' => 'btn btn-white btn-sm collapse-all', 'data-action' => 'collapse-all']); ?>
        </p>

        <div class="panel-group accordion" id="accordions">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle tb1" data-toggle="collapse" data-parent="#accordions" href="#collapseOnes">
                            <span class="success">ปริมาณคลังย่อย</span>
                        </a>
                    </h4>
                </div>
                <div id="collapseOnes" class="panel-collapse collapse in">
                    <div class="panel-body border-red">
                        <div id="tbstock"></div>
                        <input id="tb1" type="hidden"/>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed tb4" data-toggle="collapse" data-parent="#accordions" href="#collapseFour">
                            <span class="success">ราคากลาง</span>
                        </a>
                    </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse">
                    <div class="panel-body border-red">
                        <?php echo empty($QueryGPU) ? '0.00' : $QueryGPU['GPUStdCost'] ?> บาท
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed tb2" data-toggle="collapse" data-parent="#accordions" href="#collapseTwos">
                            <span class="success">Price List</span>
                        </a>
                    </h4>
                </div>
                <div id="collapseTwos" class="panel-collapse collapse">
                    <div class="panel-body border-red">
                        <div id="tbpricelist"></div>
                        <input id="tb2" type="hidden"/>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed tb3" data-toggle="collapse" data-parent="#accordions" href="#collapseThrees">
                            <span class="success">ประวัติการสั่งซื้อ</span>
                        </a>
                    </h4>
                </div>
                <div id="collapseThrees" class="panel-collapse collapse">
                    <div class="panel-body border-gold">
                        <div id="tbhistory"></div>
                        <input id="tb3" type="hidden"/>
                    </div>
                </div>
            </div>
            <input id="tball" type="hidden"/>
        </div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        GettbList('1');
        $('input[id=tb1]').val('1');
    });

    $("button.expand-all").click(function () {
        Expandall();
        var tball = $('input[id=tball]').val();
        if ( $('input[id=tb2]').val() == '1' && $('input[id=tb3]').val() == '1') {

        } else {
            if (tball != '1') {
                $('input[id=tball]').val('1');
                $('input[id=tb2]').val('1');
                $('input[id=tb3]').val('1');
                GettbListAll();
            }
        }
    });

    $("button.collapse-all").click(function () {
        Collapseall();
    });

    function Expandall() {
        $('div.panel-collapse').addClass('collapse in');
        $("div.panel-collapse").attr("aria-expanded", "true");
        $("div.panel-collapse").css("height", "")
        $('a.accordion-toggle').removeClass('collapsed');
    }
    function Collapseall() {
        $('div.panel-collapse').removeClass('in');
        $("div.panel-collapse").attr("aria-expanded", "false");
        $("div.panel-collapse").css("height", "0px")
        $('a.accordion-toggle').addClass('collapsed');
        $("a.accordion-toggle").attr("aria-expanded", "false");
    }

    $("a.tb1").click(function () {
        var tb1 = $('input[id=tb1]').val();
        if (tb1 != '1') {
            $('input[id=tb1]').val('1');
            GettbList('1');
        }
    });

    $("a.tb2").click(function () {
        var tb2 = $('input[id=tb2]').val();
        if (tb2 != '1') {
            $('input[id=tb2]').val('1');
            GettbList('2');
        }
    });

    $("a.tb3").click(function () {
        var tb3 = $('input[id=tb3]').val();
        if (tb3 != '1') {
            $('input[id=tb3]').val('1');
            GettbList('3');
        }
    });

    function GettbList(type) {
        var id = <?= "'" . $ItemID . "'"; ?>;
        LoadingClass();
        $.ajax({
            url: "index.php?r=Purchasing/dashboard/gettb-list",
            type: "POST",
            data: {id: id, type: type},
            dataType: "JSON",
            success: function (result) {
                if (type == '1') {
                    $('#tbstock').html(result);
                }

                if (type == '2') {
                    $('#tbpricelist').html(result);
                }

                if (type == '3') {
                    $('#tbhistory').html(result);
                }
                $('div#ajaxCrudModal .modal-body').waitMe('hide');
            }
        });
    }

    function GettbListAll() {
        var id = <?= "'" . $ItemID . "'"; ?>;
        LoadingClass();
        $.ajax({
            url: "index.php?r=Purchasing/dashboard/gettb-list-all",
            type: "POST",
            data: {id: id},
            dataType: "JSON",
            success: function (result) {
                $('#tbpricelist').html(result.tb1);
                $('#tbhistory').html(result.tb2);
                $('div#ajaxCrudModal .modal-body').waitMe('hide');
            }
        });
    }
    function LoadingClass() {
        $('div#ajaxCrudModal .modal-body').waitMe({
            effect: 'ios', //roundBounce
            text: 'Loading...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            source: 'img.svg',
            onClose: function () {
            }
        });
    }
</script>