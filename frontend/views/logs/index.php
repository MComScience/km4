<?php
$this->title = Yii::t('app', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
$i = 1;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> Logs</h3>
    </div>
    <div class="panel-body">
        <?php if ($data->count > 0) : ?>
            <table class="default kv-grid-table table table-hover table-condensed">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th><?= Yii::t('app', 'Username') ?></th>
                        <th><?= Yii::t('app', 'Password') ?></th>
                        <th class="text-center">IP</th>
                        <th>USER AGENT</th>
                        <th><?= Yii::t('app', 'Date') ?></th>
                        <th class="nowrap">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data->models as $log) : ?>
                        <tr <?= !$log->success ? 'class="warning"' : '' ?>>
                            <td><?= $i++ /* $log->primaryKey */ ?></td>
                            <td><?= $log->username ?></td>
                            <td><?= $log->password ?></td>
                            <td><?= $log->ip ?></td>
                            <td><?= $log->user_agent ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($log->time, 'medium') ?></td>
                            <td class="nowrap"><?= !$log->success ? 'login failed' : 'login success' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?=
            yii\widgets\LinkPager::widget([
                'pagination' => $data->pagination
            ])
            ?>
        <?php else : ?>
            <p><?= Yii::t('app', 'No records found') ?></p>
<?php endif; ?>
    </div>
</div>