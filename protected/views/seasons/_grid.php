<?php $provider = $model->search(); ?>
<div class="inner" id="seasons-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Seasons'),
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

        <?php $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'seasons-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Seasons').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'filter'=>$model,
            'pager' => array(
                'class' => 'bootstrap.widgets.TbPager',
                'displayFirstAndLast' => true,
            ),
            'columns'=>array(
                'commemoration',
                'froom',
                'too',
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                    'headerHtmlOptions' => array('style' => 'width:150px;width:150px;text-align:center;'),
                    'header'=>Yii::t('mx','Actions')
                ),
            ),
        ));
        ?>

    <?php $this->endWidget();?>


</div>