<?php

$this->breadcrumbs=array(
    Yii::t('mx','Roles')=>array('/cruge/ui/rbaclistroles'),
    Yii::t('mx','Manage'),
);

$this->pageSubTitle=Yii::t('mx','Manage');
$this->pageIcon='icon-cogs';

$this->menu=array(
    array('label'=>Yii::t('mx','Create New Rol'),'icon'=>'icon-plus','url'=>Yii::app()->user->ui->getRbacAuthItemCreateUrl(CAuthItem::TYPE_ROLE)),
);

?>


<?php $this->renderPartial('_listauthitems',array('dataProvider'=>$dataProvider),false);?>