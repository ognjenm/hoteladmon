<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bank-accounts-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldRow($model,'account_name',array('class'=>'span5','maxlength'=>500)); ?>

    <?php echo $form->dropDownListRow($model,'account_type_id',AccountTypes::model()->listAll(),array(
        'prompt'=>Yii::t('mx','Select')
    )); ?>

    <?php echo $form->dropDownListRow($model,'bank_id',Banks::model()->listAll(),array(
        'prompt'=>Yii::t('mx','Select')
    )); ?>


	<?php echo $form->textFieldRow($model,'account_number',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'clabe',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'initial_balance',array('class'=>'span5','maxlength'=>10)); ?>

	<?php //echo $form->textFieldRow($model,'cheq_num_start',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'cheq_num_end',array('class'=>'span5')); ?>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
