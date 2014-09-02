<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 26/02/14
 * Time: 17:58
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

$this->pageSubTitle=Yii::t('mx','Bank Account Deposit');
$this->pageIcon='icon-ok';

?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'operations-form',
    'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>


    <?php echo $form->datepickerRow($model,'datex',array(
        'prepend'=>'<i class="icon-calendar"></i>',
        'options'=>array(
            'format'=>'yyyy-M-dd',
            'autoclose'=>true
        )
    )); ?>

    <?php echo $form->dropDownListRow($model,'payment_type',PaymentsTypes::model()->listAll(),array(
        'class'=>'span5',
        'prompt'=>Yii::t('mx','Select')
    )); ?>

    <?php echo $form->dropDownListRow($model,'bank_id',Banks::model()->listAllBanks(),array(
        'class'=>'span5',
        'prompt'=>Yii::t('mx','Select')
    )); ?>

    <?php echo CHtml::label(Yii::t('mx','Person'),'customer'); ?>
    <?php echo CHtml::dropDownList('de','',array(1=>Yii::t('mx','Customer'),2=>Yii::t('mx','Other')),array(
        'class'=>'span5',
        'prompt'=>Yii::t('mx','Select'),
        'onchange'=>'
                    if($(this).val()==1){
                        $("#divperson").show();
                        $("#divother").hide();
                    }else{
                            $("#divother").show();
                            $("#divperson").hide();
                    }
                '
    )); ?>

    <div id="divperson" style="display: none">
        <?php echo $form->dropDownListRow($model,'person',Customers::model()->listAllName(),array(
            'class'=>'span5',
            'prompt'=>Yii::t('mx','Select')
        )); ?>

        <?php echo CHtml::label(Yii::t('mx','Reservation Id'),'reference'); ?>
        <?php echo CHtml::textField('reference','',array('class'=>'span3')); ?>

    </div>

    <div id="divother" style="display: none">
        <?php echo CHtml::label(Yii::t('mx','Name'),'name'); ?>
        <?php echo CHtml::textField('name','',array('class'=>'span5')); ?>
    </div>


    <?php echo $form->textFieldRow($model,'concept',array('class'=>'span5','maxlength'=>100)); ?>

    <?php echo $form->textFieldRow($model,'bank_concept',array('class'=>'span5','maxlength'=>100)); ?>

    <?php echo $form->textFieldRow($model,'deposit',array('prepend'=>'$')); ?>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'encodeLabel'=>false,
        'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
