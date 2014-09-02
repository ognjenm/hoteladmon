<?php $provider = $model->search(); ?>
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
            'id'=>'tasks-grid',
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
                    'filter'=>Tasks::model()->listStatus(),
                    'class' => 'bootstrap.widgets.TbEditableColumn',
                    'headerHtmlOptions' => array('style' => 'width:80px'),
                    'editable' => array(
                        'mode'=>'inline',
                        'type' => 'select',
                        'source'=>Tasks::model()->listStatus(),
                        'url' => array('/tasks/editStatus'),
                        'success' => 'js: function(response, newValue) {
                            $.fn.yiiGridView.update("tasks-grid");
                        }',
                    )
                ),
                'name',
                array(
                    'name'=>'description',
                    'value'=>'substr($data->description,0,3)',
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

                /*array(
                   'name'=>'accepted_by',
                   'value'=>'$data->accepted_by !=0 ? $data->user->username : Yii::t("mx","Not Accepted")'
               ),*/


               array(
                    'header'=>Yii::t('mx','Assigned'),
                    'value'=>'$data->isgroup ==0 ? $data->employee->first_name : $data->group->name'
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
                    'headerHtmlOptions' => array('style' => 'width:140px;text-align: center;'),
                    'header'=>Yii::t('mx','Actions'),
                    'template'=>'{view}{update}{delete}{tracing}',
                    'buttons'=>array(
                        'tracing'=>array(
                            'label'=>Yii::t('mx','Tracing'),
                            'icon'=>'icon-pushpin',
                            'url'=>'Yii::app()->createUrl("tasks/tracing", array("id"=>$data->id))',
                        )
                    )
                ),
            ),
        ));
        ?>

    <?php $this->endWidget();?>


</div>