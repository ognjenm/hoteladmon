
<?php
$this->breadcrumbs=array(
	Yii::t('mx','Tax Information')=>array('/customers'),
	Yii::t('mx','Create'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('/customers')),
);

$this->pageSubTitle=Yii::t('mx','Create');
$this->pageIcon='icon-ok';

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>