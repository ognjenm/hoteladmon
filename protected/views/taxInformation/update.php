<?php
$this->breadcrumbs=array(
	Yii::t('mx','Tax Information')=>array('/customers'),
	Yii::t('mx','Update'),
	$model->id=>array('view','id'=>$model->id),
);

$this->menu=array(
    array('label'=>Yii::t('mx','Back'),'icon'=>'icon-chevron-left','url'=>array('/customers')),

);

$this->pageSubTitle=Yii::t('mx','Update');
$this->pageIcon='icon-edit';

?>


<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>



