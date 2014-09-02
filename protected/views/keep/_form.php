<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'budget-format-form',
    'enableAjaxValidation'=>false,
)); ?>


<?php

$pricesForm = array(

    'elements'=>array(
        'texto'=>array(
            'type'=>'textarea',
            'label'=>Yii::t('mx','Texto'),
            'class'=>'span7',
            'rows'=>5
        ),
    ));

?>


<p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('mx','are required');?>.
</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>200)); ?>


<?php 	$this->widget('ext.multimodelform.MultiModelForm',array(
    'id' => 'id_member',
    'formConfig' => $pricesForm,
    'model' =>$items,
    'tableView' => true,
    'validatedItems' => $validatedMembers,
    'removeText' =>Yii::t('mx','Remove'),
    'removeConfirm'=>Yii::t('mx','Delete this item?'),
    'addItemText'=>Yii::t('mx','Add Item'),
    //'tableView'=>true,
    'tableHtmlOptions'=>array('class'=>'items table table-hover table-condensed'),
    'data' => $items->findAll('keep_id=:groupId', array(':groupId'=>$model->id)),
    'showErrorSummary'=>true
));

?>



<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'encodeLabel'=>false,
        'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
        'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
    )); ?>
</div>

<?php $this->endWidget(); ?>

