<?php
    $this->breadcrumbs=array(
        Yii::t('mx','Direct Invoice')=>array('index'),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Refresh'),'icon'=>'icon-refresh','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx','Polizas'),'icon'=>'icon-bar-chart','url'=>array('/polizas')),
        array('label'=>Yii::t('mx','Polizas sin factura'),'icon'=>'icon-list','url'=>array('/polizas/gridPolizaNoBill')),
        array('label'=>Yii::t('mx','Polizas con diferencia'),'icon'=>'icon-list','url'=>array('/polizas/polizadifference')),
        array('label'=>Yii::t('mx','History'),'icon'=>'icon-list','url'=>array('history')),

    );

    $this->pageSubTitle=Yii::t('mx','Manage');
    $this->pageIcon='icon-cogs';

    if(Yii::app()->user->hasFlash('success')):
        Yii::app()->user->setFlash('success', '<strong>done!</strong> '.Yii::app()->user->getFlash('success'));
    endif;

    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'×',
        'alerts'=>array(
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        ),
    ));

    $url=$this->createUrl('sumaInvoices');


    Yii::app()->clientScript->registerScript('search', "

            $('#transport').click(function(){
                $('#transportdisplay').toggle();
                return false;
            });

            $('.select-on-check').click(function(){

                var invoice=$.fn.yiiGridView.getChecked('direct-invoice-grid','chk').toString();
                var adultos=$('#DirectInvoiceItems_total').val();
                var estudiantes=$('#DirectInvoiceItems_total2').val();


                if(invoice!=''){
                    $.ajax({
                        url:'$url',
                        data: { ids: invoice, adulto: adultos, estudiante: estudiantes },
                        type: 'POST',
                        dataType: 'json',
                        beforeSend: function() { $('#direct-invoice-grid-inner').addClass('loading'); }
                    })

                    .done(function(data) {  $('#suma').html(data.suma); })
                    .fail(function() { bootbox.alert('Error');  })
                    .always(function() { $('#direct-invoice-grid-inner').removeClass('loading'); });
                }

            });
        ");

?>

<div id="suma" class="pull-right"></div>

<div class="span8" id="transportdisplay" style="display:none"><?php  echo $fTransporte->render(); ?></div>

<?php echo $filter->render(); ?>

 <?php $this->renderPartial('_grid', array(
        'model' => $model,
    ));
 ?>


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-no-bill')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-comment"></i> <?php echo Yii::t('mx','Poliza sin factura'); ?></h4>
</div>

<div class="modal-body">
    <p>
        <?php

        echo $fNoBill->renderBegin();

        echo $fNoBill['typeCheq2'];
        echo $fNoBill['account_id2'];
        echo $fNoBill['authorized2'];
        echo $fNoBill['released2'];

        echo '<div class="pull-right">';

        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'button',
            'type'=>'primary',
            'icon'=>'icon-plus',
            'htmlOptions' => array(
                'data-toggle' => 'modal',
                'data-target' => '#modal-conceptx',
            ),
        ));

        echo '</div>';

        echo $fNoBill['concept2'];
        echo $fNoBill['amount'];
        echo $fNoBill['abonoencuenta2'];
        echo $fNoBill->renderElement('savepolizaNoBill');

        echo $fNoBill->renderEnd();

        ?>
    </p>
</div>

<div class="modal-footer">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>


    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-operations')); ?>
        <div class="modal-header">
            <a class="close" data-dismiss="modal">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
            </a>
            <h4><i class="icon-comment"></i> <?php echo Yii::t('mx','Generar Poliza'); ?></h4>
        </div>

        <div class="modal-body">
            <p>
                <?php echo $fOperations->renderBegin();

                    echo $fOperations['datex'];
                    echo $fOperations['typeCheq'];
                    echo $fOperations['account_id'];
                    echo $fOperations['authorized'];
                    echo $fOperations['released'];
                    echo '<div class="pull-right">';

                    $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'button',
                        'type'=>'primary',
                        'icon'=>'icon-plus',
                        'htmlOptions' => array(
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-conceptx',
                        ),
                    ));

                    echo '</div>';

                    echo $fOperations['concept'];
                    echo $fOperations['abonoencuenta'];
                    echo $fOperations->renderElement('saveOperation');

                    echo $fOperations->renderEnd();

                ?>
            </p>
        </div>

        <div class="modal-footer">

            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label' => Yii::t('mx','Return'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )); ?>

        </div>
    <?php $this->endWidget(); ?>


    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-conceptx')); ?>

        <div class="modal-header">
            <a class="close" data-dismiss="modal">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
            </a>
            <h4><i class="icon-list"></i> <?php echo Yii::t('mx','Concepts'); ?></h4>
        </div>

        <div class="modal-body" id="body-conceptPayment">
            <p><?php echo $FconceptPayments->render(); ?></p>
        </div>

        <div class="modal-footer">

            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label' => Yii::t('mx','Return'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )); ?>

        </div>

    <?php $this->endWidget(); ?>






