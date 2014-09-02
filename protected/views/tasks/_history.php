<?php $provider = $model->history(); ?>
<div class="inner" id="tasks-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Tasks'),
        'headerIcon' => 'icon-th-list',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'primary',
                'buttons' => array(
                    array('label' =>Yii::t('mx','Operations'), 'items' => $this->menu)
                )
            )
        )

    ));

    ?>

    <?php $this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'tasks-grid-history',
        'type' => 'hover condensed',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Tasks').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$provider,
        'filter'=>$model,
        'columns'=>array(

            array(
                'name'=>'priority',
                'value'=>'$data->priority',
                'filter'=>Tasks::model()->listPriority()
            ),
            array(
                'name'=>'status',
                'value'=>'CHtml::tag("span",array("class"=>Tasks::model()->statusColor($data->status)),Tasks::model()->displayStatus($data->status),"/span")',
                'type'=>'html',
                'filter'=>Tasks::model()->listStatus()
            ),
            'name',
            array(
                'name'=>'description',
                'value'=>'Tasks::popoverComments($data->description)',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'width: 50px')
            ),
            array(
                'name'=>'department',
                'value'=>'$data->department!=0 ? $data->department1->department : Yii::t("mx","Not set")'
            ),
            array(
                'name'=>'zone',
                'value'=>'$data->zone!=0 ? $data->zone1->zone : Yii::t("mx","Not set")'
            ),
            array(
                'name'=>'accepted_by',
                'value'=>'$data->accepted_by !=0 ? $data->user->username : Yii::t("mx","Not Accepted")'
            ),
            'date_due',

            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                'headerHtmlOptions' => array('style' => 'width:150px;'),
                'header'=>Yii::t('mx','Actions'),
                'template'=>'{delete}{view}'
            ),
        ),
    ));
    ?>

    <?php $this->endWidget();?>


</div>