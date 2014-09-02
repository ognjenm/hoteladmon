<?php
$this->breadcrumbs=array(
    Yii::t('mx','Rol')=>array('/cruge/ui/rbaclistroles'),
    Yii::t('mx','Properties'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('/cruge/ui/rbaclistroles')),
);


$this->pageSubTitle=Yii::t('mx','Editing')." ".$model->categoria;
$this->pageIcon='icon-list-alt';
	
?>

<?php $this->renderPartial('_authitemform',array('model'=>$model),false);?>