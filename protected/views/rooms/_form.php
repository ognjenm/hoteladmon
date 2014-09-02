<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'rooms-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->dropDownListRow($model,'room_type_id',RoomsType::model()->listAllRoomsTypes(),array('class'=>'span5','prompt'=>Yii::t('mx','Select'))) ?>

	<?php echo $form->textFieldRow($model,'capacity',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'room',array('class'=>'span5','maxlength'=>10)); ?>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>$model->isNewRecord ? 'icon-plus' : 'icon-ok' ,
        'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
