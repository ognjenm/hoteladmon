<?php

    $this->breadcrumbs=array(
        Yii::t('mx','Reservations')=>array('index'),
        Yii::t('mx','Create'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('site/index')),
    );

    $this->pageSubTitle=Yii::t('mx','Reservation');
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


    Yii::app()->clientScript->registerScript('search', "

        $('#search-button').click(function(){
            $('.daypass').toggle();
            //$('#ReservationCamped_checkin').val('')
            return false;
        });

        $('#yw12').hide();

         var startDateTextBox1 = $('#FBReservation_checkin');
         var endDateTextBox1= $('#FBReservation_checkout');

         var startDateTextBox = $('#Reservation_checkin');
         var endDateTextBox = $('#Reservation_checkout');

    ");


?>

<div id="maindiv">

    <?php echo $this->renderPartial('_form', array(
        'form'=>$form,
        'CustomerForm'=>$CustomerForm,
        'model'=>$model,
        'reservation'=>$reservation,
        'reservationForm'=>$reservationForm,
        'validatedItems' => $validatedItems,
        'pollForm'=>$pollForm,
        'formSalesAgents'=>$formSalesAgents,
        'formReservationChannel'=>$formReservationChannel,
        'bdgtReservationForm'=>$bdgtReservationForm,
        'bdgtReservation'=>$bdgtReservation
    )); ?>

</div>