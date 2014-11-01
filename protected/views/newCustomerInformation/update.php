<?php

    $this->breadcrumbs=array(
        Yii::t('mx','New Customer Information')=>array('index'),
        Yii::t('mx','Update'),
        $model->id=>array('view','id'=>$model->id),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx','Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
    );

    $this->pageSubTitle=Yii::t('mx','Update');
    $this->pageIcon='icon-edit';

    Yii::app()->clientScript->registerScript('filters', '

        $("#alternative_email_New").click(function () {
            if ($("#alternative_email_New").is(":checked") == true) {
                $("#NewCustomerInformation_alternative_email_Save").val($("#NewCustomerInformation_alternative_email").val());
            }else{
                $("#NewCustomerInformation_alternative_email_Save").val("");
            }
        })

        $("#alternative_email_Old").click(function () {
            if ($("#alternative_email_Old").is(":checked") == true) {
                $("#NewCustomerInformation_alternative_email_Save").val($("#Customers_alternative_email").val());
            }else{
                $("#NewCustomerInformation_alternative_email_Save").val("");
            }
        })

        $("#first_name_New").click(function () {
            if ($("#first_name_New").is(":checked") == true) {
                $("#NewCustomerInformation_first_name_Save").val($("#NewCustomerInformation_first_name").val());
            }else{
                $("#NewCustomerInformation_first_name_Save").val("");
            }
        })

        $("#first_name_Old").click(function () {
            if ($("#first_name_Old").is(":checked") == true) {
                $("#NewCustomerInformation_first_name_Save").val($("#Customers_first_name").val());
            }else{
                $("#NewCustomerInformation_first_name_Save").val("");
            }
        })

        $("#last_name_New").click(function () {
            if ($("#last_name_New").is(":checked") == true) {
                $("#NewCustomerInformation_last_name_Save").val($("#NewCustomerInformation_last_name").val());
            }else{
                $("#NewCustomerInformation_last_name_Save").val("");
            }
        })

        $("#last_name_Old").click(function () {
            if ($("#last_name_Old").is(":checked") == true) {
                $("#NewCustomerInformation_last_name_Save").val($("#Customers_last_name").val());
            }else{
                $("#NewCustomerInformation_last_name_Save").val("");
            }
        })

        $("#country_New").click(function () {
            if ($("#country_New").is(":checked") == true) {
                $("#NewCustomerInformation_country_Save").val($("#NewCustomerInformation_country").val());
            }else{
                $("#NewCustomerInformation_country_Save").val("");
            }
        })

        $("#country_Old").click(function () {
            if ($("#country_Old").is(":checked") == true) {
                $("#NewCustomerInformation_country_Save").val($("#Customers_country").val());
            }else{
                $("#NewCustomerInformation_country_Save").val("");
            }
        })

        $("#state_New").click(function () {
            if ($("#state_New").is(":checked") == true) {
                $("#NewCustomerInformation_state_Save").val($("#NewCustomerInformation_state").val());
            }else{
                $("#NewCustomerInformation_state_Save").val("");
            }
        })

        $("#state_Old").click(function () {
            if ($("#state_Old").is(":checked") == true) {
                $("#NewCustomerInformation_state_Save").val($("#Customers_state").val());
            }else{
                $("#NewCustomerInformation_state_Save").val("");
            }
        })

        $("#city_New").click(function () {
            if ($("#city_New").is(":checked") == true) {
                $("#NewCustomerInformation_city_Save").val($("#NewCustomerInformation_city").val());
            }else{
                $("#NewCustomerInformation_city_Save").val("");
            }
        })

        $("#city_Old").click(function () {
            if ($("#city_Old").is(":checked") == true) {
                $("#NewCustomerInformation_city_Save").val($("#Customers_city").val());
            }else{
                $("#NewCustomerInformation_city_Save").val("");
            }
        })

        $("#home_phone_New").click(function () {
            if ($("#home_phone_New").is(":checked") == true) {
                $("#NewCustomerInformation_home_phone_Save").val($("#NewCustomerInformation_home_phone").val());
            }else{
                $("#NewCustomerInformation_home_phone_Save").val("");
            }
        })

        $("#home_phone_Old").click(function () {
            if ($("#home_phone_Old").is(":checked") == true) {
                $("#NewCustomerInformation_home_phone_Save").val($("#Customers_home_phone").val());
            }else{
                $("#NewCustomerInformation_home_phone_Save").val("");
            }
        })

       $("#work_phone_New").click(function () {
            if ($("#work_phone_New").is(":checked") == true) {
                $("#NewCustomerInformation_work_phone_Save").val($("#NewCustomerInformation_work_phone").val());
            }else{
                $("#NewCustomerInformation_work_phone_Save").val("");
            }
        })

        $("#work_phone_Old").click(function () {
            if ($("#work_phone_Old").is(":checked") == true) {
                $("#NewCustomerInformation_work_phone_Save").val($("#Customers_work_phone").val());
            }else{
                $("#NewCustomerInformation_work_phone_Save").val("");
            }
        })

        $("#cell_phone_New").click(function () {
            if ($("#cell_phone_New").is(":checked") == true) {
                $("#NewCustomerInformation_cell_phone_Save").val($("#NewCustomerInformation_cell_phone").val());
            }else{
                $("#NewCustomerInformation_cell_phone_Save").val("");
            }
        })

        $("#cell_phone_Old").click(function () {
            if ($("#cell_phone_Old").is(":checked") == true) {
                $("#NewCustomerInformation_cell_phone_Save").val($("#Customers_cell_phone").val());
            }else{
                $("#NewCustomerInformation_cell_phone_Save").val("");
            }
        })


    ');

?>




<?php echo $this->renderPartial('_form',array('model'=>$model,'customer'=>$customer)); ?>



