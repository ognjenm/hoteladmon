<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'operations-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

    <?php if($model->cheq=='DEP'): ?>

        <?php echo $form->errorSummary($model); ?>

        <?php if(Yii::app()->user->isSuperAdmin): ?>

            <?php echo $form->datepickerRow($model,'datex',array(
                'prepend'=>'<i class="icon-calender"></i>',
                'options'=>array(
                    'format'=>'yyyy-M-dd'
                )
            )); ?>

            <?php echo $form->dropDownListRow($model,'payment_type',PaymentsTypes::model()->listAll(),array(
                'class'=>'span5',
                'prompt'=>Yii::t('mx','Select')
            )); ?>

            <?php echo $form->dropDownListRow($model,'account_id',BankAccounts::model()->listAll(),array(
                'class'=>'span5',
                'prompt'=>Yii::t('mx','Select')
            )); ?>

        <?php endif;?>

            <?php echo CHtml::label(Yii::t('mx','Person'),'customer'); ?>
            <?php echo CHtml::dropDownList('de','',array(1=>Yii::t('mx','Customer'),2=>Yii::t('mx','Other')),array(
                'class'=>'span5',
                'prompt'=>Yii::t('mx','Select'),
                'onchange'=>'
                                if($(this).val()==1){
                                    $("#divperson").show();
                                    $("#divother").hide();
                                }else{
                                        $("#divother").show();
                                        $("#divperson").hide();
                                }
                            '
            )); ?>


        <div id="divperson" style="display: none">

            <?php $this->widget('bootstrap.widgets.TbSelect2', array(
                'model'=>$model,
                'attribute'=>'person',
                'data' =>Customers::model()->listAllName(),
                'options' => array(
                    'allowClear' => true,
                ),
            ));
            ?>
            <?php /*echo $form->dropDownListRow($model,'person',Customers::model()->listAllName(),array(
                'class'=>'span5',
                'prompt'=>Yii::t('mx','Select')
            ));*/ ?>

            <?php echo CHtml::label(Yii::t('mx','Reservation Id'),'reference'); ?>
            <?php echo CHtml::textField('reference','',array('class'=>'span3')); ?>

        </div>

        <div id="divother" style="display: none">
            <?php echo CHtml::label(Yii::t('mx','Name'),'name'); ?>
            <?php echo CHtml::textField('name','',array('class'=>'span5')); ?>
        </div>


        <?php echo $form->textFieldRow($model,'concept',array('class'=>'span5','maxlength'=>100)); ?>

        <?php echo $form->textFieldRow($model,'bank_concept',array('class'=>'span5','maxlength'=>100)); ?>

        <?php if(Yii::app()->user->isSuperAdmin): ?>
            <?php echo $form->textFieldRow($model,'deposit',array('prepend'=>'<i class="$"></i>')); ?>
        <?php endif;?>

    <?php else: ?>


        <?php if(Yii::app()->user->isSuperAdmin): ?>

            <?php echo $form->datepickerRow($model,'datex',array(
                'prepend'=>'<i class="icon-calender"></i>',
                'options'=>array(
                    'format'=>'yyyy-M-dd'
                )
            )); ?>

            <?php echo $form->dropDownListRow($model,'payment_type',PaymentsTypes::model()->listAll(),array(
                'class'=>'span5',
                'prompt'=>Yii::t('mx','Select')
            )); ?>

            <?php echo $form->dropDownListRow($model,'account_id',BankAccounts::model()->listAll(),array(
                'class'=>'span5',
                'prompt'=>Yii::t('mx','Select')
            )); ?>

        <?php endif;?>


        <?php echo CHtml::label(Yii::t('mx','Payment To'),'pagar_a'); ?>
            <?php echo CHtml::dropDownList('pagar_a','',array(1=>Yii::t('mx','Provider'),2=>Yii::t('mx','Other')),array(
                'class'=>'span5',
                'prompt'=>Yii::t('mx','Select'),
                'onchange'=>'
                        if($(this).val()==1){
                            $("#divperson").show();
                            $("#divother").hide();
                        }else{
                                $("#divother").show();
                                $("#divperson").hide();
                        }
                    '
            )); ?>

        <div id="divperson" style="display: none">

            <?php $this->widget('bootstrap.widgets.TbSelect2', array(
                'model'=>$model,
                'attribute'=>'released',
                'data' =>Providers::model()->listAllCompanyByIndexText(),
                'options' => array(
                    'allowClear' => true,
                ),
            ));
            ?>
            <?php /*echo $form->dropDownListRow($model,'released',Providers::model()->listAllOrganization(),array(
                'class'=>'span5',
                'prompt'=>Yii::t('mx','Select')
            ));*/ ?>

        </div>

        <div id="divother" style="display: none">
            <?php echo CHtml::label(Yii::t('mx','Released To'),'name'); ?>
            <?php echo CHtml::textField('name','',array('class'=>'span5')); ?>
        </div>


        <?php echo $form->textFieldRow($model,'concept',array('class'=>'span5','maxlength'=>100)); ?>

        <?php echo $form->textFieldRow($model,'bank_concept',array('class'=>'span5','maxlength'=>100)); ?>

        <?php if(Yii::app()->user->isSuperAdmin): ?>
            <?php echo $form->textFieldRow($model,'retirement',array('prepend'=>'<i class="$"></i>')); ?>
            <?php echo $form->textFieldRow($model,'cheq',array('class'=>'span5','maxlength'=>100)); ?>
        <?php endif;?>

    <?php endif; ?>



    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'encodeLabel'=>false,
            'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
