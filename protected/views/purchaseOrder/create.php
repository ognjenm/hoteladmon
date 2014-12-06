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

    $(document).ready(function() {

        $("#table-2").tableDnD({
            onDragClass: "myDragClass",

            onDrop: function(table, row) {

                var rows = table.tBodies[0].rows;

                for (var i=0; i<rows.length; i++) {
                    if(i==0) $("#PurchaseOrderItems_order").val(i);
                    else $("#PurchaseOrderItems_order"+i).val(i);
                }
            }

        });


        $("#table-2 tr").hover(function() {
            $(this.cells[0]).addClass('showDragHandle');

        }, function() {
            $(this.cells[0]).removeClass('showDragHandle');
        });


        $("#ButtonText").click(function(){

            var nuevaFila='<tr class="copy newcopy'+ index +'" id="t'+(index+1)+'" style="cursor: move">'+
                            '<td style="width: 50px;" class="">'+'</td>'+
                            '<td colspan="4"><textarea rows="2" placeholder="Nota" class="span-12" name="PurchaseOrderItems[note][]" id="PurchaseOrderItems_note' + index + '"></textarea></td>'+
                            '<td><a class="btn btn-danger" onclick="$(this).parents().get(1).remove(); index--; return false;" href="#"><i class="icon-remove icon-white"></i></a></td>'+
                          "</tr>";

            $("#table-2").find('tbody').append(nuevaFila);
            //$("#table-2").append(nuevaFila);

            index++;

        });


        var objs=[];
        var temp_objs=[];

        $( "#add_button" ).click(function() {

            var html = "";

            var obj={
                "ROW_ID" : itemCount,
                "ITEM_NAME" :  $("#item_article").val(),
                "ITEM_PRICE" : $("#item_price").val(),
                "ITEM_QUANTITY" : $("#item_quantity").val()
            }

            objs.push(obj);

            itemCount++;
            html = "<tr id='tr"+ itemCount + "'>" +
                        "<td>"+ obj['ITEM_NAME'] + "</td>" +
                        "<td>" +  obj['ITEM_PRICE'] + " </td>" +
                        "<td>" +  obj['ITEM_QUANTITY'] + " </td>" +
                        "<td><input type='button'  id='" + itemCount + "' value='remove'></td>" +
                    "</tr>";

            $("#bill_table").append(html)

            $("#"+itemCount).click(function() {
                var buttonId = $(this).attr("id");
                $("#tr"+ buttonId).remove();
            });

            //$("#PurchaseOrder_provider_id").prop("selectedIndex",0);
            $("#PurchaseOrderItems_article_id").prop("selectedIndex",0);
            $("#item_price").val("");
            $("#item_quantity").val("");


        });


    });

</script>

<div id="debugArea"></div>

<?php echo $this->renderPartial('_form', array('model'=>$model,'items'=>$items)); ?>