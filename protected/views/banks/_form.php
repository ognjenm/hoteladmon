<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'banks-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('mx','are required');?>.
</p>

	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->textFieldRow($model,'bank',array('class'=>'span5','maxlength'=>500)); ?>


	<?php echo $form->textAreaRow($model,'address',array('rows'=>6, 'cols'=>50, 'class'=>'span5')); ?>

        <div class="controls controls-row">
            <?php echo $form->textFieldRow($model,'international_code',array(
                'class'=>'span1',
                'style'=>'background:#F5FCCE;border-style:dotted solid')); ?>
            <?php

            $this->widget('CMaskedTextField', array(
                    'model' => $model,
                    'value' => $model->isNewRecord ? $model->phone : '',
                    'attribute' => 'phone',
                    'mask' => '(999)-999-9999',
                )
            );

             ?>
        </div>


	<?php echo $form->textFieldRow($model,'rfc',array('class'=>'span5','maxlength'=>50)); ?>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
