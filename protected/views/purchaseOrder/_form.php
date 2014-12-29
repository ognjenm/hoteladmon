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

                if(seordeno==false){
                    for(var i=0; i<=orders.length; i++) {
                        ordenCompra.push(orders[i]);
                    }
                }


                $.ajax({
                url: "'.CController::createUrl('/purchaseOrder/create').'",
                data: { purchaseOrder: ordenCompra },
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

    ?>

</div>



