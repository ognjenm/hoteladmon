<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);


$datePicker =  array(
    'model'=>$model,
    'attribute'=>'fecha[]',
    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
    'options'=>array(
        'showAnim'=>'slide',
        'changeYear' => true,
        'changeMonth' => true,
        'dateFormat'=>'yy-mm-dd',
    ));

?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    'type'=>'inline'
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

    <table border="0" cellpadding="1" cellspacing="1">
        <tbody>
        <tr>
            <td style="width: 220px;">Fecha</td>
            <td style="width: 220px;">Hora</td>
            <td style="width: 220px;">Llega en</td>
            <td style="width: 220px;"> % de disponibilidad</td>
            <td style="width: 220px;">Dias para pagar</td>
        </tr>
        </tbody>
    </table>


    <?php $this->widget('ext.jqrelcopy.JQRelcopy',array(
        'id' => 'copylink',
        'removeText' => 'Remove',
        'jsAfterNewId' => JQRelcopy::afterNewIdDatePicker($datePicker),
        'removeHtmlOptions' => array('class'=>'btn btn-danger'),
        'options' => array(
            'copyClass'=>'newcopy',
            //'limit'=>5,
            'clearInputs'=>true,
        )
    ));

    ?>
        <div class="copy">
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',$datePicker); ?>
            <?php echo $form->textFieldRow($model,'hora[]',array('placeholder'=>'Hora')); ?>
            <?php echo $form->textFieldRow($model,'llega[]',array('placeholder'=>'Llega en')); ?>
            <?php echo $form->textFieldRow($model,'disponibilidad[]',array('placeholder'=>'% disponibilidad')); ?>
            <?php echo $form->textFieldRow($model,'dias[]',array('placeholder'=>'Dias para pagar')); ?>
        </div>

    <div class="form-actions">

        <?php echo CHtml::button(Yii::t('mx','Add'),array(
            'id'=>'copylink',
            'href'=>'#',
            'rel'=>'.copy',
            'class'=>'btn btn-primary',
        )); ?>

    </div>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'ajaxSubmit',
            'type'=>'primary',
            'icon'=>'icon-plus icon-white',
            'label'=>Yii::t('mx','Calcular'),
            'ajaxOptions' => array(
                'dataType'=>'json',
                'beforeSend' => 'function() { $(".copy").addClass("saving");  }',
                'complete' => 'function() { $(".copy").removeClass("saving"); }',
                'success' =>'function(data){
                        $(".tabledias").html(data.tabla);
                }',
            ),
        )); ?>
    </div>


<?php $this->endWidget(); ?>




<div class="tabledias"></div>


