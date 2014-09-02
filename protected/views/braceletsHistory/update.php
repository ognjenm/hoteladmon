<?php
$this->breadcrumbs=array(
	Yii::t('mx','Bracelets')=>array('/assignment'),
	Yii::t('mx','Update'),
	$model->id=>array('view','id'=>$model->id),
);

$this->menu=array(
    array('label'=>Yii::t('mx','Back'),'icon'=>'icon-chevron-left','url'=>array('/assignment/view','id'=>$asigmentId)),

);

$this->pageSubTitle=Yii::t('mx','Update');
$this->pageIcon='icon-edit';

?>


<?php echo $this->renderPartial('_update',array('model'=>$model)); ?>



