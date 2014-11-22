<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bdgt-concepts-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->dropDownListRow($model,'bdgt_group_id',BdgtGroups::model()->listAll(),
        array('prompt'=>Yii::t('mx','Select'))
    ); ?>

    <?php echo $form->textAreaRow($model,'concept',array(
        'rows'=>3,
        'cols'=>50,
        'class'=>'span5',
        'rel'=>'tooltip',
        'title'=>'Es el concepto que te aparece cuando haces una cotizacón'
    )); ?>

	<?php echo $form->textAreaRow($model,'description',array(
        'rows'=>6,
        'cols'=>50,
        'class'=>'span5',
        'rel'=>'tooltip',
        'title'=>'Es lo que le aparece al cliente en su cotización'

    )); ?>

    <?php echo $form->textAreaRow($model,'description_suppliers',array(
        'rows'=>6,
        'cols'=>50,
        'class'=>'span5',
        'rel'=>'tooltip',
        'title'=>'Es lo que aparece en el reporte para los proveedores'

    )); ?>

    <?php
    $this->widget('application.extensions.moneymask.MMask',array(
        'element'=>'#BdgtConcepts_price,#BdgtConcepts_supplier_price',
        'currency'=>'PHP',
    ));

    ?>

	<?php echo $form->textFieldRow($model,'price',array(
        'class'=>'span12',
        'maxlength'=>10,
        'prepend'=>'$',
        'placeholder'=>'0.00',
        'rel'=>'tooltip',
        'title'=>'Es el precio que se le da al cliente'

    )); ?>

    <?php echo $form->textFieldRow($model,'supplier_price',array(
        'class'=>'span12',
        'maxlength'=>10,
        'prepend'=>'$',
        'placeholder'=>'0.00',
        'rel'=>'tooltip',
        'title'=>'Es el precio que nos da los proveedores'
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
