<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'articles-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));

?>

<?php
    $datePickerConfig =  array(
        'model'=>$items,
        'attribute'=>'date_price[]',
        'language'=>substr(Yii::app()->getLanguage(), 0, 2),
        'options'=>array(
            'showAnim'=>'slide',
            'changeYear' => true,
            'changeMonth' => true,
            'dateFormat'=>'dd-M-yy',
        ),
        'htmlOptions'=>array(
            'placeholder'=>Yii::t('mx','Date Price'),
        ),
    );

?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($items); ?>

    <?php echo $form->select2Row($items, 'provider_id',
        array(
            'data' =>Providers::model()->listAllOrganization(),
            'options' => array(
                'placeholder' =>Yii::t('mx','Select'),
                'allowClear' => true,
            ),
        )
    );

    ?>

	<?php echo $form->textFieldRow($items,'name_article',array('class'=>'span5','maxlength'=>100)); ?>
	<?php echo $form->textFieldRow($items,'name_store',array('class'=>'span5','maxlength'=>100)); ?>
	<?php echo $form->textFieldRow($items,'name_invoice',array('class'=>'span5','maxlength'=>100)); ?>


    <?php $this->widget('ext.jqrelcopy.JQRelcopy',array(
        'id' => 'copylink',
        'removeText' => 'Remove',
        'jsAfterNewId' => JQRelcopy::afterNewIdDatePicker($datePickerConfig),
        'removeHtmlOptions' => array('class'=>'btn btn-danger'),
        'options' => array(
            'copyClass'=>'newcopy',
            //'limit'=>5,
            'clearInputs'=>true,
        )
    ));
    ?>


    <div class="well form-inline">

        <div class="copy">

            <?php echo $form->textField($items,"quantity[]",array('placeholder'=>Yii::t('mx','Quantity'),'class'=>'span1')); ?>

            <?php echo $form->dropDownList($items,'unit_measure_id[]',UnitsMeasurement::model()->listAll(),array(
                'prompt'=>Yii::t('mx','Unit Of Measure'),
                'class'=>'span2'
            )); ?>

            <?php echo $form->textField($items,"measure[]",array('placeholder'=>Yii::t('mx','Measure'))); ?>
            <?php echo $form->textField($items,"price[]",array('placeholder'=>Yii::t('mx','Price'))); ?>
            <?php //echo $form->textField($items,"unit_price[]",array('placeholder'=>Yii::t('mx','Unit Price'))); ?>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',$datePickerConfig); ?>
            <?php echo $form->textField($items,"code[]",array('placeholder'=>Yii::t('mx','Code'))); ?>
            <?php echo $form->textField($items,"code_store[]",array('placeholder'=>Yii::t('mx','Code Store'))); ?>
            <?php echo $form->textField($items,"code_invoice[]",array('placeholder'=>Yii::t('mx','Code Invoice'))); ?>
            <?php echo $form->textField($items,"color[]",array('placeholder'=>Yii::t('mx','Color'))); ?>
            <?php echo $form->textField($items,"presentation[]",array('placeholder'=>Yii::t('mx','Presentation'))); ?>
            <?php //echo $form->textField($items,"conversion_unit[]",array('placeholder'=>Yii::t('mx','Conversion Unit'))); ?>
            <?php echo $form->textField($items,"barcode[]",array('placeholder'=>Yii::t('mx','Barcode'))); ?>
            <?php //echo $form->textField($items,"notes[]",array('placeholder'=>Yii::t('mx','Notes'))); ?>
            <?php //echo $form->textField($items,"explanation[]",array('placeholder'=>Yii::t('mx','Explanation'))); ?>
            <?php echo $form->fileField($items,"image[]"); ?>
            <hr>

        </div>

    </div>

    <?php echo CHtml::button(Yii::t('mx','Add'),array(
        'id'=>'copylink',
        'href'=>'#',
        'rel'=>'.copy',
        'class'=>'btn btn-primary'
    )); ?>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'encodeLabel'=>false,
            'label'=>$items->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
