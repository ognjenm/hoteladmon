<?php
$this->breadcrumbs=array(
	Yii::t('mx','Reservation')=>array('index'),
	Yii::t('mx','Update'),
	$model->id=>array('view','id'=>$model->id),
);

$this->menu=array(
    array('label'=>Yii::t('mx','Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
    array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
    array('label'=>Yii::t('mx','View'),'icon'=>'icon-eye-open','url'=>array('view','id'=>$model->id)),
);

$this->pageSubTitle=Yii::t('mx','Update');
$this->pageIcon='icon-edit';

?>


<?php echo $this->renderPartial('_status',array('model'=>$model)); ?>



