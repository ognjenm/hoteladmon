<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tax-information-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'bill',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'rfc',array('class'=>'span5','maxlength'=>25)); ?>

	<?php echo $form->textFieldRow($model,'company_name',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'street',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'outside_number',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'internal_number',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'neighborhood',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'locality',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'reference',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'municipality',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'state',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'country',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'zipcode',array('class'=>'span5','maxlength'=>50)); ?>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'encodeLabel'=>false,
        'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
