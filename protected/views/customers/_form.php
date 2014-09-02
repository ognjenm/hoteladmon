<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'customers-form',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>false,
    'focus'=>array($model,'alternative_email'),
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>


    <?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'alternative_email',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'country',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'state',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'city',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textAreaRow($model,'how_find_us',array('rows'=>6, 'cols'=>50, 'class'=>'span5')); ?>


<?php echo $form->textFieldRow($model,'international_code1',array('class' => 'span1',
    'style'=>'background:#F5FCCE;border-style:dotted solid')); ?>

    <?php $this->widget('CMaskedTextField', array(
            'model' => $model,
            'value' => $model->isNewRecord ? $model->home_phone : '',
            'attribute' => 'home_phone',
            'mask' => '(999)-999-9999',
            'htmlOptions' => array('class'=>'span3')
        )
    );
    ?>


<?php echo $form->textFieldRow($model,'international_code2',array('class' => 'span1',
    'style'=>'background:#F5FCCE;border-style:dotted solid')); ?>
<?php $this->widget('CMaskedTextField', array(
        'model' => $model,
        'value' => $model->isNewRecord ? $model->work_phone : '',
        'attribute' => 'work_phone',
        'mask' => '(999)-999-9999',
        'htmlOptions' => array('class'=>'span3')
    )
);
?>


<?php echo $form->textFieldRow($model,'international_code3',array('class' => 'span1',
    'style'=>'background:#F5FCCE;border-style:dotted solid')); ?>
<?php $this->widget('CMaskedTextField', array(
        'model' => $model,
        'value' => $model->isNewRecord ? $model->cell_phone : '',
        'attribute' => 'cell_phone',
        'mask' => '(999)-999-9999',
        'htmlOptions' => array('class'=>'span3')
    )
);
?>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus' : 'icon-ok',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
