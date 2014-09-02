<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	Yii::t('mx','Create'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Create');
$this->pageIcon='icon-ok';


$mensaje=Yii::t('mx','Please select a item');
//$url=Yii::app()->createUrl('operations/getOperation');

Yii::app()->clientScript->registerScript('replication', "

var count=0;
var selection=0;

    $('#id_member').click(function(){

        count++;

        $('#operations-invoice-modal').modal();

        return false;
    });


    $('#buttonOk').click(function(){

        if($('#Operations-invoice').yiiGridView('getSelection')==0) js:bootbox.alert('{$mensaje}');
        else {
                selection=$('#Operations-invoice').yiiGridView('getSelection');

                if(count==1){

                    $('#ItemsInvoice_operation_id').val(selection);
                    $('#ItemsInvoice_quantity').val(1);
                    $('#ItemsInvoice_unit').val('NO APLICA');
                    $('#ItemsInvoice_identification').val('-');

                    $.ajax({
                        url: '".CController::createUrl('/operations/getOperation')."',
                        data: { operationId: selection },
                        type: 'POST',
                        dataType:'json',
                        beforeSend: function() { $('#maindiv').addClass('loading'); }
                    })

                    .done(function(data) {

                        if(data.ok==true) $('#ItemsInvoice_unit_price').val(data.price);

                    })

                    .fail(function() { js:bootbox.alert( 'error' ); })
                    .always(function() { $('#maindiv').removeClass('loading'); });


                }else{
                        $('#ItemsInvoice_operation_id'+count).val(selection);
                        $('#ItemsInvoice_quantity'+count).val(1);
                        $('#ItemsInvoice_unit'+count).val('NO APLICA');
                        $('#ItemsInvoice_identification'+count).val('-');

                        $.ajax({
                            url: '".CController::createUrl('/operations/getOperation')."',
                            data: { operationId: selection },
                            type: 'POST',
                            dataType:'json',
                            beforeSend: function() { $('#maindiv').addClass('loading'); }
                        })

                        .done(function(data) {

                            if(data.ok==true) $('#ItemsInvoice_unit_price'+count).val(data.price);

                        })

                        .fail(function() { js:bootbox.alert( 'error' ); })
                        .always(function() { $('#maindiv').removeClass('loading'); });
                }
        }

    });

");

?>

<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
    'items'=>$items,
    'validatedMembers' => $validatedMembers,
    'operations'=>$operations
)); ?>





<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'operations-invoice-modal')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Operations'); ?></h4>
    </div>

    <div class="modal-body">

        <?php

        $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'Operations-invoice',
            'type' => 'hover condensed striped',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Operations').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'pager' => array(
                'class' => 'bootstrap.widgets.TbPager',
                'displayFirstAndLast' => true,
                'lastPageLabel'=>Yii::t('mx','Last'),
                'firstPageLabel'=>Yii::t('mx','First'),
            ),
            'dataProvider'=>$operations,
            'selectableRows'=>1,
            'columns'=>array(
                array(
                    'class'=>'CCheckBoxColumn',
                ),
                'datex',
                array(
                    'name'=>'payment_type',
                    'value'=>'$data->payment->payment'
                ),
                'person',
                'bank_concept',
                'deposit'
            ),
        ));
        ?>
    </div>

    <div class="modal-footer">

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'id'=>'buttonOk',
            'label' => Yii::t('mx','Return'),
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )); ?>

    </div>
<?php $this->endWidget(); ?>