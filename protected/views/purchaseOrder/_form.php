<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'purchase-order-form',
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
                                $("#PurchaseOrder_article_id").html(data.articles);
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

                            provider= $("#PurchaseOrder_provider_id").val();
                            providerTexto= $("#PurchaseOrder_provider_id option:selected").html();

                            if(index==1){
                                    $("#provider").val(providerTexto);
                                    $("#PurchaseOrderItems_provider_id").val(provider);
                                    $("#PurchaseOrderItems_article_id").val(data.id);
                                    $("#PurchaseOrderItems_price").val(data.price);
                                    $("#PurchaseOrderItems_unit_measure_id").val(data.unit_measure_id);
                                    $("#PurchaseOrderItems_color").val(data.color);
                                    $("#PurchaseOrderItems_presentation").val(data.presentation);
                                    $("#PurchaseOrderItems_order").val(index);


                            }else{
                                    $("#provider"+index).val(providerTexto);
                                    $("#PurchaseOrderItems_provider_id"+index).val(provider);
                                    $("#PurchaseOrderItems_article_id"+index).val(data.id);
                                    $("#PurchaseOrderItems_price"+index).val(data.price);
                                    $("#PurchaseOrderItems_unit_measure_id"+index).val(data.unit_measure_id);
                                    $("#PurchaseOrderItems_color"+index).val(data.color);
                                    $("#PurchaseOrderItems_presentation"+index).val(data.presentation);
                                    $("#PurchaseOrderItems_order"+index).val(index);

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
        'jsBeforeClone' =>'index++;',
        'options' => array(
            'copyClass'=>'newcopy',
            'clearInputs'=>true,
        )
    ));
    ?>

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Purchase Order'),
        'headerIcon' => 'icon-th-list',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
    ));?>

        <table id="table-2" class="items table table-hover table-condensed table-bordered">
            <thead>

            <tr>
                <th>Order</th>
                <th style="text-align: center">Proveedor</th>
                <th style="text-align: center">Cantidad</th>
                <th style="text-align: center">Precio Unitario</th>
                <th style="text-align: center">Unidad De Medida</th>
                <th style="text-align: center">Color</th>
                <th style="text-align: center">Presentacion</th>
                <th style="text-align: center">Remove</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <?php  $this->widget('bootstrap.widgets.TbButton', array(
                            'id'=>'copylink',
                            'type'=>'primary',
                            'icon'=>'icon-plus icon-white',
                            'label'=>Yii::t('mx','Article'),
                            'htmlOptions'=>array(
                                'rel'=>'.copy',
                            )
                        ));
                        ?>

                        <?php  $this->widget('bootstrap.widgets.TbButton', array(
                            'id'=>'textoz',
                            'type'=>'primary',
                            'icon'=>'icon-plus icon-white',
                            'label'=>Yii::t('mx','Text'),
                        ));
                        ?>

                    </td>
                </tr>
            </tfoot>
            <tbody>
            <tr class="copy" id="t">
                <td style="width: 50px;">
                    <?php //echo $form->textField($items,"order[]",array('class'=>'span12','readonly'=>'readonly')); ?>
                    <?php //echo CHtml::image(Yii::app()->theme->baseUrl."/images/updown2.gif",'',array()); ?>
                    <?php echo CHtml::activeHiddenField($items,'provider_id[]',array()); ?>
                    <?php echo CHtml::activeHiddenField($items,'article_id[]',array()); ?>
                </td>
                <td><?php echo CHtml::textField('provider','',array('id'=>'provider','placeholder'=>Yii::t('mx','Proveedor'))); ?>
                </td>
                <td><?php echo $form->textField($items,"quantity[]",array('placeholder'=>Yii::t('mx','Cantidad'))); ?></td>
                <td><?php echo $form->textField($items,"price[]",array('placeholder'=>Yii::t('mx','Price'))); ?></td>
                <td><?php echo $form->dropDownList($items,'unit_measure_id[]',UnitsMeasurement::model()->listAll(),array(
                        'prompt'=>Yii::t('mx','Unit Of Measure'),
                        'class'=>'span12'
                    )); ?>
                </td>
                <td><?php echo $form->textField($items,"color[]",array('placeholder'=>Yii::t('mx','Color'))); ?></td>
                <td><?php echo $form->textField($items,"presentation[]",array('placeholder'=>Yii::t('mx','Presentation'))); ?></td>
                <td>
                    <?php

                        $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType'=>'link',
                            'type'=>'danger',
                            'icon'=>'icon-remove icon-white',
                            'label'=>'',
                            'htmlOptions'=>array(
                                'onclick'=>'$(this).parents().get(1).remove(); index--; return false;'
                            )
                        ));

                    ?>
                </td>
            </tr>
            </tbody>
        </table>

    <?php $this->endWidget();?>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>


    </div>


<?php $this->endWidget(); ?>
