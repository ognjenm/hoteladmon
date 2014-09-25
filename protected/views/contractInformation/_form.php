<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'contract-information-form',
	'enableAjaxValidation'=>false,
    'type'=>'horizontal'
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>
    <br>
    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'title',array(
        'class'=>'span12',
        'maxlength'=>100,
        'style'=>'text-transform:uppercase',
        'rel'=>'tooltip',
        'title'=>Yii::t('mx','This text does not appear in the contract')
    )); ?>

<div class="container-fluid">
        <div class="span6">
        <div class="control-group">
            <label class="control-label" for="ContractInformation_iscompany_lessee">
                <?php echo Yii::t('mx','The lessee is a company'); ?>
            </label>
            <div class="controls">
                <?php $this->widget('bootstrap.widgets.TbToggleButton',array(
                    'model' => $model,
                    'attribute'=>'iscompany_lessee',
                    'enabledLabel'=>Yii::t('mx','Yes'),
                    'disabledLabel'=>Yii::t('mx','No'),
                    'onChange'=>'js:function($el, status, e){
                                    if(status==true){
                                        $("#iscompany_lesseediv").show();
                                    }
                                    else{
                                        $("#iscompany_lesseediv").hide();
                                    }
                             }',
                ));
                ?>
            </div>
        </div>

        <?php if($model->isNewRecord){ ?>
            <div id="iscompany_lesseediv" style="display: none">
                <?php echo $form->textFieldRow($model,'company_lessee',array('class'=>'span12','maxlength'=>150,'style'=>'text-transform:uppercase')); ?>
                <?php echo $form->textFieldRow($model,'rfc_lessee',array('class'=>'span12','maxlength'=>25,'style'=>'text-transform:uppercase')); ?>
            </div>
       <?php  }elseif($model->iscompany_lessee==true){ ?>
        <div id="iscompany_lesseediv">
                <?php echo $form->textFieldRow($model,'company_lessee',array('class'=>'span12','maxlength'=>150,'style'=>'text-transform:uppercase')); ?>
                <?php echo $form->textFieldRow($model,'rfc_lessee',array('class'=>'span12','maxlength'=>25,'style'=>'text-transform:uppercase')); ?>
        </div>
        <?php  }else{ ?>
                <div id="iscompany_lesseediv" style="display: none">
                    <?php echo $form->textFieldRow($model,'company_lessee',array('class'=>'span12','maxlength'=>150,'style'=>'text-transform:uppercase')); ?>
                    <?php echo $form->textFieldRow($model,'rfc_lessee',array('class'=>'span12','maxlength'=>25,'style'=>'text-transform:uppercase')); ?>
                </div>
        <?php } ?>

            <?php echo $form->dropDownListRow($model,'gender_lessee',ContractInformation::model()->listGender(),array(
                'prompt'=>Yii::t('mx','Select')
            )); ?>

            <?php echo $form->textFieldRow($model,'lessee',array(
                'class'=>'span12',
                'maxlength'=>255,
                'style'=>'text-transform:uppercase',
                'rel'=>'tooltip',
                'title'=>Yii::t('mx','Which will rent the property')
            )); ?>


        <?php echo $form->textAreaRow($model,'address_public_register_lessee',array(
            'rows'=>6,
            'cols'=>50,
            'class'=>'span12',
            'style'=>'text-transform:uppercase',
            'rel'=>'tooltip',
            'title'=>Yii::t('mx','Example').': Boca del Río, veracruz, bajo el número 11173 del volumen 529 de la sección primera con fecha 26 de agosto del año 2003'
        )); ?>


        <div class="control-group">
            <label class="control-label" for="ContractInformation_iscompany_owner"><?php echo Yii::t('mx','The owner is a company'); ?></label>
            <div class="controls">
                <?php $this->widget('bootstrap.widgets.TbToggleButton',array(
                    'model' => $model,
                    'attribute'=>'iscompany_owner',
                    'enabledLabel'=>Yii::t('mx','Yes'),
                    'disabledLabel'=>Yii::t('mx','No'),
                    'onChange'=>'js:function($el, status, e){
                                    if(status==true){
                                        $("#iscompany_ownerdiv").show();
                                        //$("#ownerOnly").hide();
                                    }
                                    else{
                                        $("#iscompany_ownerdiv").hide();
                                        //$("#ownerOnly").show();
                                    }
                             }',
                ));
                ?>
            </div>
        </div>

        <?php if($model->isNewRecord){ ?>
            <div id="iscompany_ownerdiv" style="display: none">
                <?php echo $form->textFieldRow($model,'company_owner',array('class'=>'span12','maxlength'=>150,'style'=>'text-transform:uppercase')); ?>
            </div>
        <?php  }elseif($model->iscompany_owner==true){ ?>
            <div id="iscompany_ownerdiv">
                <?php echo $form->textFieldRow($model,'company_owner',array('class'=>'span12','maxlength'=>150,'style'=>'text-transform:uppercase')); ?>
            </div>
        <?php  }else{ ?>
            <div id="iscompany_ownerdiv" style="display: none">
                <?php echo $form->textFieldRow($model,'company_owner',array('class'=>'span12','maxlength'=>150,'style'=>'text-transform:uppercase')); ?>
            </div>
        <?php } ?>


            <?php echo $form->dropDownListRow($model,'gender_owner',ContractInformation::model()->listGender(),array(
                'prompt'=>Yii::t('mx','Select')
            )); ?>

            <?php echo $form->textFieldRow($model,'owner',array(
                'class'=>'span12',
                'maxlength'=>100,
                'style'=>'text-transform:uppercase',
                'rel'=>'tooltip',
                'title'=>Yii::t('mx','The owner of the property')
            )); ?>

            <div class="control-group">
                <?php echo CHtml::label(Yii::t('mx','Property Type'),'property_type',array('class'=>"control-label")); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'property_type',PropertyTypes::model()->listAll(),array(
                        'prompt'=>Yii::t('mx','Select')
                    )); ?>

                    <?php  $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'button',
                        'type'=>'primary',
                        'icon'=>'icon-home',
                        'htmlOptions' => array(
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-property',
                        ),
                    )); ?>
                </div>
            </div>

            <?php echo $form->textAreaRow($model,'property_location',array(
                'rows'=>6,
                'cols'=>50,
                'class'=>'span12',
                'style'=>'text-transform:uppercase',
                'rel'=>'tooltip',
                'title'=>Yii::t('mx','Write first if street or avenue')
            )); ?>

            <?php echo $form->textAreaRow($model,'address_payment',array(
                'rows'=>6,
                'cols'=>50,
                'class'=>'span12',
                'style'=>'text-transform:uppercase',
                'rel'=>'tooltip',
                'title'=>Yii::t('mx','Write first if street or avenue')
            )); ?>

            <?php echo $form->textFieldRow($model,'amount_rent',array(
                'class'=>'span12',
                'maxlength'=>10,
                'prepend'=>'$',
                'rel'=>'tooltip',
                'placeholder'=>'0.00',
                'title'=>Yii::t('mx','Not put commas').'. '.Yii::t('mx','Example').': 11540.00'

            )); ?>

            <div class="control-group ">
                <label class="control-label" for="ContractInformation_is_iva"><?php echo Yii::t('mx','Applies IVA'); ?></label>
                <div class="controls">
                    <?php $this->widget('bootstrap.widgets.TbToggleButton',array(
                            'model' => $model,
                            'attribute'=>'is_iva',
                            'enabledLabel'=>Yii::t('mx','Yes'),
                            'disabledLabel'=>Yii::t('mx','No'),
                            'onChange'=>'js:function($el, status, e){
                                    if(status==true) $("#isiva").show();
                                    else $("#isiva").hide();
                             }',
                        ));
                    ?>
                </div>
            </div>

        <?php if($model->isNewRecord){ ?>
            <div id="isiva" style="display: none">
                <?php echo $form->textFieldRow($model,'iva_percent',array('class'=>'span12','prepend'=>'%')); ?>
                <?php echo $form->textFieldRow($model,'iva',array('class'=>'span12','maxlength'=>10,'prepend'=>'$')); ?>
            </div>
        <?php  }elseif($model->is_iva==true){ ?>
            <div id="isiva">
                <?php echo $form->textFieldRow($model,'iva_percent',array('class'=>'span12','prepend'=>'%')); ?>
                <?php echo $form->textFieldRow($model,'iva',array('class'=>'span12','maxlength'=>10,'prepend'=>'$')); ?>
            </div>
        <?php  }else{ ?>
            <div id="isiva" style="display: none">
                <?php echo $form->textFieldRow($model,'iva_percent',array('class'=>'span12','prepend'=>'%')); ?>
                <?php echo $form->textFieldRow($model,'iva',array('class'=>'span12','maxlength'=>10,'prepend'=>'$')); ?>
            </div>
        <?php } ?>




            <div class="control-group ">
                <label class="control-label" for="ContractInformation_is_isr"><?php echo Yii::t('mx','Applies ISR'); ?></label>
                <div class="controls">
                    <?php $this->widget('bootstrap.widgets.TbToggleButton',array(
                        'model' => $model,
                        'attribute'=>'is_isr',
                        'enabledLabel'=>Yii::t('mx','Yes'),
                        'disabledLabel'=>Yii::t('mx','No'),
                        'onChange'=>'js:function($el, status, e){
                                    if(status==true) $("#isisr").show();
                                    else $("#isisr").hide();
                             }',
                    ));
                    ?>
                </div>
            </div>

            <?php if($model->isNewRecord){ ?>
                <div id="isisr" style="display: none">
                    <?php echo $form->textFieldRow($model,'isr_percent',array('class'=>'span12','prepend'=>'%')); ?>
                    <?php echo $form->textFieldRow($model,'isr',array('class'=>'span12','maxlength'=>10,'prepend'=>'$')); ?>
                </div>
            <?php  }elseif($model->is_isr==true){ ?>
                <div id="isisr">
                    <?php echo $form->textFieldRow($model,'isr_percent',array('class'=>'span12','prepend'=>'%')); ?>
                    <?php echo $form->textFieldRow($model,'isr',array('class'=>'span12','maxlength'=>10,'prepend'=>'$')); ?>
                </div>
            <?php  }else{ ?>
                <div id="isisr" style="display: none">
                    <?php echo $form->textFieldRow($model,'isr_percent',array('class'=>'span12','prepend'=>'%')); ?>
                    <?php echo $form->textFieldRow($model,'isr',array('class'=>'span12','maxlength'=>10,'prepend'=>'$')); ?>
                </div>
            <?php } ?>


            <div class="control-group ">
                <label class="control-label" for="ContractInformation_is_retiva"><?php echo Yii::t('mx','Retention of IVA applies'); ?></label>
                <div class="controls">
                    <?php $this->widget('bootstrap.widgets.TbToggleButton',array(
                        'model' => $model,
                        'attribute'=>'is_retiva',
                        'enabledLabel'=>Yii::t('mx','Yes'),
                        'disabledLabel'=>Yii::t('mx','No'),
                        'onChange'=>'js:function($el, status, e){
                                    if(status==true) $("#isretiva").show();
                                    else $("#isretiva").hide();
                             }',
                    ));
                    ?>
                </div>
            </div>

        <?php if($model->isNewRecord){ ?>
            <div id="isretiva" style="display: none">
                <?php echo $form->textFieldRow($model,'retiva',array('class'=>'span12','maxlength'=>10,'prepend'=>'$')); ?>
            </div>
        <?php  }elseif($model->is_retiva==true){ ?>
            <div id="isretiva">
                <?php echo $form->textFieldRow($model,'retiva',array('class'=>'span12','maxlength'=>10,'prepend'=>'$')); ?>
            </div>
        <?php  }else{ ?>
            <div id="isretiva" style="display: none">
                <?php echo $form->textFieldRow($model,'retiva',array('class'=>'span12','maxlength'=>10,'prepend'=>'$')); ?>
            </div>
        <?php } ?>


            <?php
            $this->widget('application.extensions.moneymask.MMask',array(
                'element'=>'#ContractInformation_amount_rent,#ContractInformation_payment_services,#ContractInformation_new_rent_payment,#ContractInformation_deposit_guarantee,#ContractInformation_total_amount',
                'currency'=>'PHP',
            ));

            ?>

            <?php echo $form->textFieldRow($model,'total_amount',array(
                'class'=>'span12',
                'maxlength'=>10,
                'prepend'=>'$',
                'rel'=>'tooltip',
                'placeholder'=>'0.00',
                'title'=>Yii::t('mx','Not put commas').'. '.Yii::t('mx','Example').': 11540.00'

            )); ?>


            <?php echo $form->textFieldRow($model,'forced_months',array(
                'class'=>'span12',
                'maxlength'=>100,
                'style'=>'text-transform:uppercase',
                'rel'=>'tooltip',
                'title'=>Yii::t('mx','Write letters')
            )); ?>

            <?php echo $form->datepickerRow($model, 'inception_lease',array(
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'options'=>array(
                        'format'=>'dd-M-yyyy',
                        'autoclose'=>true
                    ),
                ));
            ?>

            <?php echo $form->datepickerRow($model, 'end_lease',array(
                'prepend'=>'<i class="icon-calendar"></i>',
                'options'=>array(
                    'format'=>'dd-M-yyyy',
                    'autoclose'=>true
                ),
            ));
            ?>

            <div class="control-group">
                <?php echo CHtml::label(Yii::t('mx','Name of services'),'property_type',array('class'=>"control-label")); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'service_id',Services::model()->listAll(),array(
                        'prompt'=>Yii::t('mx','Select'),
                        'rel'=>'tooltip',
                        'title'=>Yii::t('mx','If not exist, select none')
                    )); ?>

                    <?php  $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'button',
                        'type'=>'primary',
                        'icon'=>'icon-wrench',
                        'htmlOptions' => array(
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-services',
                        ),
                    )); ?>
                </div>
            </div>

            <?php echo $form->textFieldRow($model,'payment_services',array(
                'class'=>'span12',
                'maxlength'=>10,
                'placeholder'=>'0.00',
                'rel'=>'tooltip',
                'title'=>Yii::t('mx','Not put commas').', '.Yii::t('mx','Example').': 11540.00 Si no hay poner 0.00'
            )); ?>

            <?php echo $form->textFieldRow($model,'monthly_payment_arrears',array(
                'class'=>'span12',
                'prepend'=>'%',
                'placeholder'=>'0.00',
                'rel'=>'tooltip',
                'title'=>Yii::t('mx','Suggested').': 10.00'
            )); ?>

        </div>

        <div class="span6">
            <?php echo $form->textFieldRow($model,'new_rent_payment',array(
                'class'=>'span12',
                'maxlength'=>10,
                'prepend'=>'$',
                'placeholder'=>'0.00',
                'rel'=>'tooltip',
                'title'=>Yii::t('mx','Not put commas').'. '.Yii::t('mx','Example').': 11540.00'
            )); ?>

            <?php echo $form->textFieldRow($model,'monthly_payment_increase',array(
                'class'=>'span12',
                'prepend'=>'%',
                'placeholder'=>'0.00',
                'rel'=>'tooltip',
                'title'=>Yii::t('mx','Suggested').': 10.00'
            )); ?>

            <?php echo $form->textFieldRow($model,'penalty_nonpayment',array(
                'class'=>'span12',
                'prepend'=>'%',
                'placeholder'=>'0.00',
                'rel'=>'tooltip',
                'title'=>Yii::t('mx','Suggested').': 100.00'
            )); ?>

            <?php echo $form->textFieldRow($model,'deposit_guarantee',array(
                'class'=>'span12',
                'maxlength'=>10,
                'prepend'=>'$',
                'placeholder'=>'0.00',
                'rel'=>'tooltip',
                'title'=>Yii::t('mx','Not put commas').'. '.Yii::t('mx','Example').': 11540.00'
            )); ?>

            <div class="control-group">
                <label class="control-label" for="ContractInformation_has_surety">
                    <?php echo Yii::t('mx','Surety'); ?>
                </label>
                <div class="controls">
                    <?php $this->widget('bootstrap.widgets.TbToggleButton',array(
                        'model' => $model,
                        'attribute'=>'has_surety',
                        'enabledLabel'=>Yii::t('mx','Yes'),
                        'disabledLabel'=>Yii::t('mx','No'),
                        'onChange'=>'js:function($el, status, e){
                                    if(status==true){
                                        $("#hasSuretyDiv").show();
                                    }
                                    else{
                                        $("#hasSuretyDiv").hide();
                                    }
                             }',
                    ));
                    ?>
                </div>
            </div>

            <?php if($model->isNewRecord){ ?>
                <div id="hasSuretyDiv" style="display: none">

                    <?php echo $form->dropDownListRow($model,'gender_surety',ContractInformation::model()->listGender(),array(
                        'prompt'=>Yii::t('mx','Select')
                    )); ?>

                    <?php echo $form->textFieldRow($model,'name_surety',array(
                        'class'=>'span12',
                        'maxlength'=>100,
                        'style'=>'text-transform:uppercase',
                        'rel'=>'tooltip',
                        'title'=>Yii::t('mx','If there is more than one guarantor introduce separated by semicolons. Example: Graciela Arroyo; Julian Martin Sagardi')
                    )); ?>

                    <?php

                    $cadena=Yii::t('mx','Write first if street or avenue')." __________________________________ ".Yii::t('mx','Format').": ".Yii::t('mx','Street').", ".Yii::t('mx','Number').", ".Yii::t('mx','Neighborhood');
                    $cadena.=", ".Yii::t('mx','City').", ".Yii::t('mx','State').". ".Yii::t('mx','Example').": __________________________________ ";
                    $cadena.="Avenida Venustiano Carranza Nº. 631 de la colonia Ricardo Flores Magón de la ciudad de Veracruz, Veracruz";

                    echo $form->textAreaRow($model,'address_surety',array(
                        'rows'=>6,
                        'cols'=>50,
                        'class'=>'span12',
                        'style'=>'text-transform:uppercase',
                        'rel'=>'tooltip',
                        'title'=>$cadena
                    )); ?>

                    <?php echo $form->textAreaRow($model,'property_address_surety',array(
                        'rows'=>6,
                        'cols'=>50,
                        'class'=>'span12',
                        'style'=>'text-transform:uppercase',
                        'rel'=>'tooltip',
                        'title'=>Yii::t('mx','Write first if street or avenue')." __________________________________ ".Yii::t('mx','Format').': '.Yii::t('mx','Street').', '.Yii::t('mx','Number').', '.Yii::t('mx','Neighborhood').', '.Yii::t('mx','City').', '.Yii::t('mx','State').'. '.Yii::t('mx','Example').': __________________________________ Avenida Venustiano Carranza Nº. 631 de la colonia Ricardo Flores Magón de la ciudad de Veracruz, Veracruz'
                    )); ?>
                    <?php echo $form->textAreaRow($model,'address_public_register',array(
                        'rows'=>6,
                        'cols'=>50,
                        'class'=>'span12',
                        'style'=>'text-transform:uppercase',
                        'rel'=>'tooltip',
                        'title'=>Yii::t('mx','Example').': Boca del Río, veracruz, bajo el número 11173 del volumen 529 de la sección primera con fecha 26 de agosto del año 2003'
                    )); ?>

                </div>
            <?php  }elseif($model->has_surety==true){ ?>
                <div id="hasSuretyDiv">

                    <?php echo $form->dropDownListRow($model,'gender_surety',ContractInformation::model()->listGender(),array(
                        'prompt'=>Yii::t('mx','Select')
                    )); ?>

                    <?php echo $form->textFieldRow($model,'name_surety',array(
                        'class'=>'span12',
                        'maxlength'=>100,
                        'style'=>'text-transform:uppercase',
                        'rel'=>'tooltip',
                        'title'=>Yii::t('mx','If there is more than one guarantor introduce separated by semicolons. Example: Graciela Arroyo; Julian Martin Sagardi')
                    )); ?>

                    <?php

                    $cadena=Yii::t('mx','Write first if street or avenue')." __________________________________ ".Yii::t('mx','Format').": ".Yii::t('mx','Street').", ".Yii::t('mx','Number').", ".Yii::t('mx','Neighborhood');
                    $cadena.=", ".Yii::t('mx','City').", ".Yii::t('mx','State').". ".Yii::t('mx','Example').": __________________________________ ";
                    $cadena.="Avenida Venustiano Carranza Nº. 631 de la colonia Ricardo Flores Magón de la ciudad de Veracruz, Veracruz";

                    echo $form->textAreaRow($model,'address_surety',array(
                        'rows'=>6,
                        'cols'=>50,
                        'class'=>'span12',
                        'style'=>'text-transform:uppercase',
                        'rel'=>'tooltip',
                        'title'=>$cadena
                    )); ?>

                    <?php echo $form->textAreaRow($model,'property_address_surety',array(
                        'rows'=>6,
                        'cols'=>50,
                        'class'=>'span12',
                        'style'=>'text-transform:uppercase',
                        'rel'=>'tooltip',
                        'title'=>Yii::t('mx','Write first if street or avenue')." __________________________________ ".Yii::t('mx','Format').': '.Yii::t('mx','Street').', '.Yii::t('mx','Number').', '.Yii::t('mx','Neighborhood').', '.Yii::t('mx','City').', '.Yii::t('mx','State').'. '.Yii::t('mx','Example').': __________________________________ Avenida Venustiano Carranza Nº. 631 de la colonia Ricardo Flores Magón de la ciudad de Veracruz, Veracruz'
                    )); ?>
                    <?php echo $form->textAreaRow($model,'address_public_register',array(
                        'rows'=>6,
                        'cols'=>50,
                        'class'=>'span12',
                        'style'=>'text-transform:uppercase',
                        'rel'=>'tooltip',
                        'title'=>Yii::t('mx','Example').': Boca del Río, veracruz, bajo el número 11173 del volumen 529 de la sección primera con fecha 26 de agosto del año 2003'
                    )); ?>

                </div>
            <?php  }else{ ?>
                <div id="hasSuretyDiv" style="display: none">

                    <?php echo $form->dropDownListRow($model,'gender_surety',ContractInformation::model()->listGender(),array(
                        'prompt'=>Yii::t('mx','Select')
                    )); ?>

                    <?php echo $form->textFieldRow($model,'name_surety',array('class'=>'span12','maxlength'=>100,'style'=>'text-transform:uppercase')); ?>

                    <?php

                    $cadena=Yii::t('mx','Write first if street or avenue')." __________________________________ ".Yii::t('mx','Format').": ".Yii::t('mx','Street').", ".Yii::t('mx','Number').", ".Yii::t('mx','Neighborhood');
                    $cadena.=", ".Yii::t('mx','City').", ".Yii::t('mx','State').". ".Yii::t('mx','Example').": __________________________________ ";
                    $cadena.="Avenida Venustiano Carranza Nº. 631 de la colonia Ricardo Flores Magón de la ciudad de Veracruz, Veracruz";

                    echo $form->textAreaRow($model,'address_surety',array(
                        'rows'=>6,
                        'cols'=>50,
                        'class'=>'span12',
                        'style'=>'text-transform:uppercase',
                        'rel'=>'tooltip',
                        'title'=>$cadena
                    )); ?>

                    <?php echo $form->textAreaRow($model,'property_address_surety',array(
                        'rows'=>6,
                        'cols'=>50,
                        'class'=>'span12',
                        'style'=>'text-transform:uppercase',
                        'rel'=>'tooltip',
                        'title'=>Yii::t('mx','Write first if street or avenue')." __________________________________ ".Yii::t('mx','Format').': '.Yii::t('mx','Street').', '.Yii::t('mx','Number').', '.Yii::t('mx','Neighborhood').', '.Yii::t('mx','City').', '.Yii::t('mx','State').'. '.Yii::t('mx','Example').': __________________________________ Avenida Venustiano Carranza Nº. 631 de la colonia Ricardo Flores Magón de la ciudad de Veracruz, Veracruz'
                    )); ?>
                    <?php echo $form->textAreaRow($model,'address_public_register',array(
                        'rows'=>6,
                        'cols'=>50,
                        'class'=>'span12',
                        'style'=>'text-transform:uppercase',
                        'rel'=>'tooltip',
                        'title'=>Yii::t('mx','Example').': Boca del Río, veracruz, bajo el número 11173 del volumen 529 de la sección primera con fecha 26 de agosto del año 2003'
                    )); ?>

                </div>
            <?php } ?>




            <?php echo $form->datepickerRow($model, 'date_signature',array(
                'prepend'=>'<i class="icon-calendar"></i>',
                'options'=>array(
                    'format'=>'dd-M-yyyy',
                    'autoclose'=>true
                ),
            ));
            ?>

        </div>
    </div>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'encodeLabel'=>false,
            'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>



    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-property')); ?>
        <div class="modal-header">
            <a class="close" data-dismiss="modal">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
            </a>
            <h4><i class="icon-home"></i> <?php echo Yii::t('mx','New Type Property'); ?></h4>
        </div>

        <div class="modal-body"><?php echo $property->render(); ?></div>

        <div class="modal-footer">

            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label' => Yii::t('mx','Return'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )); ?>

        </div>
    <?php $this->endWidget(); ?>


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-services')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-wrench"></i> <?php echo Yii::t('mx','New Services'); ?></h4>
</div>

<div class="modal-body"><?php echo $servicesForm->render(); ?></div>

<div class="modal-footer">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>
