<?php $provider = $model->search(); ?>
<div class="inner" id="expirationday-prebooking-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Expiration day pre booking'),
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
            'id'=>'expirationday-prebooking-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Expiration day pre bookings').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'filter'=>$model,
            'columns'=>array(
                array(
                    'name' => 'arrives',
                    'class' => 'bootstrap.widgets.TbEditableColumn',
                    'headerHtmlOptions' => array('style' => 'width:80px'),
                    'editable' => array(
                        'mode'=>'inline',
                        'type' => 'text',
                        'url' => array('editArrives'),
                        'success' => 'js: function(response, newValue) {
                        $.fn.yiiGridView.update("expirationday-prebooking-grid");
                    }',
                    )
                ),
                array(
                    'name' => 'availability',
                    'class' => 'bootstrap.widgets.TbEditableColumn',
                    'headerHtmlOptions' => array('style' => 'width:80px'),
                    'editable' => array(
                        'mode'=>'inline',
                        //'inputclass'=>'input-small',
                        'type' => 'text',
                        'url' => array('editAvailability'),
                        'success' => 'js: function(response, newValue) {
                        $.fn.yiiGridView.update("expirationday-prebooking-grid");
                    }',
                    )
                ),
                array(
                    'name' => 'daystopay',
                    'class' => 'bootstrap.widgets.TbEditableColumn',
                    'headerHtmlOptions' => array('style' => 'width:80px'),
                    'editable' => array(
                        'mode'=>'inline',
                        'type' => 'text',
                        'url' => array('editDaystopay'),
                        'success' => 'js: function(response, newValue) {
                        $.fn.yiiGridView.update("expirationday-prebooking-grid");
                    }',
                    )
                ),
               /* array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                    'headerHtmlOptions' => array('style' => 'width:150px;'),
                    'header'=>Yii::t('mx','Actions')
                ),*/

            ),
        ));
        ?>

    <?php $this->endWidget();?>


</div>