
<?php
$this->breadcrumbs=array(
    Yii::t('mx','Rooms')=>array('index'),
	Yii::t('mx','Create'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Create');
$this->pageIcon='icon-ok';

?>

<?php echo Yii::app()->user->setFlash('warning', Yii::t('mx','IMPORTANT: Maximum capacity including adults and children')); ?>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true,
    'fade'=>true,
    'closeText'=>'×',
    'alerts'=>array('warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×')),
));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>