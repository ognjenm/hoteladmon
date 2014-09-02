<?php
$this->breadcrumbs=array(
        Yii::t('mx','Rates')=>array('index'),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Rates'),'icon'=>'icon-refresh','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        //array('label'=>Yii::t('mx','Apply Tariffs'),'icon'=>'icon-plus','url'=>'#','linkOptions'=>array('id'=>'apply')),
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

    $rates = CJavaScript::quote($this->createUrl('/rates/clone'), true);
    $mensaje=Yii::t('mx','Please select a rates source');

    Yii::app()->clientScript->registerScript('replication', "

    $('#apply').click(function(){

            var rates=$('#rates-grid').yiiGridView('getSelection');

            if(rates==0) alert('{$mensaje}');
            else document.location.href = '{$rates}&ids='+rates;

        return false;
    });

    $('#filter-button').click(function(){
            $('.filters').toggle();
            return false;
     });

    $('.filters').hide();

");



    ?>


 <?php $this->renderPartial('_grid', array(
        'model' => $model,
    ));
 ?>






