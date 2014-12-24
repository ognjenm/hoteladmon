<div class="inner" id="operations-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Operations'),
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
            'id'=>'operations-grid',
            'type' => 'striped bordered hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Operations').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'pager' => array(
                'class' => 'bootstrap.widgets.TbPager',
                'displayFirstAndLast' => true,
            ),
            'selectableRows'=>1,
            'dataProvider'=>$dataProvider->search($accountId),
            'filter'=>$dataProvider,
            'rowCssClassExpression'=>function($row, $data){

                $class= 'white';

                if ($data['person']=='PENDIENTE') { $class= 'warning'; }
                if ($data['bank_concept']=='PENDIENTE') {$class= 'error'; }
                if ($data['concept']=='PENDIENTE POR FACTURAR') {$class= 'success'; }

                return $class;
            },


            'columns'=>array(
                array(
                    'class'=>'CCheckBoxColumn',
                ),

                array(
                    'name'=>'datex',
                    'value'=>'$data->datex',
                    'htmlOptions'=>array('style'=>'width:80px;'),
                ),
                array(
                    'name'=>'payment_type',
                    'value'=>'$data->payment->payment',
                    'filter'=>PaymentsTypes::model()->listAll()
                ),
                array(
                    'name'=>'cheq',
                    'value'=>'$data->cheq',
                    'htmlOptions'=>array('style'=>'width:60px;'),
                ),
                'released',
                'concept',
                array(
                    'name'=>'person',
                    'value'=>'$data->person',
                    'htmlOptions'=>array('style'=>'text-align: center;'),
                ),
                'bank_concept',
                array(
                    'name'=>'charge_bank',
                    'value'=>'($data->charge_bank!=null) ? "$".number_format($data->charge_bank,2) : "$0.00"',
                    'htmlOptions'=>array('style'=>'width:80px; text-align: right;font-style:italic;'),
                ),

                array(
                    'name'=>'commission_fee',
                    'value'=>'($data->commission_fee!=null) ? "$".number_format($data->commission_fee,2) : "$0.00"',
                    'htmlOptions'=>array('style'=>'width:80px; text-align: right;color:red;font-style:italic;'),
                ),
                array(
                    'name'=>'vat_commission',
                    'value'=>'($data->vat_commission!=null) ? "$".number_format($data->vat_commission,2) : "$0.00"',
                    'htmlOptions'=>array('style'=>'width:80px; text-align: right;color:red;font-style:italic;'),
                ),
                array(
                    'name'=>'retirement',
                    'value'=>'($data->retirement!=null) ? "$".number_format($data->retirement,2) : "$0.00"',
                    'htmlOptions'=>array('style'=>'width:80px; text-align: right;color:red;font-style:italic;'),
                ),
                array(
                    'name'=>'deposit',
                    'value'=>'($data->deposit!=null) ? "$".number_format($data->deposit,2) : "$0.00"',
                    'htmlOptions'=>array('style'=>'width:80px; text-align: right;color:green;font-style:italic;'),
                ),
                array(
                    'name'=>'balance',
                    'value'=>'($data->balance!=null) ? "$".number_format($data->balance,2) : "$0.00"',
                    'htmlOptions'=>array('style'=>'width:80px; text-align: right;font-style:italic;font-weight:bold;'),
                ),
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                    'headerHtmlOptions' => array('style' => 'width:200px;'),
                    'header'=>Yii::t('mx','Actions'),
                    'template'=>'{view}{details}{update}{delete}{cancel}',
                    'buttons'=>array(

                        'view' => array(
                            'label'=>Yii::t('mx','View'),
                            'icon'=>'icon-eye-open',
                            'url'=>'Yii::app()->createUrl("operations/view", array("id"=>$data->id))',
                            'options'=>array(
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>"js:$(this).attr('href')",
                                    'success'=>'function(data) {
                                    $("#detail-modal .modal-body p").html(data);
                                    $("#detail-modal").modal();
                                }'
                                ),
                            ),
                        ),

                        'details' => array(
                            'label'=>Yii::t('mx','Details'),
                            'icon'=>'icon-list',
                            'click'=>'function( e ){
                                    e.preventDefault();
                                    mostrarDetalles();
                            }',
                        ),

                        'delete'=>array(
                            'visible'=>'Yii::app()->user->isSuperAdmin',
                        ),
                        'cancel' => array(
                            'label' => Yii::t('mx','Canceled Check'),
                            'icon' => 'icon-remove',
                            'visible'=>'Yii::app()->user->isSuperAdmin',
                            'url'=>'Yii::app()->createUrl("operations/cancel", array("id"=>$data->id))',
                            'options'=>array(
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>"js:$(this).attr('href')",
                                    'dataType'=>'json',
                                    'beforeSend' => 'function() {  $("#operations-grid-inner").addClass("saving");    }',
                                    'complete' => 'function()   {  $("#operations-grid-inner").removeClass("saving"); }',
                                    'success'=>'function(data) {

                                        if(data.ok==true){
                                              $("#operations-grid").yiiGridView("update", {
                                                    data: $(this).serialize()
                                              });
                                        }

                                     }'
                                ),
                            )
                        ),
                    ),
                ),
            ),
        ));
        ?>

    <?php $this->endWidget();?>


</div>