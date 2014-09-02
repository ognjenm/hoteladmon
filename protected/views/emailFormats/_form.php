<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'email-formats-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php

$pricesForm = array(

    'elements'=>array(
        'orden'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Order'),
            'class'=>'span3'
        ),
        'name'=>array(
            'type'=>'dropdownlist',
            'label'=>Yii::t('mx','Name'),
            'items'=>Policies::model()->listAll(),
            'prompt'=>Yii::t('mx','Select'),
        ),
    ));

?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'format_name',array('class'=>'span5')); ?>

    <?php 	$this->widget('ext.multimodelform.MultiModelForm',array(
        'id' => 'id_member',
        'formConfig' => $pricesForm,
        'model' =>$items,
        'tableView' => true,
        'validatedItems' => $validatedMembers,
        'removeText' =>Yii::t('mx','Remove'),
        'removeConfirm'=>Yii::t('mx','Delete this item?'),
        'addItemText'=>Yii::t('mx','Add Item'),
        'tableView'=>true,
        'tableHtmlOptions'=>array('class'=>'items table table-hover table-condensed'),
        'data' => $items->findAll('email_format_id=:groupId', array(':groupId'=>$model->id)),
        'showErrorSummary'=>true
    ));
    ?>

    <?php

    /*$this->widget('bootstrap.widgets.TbSelect2',array(
            'model'=>$model,
            'attribute'=>'policies',
            'val' =>'['.$model->policies.']',
            'data' => CHtml::listData(Policies::model()->findAll(), 'id', 'title'),
            'asDropDownList' => true,
            'options' => array(
                'tokenSeparators' => array(',', ' '),
                'width'=>'100%',
            ),
            'htmlOptions' => array(
                'multiple' => 'multiple',
                'placeholder' => Yii::t('mx','Select'),
            ),
        )
    );*/

    ?>

<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>$model->isNewRecord ? 'icon-plus' : 'icon-ok',
        'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
