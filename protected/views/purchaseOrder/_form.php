<table id='bill_table'  width='50%' align='center'  class='items table table-hover table-condensed'></table>

<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'id'=>'sendPurchaseOrder',
        'buttonType'=>'button',
        'type'=>'primary',
        'icon'=>'icon-plus icon-white',
        'label'=>Yii::t('mx','Create'),
        'htmlOptions'=> array(
            'onclick' =>'

                $.ajax({
                url: "'.CController::createUrl('/purchaseOrder/create').'",
                data: { purchaseOrder: orders },
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
            '
        )
    ));

    /*
     $("#table-2").tableDnD({
	    onDragClass: "myDragClass",
	    onDrop: function(table, row) {
            var rows = table.tBodies[0].rows;
            var debugStr = "Row dropped was "+row.id+". New order: ";
            for (var i=0; i<rows.length; i++) {
                debugStr += rows[i].id+" ";
            }
	        $("#debugArea").html(debugStr);
	    },
		onDragStart: function(table, row) {
			$("#debugArea").html("Started dragging row "+row.id);
		}
	});
     */

    ?>

</div>



