<?php
$this->breadcrumbs=array(
    Yii::t('mx','Rates')=>array('index'),
    Yii::t('mx','Clone'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'url'=>array('index'),'icon'=>'icon-chevron-left'),
);

$this->pageSubTitle=Yii::t('mx','Rates');
$this->pageIcon='icon-money';

?>

<?php

    if(Yii::app()->user->hasFlash('success')):
        Yii::app()->user->setFlash('success', '<strong>done!</strong> '.Yii::app()->user->getFlash('success'));
    endif;

    $this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true, // display a larger alert block?
    'fade'=>true, // use transitions?
    'closeText'=>'×', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
    ),
    ));

?>


<?php echo $this->renderPartial('_clone', array()); ?>