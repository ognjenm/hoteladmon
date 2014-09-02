<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 20/11/13
 * Time: 9:18
 */
?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'export-form',
    'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>


<?php echo CHtml::checkBox('general',false); ?>



<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>'icon-ok',
        'label'=>Yii::t('mx','Ok'),
    )); ?>
</div>


<?php $this->endWidget(); ?>