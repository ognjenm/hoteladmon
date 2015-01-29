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

    echo Yii::app()->user->setFlash('info', $customerReservation->customer->first_name.' '.$customerReservation->customer->last_name);

     $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'×',
        'alerts'=>array(
            'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×')
        ),
    ));




    $this->renderPartial('_cancel', array());