<?php
/**
 * Created by PhpStorm.
 * User: chinux
 * Date: 14/04/14
 * email: chinuxe@hmail.com
 */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'contact-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

    <?php echo CHtml::label(Yii::t('mx','Employee'),'employee'); ?>
    <?php echo CHtml::dropDownList('employee','',Employees::model()->listAll()); ?>

    <?php echo CHtml::label(Yii::t('mx','Balance'),'balance'); ?>
    <?php $lista=array(1=>'En ceros',2=>'Saldo negativo',3=>'Todos'); ?>
    <?php echo CHtml::dropDownList('balance','',$lista,array('prompt'=>Yii::t('mx','Select'))); ?>

    <?php echo CHtml::label(Yii::t('mx','Registers'),'registers'); ?>
    <?php echo CHtml::textField('registers',''); ?>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>'icon-ok' ,
            'label'=>Yii::t('mx','Submit'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>