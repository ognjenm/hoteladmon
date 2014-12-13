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

    $(document).ready(function() {

        $("#bill_table").tableDnD();

        $("#bill_table tr").hover(function() {
            $(this.cells[0]).addClass('showDragHandle');

        }, function() {
            $(this.cells[0]).removeClass('showDragHandle');
        });

        $('#sendPurchaseOrder').click(function(){

            $.ajax({
                url: "<?php echo CController::createUrl('/purchaseOrder/create'); ?>",
                data: { purchaseOrder: orders },
                type: "POST",
                dataType: "json",
                beforeSend: function() {}
            })

                .done(function(data) {  })
                .fail(function(data) { bootbox.alert("error"); })
                .always(function(data) { });
        });

        $("#add_note").click(function() {

            html="<tr id='"+providers+"' style='cursor: move;'>"+
                "<td colspan='4' scope='row'>"+
                "<textarea rows='3' style='width: 100%;'></textarea>"
                "</td></tr>";
            $("#providers"+providers).append(html);
            html="";

            //var order={"NOTE" :  $(this).val()};
            //orders.push(order);

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

            html= "<tr id='tr"+ itemCount + "'>" +
                        "<td>"+$("#PurchaseOrderItems_article_id option:selected").text()+"</td>" +
                        "<td>" +  item['ITEM_PRICE'] + " </td>" +
                        "<td>" +  item['ITEM_QUANTITY'] + " </td>" +
                        "<td><input type='button'  id='" + itemCount + "' value='remove'></td>" +
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

<div id="debugArea"></div>

<?php echo $this->renderPartial('_form', array('model'=>$model,'items'=>$items)); ?>