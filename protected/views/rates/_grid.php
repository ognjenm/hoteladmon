<?php $provider = $model->search(); ?>
<div class="inner" id="rates-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Rates').': '.Rates::model()->count(),
        'headerIcon' => 'icon-th-list',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'primary',
                'buttons' => array(
                    array('label' =>Yii::t('mx','Operations'), 'items' => $this->menu)
                ),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButton',
                'label'=>Yii::t('mx','Filter'),
                'type'=>'primary',
                'size'=>'large',
                'id'=>'filter-button'
            )
        )

    ));?>

        <?php $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'rates-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Rates').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'filter'=>$model,
            'pager' => array(
                'class' => 'bootstrap.widgets.TbPager',
                'displayFirstAndLast' => true,
            ),
            //'selectableRows'=>2,
            'columns'=>array(
                /*array(
                    'class' => 'CCheckBoxColumn',
                ),*/
                array(
                    'name'=>'service_type',
                    'value'=>'Yii::t("mx",$data->service_type)',
                    'filter'=>Rates::model()->listServiceType()
                ),
                array(
                    'name'=>'room_type_id',
                    'value'=>'$data->roomType->tipe',
                    'filter'=>RoomsType::model()->listAllRoomsTypes()
                ),
                array(
                    'name'=>'type_reservation_id',
                    'value'=>'$data->typeReservation->tipe',
                    'filter'=>TypeReservation::model()->listAllTypeReservations()
                ),
                array(
                    'name'=>'season',
                    'value'=>'$data->season',
                    'filter'=>array('ALTA'=>'ALTA','BAJA'=>'BAJA')
                ),
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