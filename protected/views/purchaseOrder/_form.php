<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'purchase-order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo CHtml::label(Yii::t('mx','Providers'),'provider_id'); ?>



    <?php $this->widget('ext.jqrelcopy.JQRelcopy',array(
        'id' => 'copylink',
        'jsBeforeClone' =>'index++;',
        'options' => array(
            'copyClass'=>'newcopy',
            'clearInputs'=>true,
        )
    ));
    ?>

    <table border='0' width='100%' align='center' class="items table table-condensed table-bordered">
        <th>Provider</th>
        <th>Article</th>
        <th>Price</th>
        <th>Quantity</th>
        <th></th>
        <tr>
            <td>
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

                        providers++;

                        html+="<tr><td><table id=\'providers"+providers+"\' style="width:100%"><tbody><tr><th colspan=\'4\' scope=\'row\'>"+ $(this).val() +"</th></tr></tbody></table></td></tr>";

                        $("#bill_table").append(html);

                        html="";

                        $.ajax({
                            url: "'.CController::createUrl('/articles/getArticleDescription').'",
                            data: { provider: $(this).val() },
                            type: "POST",
                            dataType: "json",
                            beforeSend: function() {}
                        })

                        .done(function(data) {

                            if(data.ok==true){

                            $("#item_price").html(data.articles);

                                if(index > 1) $("#PurchaseOrderItems_article_id"+index).html(data.articles);
                                else $("#PurchaseOrderItems_article_id").html(data.articles);

                            }

                        })

                        .fail(function() { bootbox.alert("Error"); })
                        .always(function() { });

                    }'
                    ),
                ));
                ?>
            </td>
            <td>
                <input name="item_article" type="hidden" id="item_article" size="100"/>
                <?php echo $form->dropDownList($items,'article_id',array(),array(
                    'class'=>'span12',
                    'prompt'=>Yii::t('mx','Select'),
                    'onchange'=>'

                            var indice=$(this).attr("id");
                            var index2=indice.substring(29,31);

                            $.ajax({
                                    url: "'.CController::createUrl('/articles/GetAttributesArticle').'",
                                    data: { articleId: $(this).val() },
                                    type: "POST",
                                    dataType: "json",
                                    beforeSend: function() {}
                                })

                                .done(function(data) {

                                    $("#item_price").val(data.price);
                                    $("#item_article").val(data.presentation);

                                    provider= $("#PurchaseOrder_provider_id").val();

                                    if(index==1){
                                            $("#PurchaseOrderItems_provider_id").val(provider);
                                            $("#PurchaseOrderItems_price").val(data.price);
                                            $("#PurchaseOrderItems_presentation").val(data.presentation);
                                    }else{
                                            $("#PurchaseOrderItems_provider_id"+index2).val(provider);
                                            $("#PurchaseOrderItems_price"+index2).val(data.price);
                                            $("#PurchaseOrderItems_presentation"+index2).val(data.presentation);
                                    }

                                })

                                .fail(function() { bootbox.alert("Error"); })
                                .always(function() {});
                        '
                )); ?>
            </td>
            <td><input name="item_price" type="text" id="item_price" size="20"/></td>
            <td><input name="item_quantity" type="text" id="item_quantity" size="20"/></td>
            <td>

                <input name="add_button" type="button" id="add_button" size="20" value="Add" />
                <input name="add_note" type="button" id="add_note" size="20" value="Nota" />
            </td>
    </table>


    <div id="billing_items_div">
        <table id='bill_table'  width='50%' align='center'  class='items table table-hover table-condensed'></table>
    </div>

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx','Purchase Order'),
        'headerIcon' => 'icon-th-list',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
    ));?>


        <table id="table-2" class="items table table-hover table-condensed">
            <thead>
            <tr>
                <th>Order</th>
                <th style="text-align: center">Articulo</th>
                <th style="text-align: center">Cantidad</th>
                <th style="text-align: center">Precio Unitario</th>
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
                            'id'=>'ButtonText',
                            'type'=>'primary',
                            'icon'=>'icon-plus icon-white',
                            'label'=>Yii::t('mx','Note'),
                        ));
                        ?>

                    </td>
                </tr>
            </tfoot>
            <tbody>
            <tr class="copy" id="t">
                <td style="width: 50px;">
                    <?php echo CHtml::activeHiddenField($items,'provider_id[]',array()); ?>
                    <?php echo CHtml::activeHiddenField($items,'note[]',array()); ?>
                </td>
                <td width="300px">

                    <?php echo $form->dropDownList($items,'article_id[]',array(),array(
                        'class'=>'span12',
                        'prompt'=>Yii::t('mx','Select'),
                        'onchange'=>'

                            var indice=$(this).attr("id");
                            var index2=indice.substring(29,31);

                            $.ajax({
                                    url: "'.CController::createUrl('/articles/GetAttributesArticle').'",
                                    data: { articleId: $(this).val() },
                                    type: "POST",
                                    dataType: "json",
                                    beforeSend: function() {}
                                })

                                .done(function(data) {

                                    provider= $("#PurchaseOrder_provider_id").val();

                                    if(index==1){
                                            $("#PurchaseOrderItems_provider_id").val(provider);
                                            $("#PurchaseOrderItems_price").val(data.price);
                                            $("#PurchaseOrderItems_presentation").val(data.presentation);

                                    }else{
                                            $("#PurchaseOrderItems_provider_id"+index2).val(provider);
                                            $("#PurchaseOrderItems_price"+index2).val(data.price);
                                            $("#PurchaseOrderItems_presentation"+index2).val(data.presentation);
                                    }

                                })

                                .fail(function() { bootbox.alert("Error"); })
                                .always(function() {});
                        '
                    )); ?>

                </td>
                <td width="100px"><?php echo $form->textField($items,"quantity[]",array('placeholder'=>Yii::t('mx','Cantidad'),'class'=>'span12')); ?></td>
                <td width="100px"><?php echo $form->textField($items,"price[]",array('placeholder'=>Yii::t('mx','Price'),'class'=>'span12')); ?></td>
                <td><?php echo $form->textField($items,"presentation[]",array('placeholder'=>Yii::t('mx','Presentation'),'class'=>'span12')); ?></td>
                <td width="50">
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
