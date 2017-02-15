
<?=
                     GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'bootstrap' => true,
                'responsiveWrap' => FALSE,
                'responsive' => true,
                //'showPageSummary' => true,
                'layout' => "{items}\n{pager}",
                'hover' => true,
                'pjax' => true,
                'striped' => true,
                'condensed' => true,
                'toggleData' => false,
                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '36px',
                        'header' => '<a>ลำดับ</a>',
                        'headerOptions' => ['class' => 'kartik-sheet-style']
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'PRNum',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->PRNum == null) {
                        return '-';
                    } else {
                        return $model->PRNum;
                    }
                }
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'PRDate',
                        'format' => ['date', 'php:d/m/Y'],
                        'hAlign' => GridView::ALIGN_CENTER,
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'PRTypeID',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->PRTypeID == null) {
                        return '-';
                    } else {
                        return $model->datatemp->PRType;
                    }
                }
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'POTypeID',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->POTypeID == null) {
                        return '-';
                    } else {
                        return $model->datatemp->POType;
                    }
                }
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'PRExpectDate',
                        //'format' => ['date', 'php:d-m-Y'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->PRExpectDate == null) {
                        return '-';
                    } else {
                        return Yii::$app->componentdate->convertMysqlToThaiDate($model->PRExpectDate);
                    }
                }
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'PRStatus',
                        'value' => 'datatemp.PRStatus',
                        'hAlign' => GridView::ALIGN_CENTER,
                    ],
                     [
                                'class' => 'kartik\grid\ActionColumn',
                                //'contentOptions' => ['style' => 'width:260px;'],
                                'options' => ['style' => 'width:160px;'],
                                'header' => '<a>Actions</a>',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'template' => '{view} {update} {delete}',
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'buttons' => [
                                    //view button
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-success btn-xs btn-group"> Detail </span>', $url, [
                                                    'title' => Yii::t('app', 'view'),
                                        ]);
                                    },
                                            'update' => function ($url, $model) {
                                        if ($model->PRStatusID == 1) {
                                            return Html::a('<span class="btn btn-primary btn-xs"> Edit </span>', $url, [
                                                        'title' => Yii::t('app', 'Edit'),
                                                            //'class' => 'btn btn-primary btn-xs',
                                            ]);
                                        } 
                                        else {
                                            return Html::a('<span class="btn btn-primary btn-xs" disabled="disabled"> Edit </span>', $url, [
                                                        'title' => Yii::t('app', 'Edit'),
                                                        'data-toggle' => 'modal',
                                                        'data-target' => '#gpu-modal',
                                                            //'class' => 'btn btn-primary btn-xs',
                                            ]);
                                        }
                                    },
                                            'delete' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', $url, [
                                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                    'title' => Yii::t('app', 'Delete'),
                                                    'data-method' => "post",
                                                    'role' => 'modal-remote',
                                        ]);
                                    },
                                        ],
                                        'urlCreator' => function ($action, $model, $key, $index) {
                                    //Update
                                    if ($model->PRTypeID == 1 || $model->PRTypeID == 5 || $model->PRTypeID == 8) {//ยาสามัญ
                                        if ($action === 'update') {
                                            return Url::to(['create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => '']);
                                        }
                                    } elseif ($model->PRTypeID == 2 || $model->PRTypeID == 6 || $model->PRTypeID == 9) {//ยาการค้า
                                        if ($action === 'update') {
                                            return Url::to(['addpr-tpu/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => '']);
                                        }
                                    } elseif ($model->PRTypeID == 3 || $model->PRTypeID == 7 || $model->PRTypeID == 10) {//เวชภัณฑ์
                                        if ($action === 'update') {
                                            return Url::to(['addpr-nd/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => '']);
                                        }
                                    } elseif ($model->PRTypeID == 11) {
                                        if ($action === 'update') {
                                            return Url::to(['addpr-tpu-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => '']);
                                        }
                                    } elseif ($model->PRTypeID == 12) {//เวชภัณฑ์ จะซื้อจะขาย
                                        if ($action === 'update') {
                                            return Url::to(['addpr-nd-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => '']);
                                        }
                                    }

                                    //View//Delete
                                    if ($model->PRTypeID == 1 || $model->PRTypeID == 5 || $model->PRTypeID == 8) {//ยาสามัญ
                                        if ($action === 'view') {//View
                                            return Url::to(['create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                                        }
                                        if ($action === 'delete') {//Delete
                                            return Url::to(['delete-prgpu', 'id' => $key]);
                                        }
                                    } elseif ($model->PRTypeID == 2 || $model->PRTypeID == 6 || $model->PRTypeID == 9) {//ยาการค้า
                                        if ($action === 'view') {//View
                                            return Url::to(['addpr-tpu/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                                        }
                                        if ($action === 'delete') {//Delete
                                            return Url::to(['addpr-tpu/delete-tempgpu', 'id' => $key]);
                                        }
                                    } elseif ($model->PRTypeID == 3 || $model->PRTypeID == 7 || $model->PRTypeID == 10) {//เวชภัณฑ์
                                        if ($action === 'view') {//View
                                            return Url::to(['addpr-nd/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                                        }
                                    } elseif ($model->PRTypeID == 11) {
                                        if ($action === 'view') {//View
                                            return Url::to(['addpr-tpu-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => 'view']);
                                        }
                                    } elseif ($model->PRTypeID == 12) {//เวชภัณฑ์ จะซื้อจะขาย
                                        if ($action === 'view') {//View
                                            return Url::to(['addpr-nd-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => 'view']);
                                        }
                                    }
                                    if ($action === 'delete') {//Delete
                                        return Url::to(['delete-prgpu', 'id' => $key]);
                                    }
                                }
                                    ],
                            
                ],
            ]);
            ?>