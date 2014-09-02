<?php $provider = $model->search(); ?>
<div class="inner" id="contract-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Contracts'),
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
        'id'=>'contract-information-grid',
        'type' => 'hover condensed',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Contracts').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$provider,
        'filter'=>$model,
        'columns'=>array(
            'id',
            'title',
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                'headerHtmlOptions' => array('style' => 'width:200px;'),
                'header'=>Yii::t('mx','Actions'),
                'template'=>'{view}{update}{delete}',
                'buttons'=>array(
                    'view'=>array(
                        'label'=>Yii::t('mx','View'),
                        'icon'=>'icon-eye-open',
                        'url'=>'Yii::app()->createUrl("/ContractInformation/contract", array("id"=>$data->id))'
                    ),
                    'update'=>array(
                        'label'=>Yii::t('mx','Edit'),
                        'icon'=>'icon-pencil',
                        'url'=>'Yii::app()->createUrl("/ContractInformation/contract", array("id"=>$data->id))'
                    )

                )

            ),
        ),
    ));
    ?>

    <?php $this->endWidget();?>


</div>