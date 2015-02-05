<?php
/**
 * Created by PhpStorm.
 * User: usof03
 * Date: 28/01/2015
 * Time: 05:48 PM
 */

    $this->breadcrumbs=array(
        Yii::t('mx','Reservations')=>array('index'),
        Yii::t('mx','Cancel'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
    );

    $this->pageSubTitle=Yii::t('mx','Cancel');
    $this->pageIcon='icon-list-alt';

    echo Yii::app()->user->setFlash('danger',"<h3>Cancelar Reservación: ".$customerReservation->customer->first_name.' '.$customerReservation->customer->last_name." ?</h3>");

    if(Yii::app()->user->hasFlash('error')):
        Yii::app()->user->setFlash('warning',Yii::app()->user->getFlash('error'));
    endif;

     $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'×',
        'alerts'=>array(
            'danger'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
            'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        ),
    ));

?>

<div class="mainDiv">
<?php  $this->renderPartial('_cancel', array('Formcancel'=>$Formcancel)); ?>
</div>