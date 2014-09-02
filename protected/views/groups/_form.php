<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'groups-form',
	'enableAjaxValidation'=>false,
));

$pricesForm = array(
    'elements'=>array(
        'employee_id'=>array(
            'type'=>'dropdownlist',
            'label'=>Yii::t('mx','Employee'),
            'items'=>Employees::model()->listAll(),
        ),
    ));

?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>100)); ?>

    <?php 	$this->widget('ext.multimodelform.MultiModelForm',array(
        'id' => 'id_member',
        'formConfig' => $pricesForm,
        'model' =>$items,
        'tableView' => true,
        'validatedItems' => $validatedMembers,
        'removeText' =>Yii::t('mx','Remove'),
        'removeConfirm'=>Yii::t('mx','Delete this item?'),
        'removeHtmlOptions'=>array('class'=>'btn btn-danger'),
        'addItemText'=>Yii::t('mx','Add Item'),
        'tableView'=>true,
        'hideCopyTemplate'=>true,
        'tableHtmlOptions'=>array('class'=>'items table table-hover table-condensed'),
        'data' => $items->findAll('group_id=:groupId', array(':groupId'=>$model->id)),
        'showErrorSummary'=>true,
    ));
    ?>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
