<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'document-types-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'document_type',array('class'=>'span5','maxlength'=>100)); ?>

    <div class="control-group">
        <label class="control-label" for="DocumentTypes_billable"><?php echo Yii::t('mx','Billable'); ?></label>
        <div class="controls">
            <?php $this->widget('bootstrap.widgets.TbToggleButton',array(
                'model' => $model,
                'attribute'=>'billable',
                'enabledLabel'=>Yii::t('mx','Yes'),
                'disabledLabel'=>Yii::t('mx','No'),
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
