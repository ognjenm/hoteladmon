<?php

    if(Yii::app()->user->isSuperAdmin){
        $this->breadcrumbs=array(
            Yii::t('mx','Tasks')=>array('index'),
            Yii::t('mx','Update'),
            $model->id=>array('view','id'=>$model->id),
        );
    }else{
        $this->breadcrumbs=array(
            Yii::t('mx','Tasks')=>array('myTasks'),
            Yii::t('mx','Update'),
            $model->id=>array('view','id'=>$model->id),
        );
    }



$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index'),'visible'=>Yii::app()->user->isSuperAdmin),
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('myTasks'),'visible'=>!Yii::app()->user->isSuperAdmin),
    array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
    array('label'=>Yii::t('mx','View'),'icon'=>'icon-eye-open','url'=>array('view','id'=>$model->id)),
);

$this->pageSubTitle=Yii::t('mx','Update');
$this->pageIcon='icon-edit';

?>


<?php echo $this->renderPartial('_form',array('model'=>$model,'department'=>$department,'zones'=>$zones)); ?>



