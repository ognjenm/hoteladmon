<?php $provider = $model->search(); ?>
<div class="inner" id="bank-accounts-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Bank Accounts'),
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
            'id'=>'bank-accounts-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Bank Accounts').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'filter'=>$model,
            'columns'=>array(
                'account_name',
                array(
                    'name'=>'bank_id',
                    'value'=>'$data->bank->bank'
                ),
                array(
                    'name'=>'account_type_id',
                    'value'=>'$data->accountType->tipe'
                ),
                'account_number',
                'clabe',

                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                    'headerHtmlOptions' => array('style' => 'width:150px;'),
                    'header'=>Yii::t('mx','Actions'),
                    'template'=>'{view}{update}{delete}{cheq}',
                    'buttons'=>array(
                        'cheq'=>array(
                            'label'=>Yii::t('mx','Assign checkbook folio'),
                            'icon'=>'icon-book',
                            'url'=>'Yii::app()->createUrl("bankAccounts/checkbook", array("id"=>$data->id))',
                            'options'=>array(
                                'class'=>'btn btn-small',
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>"js:$(this).attr('href')",
                                    'success'=>'function(data) {
                                        $("#checkbookModal .modal-body p").html(data);
                                         $("#checkbookModal").modal();
                                    }'
                                ),
                            )
                        )
                    )
                ),
            ),
        ));
        ?>

    <?php $this->endWidget();?>


</div>