<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'bracelets-history-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

<?php echo $form->errorSummary($model); ?>

    <?php echo $form->datepickerRow($model, 'datex',array(
        'prepend'=>'<i class="icon-calendar"></i>',
        'options'=>array(
            'format'=>'dd-M-yyyy',
            'autoclose'=>true
        ),
    ));
    ?>

<?php echo $form->select2Row($model, 'assignment_id',
    array(
        'data' => Assignment::model()->listAllBracelets(),
        'options' => array(
            'placeholder' =>Yii::t('mx','Select'),
            'allowClear' => true,
            'width' => '40%',
        ),
    )
);

?>

<?php echo $form->select2Row($model, 'employeed_id',
    array(
        'data' => Employees::model()->listAll(),
        'options' => array(
            'placeholder' =>Yii::t('mx','Select'),
            'allowClear' => true,
            'width' => '40%',
        ),
    )
);

?>

<?php echo $form->textFieldRow($model,'quantity',array('class'=>'span5')); ?>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>'icon-exchange icon-white',
        'label'=>Yii::t('mx','Transfer'),
    )); ?>
</div>


<?php $this->endWidget(); ?>



