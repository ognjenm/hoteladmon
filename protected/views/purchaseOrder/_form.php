<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'purchase-order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

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

                        aux[providers]=$(this).val();
                        note[noteIndex]=$("#note"+noteIndex).val();

                        if(providers>0){

                            /*var t=note.length;
                            $.each( note, function( key, value ) {
                            });*/

                            orders.push({"provider": aux[providers-1], "items": items, "note": note[noteIndex]});
                            items=[];
                        }

                        providers++;

                        var prov=$("#PurchaseOrder_provider_id option:selected").text();

                        html+="<tr id=\'"+providers+"\' style=\'cursor: move;\'>"+
                                    "<td>index</td>"+
                                    "<td>"+
                                        "<table id=\'providers"+providers+"\' style=\'width:100%\'><tbody><tr><th colspan=\'4\' scope=\'row\'><input type=\'hidden\' value=\'"+$(this).val()+"\' name=\'provider[]\' />"+ prov +"</th></tr></tbody></table>"+
                                    "</td>"+
                                    "<td style=\'text-align: center;vertical-align: middle;\'><input type=\'button\'  id=\'" + providers + "\' value=\'remove\'></td>" +
                               "</tr>";

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
                                    //$("#item_article").val(data.presentation);
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

    <table id='bill_table'  width='50%' align='center'  class='items table table-hover table-condensed'></table>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'id'=>'sendPurchaseOrder',
            'buttonType'=>'button',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>

    </div>


<?php $this->endWidget(); ?>
