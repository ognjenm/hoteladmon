<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chinux
 * mail: chinuxe@gmail.com
 * Date: 3/8/14
 * Time: 1:32 PM
 * To change this template use File | Settings | File Templates.
 */
?>


<?php
$this->breadcrumbs=array(
    'Operations'=>array('index'),
    Yii::t('mx','Deposit'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Transfer Between Bank Accounts');
$this->pageIcon='icon-ok';

?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'operations-form',
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
        'format'=>'yyyy-M-dd',
        'autoclose'=>true
    ),
));
?>


<?php echo $form->dropDownListRow($model,'payment_type',PaymentsTypes::model()->listAll(),array(
    'class'=>'span5',
    'prompt'=>Yii::t('mx','Select')
)); ?>


<?php echo CHtml::label(Yii::t('mx','Source Account'),'sourceAccount'); ?>
<?php echo CHtml::dropDownList('sourceAccount','',Banks::model()->listAllBanks(),array(
    'class'=>'span5',
    'prompt'=>Yii::t('mx','Select'),
)); ?>

<?php echo CHtml::label(Yii::t('mx','Destination Account'),'destinationAccount'); ?>
<?php echo CHtml::dropDownList('destinationAccount','',Banks::model()->listAllBanks(),array(
    'class'=>'span5',
    'prompt'=>Yii::t('mx','Select'),
)); ?>


<?php echo $form->textFieldRow($model,'retirement',array(
    'prepend'=>'$'
)); ?>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
        'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
