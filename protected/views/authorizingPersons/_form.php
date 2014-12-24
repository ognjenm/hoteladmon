<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'authorizing-persons-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->dropDownListRow($model,'bank_id',BankAccounts::model()->listAll(),array(
        'class'=>'span5',
        'prompt'=>Yii::t('mx','Select')
    )); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'initials',array('class'=>'span5','maxlength'=>20)); ?>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'encodeLabel'=>false,
        'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
