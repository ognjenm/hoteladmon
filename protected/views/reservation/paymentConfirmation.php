<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 23/11/13
 * Time: 13:27
 */
?>

<?php

$this->breadcrumbs=array(
    'Reservation'=>array('index'),
    Yii::t('mx','Budget'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('/reservation')),
    array('label'=>Yii::t('mx', 'Export PDF'),'icon'=>'icon-chevron-left','url'=>array('index')),
    array('label'=>Yii::t('mx', 'Export Word'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Budget');
$this->pageIcon='icon-ok';


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

Yii::app()->clientScript->registerScript('replication', "

$('#sendmail').click(function() {
    CKEDITOR.instances.ckeditor.updateElement();
});


");


?>

<div id="maindiv">

    <?php echo $this->renderPartial('_paymentConfirmation', array(
        'format'=>$format,
        'customerReservationId'=>$customerReservationId,
        'from'=>$from,
        'email'=>$email,
        'cc'=>$cc,
    )); ?>

</div>