<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'lista-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

<?php echo CHtml::label(Yii::t('mx','Providers'),'provider_id'); ?>
<?php $this->widget('bootstrap.widgets.TbSelect2', array(
    'model'=>$model,
    'attribute'=>'provider_id',
    'data' =>Providers::model()->listAllOrganization(),
    'options' => array(
        'allowClear' => true,
    ),
    'htmlOptions' => array(
        'placeholder' =>Yii::t('mx','Select'),
    ),
    'events' =>array(
        'change'=>'js:function(e){
                    $.ajax({
                        url: "'.CController::createUrl('/articles/getArticleDescription').'",
                        data: { provider: $(this).val() },
                        type: "POST",
                        dataType: "json",
                        beforeSend: function() {}
                    })

                    .done(function(data) {

                        if(data.ok==true){
                            $("#Lista_article_id").html(data.articles);
                        }

                    })

                    .fail(function() { bootbox.alert("Error"); })
                    .always(function() { });

                }'
    ),
));
?>

<?php echo CHtml::label(Yii::t('mx','Articles'),'name_article'); ?>

<?php $this->widget('bootstrap.widgets.TbSelect2', array(
    'model'=>$model,
    'attribute'=>'article_id',
    'data' =>array(''=>Yii::t('mx','Select')),
    'options' => array(
        'allowClear' => true,
    ),
    'events' =>array(
        'change'=>'js:function(e){

                    $.ajax({
                        url: "'.CController::createUrl('/articles/GetAttributesArticle').'",
                        data: { articleId: $(this).val() },
                        type: "POST",
                        dataType: "json",
                        beforeSend: function() {}
                    })

                    .done(function(data) {

                        if(index==1){

                                $("#Lista_price").val(data.price);
                                $("#Lista_unit_measure_id").val(data.unit_measure_id);
                                $("#Lista_color").val(data.color);
                                $("#Lista_presentation").val(data.presentation);


                        }else{

                                $("#Lista_price"+index).val(data.price);
                                $("#Lista_unit_measure_id"+index).val(data.unit_measure_id);
                                $("#Lista_color"+index).val(data.color);
                                $("#Lista_presentation"+index).val(data.presentation);

                        }


                    })

                    .fail(function() { bootbox.alert("Error"); })
                    .always(function() {});
                }'
    ),

));
?>


        <?php $this->widget('ext.jqrelcopy.JQRelcopy',array(
            'id' => 'copylink',
            'removeText' => 'Remove',
            'removeHtmlOptions' => array(
                'class'=>'btn btn-danger',
            ),
            'jsBeforeClone' => '
                index++;
            ',
            'options' => array(
                'copyClass'=>'newcopy',
                'clearInputs'=>true,
            )
        ));
        ?>

        <table id="table-2" cellspacing="0" cellpadding="2">
            <thead>

            <tr>
                <th>Order</th>
                <th style="text-align: center">Cantidad</th>
                <th style="text-align: center">Precio Unitario</th>
                <th style="text-align: center">Unidad De Medida</th>
                <th style="text-align: center">Color</th>
                <th style="text-align: center">Presentacion</th>
            </tr>
            </thead>
            <tbody>
                <tr class="copy" id="row">
                    <td><?php echo CHtml::image(Yii::app()->baseUrl.'/extensions/tableorder/images/updown2.gif','',array()); ?></td>
                    <td><?php echo $form->textField($model,"quantity[]",array('placeholder'=>Yii::t('mx','Cantidad'))); ?></td>
                    <td><?php echo $form->textField($model,"price[]",array('placeholder'=>Yii::t('mx','Price'))); ?></td>
                    <td><?php echo $form->dropDownList($model,'unit_measure_id[]',UnitsMeasurement::model()->listAll(),array(
                            'prompt'=>Yii::t('mx','Unit Of Measure'),
                            'class'=>'span12'
                        )); ?><?php //echo $form->textField($model,"unit_measure_id[]",array('placeholder'=>Yii::t('mx','Measure'))); ?></td>
                    <td><?php echo $form->textField($model,"color[]",array('placeholder'=>Yii::t('mx','Color'))); ?></td>
                    <td><?php echo $form->textField($model,"presentation[]",array('placeholder'=>Yii::t('mx','Presentation'))); ?></td>
                </tr>
            </tbody>
        </table>


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
            'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
