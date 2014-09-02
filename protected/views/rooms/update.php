<?php
$this->breadcrumbs=array(
	Yii::t('mx','Rooms')=>array('index'),
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

<?php echo Yii::app()->user->setFlash('warning', Yii::t('mx','IMPORTANT: Maximum capacity including adults and children')); ?>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true,
    'fade'=>true,
    'closeText'=>'×',
    'alerts'=>array('warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×')),
));
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>



