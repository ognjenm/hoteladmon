<?php
	/*
		$model:  es una instancia que implementa a CrugeAuthItemEditor
	*/

$this->pageSubTitle=Yii::t('mx','Create');
$this->pageIcon='icon-cogs';

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('/cruge/ui/rbaclistroles')),
);

?>

<fieldset>
    <legend><?php echo Yii::t('mx','Creating')." ".CrugeTranslator::t($model->categoria); ?></legend>
    <?php $this->renderPartial('_authitemform',array('model'=>$model),false); ?>
</fieldset>