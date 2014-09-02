
<?php

if(Yii::app()->user->isSuperAdmin){
    $this->breadcrumbs=array(
        Yii::t('mx','Tasks')=>array('index'),
        Yii::t('mx','Create'),
    );
}else{
    $this->breadcrumbs=array(
        Yii::t('mx','Tasks')=>array('myTasks'),
        Yii::t('mx','Create'),
    );
}


$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index'),'visible'=>Yii::app()->user->isSuperAdmin),
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('myTasks'),'visible'=>!Yii::app()->user->isSuperAdmin),
);

$this->pageSubTitle=Yii::t('mx','Create');
$this->pageIcon='icon-ok';

?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'department'=>$department,'zones'=>$zones)); ?>