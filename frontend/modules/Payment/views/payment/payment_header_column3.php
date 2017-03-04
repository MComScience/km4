<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 stats-col">
        <div class="invoice-container">
            <ul>
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="margin-left: 25px;">
                        <li style="text-align: -webkit-left;">เลขที่ใบเสร็จรับเงิน</li>
                            <?=
                            $form->field($modelHD, 'rep_num', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white'
                            ])
                            ?>
                    </div>
                    <?php if ($view == 'create') { ?>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="margin-top:5px;margin-left: 25px;">
                        <li style="text-align: -webkit-left;">วันที่</li>
                            <?=
                            $form->field($modelHD, 'repdate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                'language' => 'th',
                                'dateFormat' => 'dd/MM/yyyy',
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'options' => [
                                    'class' => 'form-control',
                                    'style' => 'background-color: #FFFF99',
                                ],
                            ])
                            ?>
                    </div>
                    <?php }?>
                    <?php if ($view == 'history') { ?>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="margin-top:5px;margin-left: 25px;">
                        <li style="text-align: -webkit-left;">วันที่</li>
                            <?=
                            $form->field($modelHD, 'repdate',['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white',
                                'value' => Yii::$app->formatter->asDate($modelHD->repdate,'php:d/m/Y'),
                            ]) 
                            ?>
                    </div>
                    <?php }?>
                </div>
            </ul>
        </div>
    </div>
</div>