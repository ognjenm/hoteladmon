<?php $provider = $model->mytasks(); ?>
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

    <?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
        'id'=>'mytasks-grid',
        'type' => 'hover condensed',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','My Tasks').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$provider,
        'filter'=>$model,
        'columns'=>array(
            array(
                'name'=>'priority',
                'value'=>'$data->priority',
                'type'=>'html',
                'filter'=>Tasks::model()->listPriority()
            ),
            array(
               'name'=>'status',
               'value'=>'CHtml::tag("span",array("class"=>Tasks::model()->statusColor($data->status)),Tasks::model()->displayStatus($data->status),"/span")',
               'type'=>'html',
               'filter'=>Tasks::model()->listStatus(),
               'headerHtmlOptions' => array('style' => 'width:80px'),
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
                'header'=>Yii::t('mx','Assigned'),
                'value'=>'$data->isgroup ==0 ? $data->employee->names : $data->group->name'
            ),
            array(
                'name'=>'date_due',
                'value'=>'$data->date_due',
                'htmlOptions'=>array('style'=>'width: 100px')
            ),
            array
            (
                'header'=>'Proveedores',
                'value'=>'Tasks::popover($data->providers)',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'width: 100px')
            ),
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                'headerHtmlOptions' => array('style' => 'width:150px;width:150px;text-align:center;'),
                'header'=>Yii::t('mx','Actions'),
                'template'=>'{view}{reallocate}{tracing}',
                'buttons'=>array(
                        'reallocate'=>array(
                            'label'=>Yii::t('mx','Reallocate'),
                            'icon'=>'icon-retweet',
                            'url'=>'Yii::app()->createUrl("tasks/reallocate", array("id"=>$data->id))',
                        ),
                        'tracing'=>array(
                            'label'=>Yii::t('mx','Tracing'),
                            'icon'=>'icon-pushpin',
                            'url'=>'Yii::app()->createUrl("tasks/tracing", array("id"=>$data->id))',
                        ),


                )
            ),
        ),
    ));
    ?>

    <?php $this->endWidget();?>


</div>