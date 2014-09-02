<?php $provider = $minimos->minimos(); ?>
<div class="inner" id="assignment-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Assignment'),
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

    <?php $this->widget('bootstrap.widgets.TbGroupGridView',array(
        'id'=>'assignment-grid-minimos',
        'type' => 'hover condensed',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Assignments').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'pager' => array(
            'class' => 'bootstrap.widgets.TbPager',
            'displayFirstAndLast' => true,
            'lastPageLabel'=>Yii::t('mx','Last'),
            'firstPageLabel'=>Yii::t('mx','First'),
        ),
        'dataProvider'=>$provider,
        'filter'=>$minimos,
        'extraRowColumns'=> array('employeed_id'),
        'extraRowExpression' => '"<b style=\"font-size: 2em; color: #333;text-align: center\">".$data->employeed->names."</b>"',
        'extraRowHtmlOptions' => array('style'=>'padding:10px'),
        'rowCssClassExpression'=>'$data->markMinimum',

        'columns'=>array(

           array(
                'name'=>'bracelet_id',
                'value'=>'$data->bracelet->color." - ".$data->bracelet->use->used',
                'filter'=>Bracelets::model()->listAll()
            ),
            'balance',
            'minimum_balance',
            'date_assignment',
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                'headerHtmlOptions' => array('style' => 'width:150px;'),
                'header'=>Yii::t('mx','Actions'),
            ),
        ),
    ));
    ?>

    <?php $this->endWidget();?>


</div>