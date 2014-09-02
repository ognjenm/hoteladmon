
<?php
$this->breadcrumbs=array(
    Yii::t('mx','Bracelets')=>array('/assignment'),
	Yii::t('mx','Sell'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('/assignment')),
);

$this->pageSubTitle=Yii::t('mx','Sell');
$this->pageIcon='icon-minus';

?>

<?php echo Yii::app()->user->setFlash('warning', Yii::t('mx','<strong>Nota:</strong> Cambiar el primer folio y darle click a vender, para que al vender de nuevo
 continue con el siguiente folio.')); ?>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true,
    'fade'=>true,
    'closeText'=>'×',
    'alerts'=>array('warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×')),
));
?>

<div class="divContent">
    <?php echo $this->renderPartial('_form', array(
        'model'=>$model,
        'validatedMembers' => $validatedMembers
    )); ?>
</div>