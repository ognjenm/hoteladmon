<?php

$this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs', // 'tabs' or 'pills'
    'tabs'=>array(
        array('label'=>Yii::t('mx','Cabanas And Camped'),'content'=>$this->renderPartial("_cabana",array(
                'form'=>$form,
                'CustomerForm'=>$CustomerForm,
                'model'=>$model,
                'reservation'=>$reservation,
                'reservationForm'=>$reservationForm,
                'validatedItems' => $validatedItems,
                'pollForm'=>$pollForm,
                'formSalesAgents'=>$formSalesAgents,
                'formReservationChannel'=>$formReservationChannel
            ),true), 'active'=>true),
        array('label'=>Yii::t('mx','Groups And Events'), 'content'=>$this->renderPartial("_groupsAndEvents",array(),true)),
    ),
));

?>
