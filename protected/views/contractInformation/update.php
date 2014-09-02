<?php

    $this->breadcrumbs=array(
        Yii::t('mx','Contracts')=>array('index'),
        Yii::t('mx','Update'),
        $model->id=>array('view','id'=>$model->id),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx','Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx','View'),'icon'=>'icon-eye-open','url'=>array('view','id'=>$model->id)),
    );

    $this->pageSubTitle=Yii::t('mx','Update');
    $this->pageIcon='icon-edit';

    Yii::app()->clientScript->registerScript('search', "

    function isdecimal(service){

        var n = service.toString();
        var tienepunto=false;
        var subcadena;

        for(i=0;i<n.length;i++){
            if(n[i]=='.'){
                tienepunto=true;
                break;
            }
        }

        if(tienepunto) return true;
        else return false;
    }

            $('#ContractInformation_payment_services').focusout(function() {
                var service=$('#ContractInformation_payment_services').val();
                if(!isdecimal(service)) $('#ContractInformation_payment_services').val(service+'.00');
            });

            $('#ContractInformation_monthly_payment_arrears').focusout(function() {
                var service=$('#ContractInformation_monthly_payment_arrears').val();
                if(!isdecimal(service)) $('#ContractInformation_monthly_payment_arrears').val(service+'.00');
            });

            $('#ContractInformation_new_rent_payment').focusout(function() {
                var service=$('#ContractInformation_new_rent_payment').val();
                if(!isdecimal(service)) $('#ContractInformation_new_rent_payment').val(service+'.00');
            });

            $('#ContractInformation_monthly_payment_increase').focusout(function() {
                var service=$('#ContractInformation_monthly_payment_increase').val();
                if(!isdecimal(service)) $('#ContractInformation_monthly_payment_increase').val(service+'.00');
            });

            $('#ContractInformation_penalty_nonpayment').focusout(function() {
                var service=$('#ContractInformation_penalty_nonpayment').val();
                if(!isdecimal(service)) $('#ContractInformation_penalty_nonpayment').val(service+'.00');
            });

            $('#ContractInformation_deposit_guarantee').focusout(function() {
                var service=$('#ContractInformation_deposit_guarantee').val();
                if(!isdecimal(service)) $('#ContractInformation_deposit_guarantee').val(service+'.00');
            });

            $('#ContractInformation_amount_rent').focusout(function() {
                var service=$('#ContractInformation_amount_rent').val();
                if(!isdecimal(service)) $('#ContractInformation_amount_rent').val(service+'.00');
            });


    ");


?>


    <?php echo $this->renderPartial('_form',array(
        'model'=>$model,
        'property'=>$property,
        'servicesForm'=>$servicesForm
    )); ?>



