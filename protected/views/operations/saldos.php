<?php

$this->breadcrumbs=array(
    Yii::t('mx','Operations')=>array('index'),
    Yii::t('mx','Balance'),
);


$this->menu=array(
    array('label'=>Yii::t('mx', 'Refresh'),'icon'=>'icon-refresh','url'=>array('index')),
    array('label'=>Yii::t('mx','Deposits'),'icon'=>'icon-plus','url'=>array('/operations/deposit','accountId'=>$accountId,'accountType'=>$accountType)),
    array('label'=>Yii::t('mx','Payments'),'icon'=>'icon-minus','url'=>array('/operations/payment','accountId'=>$accountId,'accountType'=>$accountType)),
    array('label'=>Yii::t('mx','Tranfers'),'icon'=>'icon-exchange','url'=>array('/operations/transfer','accountId'=>$accountId,'accountType'=>$accountType)),
    array('label'=>Yii::t('mx','Export Pdf'),'icon'=>'icon-file','url'=>array('/operations/exportBalanceToPdf')),
    array('label'=>Yii::t('mx','export Sheet To The Accountant'),'icon'=>'icon-file','url'=>array('/operations/exportPdfToAccountant')),
);

$url=$this->createUrl('sumaOperations');


Yii::app()->clientScript->registerScript('filterss', "

        var sumaTotal=0;

       $('#filterForm').submit(function(){

            $('#operations-grid').yiiGridView('update', {
                data: $(this).serialize()
            });

            $('#operations-grid-inner').show();

            return false;

        });

        function sumaOperaciones(){

                var invoice = $.fn.yiiGridView.getSelection('operations-grid').toString();

                if(invoice!=''){
                    $.ajax({
                        url:'$url',
                        data: { ids: invoice },
                        type: 'POST',
                        dataType: 'json',
                        beforeSend: function() { $('#mainDiv').addClass('loading'); }
                    })

                    .done(function(data) {
                        $('#suma').html('$'+data.suma);
                        sumaTotal=data.sumaNoFormat;
                    })
                    .fail(function() { bootbox.alert('Error');  })
                    .always(function() { $('#mainDiv').removeClass('loading'); });
                }
        }

    ",CClientScript::POS_END);

?>

<div class="box-title">

    <?php
        foreach( $botones as $botom){

            $this->widget('bootstrap.widgets.TbButtonGroup',
                array(
                    'size' => 'large',
                    'buttons' => array($botom),
                )
            );
        }
    ?>

</div>

<?php echo Yii::app()->user->setFlash('info',"<h3>".$display."</h3>"); ?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true,
    'fade'=>true,
    'closeText'=>'×',
    'alerts'=>array('info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×')),
));
?>

<?php echo $Formfilter->render(); ?>

<div id="suma" class="pull-right well">$0.00</div>

<div id="mainDiv">
    <?php $this->renderPartial('_grid', array(
        'dataProvider'=>$dataProvider,
        'accountId'=>$accountId
    ));
    ?>
</div>

<!-- Formulario para mostrar detalles !-->


    <?php $this->beginWidget('bootstrap.widgets.TbModal', array(
        'id' => 'detail-modal',
        'autoOpen'=>false
    ));
    ?>

        <div class="modal-header">
            <a class="close" data-dismiss="modal">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
            </a>
            <h4><?php echo Yii::t('mx','Details'); ?></h4>
        </div>

        <div class="modal-body" id="charges-messages">
            <p></p>
        </div>

        <div class="modal-footer">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label' => Yii::t('mx','Cancel'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )); ?>
        </div>

    <?php $this->endWidget(); ?>