<?php

    $this->breadcrumbs=array(
        Yii::t('mx','Purchase Order')=>array('index'),
        Yii::t('mx','Create'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
    );

    $this->pageSubTitle=Yii::t('mx','Create');
    $this->pageIcon='icon-ok';

    $order=Yii::getPathOfAlias('ext.tableorder');
    $assets =Yii::app()->assetManager->publish($order);

    $cs = Yii::app()->getClientScript();

    $cs->registerScriptFile($assets.'/js/jquery.tablednd.0.7.min.js');
    $cs->registerCssFile($assets.'/css/tablednd.css');

?>

<script type="text/javascript">

    var index=1;
    var itemCount = 0;
    var html = "";
    var providers=0;
    var items=[];
    var orders=[];
    var purchaseOrders=[];
    var aux=new Array();
    var note=new Array();
    var noteIndex=0;


    $(document).ready(function() {


        $("#bill_table").tableDnD();

        $("#bill_table tr").hover(function() {
            $(this.cells[0]).addClass('showDragHandle');

        }, function() {
            $(this.cells[0]).removeClass('showDragHandle');
        });


        $('#sendPurchaseOrder').click(function(){

            note[noteIndex]=$("#note"+noteIndex).val();
            orders.push({"provider": aux[providers-1],"items": items, "note": note[noteIndex]});

            $.ajax({
                url: "<?php echo CController::createUrl('/purchaseOrder/create'); ?>",
                data: { purchaseOrder: orders }, //$("#purchase-order-form").serialize(),
                type: "POST",
                dataType: "json",
                beforeSend: function() { $("#content").addClass("loading"); }
            })

                .done(function(data) {
                    if(data.ok==true){
                        window.location.href=data.url;
                    }
                })

                .fail(function(data) {
                    if(data.ok==false){
                        bootbox.alert(data.error);
                    }

                })

                .always(function() { $("#content").removeClass("loading"); });

            items=[];
            providers=[];
            note=[];
            //orders=[];

        });

        $("#add_note").click(function() {

            itemCount++;
            noteIndex++;

            html="<tr>"+
                "<td colspan='4' scope='row'>"+
                "<textarea id='note"+noteIndex+ "' rows='3' style='width: 100%;'></textarea>"
                "</td></tr>";
            $("#providers"+providers).append(html);
            html="";

            $("#bill_table").tableDnDUpdate();

        });

        $("#add_button").click(function() {

            var item={
                "ROW_ID" : itemCount,
                "ITEM_ARTICLE_ID" :  $("#PurchaseOrderItems_article_id").val(),
                "ITEM_PRICE" : $("#item_price").val(),
                "ITEM_QUANTITY" : $("#item_quantity").val()
            }

            items.push(item);

            itemCount++;

            html= "<tr id='tr"+itemCount+"'>" +
                        "<td>"+$("#PurchaseOrderItems_article_id option:selected").text()+"</td>" +
                        "<td>" +  item['ITEM_PRICE'] + " </td>" +
                        "<td>" +  item['ITEM_QUANTITY'] + " </td>" +
                        "<td><button class='btn btn-danger' type='button' id='btn" + itemCount + "' onclick='$(this).parents().get(1).remove(); orders["+(providers-1)+"].items.splice("+(itemCount-1)+ ",1);' ><i class='icon-remove'></i></button></td>" +
                    "</tr>";

            $("#providers"+providers).append(html);

            html="";

            $("#PurchaseOrderItems_article_id").prop("selectedIndex",0);
            $("#item_price").val("");
            $("#item_quantity").val("");

            $("#bill_table").tableDnDUpdate();

        });

    });



    function estatus()
    {
        var sList = "";

        $('input[type=checkbox]').each(function () {

            if(this.checked){
                var sThisVal=this.id;
                sList += (sList=="" ? sThisVal : "," + sThisVal);
            }

        });


    }

</script>

<div id="content">
    <fieldset>
        <legend>Busqueda:</legend>
        <div class="checkbox">
            <label>
                <?php echo CHtml::radioButtonList('choice','',array('provider'=>Yii::t('mx','Provider'),'article'=>Yii::t('mx','Article')), array(
                        'labelOptions'=>array('style'=>'display:inline'),
                        'separator' => "",
                        'onClick'=>"

                            var search=$(\"input:radio[name='choice']:checked\").val();

                            if(search=='provider'){
                               $('#providersDiv').show();
                               $('#articlesDiv').hide();
                            }else{
                                $('#articlesDiv').show();
                                $('#providersDiv').hide();
                            }

                        "
                    )
                ); ?>
            </label>
        </div>

            <div id="providersDiv" style="display: none">
                <?php echo $form->render(); ?>
            </div>
            <div id="articlesDiv" style="display: none">
                <?php echo $formArticle->render(); ?>
            </div>

    </fieldset>
    <?php echo $this->renderPartial('_form', array('model'=>$model,'items'=>$items)); ?>
</div>