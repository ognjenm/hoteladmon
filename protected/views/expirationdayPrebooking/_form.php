<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'expirationday-prebooking-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'arrives',array('class'=>'span12','prepend'=>'#')); ?>

	<?php echo $form->textFieldRow($model,'availability',array('class'=>'span12','prepend'=>'%')); ?>

	<?php echo $form->textFieldRow($model,'daystopay',array('class'=>'span12','prepend'=>'#')); ?>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus' : 'icon-ok',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
