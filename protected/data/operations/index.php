<?php
    $this->breadcrumbs=array(
        Yii::t('mx','Operations')=>array('index'),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Operations'),'icon'=>'icon-refresh','url'=>array('index')),
        array('label'=>Yii::t('mx','Deposits'),'icon'=>'icon-plus','url'=>array('/operations/deposit')),
        array('label'=>Yii::t('mx','Payments'),'icon'=>'icon-minus','url'=>array('/operations/payment')),
        array('label'=>Yii::t('mx','Tranfers'),'icon'=>'icon-exchange','url'=>array('/operations/transfer')),
        array('label'=>Yii::t('mx','Export Pdf'),'icon'=>'icon-file','url'=>array('/operations/exportBalanceToPdf')),
        array('label'=>Yii::t('mx','export Sheet To The Accountant'),'icon'=>'icon-file','url'=>array('/operations/exportPdfToAccountant')),
    );

    $this->pageSubTitle=Yii::t('mx','Manage');
    $this->pageIcon='icon-cogs';

    if(Yii::app()->user->hasFlash('success')):
    Yii::app()->user->setFlash('success', '<strong>done!</strong> '.Yii::app()->user->getFlash('success'));
    endif;

    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'×', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
        ),
    ));


    Yii::app()->clientScript->registerScript('filters', "

        $('#filterForm').submit(function(){

            $('#operations-grid').yiiGridView('update', {
                data: $(this).serialize()
            });

            $('#div-grid-operations').show();

            return false;
        });

        function mostrarDetalles(){
            var operationId = $.fn.yiiGridView.getSelection('operations-grid');
            $.fn.yiiGridView.update('Operations-History',{ data: operationId });
            $('#operationsHistory').modal();

	    }

    ");

?>

    <?php echo $formFilter->render(); ?>

    <div id="div-grid-operations" style="display: none">
         <?php $this->renderPartial('_grid', array(
                'model' => $model,
            ));
         ?>
    </div>




<!-- aqui empieda el historial del cliente !-->


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'operationsHistory')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Operations History'); ?></h4>
</div>

<div class="modal-body">
    <?php

    $this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'Operations-History',
        'type' => 'hover condensed striped',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Operations History').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'pager' => array(
            'class' => 'bootstrap.widgets.TbPager',
            'displayFirstAndLast' => true,
            'lastPageLabel'=>Yii::t('mx','Last'),
            'firstPageLabel'=>Yii::t('mx','First'),
        ),
        'dataProvider'=>$operationsHistory,
        'columns'=>array(
            'field',
            'old_value',
            'new_value',
            'stamp',
            array(
                'name'=>'user_id',
                'value'=>'$data->users->username'
            ),
        ),
    ));
    ?>
</div>

<div class="modal-footer">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>






