<?php

$pricesForm = array(

    'elements'=>array(
        'operation_id'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Operation'),
            'class'=>'span12'
        ),
        'quantity'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Quantity'),
            'class'=>'span12'
        ),
        'unit'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Unit'),
            'class'=>'span12'
        ),
        'identification'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Identification'),
            'class'=>'span12'
        ),
        'description'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Description'),
            'class'=>'span12'
        ),
        'unit_price'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Unit Price'),
            'class'=>'span12'
        ),

    ));


Yii::app()->clientScript->registerScript('filters', '


       function handleClick(radio){

            alert(radio.value);

        }

    ');


?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'invoices-form',
	'enableAjaxValidation'=>false,
    'type'=>'vertical'
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

    <fieldset>
        <legend><?php echo Yii::t('mx', 'Invoice'); ?></legend>


        <?php echo $form->radioButtonListInlineRow(
            $model,
            'bill_to',
            array(
                Yii::t('mx','Customer'),
                Yii::t('mx','Provider'),
            ),
            array(
                'onclick'=>'handleClick(this);'
            )
        ); ?>


        <?php echo $form->dropdownlistRow($model,'provider_id',Customers::model()->listFullName(),array(
            'class'=>'span5',
            'prompt'=>Yii::t('mx','Select'),
            'ajax' => array(
                'type'=>'POST',
                'data'=>array('customerId'=>'js:this.value'),
                'url'=>Yii::app()->createUrl('TaxInformation/getBillTo'),
                'update'=>'#Invoices_tax_information_id'
            )
        )); ?>

        <?php echo $form->dropdownlistRow($model,'tax_information_id',array(),array('class'=>'span5')); ?>
        <?php echo $form->datepickerRow($model, 'date_expedition',array(
            'value'=>date('Y-m-d'),
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array('format'=>'yyyy-mm-dd'),
            //'class'=>'span4',
        ));
        ?>

    </fieldset>


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
        'data' => $items->findAll('invoice_id=:groupId', array(':groupId'=>$model->id)),
        'showErrorSummary'=>true,
        //'jsAfterCloneCallback'=>'alertIds',
        /*'jsAfterNewId' => "
            var data=this.attr('id');
            alert(data);
        "*/
        //'jsAfterClone' => "alert(this.attr('class'));"
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
