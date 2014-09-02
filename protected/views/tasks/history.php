<?php

if(Yii::app()->user->isSuperAdmin){
    $this->breadcrumbs=array(
        Yii::t('mx','Tasks')=>array('index'),
        Yii::t('mx','History'),
    );
}else{
    $this->breadcrumbs=array(
        Yii::t('mx','Tasks')=>array('myTasks'),
        Yii::t('mx','History'),
    );
}



$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index'),'visible'=>Yii::app()->user->isSuperAdmin),
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('myTasks'),'visible'=>!Yii::app()->user->isSuperAdmin),
);

$this->pageSubTitle=Yii::t('mx','History');
$this->pageIcon='icon-th-list';

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

    Yii::app()->clientScript->registerScript('task2', "

        $('.popover-examples a').popover({
                trigger : 'hover',
                placement : 'top',
                html : true
        });

    ");

?>

<?php $this->renderPartial('_history', array(
    'model' => $model,
));
?>








