<?php

$pricesForm = array(

    'elements'=>array(
        'datex' => array(
            'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
            'language'=>substr(Yii::app()->getLanguage(), 0, 2),
            'mode'=>'date',
            'options'=>array(
                'showAnim'=>'slide',
                'changeYear' => true,
                'changeMonth' => true,
                'dateFormat'=>'dd-M-yy',

            ),
            'htmlOptions' => array(
                'class' => 'input-medium',
            ),
        ),

        'register'=>array(
            'type'=>'dropdownlist',
            'label'=>Yii::t('mx','Register'),
            'items'=>TypesReport::model()->listAll(),
            'prompt'=>Yii::t('mx','Select'),
            'onchange'=>'

                var idx=$(this).attr("id");
                var indexid = idx.substring(25,27);
                var report=$(this).val();

                if(report!=4){

                     $.ajax({
                        url: "'.CController::createUrl('/typesReport/getFolio').'",
                        data: { index: indexid, typeReportId:report },
                        dataType: "json",
                        type: "POST",
                        beforeSend: function() { $(".divContent").addClass("loading"); }
                    })

                    .done(function(data) {
                        if(data.ok==true) $("#BraceletsHistory_folio"+indexid).val(data.msg);
                        else bootbox.alert(data.msg);
                     })
                    .fail(function(data) { bootbox.alert(data); })
                    .always(function() { $(".divContent").removeClass("loading"); });
                }

            '
        ),
        'folio'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Folio'),
        ),
        'quantity'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Quantity'),
        ),

    ));

?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bracelets-history-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->select2Row($model, 'assignment_id',
        array(
            'data' => Assignment::model()->listAllBracelets(),
            'labelOptions'=>array(
                'label'=>Yii::t('mx','Sell')
            ),
            'options' => array(

                'placeholder' =>Yii::t('mx','Select'),
                'allowClear' => true,
                'width' => '40%',
            ),
        )
    );

    ?>


    <?php 	$this->widget('ext.multimodelform.MultiModelForm',array(
        'id' => 'id_member',
        'formConfig' => $pricesForm,
        'model' =>$model,
        'tableView' => true,
        'validatedItems' => $validatedMembers,
        'removeText' =>Yii::t('mx','Remove'),
        'removeConfirm'=>Yii::t('mx','Delete this item?'),
        'removeHtmlOptions'=>array('class'=>'btn btn-danger'),
        'addItemText'=>Yii::t('mx','Add Item'),
        'tableView'=>true,
        'hideCopyTemplate'=>false,
        'tableHtmlOptions'=>array('class'=>'items table table-hover table-condensed'),
        //'data' => $model->findAll('assignment_id=:groupId', array(':groupId'=>$masterId)),
        'showErrorSummary'=>true,
        'jsAfterNewId' => MultiModelForm::afterNewIdDatePicker($pricesForm['elements']['datex']),
        //'afterAddItem' => "alert(this.attr('id'));",
    ));
    ?>

	<?php //echo $form->textFieldRow($model,'quantity',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'register',array('class'=>'span5','maxlength'=>100)); ?>

    <?php /*echo $form->datepickerRow($model, 'datex',array(
        'value'=>date('Y-m-d'),
        'prepend'=>'<i class="icon-calendar"></i>',
        'options'=>array('format'=>'yyyy-mm-dd'),
        //'class'=>'span4',
    ));*/
    ?>

<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>'icon-minus icon-white',
        'label'=>Yii::t('mx','Sell'),
    )); ?>
</div>


<?php $this->endWidget(); ?>



