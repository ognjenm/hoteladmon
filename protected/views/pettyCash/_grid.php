<?php $provider = $model->search(); ?>
<div class="inner" id="petty-cash-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Petty Cash'),
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
            'id'=>'petty-cash-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Petty Cashes').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'filter'=>$model,
            'columns'=>array(
                array(
                    'name'=>'user_id',
                    'value'=>'$data->employe->names'
                ),
                'amount',
                'datex',
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                    'headerHtmlOptions' => array('style' => 'width:150px;'),
                    'header'=>Yii::t('mx','Actions'),
                    'template'=>'{view}{update}{delete}',
                    /*'buttons'=>array(
                        'close'=>array(
                            'label'=>Yii::t('mx','Close'),
                            'icon'=>'icon-remove',
                            'url'=>'Yii::app()->createUrl("pettyCash/close", array("id"=>$data->id))',
                            'options'=>array(
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>"js:$(this).attr('href')",
                                    'dataType'=>'json',
                                    'beforeSend' => 'function() {  $("#petty-cash-grid-inner").addClass("saving"); }',
                                    'complete' => 'function() { $("#petty-cash-grid-inner").removeClass("saving"); }',
                                    'success'=>'function(data) {

                                        if(data.ok==true){
                                             bootbox.alert(data.response);
                                        }

                                        if(data.ok==false){
                                             bootbox.alert(data.response);
                                        }

                                        $("#petty-cash-grid").yiiGridView("update", {
                                            data: $(this).serialize()
                                        });

                                    }'
                                ),
                            )
                        )
                    )*/
                ),
            ),
        ));
        ?>

    <?php $this->endWidget();?>


</div>