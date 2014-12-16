<?php

    $this->breadcrumbs=array(
        'Purchase Order'=>array('index'),
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
            orders=[];

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

            html= "<tr>" +
                        "<td><input type='hidden' value='"+item['ITEM_ARTICLE_ID']+"' name='article_id[]'/>"+$("#PurchaseOrderItems_article_id option:selected").text()+"</td>" +
                        "<td><input type='hidden' value='"+item['ITEM_PRICE']+"' name='price[]'/>" +  item['ITEM_PRICE'] + " </td>" +
                        "<td><input type='hidden' value='"+item['ITEM_QUANTITY']+"' name='quantity[]'/>" +  item['ITEM_QUANTITY'] + " </td>" +
                        "<td><input type='button'  id='" + itemCount + "' value='Eliminar'></td>" +
                    "</tr>";

            $("#providers"+providers).append(html);

            html="";

            $("#"+itemCount).click(function() {
                var buttonId = $(this).attr("id");
                $("#tr"+ buttonId).remove();
            });

            $("#PurchaseOrderItems_article_id").prop("selectedIndex",0);
            $("#item_price").val("");
            $("#item_quantity").val("");


        });

    });

</script>

<div id="content">
    <?php echo $this->renderPartial('_form', array('model'=>$model,'items'=>$items)); ?>
</div>