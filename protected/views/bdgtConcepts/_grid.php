<?php $provider = $model->search(); ?>
<div class="inner" id="bdgt-concepts-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Concepts'),
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

    ));?>

        <?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
            'id'=>'bdgt-concepts-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Concepts').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'filter'=>$model,
            'afterAjaxUpdate'=>"function(id,data){
                $('.popover-examples a').popover({
                    trigger : 'hover',
                    placement : 'top',
                    html : true
                });

            }",
            'columns'=>array(
                array(
                    'name'=>'bdgt_group_id',
                    'value'=>'$data->bdgtGroup->group_name',
                    'filter'=>BdgtGroups::model()->listAll()
                ),
                'concept',
                array(
                    'header'=>Yii::t('mx','Description'),
                    'value'=>'BdgtConcepts::popover($data->description)',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'width: 100px')
                ),
                array(
                    'name'=>'price',
                    'value'=>'"$".$data->price'
                ),
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                    'headerHtmlOptions' => array('style' => 'width:150px;'),
                    'header'=>Yii::t('mx','Actions')
                ),
            ),
        ));
        ?>

    <?php $this->endWidget();?>


</div>