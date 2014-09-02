<?php

$this->breadcrumbs=array(
    Yii::t('mx','Contracts')=>array('index'),
    Yii::t('mx','Manage'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
    array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('createContract')),
);

$this->pageSubTitle=Yii::t('mx','Manage');
$this->pageIcon='icon-cogs';

if(Yii::app()->user->hasFlash('success')):
    Yii::app()->user->setFlash('success', '<strong>done!</strong> '.Yii::app()->user->getFlash('success'));
endif;

$this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true,
    'fade'=>true,
    'closeText'=>'×',
    'alerts'=>array(
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
    ),
));

?>


<?php $this->renderPartial('_contracts', array(
    'model' => $model,
));
?>






