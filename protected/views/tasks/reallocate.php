<?php

if(Yii::app()->user->isSuperAdmin){
    $this->breadcrumbs=array(
        Yii::t('mx','Tasks')=>array('index'),
        Yii::t('mx','Reallocate'),
    );
}else{
    $this->breadcrumbs=array(
        Yii::t('mx','Tasks')=>array('myTasks'),
        Yii::t('mx','Reallocate'),
    );
}


$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('mytasks')),
);

$this->pageSubTitle=Yii::t('mx','Reallocate');
$this->pageIcon='icon-ok';

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

?>

<?php $this->renderPartial('_reallocate', array(
    'model' => $model,
));
?>








