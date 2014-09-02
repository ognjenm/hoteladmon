<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 28/03/14
 * Time: 9:39
 */
?>


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

<?php //echo $form->textFieldRow($model,'quantity',array('class'=>'span5')); ?>

<?php echo $form->textFieldRow($model,'register',array('class'=>'span5','maxlength'=>100)); ?>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>