<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'contract-employees-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo CHtml::label(Yii::t('mx','Employee'),'',array()); ?>

    <?php $this->widget('bootstrap.widgets.TbSelect2', array(
        'model'=>$model,
        'attribute'=>'employee_id',
        'data' =>Employees::model()->listAll(),
        'options' => array(
            'allowClear' => true,
        ),
        'htmlOptions' => array(
            'placeholder' =>Yii::t('mx','Select'),
        ),
    ));
    ?>

    <?php echo $form->datepickerRow($model, 'date_signing_contract',array(
        'prepend'=>'<i class="icon-calendar"></i>',
        'options'=>array(
            'format'=>'dd-M-yyyy',
            'autoclose'=>true
        ),
    ));
    ?>

	<?php echo $form->textFieldRow($model,'contract_type',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'object',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'need',array('class'=>'span5','maxlength'=>500)); ?>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'encodeLabel'=>false,
            'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
