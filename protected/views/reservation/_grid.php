<?php $provider = $model->search2(); ?>
<div class="inner" id="reservation-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Reservations'),
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
            'id'=>'reservation-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Reservations').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'filter'=>$model,
            'rowCssClassExpression'=>'$data->color',
            'pager' => array(
                'class' => 'bootstrap.widgets.TbPager',
                'displayFirstAndLast' => true,
            ),
            'columns'=>array(

               array(
                    'name'=>'room_id',
                    'value'=>'$data->room->room',
                   'filter'=>Rooms::model()->listAllRooms()
                ),
                'checkin',
                'checkout',
                'adults',
                'children',
                'pets',
                array(
                    'name'=>'statux',
                    'value'=>'$data->statux',
                    'filter'=>Reservation::model()->listStatus()
                ),

                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                    'headerHtmlOptions' => array('style' => 'width:150px;text-align:center;'),
                    'header'=>Yii::t('mx','Actions'),
                    'template'=>'{view}{status}',
                    'buttons'=>array(

                        'view' => array
                        (
                            'label'=>Yii::t('mx','Details reservation'),
                            'icon'=>'icon-eye-open',
                            'url'=>'Yii::app()->createUrl("reservation/view", array("id"=>$data->id))',
                            'options'=>array(
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>"js:$(this).attr('href')",
                                    'success'=>'function(data) { $("#detailsview .modal-body p").html(data); $("#detailsview").modal(); }'
                                ),
                            ),
                        ),

                        'status' => array
                        (
                            'label'=>Yii::t('mx','Change Status'),
                            'icon'=>'icon-pencil',
                            'url'=>'Yii::app()->createUrl("reservation/update", array("id"=>$data->id))',
                            'options'=>array(
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>"js:$(this).attr('href')",
                                    'success'=>'function(data) { $("#changeStatus .modal-body p").html(data); $("#changeStatus").modal(); }'
                                ),
                            ),
                        ),


                    )
                ),
            ),
        ));
        ?>

    <?php $this->endWidget();?>


</div>