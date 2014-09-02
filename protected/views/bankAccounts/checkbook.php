<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 28/02/14
 * Time: 11:26
 */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'banks-form',
    'enableAjaxValidation'=>false,
)); ?>

<p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('mx','are required');?>.
</p>

<?php echo $form->errorSummary($model); ?>


<?php echo $form->textFieldRow($model,'cheq_num_start',array('prepend'=>'#')); ?>
<?php echo $form->textFieldRow($model,'cheq_num_end',array('prepend'=>'#')); ?>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>'icon-ok icon-white',
        'label'=>Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
