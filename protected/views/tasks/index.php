<?php

    if(Yii::app()->user->isSuperAdmin){
        $this->breadcrumbs=array(
            Yii::t('mx','Tasks')=>array('index'),
            Yii::t('mx','Manage'),
        );
    }else{
        $this->breadcrumbs=array(
            Yii::t('mx','Tasks')=>array('myTasks'),
            Yii::t('mx','Manage'),
        );
    }


    $this->menu=array(
        array('label'=>Yii::t('mx', 'Tasks'),'icon'=>'icon-refresh','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx','Groups'),'icon'=>'icon-group','url'=>array('/groups')),
        array('label'=>Yii::t('mx','History'),'icon'=>'icon-remove','url'=>array('history')),
        array('label'=>Yii::t('mx','Departments'),'icon'=>'icon-home','url'=>array('/departments')),
        array('label'=>Yii::t('mx','Zones'),'icon'=>'icon-map-marker','url'=>array('/zones')),
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

    $message=Yii::t('mx','Please, select items or items');
    $reallocateUrl=$this->createUrl('reallocate');

    Yii::app()->clientScript->registerScript('task2', "

        $('.popover-examples a').popover({
                trigger : 'hover',
                placement : 'top',
                html : true
        });

    ");


?>

 <?php $this->renderPartial('_grid', array(
        'model' => $model,
    ));
 ?>

    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-comment')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><i class="icon-comment"></i> <?php echo Yii::t('mx','New Comment'); ?></h4>
    </div>

    <div class="modal-body"><p></p></div>

    <div class="modal-footer">

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('mx','Return'),
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )); ?>

    </div>
    <?php $this->endWidget(); ?>







