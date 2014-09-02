<?php
/**
 * Created by PhpStorm.
 * User: chinux
 * mail: chinuxe@gmail.com
 * Time: 17:57
 */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'articles-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));

?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->select2Row($model, 'provider_id',
    array(
        'data' =>Providers::model()->listAll(),
        'options' => array(
            'placeholder' =>Yii::t('mx','Select'),
            'allowClear' => true,
        ),
    )
);

?>

    <?php echo $form->textFieldRow($model,'name_article',array('class'=>'span5','maxlength'=>100)); ?>
    <?php echo $form->textFieldRow($model,'name_store',array('class'=>'span5','maxlength'=>100)); ?>
    <?php echo $form->textFieldRow($model,'name_invoice',array('class'=>'span5','maxlength'=>100)); ?>
    <?php echo $form->textFieldRow($model,"quantity",array('placeholder'=>Yii::t('mx','Quantity'),'class'=>'span1')); ?>

    <?php echo $form->dropDownListRow($model,'unit_measure_id',UnitsMeasurement::model()->listAll(),array(
        'prompt'=>Yii::t('mx','Select'),
        'class'=>'span2'
    )); ?>

    <?php echo $form->textFieldRow($model,"measure",array('placeholder'=>Yii::t('mx','Measure'))); ?>
    <?php echo $form->textFieldRow($model,"price",array('placeholder'=>Yii::t('mx','Price'))); ?>

    <?php echo $form->datepickerRow($model, 'date_price',array(
        'prepend'=>'<i class="icon-calendar"></i>',
        'value'=>date('d-M-Y'),
        'options'=>array(
            'format'=>'dd-M-yyyy',
            'autoclose'=>true
        ),
    ));
    ?>

    <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker',array(
        'model'=>$model,
        'attribute'=>'date_price',
        'language'=>substr(Yii::app()->getLanguage(), 0, 2),
        'value'=>Yii::t('mx','Date Price'),
        'options'=>array(
            'showAnim'=>'slide',
            'changeYear' => true,
            'changeMonth' => true,
            'dateFormat'=>Yii::app()->format->dateFormat,
        )));*/ ?>

    <?php echo $form->textFieldRow($model,"code",array('placeholder'=>Yii::t('mx','Code'))); ?>
    <?php echo $form->textFieldRow($model,"code_store",array('placeholder'=>Yii::t('mx','Code Store'))); ?>
    <?php echo $form->textFieldRow($model,"code_invoice",array('placeholder'=>Yii::t('mx','Code Invoice'))); ?>
    <?php echo $form->textFieldRow($model,"color",array('placeholder'=>Yii::t('mx','Color'))); ?>
    <?php echo $form->textFieldRow($model,"presentation",array('placeholder'=>Yii::t('mx','Presentation'))); ?>
    <?php echo $form->textFieldRow($model,"barcode",array('placeholder'=>Yii::t('mx','Barcode'))); ?>
    <?php echo $form->fileFieldRow($model,"image"); ?>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'encodeLabel'=>false,
            'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>


