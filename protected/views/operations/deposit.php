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

<?php echo Yii::app()->user->setFlash('info',"<h3>".$display."</h3>"); ?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true,
    'fade'=>true,
    'closeText'=>'×',
    'alerts'=>array('info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×')),
));
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

    <?php echo $form->textFieldRow($model,'person',array('class'=>'span5','maxlength'=>100)); ?>

    <?php echo $form->textFieldRow($model,'concept',array('class'=>'span5','maxlength'=>100)); ?>

    <?php echo $form->textFieldRow($model,'bank_concept',array('class'=>'span5','maxlength'=>100)); ?>

    <?php echo $form->textFieldRow($model,'deposit',array('prepend'=>'$')); ?>

    <?php echo $form->textFieldRow($model,'vat_commission',array('prepend'=>'$')); ?>

    <?php echo $form->textFieldRow($model,'commission_fee',array('prepend'=>'$')); ?>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'encodeLabel'=>false,
        'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
