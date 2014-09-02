<?php $provider = $model->search(); ?>


<div class="inner" id="pc-summary-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Pc Summary'),
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
            'id'=>'pc-summary-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Pc Summaries').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'pager' => array(
                'class' => 'bootstrap.widgets.TbPager',
                'displayFirstAndLast' => true,
            ),
            'dataProvider'=>$provider,
            'filter'=>$model,
            'selectableRows'=>2,
            'rowCssClassExpression'=>'$data->isInvoiced',
            'selectionChanged'=>'userClicks',

            'columns'=>array(
                array(
                    'class'=>'CCheckBoxColumn',
                ),
                'datex',
                array(
                    'name'=>'provider_id',
                    'value'=>'$data->provider->company'
                ),
                array(
                    'name'=>'article_id',
                    'value'=>'$data->article->article'
                ),
                'n_invoice',
                array(
                    'name'=>'price',
                    'value'=>'number_format($data->price,2)'
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