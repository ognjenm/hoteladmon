<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'sales-agents-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span12','maxlength'=>500,'prepend'=>'<i class="icon-user"></i>')); ?>
    <?php echo $form->textFieldRow($model,'commission',array('class'=>'span12','prepend'=>'%')); ?>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'encodeLabel'=>false,
            'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
