<?php $provider = $model->history(); ?>

<div class="inner" id="direct-invoice-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Direct Invoice'),
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
            ),
            array(
                'id'=>'transport',
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary',
                'label'=>Yii::t('mx','Transport'),
            ),
        )

    ));?>

    <?php $this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'direct-invoice-grid',
        'type' => 'hover condensed',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Direct Invoices').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$provider,
        'filter'=>$model,
        'pager' => array(
            'class' => 'bootstrap.widgets.TbPager',
            'displayFirstAndLast' => true,
            'lastPageLabel'=>Yii::t('mx','Last'),
            'firstPageLabel'=>Yii::t('mx','First'),
        ),
        'selectableRows'=>2,
        'columns'=>array(
            array(
                'id'=>'chk',
                'class'=>'CCheckBoxColumn'
            ),
            'datex',
            'n_invoice',
            array(
                'name'=> 'provider_id',
                'value'=>'$data->provider->company'
            ),
            array(
                'name'=>'total',
                'value'=>'number_format($data->total,2)'
            ),
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                'headerHtmlOptions' => array('style' => 'width:150px;'),
                'header'=>Yii::t('mx','Actions'),
                'template'=>'{view}{delete}{update}'
            ),
        ),
    ));
    ?>

    <?php $this->endWidget();?>



</div>