<?php
/**
 * Created by PhpStorm.
 * User: chinux
 * email: chinuxe@gmail.com
 * Date: 12/04/14
 * Time: 13:03
 */
?>

<div class="inner" id="assignment-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Minimum Balance'),
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
        'id'=>'assignment-grid',
        'type' => 'hover condensed',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Minimum Balance').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'pager' => array(
            'class' => 'bootstrap.widgets.TbPager',
            'displayFirstAndLast' => true,
            'lastPageLabel'=>Yii::t('mx','Last'),
            'firstPageLabel'=>Yii::t('mx','First'),
        ),
        'dataProvider'=>$model,
        'extraRowColumns'=> array('employeed_id'),
        'extraRowExpression' => '"<b style=\"font-size: 2em; color: #333;text-align: center\">".$data->employeed->names."</b>"',
        'extraRowHtmlOptions' => array('style'=>'padding:10px'),
        'rowCssClassExpression'=>'$data->markMinimum',

        'columns'=>array(
               /* array(
                    'name'=>'employeed_id',
                    'value'=>'$data->employeed->names',
                ),*/

            array(
                'name'=>Yii::t('mx','Use'),
                'value'=>'$data->bracelet->use->used',
            ),
            array(
                'name'=>'bracelet_id',
                'value'=>'$data->bracelet->color',
            ),
            array(
                'name' => 'minimum_balance',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'headerHtmlOptions' => array('style' => 'width:80px'),
                'editable' => array(
                    'type' => 'text',
                    'url' => array('editMinimus'),
                    'success' => 'js: function(response, newValue) {
                       $.fn.yiiGridView.update("assignment-grid");
                    }',
                )
            )

        ),
    ));
    ?>

    <?php $this->endWidget();?>


</div>