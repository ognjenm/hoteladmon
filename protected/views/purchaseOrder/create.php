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

    $(document).ready(function() {

        $("#bill_table").tableDnD({
            onDragClass: "myDragClass",

            onDrop: function(table, row) {

                var rows = table.tBodies[0].rows;

                /*for (var i=0; i<rows.length; i++) {
                    if(i==0) $("#PurchaseOrderItems_order").val(i);
                    else $("#PurchaseOrderItems_order"+i).val(i);
                }*/
            }

        });


        $("#bill_table tr").hover(function() {
            $(this.cells[0]).addClass('showDragHandle');

        }, function() {
            $(this.cells[0]).removeClass('showDragHandle');
        });

        var objs=[];

        $("#add_note").click(function() {

            html="<tr id='tr'>"+
                "<td colspan='4' scope='row'>"+
                "<textarea rows='3' style='width: 100%;'></textarea>"
                "</td></tr>";
            $("#providers"+providers).append(html);
            html="";

        });

        $( "#add_button" ).click(function() {

            var obj={
                "ROW_ID" : itemCount,
                "ITEM_NAME" :  $("#item_article").val(),
                "ITEM_PRICE" : $("#item_price").val(),
                "ITEM_QUANTITY" : $("#item_quantity").val()
            }

            objs.push(obj);

            //anade una fila

            itemCount++;

            html= "<tr id='tr"+ itemCount + "'>" +
                        "<td><input name='item_name[]' type='text' id='item_name"+itemCount+"' value='"+obj['ITEM_NAME']+"'/></td>" +
                        "<td>" +  obj['ITEM_PRICE'] + " </td>" +
                        "<td>" +  obj['ITEM_QUANTITY'] + " </td>" +
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