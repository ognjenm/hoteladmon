<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'debit-operations-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'payment_type',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'bank_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cheq',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'datex',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'released',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'concept',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'person',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'bank_concept',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'retirement',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'deposit',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'balance',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'iscancelled',array('class'=>'span5')); ?>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'encodeLabel'=>false,
        'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
