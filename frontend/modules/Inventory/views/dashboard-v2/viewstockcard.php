  <?php 
use yii\helpers\Html;
$this->registerJs('$("#tab_G").addClass("active");');
$this->title = 'stock card';
$this->params['breadcrumbs'][] = ['label' => 'dashbord', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
  ?>
  <div class="well">
  <div class="row">
  <div class="col-md-12">
  <?php if ($model != null) {
            $html = '<table  class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%"  id="data_tpu">'
                    . ' <thead class="bordered-success"><tr>'
                    . '<th style="text-align:center">วันที่</th>'
                    . '<th style="text-align:center">เลขที่รายการ</th>'
                    . '<th style="text-align:center">ประเภทรายการ</th>'
                    . '<th style="text-align:center">ยอดเข้า</th>'
                    . '<th style="text-align:center">ยอดออก</th>'
                    . '<th style="text-align:center">ยอดคงเหลือ</th>'
                    . '<th style="text-align:center">หน่วย</th>'
                    . '</tr></thead><tbody>';
            foreach ($model as $r) {
                $html .= '<tr>'
                        . '<td style="text-align:center">' . Yii::$app->componentdate->convertMysqlToThaiDate2($r['StkTransDateTime']) . '</td>'
                        . '<td style="text-align:center">' . $r['StkDocNum'] . '</td>'
                        . '<td style="text-align:center">' . $r['StkDocType'] . '</td>'
                        . '<td style="text-align:center">' . number_format($r['ItemQtyIn'], 2) . '</td>'
                        . '<td style="text-align:center">' . number_format($r['ItemQtyOut'], 2) . '</td>'
                        . '<td style="text-align:center">' . number_format($r['ItemQtyBalance'], 2) . '</td>'
                        . '<td style="text-align:center">' . $r['DispUnit'] . '</td>'
                        . '</tr>';
            }
            $html .='</tbody></table>';
        } else {
            $html = 'nodata';
        }
      echo $html;
      $mo = str_split($models->ItemID);
      if($mo[0] == 1 || $mo[0] == 3){
        ?>
        <div class="pull-right"> <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?></div>
        <?php }else if($mo[0] == 2 || $mo[0] == 4){ ?>
        <div class="pull-right"> <?= Html::a('Close', ['status-drug'], ['class' => 'btn btn-default']) ?></div>
        <?php } ?>
        </div>
        </div>
        </div>
<?php
         $script = <<< JS
  $('#data_tpu').DataTable({
                            "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                            "pageLength": 10,
                            responsive: true,
                            "language": {
                                "lengthMenu": " _MENU_ ",
                                "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                "search": "ค้นหา "
                            },
                            "aLengthMenu": [
                                [5, 10, 15, 20, 100, -1],
                                [5, 10, 15, 20, 100, "All"]
                            ]
                        });
JS;
            $this->registerJs($script);
            ?>