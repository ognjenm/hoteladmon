
<?php
$this->breadcrumbs=array(
    Yii::t('mx','New Customer Information')=>array('index'),
	Yii::t('mx','Create'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Create');
$this->pageIcon='icon-ok';

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>