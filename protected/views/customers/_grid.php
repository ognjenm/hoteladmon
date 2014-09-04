<?php $provider = $model->search(); ?>
<div class="inner" id="customers-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Customers'),
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
            'id'=>'customers-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' =>'<strong>'.Yii::t('mx','Customers').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'filter'=>$model,
            'columns'=>array(
                'email',
                'first_name',
                'last_name',
                'city',
               array(
                   'name'=>'is_billed',
                   'value'=>'$data->is_billed==1 ? "Si" : "No"',
                   'filter'=>array(1=>'Si',0=>'No')
               ),
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                    'headerHtmlOptions' => array('style' => 'width:150px;'),
                    'header'=>Yii::t('mx','Actions'),
                    'template'=>'{view}{update}{delete}{tax}',
                    'buttons'=>array(
                        'tax'=>array(
                            'icon'=>'icon-user',
                            'label'=>Yii::t('mx','Tax Information'),
                            'url'=>'Yii::app()->createUrl("TaxInformation/create", array("id"=>$data->id))',
                        )
                    )
                ),
            ),
        ));
        ?>

    <?php $this->endWidget();?>


</div>