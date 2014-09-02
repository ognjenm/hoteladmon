<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bracelets-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->dropDownListRow($model,'use_id',Uses::model()->listAll(),array(
        'class'=>'span5',
        'prompt'=>Yii::t('mx','Select')
    )); ?>

	<?php echo $form->textFieldRow($model,'color',array('class'=>'span5','maxlength'=>100)); ?>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
