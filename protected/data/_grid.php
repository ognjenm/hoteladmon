<?php $provider = $model->search(); ?>
<div class="inner" id="articles-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Articles'),
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
            'id'=>'articles-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Articles').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'filter'=>$model,
            'columns'=>array(
                array(
                    'name'=> 'provider_id',
                    'value'=>'Providers::model()->CompanyByPk($data->provider_id)'
                ),
                'name_article',
                'quantity',
                array(
                    'name'=>'unit_measure_id',
                    'value'=>'$data->unitmeasure->unit'
                ),

                'measure',
                'price',
                'presentation',

               /* array(
                    'header'=>'code',
                    'value'=>'$data["subitem"]["code_store"]',
                ),*/

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