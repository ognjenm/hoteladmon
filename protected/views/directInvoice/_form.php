<?php

$a1= Yii::t('mx','Quantity');
$a2= Yii::t('mx','Presentation');
$a3= Yii::t('mx','Price');
$a4= Yii::t('mx','Amount');
$a5= Yii::t('mx','Discount');
$a6= Yii::t('mx','Subtotal');
$a7= Yii::t('mx','VAT');
$a8= Yii::t('mx','IEPS');
$a9= Yii::t('mx','Retention VAT');
$a10= Yii::t('mx','Retention ISR');
$a11= Yii::t('mx','Total');
$a12= Yii::t('mx','Actions');

$css = <<<EOD
@media
    only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {

        #direct-invoice-grid table,#direct-invoice-grid thead,#direct-invoice-grid tbody,#direct-invoice-grid th,#direct-invoice-grid td,#direct-invoice-grid tr {
            display: block;
        }

        #direct-invoice-grid thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        #direct-invoice-grid tr { border: 1px solid #ccc; }

        #direct-invoice-grid td {
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }

        #direct-invoice-grid td:before {
            position: absolute;
            top: 6px;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
        }
        .grid-view .button-column {
            text-align: left;
            width:auto;
        }

        #direct-invoice-grid td:nth-of-type(1):before { content: '$a1'; }
        #direct-invoice-grid td:nth-of-type(2):before { content: '$a2'; }
        #direct-invoice-grid td:nth-of-type(3):before { content: '$a3'; }
        #direct-invoice-grid td:nth-of-type(4):before { content: '$a4'; }
        #direct-invoice-grid td:nth-of-type(5):before { content: '$a5'; }
        #direct-invoice-grid td:nth-of-type(6):before { content: '$a6'; }
        #direct-invoice-grid td:nth-of-type(7):before { content: '$a7'; }
        #direct-invoice-grid td:nth-of-type(8):before { content: '$a8'; }
        #direct-invoice-grid td:nth-of-type(9):before { content: '$a9'; }
        #direct-invoice-grid td:nth-of-type(9):before { content: '$a10'; }
        #direct-invoice-grid td:nth-of-type(9):before { content: '$a11'; }
        #direct-invoice-grid td:nth-of-type(9):before { content: '$a12'; }
    }

EOD;

Yii::app()->clientScript->registerCss(__CLASS__ . '#direct-invoice-grid', $css);

?>

<script type="text/javascript">
    var index=1;

    function roundToTwo(num) {
        return +(Math.round(num + "e+2")  + "e-2");
    }


    function calculaFactura(){

        var totaldiscount=0;
        var totalImporte=0;
        var totalVat=0;
        var totalIeps=0;
        var totalRetiva=0;
        var totalRetisr=0;
        var sumaDiscount=0;
        var sumaVat=0;
        var sumaIeps=0;
        var sumaRetiva=0;
        var sumaRetisr=0;
        var sumaOther=0;
        var grandTotal=0;

        for(var i=1;i<=index;i++){

            if(i==1){

                var discountIndex=document.getElementById("DirectInvoiceItems_discount").value;
                var vatIndex=document.getElementById("DirectInvoiceItems_vat").value;
                var iepsIndex=document.getElementById("DirectInvoiceItems_ieps").value;
                var retivaIndex=document.getElementById("DirectInvoiceItems_retiva").value;
                var retisrIndex=document.getElementById("DirectInvoiceItems_retisr").value;
                var importeIndex=document.getElementById("DirectInvoiceItems_amount").value;

                if(discountIndex=='') discountIndex=0;
                else totaldiscount=parseFloat(totaldiscount)+parseFloat(discountIndex);

                if(vatIndex=='') vatIndex=0;
                else totalVat=parseFloat(totalVat)+parseFloat(vatIndex);

                if(iepsIndex=='') iepsIndex=0;
                else totalIeps=parseFloat(totalIeps)+parseFloat(iepsIndex);

                if(retivaIndex=='') retivaIndex=0;
                else totalRetiva=parseFloat(totalRetiva)+parseFloat(retivaIndex);

                if(retisrIndex=='') retisrIndex=0;
                else totalRetisr=parseFloat(totalRetisr)+parseFloat(retisrIndex);

                totalImporte=parseFloat(totalImporte)+parseFloat(importeIndex);


            }else{
                var discountIndex=document.getElementById("DirectInvoiceItems_discount"+i).value;
                var vatIndex=document.getElementById("DirectInvoiceItems_vat"+i).value;
                var iepsIndex=document.getElementById("DirectInvoiceItems_ieps"+i).value;
                var retivaIndex=document.getElementById("DirectInvoiceItems_retiva"+i).value;
                var retisrIndex=document.getElementById("DirectInvoiceItems_retisr"+i).value;
                var importeIndex=document.getElementById("DirectInvoiceItems_amount"+i).value;

                if(discountIndex=='') discountIndex=0;
                else totaldiscount=parseFloat(totaldiscount)+parseFloat(discountIndex);

                if(vatIndex=='') vatIndex=0;
                else totalVat=parseFloat(totalVat)+parseFloat(vatIndex);

                if(iepsIndex=='') iepsIndex=0;
                else totalIeps=parseFloat(totalIeps)+parseFloat(iepsIndex);

                if(retivaIndex=='') retivaIndex=0;
                else totalRetiva=parseFloat(totalRetiva)+parseFloat(retivaIndex);

                if(retisrIndex=='') retisrIndex=0;
                else totalRetisr=parseFloat(totalRetisr)+parseFloat(retisrIndex);

                totalImporte=parseFloat(totalImporte)+parseFloat(importeIndex);

            }
        }

        document.getElementById("DirectInvoice_discount_article").value=roundToTwo(totaldiscount.toFixed(2));
        document.getElementById("DirectInvoice_ieps_article").value=roundToTwo(totalIeps.toFixed(2));
        document.getElementById("DirectInvoice_retiva_article").value=roundToTwo(totalRetiva.toFixed(2));
        document.getElementById("DirectInvoice_retisr_article").value=roundToTwo(totalRetisr.toFixed(2));
        document.getElementById("DirectInvoice_vat_article").value=roundToTwo(totalVat.toFixed(2));
        document.getElementById("DirectInvoice_totalAmount").value=roundToTwo(totalImporte.toFixed(2));

        var discountStore=document.getElementById("DirectInvoice_discount").value;
        var iepsStore=document.getElementById("DirectInvoice_ieps").value;
        var retivaStore=document.getElementById("DirectInvoice_retiva").value;
        var retisrStore=document.getElementById("DirectInvoice_retisr").value;
        var vatStore=document.getElementById("DirectInvoice_vat").value;
        var otherStore=document.getElementById("DirectInvoice_other").value;

        sumaDiscount=parseFloat(totaldiscount)+parseFloat(discountStore);
        sumaIeps=parseFloat(totalIeps)+parseFloat(iepsStore);
        sumaRetiva=parseFloat(totalRetiva)+parseFloat(retivaStore);
        sumaRetisr=parseFloat(totalRetisr)+parseFloat(retisrStore);
        sumaVat=parseFloat(totalVat)+parseFloat(vatStore);
        sumaOther=parseFloat(otherStore);

        document.getElementById("DirectInvoice_discount_sum").value=roundToTwo(sumaDiscount.toFixed(2));
        document.getElementById("DirectInvoice_ieps_sum").value=roundToTwo(sumaIeps.toFixed(2));
        document.getElementById("DirectInvoice_retiva_sum").value=roundToTwo(sumaRetiva.toFixed(2));
        document.getElementById("DirectInvoice_retisr_sum").value=roundToTwo(sumaRetisr.toFixed(2));
        document.getElementById("DirectInvoice_vat_sum").value=roundToTwo(sumaVat.toFixed(2));
        document.getElementById("DirectInvoice_other_sum").value=roundToTwo(sumaOther.toFixed(2));

        var sumasx=parseFloat(totalImporte)+parseFloat(sumaIeps)+parseFloat(sumaVat)+parseFloat(sumaOther);
        var restasx=parseFloat(sumaDiscount)+parseFloat(sumaRetiva)+parseFloat(sumaRetisr)

        grandTotal=sumasx-restasx;


        document.getElementById("DirectInvoice_grandTotal").value=grandTotal.toFixed(2);

    }

    function decrementa(){

        index--;
        return false;

    }
    function pruebax(){

        document.getElementById('name_articlex').readOnly = false;
        document.getElementById('name_storex').readOnly = false;
        document.getElementById('name_invoicex').readOnly = false;
        document.getElementById('quantityx').readOnly = false;
        document.getElementById('unit_measure_idx').readOnly = false;
        document.getElementById('pricex').readOnly = false;
        document.getElementById('codex').readOnly = false;
        document.getElementById('code_storex').readOnly = false;
        document.getElementById('code_invoicex').readOnly = false;
        document.getElementById('measurex').readOnly = false;
        document.getElementById('colorx').readOnly = false;
        document.getElementById('presentationx').readOnly = false;

    }

    function resetx(){
        document.getElementById('idx').value = "";
        document.getElementById('name_articlex').value = "";
        document.getElementById('name_storex').value = "";
        document.getElementById('name_invoicex').value = "";
        document.getElementById('quantityx').value = 0;
        document.getElementById('unit_measure_idx').value = 1;
        document.getElementById('pricex').value = 0;
        document.getElementById('codex').value = "";
        document.getElementById('code_storex').value = "";
        document.getElementById('code_invoicex').value = "";
        document.getElementById('measurex').value = "";
        document.getElementById('colorx').value = "";
        document.getElementById('presentationx').value = "";
    }

    function calcula(index){

        var discount=0;
        var discount_percent=0;
        var vat=0;
        var vat_percent=0;
        var ieps=0;
        var ieps_percent=0;
        var retiva=0;
        var retiva_percent=0;
        var retisr=0;
        var retisr_percent=0;


        if(index==1){


            var cantidad=document.getElementById("DirectInvoiceItems_quantity").value;
            cantidad=parseFloat(cantidad).toFixed(2);

            var precio=document.getElementById("DirectInvoiceItems_price").value;
            precio=parseFloat(precio).toFixed(2);

            var importe= cantidad * precio;

            document.getElementById("DirectInvoiceItems_amount").value=importe;

            discount=document.getElementById("DirectInvoiceItems_discount").value;

            discount_percent=document.getElementById("DirectInvoiceItems_discount_percent").value;

            if(discount==0){
                discount_percent=parseFloat(discount_percent).toFixed(2);
                discount=(importe*discount_percent)/100;
                discount=parseFloat(discount);
                discount_percent=parseFloat(discount_percent);

                document.getElementById("DirectInvoiceItems_discount").value=discount.toFixed(2);
            }else{
                discount=parseFloat(discount).toFixed(2);
                discount_percent=(discount*100)/importe;
                discount=parseFloat(discount);
                discount_percent=parseFloat(discount_percent);
                document.getElementById("DirectInvoiceItems_discount_percent").value=discount_percent.toFixed(2);
            }

            var subtotal=importe-discount;

            document.getElementById("DirectInvoiceItems_subtotal").value=subtotal.toFixed(2);

            vat=document.getElementById("DirectInvoiceItems_vat").value;
            if(vat=='')vat=0;
            vat_percent=document.getElementById("DirectInvoiceItems_vat_percent").value;
            if(vat_percent=='')vat_percent=0;
            ieps=document.getElementById("DirectInvoiceItems_ieps").value;
            if(ieps=='')ieps=0;
            ieps_percent=document.getElementById("DirectInvoiceItems_ieps_percent").value;
            if(ieps_percent=='')ieps_percent=0;
            retiva=document.getElementById("DirectInvoiceItems_retiva").value;
            if(retiva=='')retiva=0;
            retiva_percent=document.getElementById("DirectInvoiceItems_retiva_percent").value;
            if(retiva_percent=='')retiva_percent=0;
            retisr=document.getElementById("DirectInvoiceItems_retisr").value;
            if(retisr=='')retisr=0;
            retisr_percent=document.getElementById("DirectInvoiceItems_retisr_percent").value;
            if(retisr_percent=='')retisr_percent=0;


            if(vat==0){
                vat=0;
                vat_percent=parseFloat(vat_percent).toFixed(2);
                vat=(importe*vat_percent)/100;
                vat=parseFloat(vat);
                vat_percent=parseFloat(vat_percent);
                document.getElementById("DirectInvoiceItems_vat").value=vat.toFixed(2);
            }else{
                vat_percent=0;
                vat=parseFloat(vat).toFixed(2);
                vat_percent=(vat*100)/importe;
                vat_percent=parseFloat(vat_percent);
                vat=parseFloat(vat);
                document.getElementById("DirectInvoiceItems_vat_percent").value=vat_percent.toFixed(2);
            }


            if(ieps==0){
                ieps=0;
                ieps_percent=parseFloat(ieps_percent).toFixed(2);
                ieps=(importe*ieps_percent)/100;
                ieps=parseFloat(ieps);
                ieps_percent=parseFloat(ieps_percent);
                document.getElementById("DirectInvoiceItems_ieps").value=ieps.toFixed(2);
            }else{
                ieps_percent=0;
                ieps=parseFloat(ieps).toFixed(2);
                ieps_percent=(ieps*100)/importe;
                ieps_percent=parseFloat(ieps_percent);
                ieps=parseFloat(ieps);
                document.getElementById("DirectInvoiceItems_ieps_percent").value=ieps_percent.toFixed(2);
            }


            if(retiva==0){
                retiva=0;
                retiva_percent=parseFloat(retiva_percent).toFixed(2);
                retiva=(importe*retiva_percent)/100;
                retiva=parseFloat(retiva);
                retiva_percent=parseFloat(retiva_percent);
                document.getElementById("DirectInvoiceItems_retiva").value=retiva.toFixed(2);
            }else{
                retiva_percent=0;
                retiva=parseFloat(retiva).toFixed(2);
                retiva_percent=(retiva*100)/importe;
                retiva_percent=parseFloat(retiva_percent);
                retiva=parseFloat(retiva);
                document.getElementById("DirectInvoiceItems_retiva_percent").value=retiva_percent.toFixed(2);
            }

            if(retisr==0){
                retisr=0;
                retisr_percent=parseFloat(retisr_percent).toFixed(2);
                retisr=(importe*retisr_percent)/100;
                retisr_percent=parseFloat(retisr_percent);
                document.getElementById("DirectInvoiceItems_retisr").value=retisr.toFixed(2);
            }else{
                retisr_percent=0;
                retisr=parseFloat(retisr).toFixed(2);
                retisr_percent=(retisr*100)/importe;
                retisr_percent=parseFloat(retisr_percent);
                retisr=parseFloat(retisr);
                document.getElementById("DirectInvoiceItems_retisr_percent").value=retisr_percent.toFixed(2);
            }

            var total=subtotal+vat+ieps-retiva-retisr;

            document.getElementById("DirectInvoiceItems_total").value=total.toFixed(2);


        }else{


            var cantidad=document.getElementById("DirectInvoiceItems_quantity"+index).value;
            cantidad=parseFloat(cantidad).toFixed(2);

            var precio=document.getElementById("DirectInvoiceItems_price"+index).value;
            precio=parseFloat(precio).toFixed(2);

            var importe= cantidad * precio;

            document.getElementById("DirectInvoiceItems_amount"+index).value=importe;

            discount=document.getElementById("DirectInvoiceItems_discount"+index).value;
            if(discount=='') discount=0;
            discount_percent=document.getElementById("DirectInvoiceItems_discount_percent"+index).value;
            if(discount_percent=='') discount_percent=0;

            if(discount==0){
                discount_percent=parseFloat(discount_percent).toFixed(2);
                discount=(importe*discount_percent)/100;
                discount_percent=parseFloat(discount_percent);
                discount=parseFloat(discount);
                discount_percent=parseFloat(discount_percent);
                document.getElementById("DirectInvoiceItems_discount"+index).value=discount.toFixed(2);
            }else{
                discount=parseFloat(discount).toFixed(2);
                discount_percent=(discount*100)/importe;
                discount=parseFloat(discount);
                discount=parseFloat(discount);
                discount_percent=parseFloat(discount_percent);
                document.getElementById("DirectInvoiceItems_discount_percent"+index).value=discount_percent.toFixed(2);
            }

            var subtotal=importe-discount;

            document.getElementById("DirectInvoiceItems_subtotal"+index).value=subtotal.toFixed(2);

            vat=document.getElementById("DirectInvoiceItems_vat"+index).value;
            if(vat=='')vat=0;
            vat_percent=document.getElementById("DirectInvoiceItems_vat_percent"+index).value;
            if(vat_percent=='')vat_percent=0;
            ieps=document.getElementById("DirectInvoiceItems_ieps"+index).value;
            if(ieps=='')ieps=0;
            ieps_percent=document.getElementById("DirectInvoiceItems_ieps_percent"+index).value;
            if(ieps_percent=='')ieps_percent=0;
            retiva=document.getElementById("DirectInvoiceItems_retiva"+index).value;
            if(retiva=='')retiva=0;
            retiva_percent=document.getElementById("DirectInvoiceItems_retiva_percent"+index).value;
            if(retiva_percent=='')retiva_percent=0;
            retisr=document.getElementById("DirectInvoiceItems_retisr"+index).value;
            if(retisr=='')retisr=0;
            retisr_percent=document.getElementById("DirectInvoiceItems_retisr_percent"+index).value;
            if(retisr_percent=='')retisr_percent=0;


            if(vat==0){
                vat=0;
                vat_percent=parseFloat(vat_percent).toFixed(2);
                vat=(importe*vat_percent)/100;
                vat=parseFloat(vat);
                vat_percent=parseFloat(vat_percent);
                document.getElementById("DirectInvoiceItems_vat"+index).value=vat.toFixed(2);
            }else{
                vat_percent=0;
                vat=parseFloat(vat).toFixed(2);
                vat_percent=(vat*100)/importe;
                vat_percent=parseFloat(vat_percent);
                vat=parseFloat(vat);
                document.getElementById("DirectInvoiceItems_vat_percent"+index).value=vat_percent.toFixed(2);
            }

            if(ieps==0){
                ieps=0;
                ieps_percent=parseFloat(ieps_percent).toFixed(2);
                ieps=(importe*ieps_percent)/100;
                ieps=parseFloat(ieps);
                ieps_percent=parseFloat(ieps_percent);
                document.getElementById("DirectInvoiceItems_ieps"+index).value=ieps.toFixed(2);
            }else{
                ieps_percent=0;
                ieps=parseFloat(ieps).toFixed(2);
                ieps_percent=(ieps*100)/importe;
                ieps_percent=parseFloat(ieps_percent);
                ieps=parseFloat(ieps);
                document.getElementById("DirectInvoiceItems_ieps_percent"+index).value=ieps_percent.toFixed(2);
            }

            if(retiva==0){
                retiva=0;
                retiva_percent=parseFloat(retiva_percent).toFixed(2);
                retiva=(importe*retiva_percent)/100;
                retiva=parseFloat(retiva);
                retiva_percent=parseFloat(retiva_percent);
                document.getElementById("DirectInvoiceItems_retiva"+index).value=retiva.toFixed(2);
            }else{
                retiva_percent=0;
                retiva=parseFloat(retiva).toFixed(2);
                retiva_percent=(retiva*100)/importe;
                retiva_percent=parseFloat(retiva_percent);
                retiva=parseFloat(retiva);
                document.getElementById("DirectInvoiceItems_retiva_percent"+index).value=retiva_percent.toFixed(2);
            }

            if(retisr==0){
                retisr=0;
                retisr_percent=parseFloat(retisr_percent).toFixed(2);
                retisr=(importe*retisr_percent)/100;
                retisr_percent=parseFloat(retisr_percent);
                document.getElementById("DirectInvoiceItems_retisr"+index).value=retisr.toFixed(2);
            }else{
                retisr_percent=0;
                retisr=parseFloat(retisr).toFixed(2);
                retisr_percent=(retisr*100)/importe;
                retisr_percent=parseFloat(retisr_percent);
                retisr=parseFloat(retisr);
                document.getElementById("DirectInvoiceItems_retisr_percent"+index).value=retisr_percent.toFixed(2);
            }

            var total=subtotal+vat+ieps-retiva-retisr;

            document.getElementById("DirectInvoiceItems_total"+index).value=total.toFixed(2);

        }
    }

</script>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'direct-invoice-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

<div class="container-fluid">
    <div class="span3">
        <?php echo $form->datepickerRow($model, 'datex',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array(
                //'dateFormat'=>'dd-M-yy',
                'format'=>'dd-M-yyyy',
                'autoclose'=>true
            ),
        ));
        ?>

        <?php echo $form->dropDownListRow($model,'document_type_id',DocumentTypes::model()->listAll(),
            array('prompt'=>Yii::t('mx','Select'))
        ); ?>

        <?php echo $form->textFieldRow($model,'n_invoice',array('prepend'=>'#')); ?>


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
                            $("#DirectInvoice_article_id").html(data.articles);
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
                        $("#idx").val(data.id);
                        $("#name_articlex").val(data.name_article);
                        $("#name_storex").val(data.name_store);
                        $("#name_invoicex").val(data.name_invoice);
                        $("#quantityx").val(data.quantity);
                        $("#unit_measure_idx").val(data.unit_measure_id);
                        $("#pricex").val(data.price);

                        $("#codex").val(data.code);
                        $("#code_storex").val(data.code_store);
                        $("#code_invoicex").val(data.code_invoice);
                        $("#measurex").val(data.measure);
                        $("#colorx").val(data.color);
                        $("#presentationx").val(data.presentation);


                        if(index==1){
                            $("#DirectInvoiceItems_article_id").val(data.id);
                            $("#DirectInvoiceItems_unit_measure_id").val(data.unit_measure_id);
                            $("#DirectInvoiceItems_code_invoice").val(data.code_invoice);
                            $("#DirectInvoiceItems_presentation").val(data.presentation);
                            $("#DirectInvoiceItems_price").val(data.price);

                        }else{
                            $("#DirectInvoiceItems_article_id"+index).val(data.id);
                            $("#DirectInvoiceItems_unit_measure_id"+index).val(data.unit_measure_id);
                            $("#DirectInvoiceItems_code_invoice"+index).val(data.code_invoice);
                            $("#DirectInvoiceItems_presentation"+index).val(data.presentation);
                            $("#DirectInvoiceItems_price"+index).val(data.price);
                        }


                    })

                    .fail(function() { bootbox.alert("Error"); })
                    .always(function() {});
                }'
            ),

        ));
        ?>


    </div>



            <div class="span4">

                <?php echo CHtml::hiddenField('idx',''); ?>

                <?php echo CHtml::label(Yii::t('mx','Name Article'),'name_articlex'); ?>
                <?php echo CHtml::textField('name_articlex','',array('readonly'=>'readonly')); ?>

                <?php echo CHtml::label(Yii::t('mx','Name Store'),'name_storex'); ?>
                <?php echo CHtml::textField('name_storex','',array('readonly'=>'readonly')); ?>

                <?php echo CHtml::label(Yii::t('mx','Name Invoice'),'name_invoicex'); ?>
                <?php echo CHtml::textField('name_invoicex','',array('readonly'=>'readonly')); ?>

                <?php echo CHtml::label(Yii::t('mx','Quantity'),'quantityx'); ?>
                <?php echo CHtml::textField('quantityx','',array('readonly'=>'readonly')); ?>

                <?php echo CHtml::label(Yii::t('mx','Unit Of Measure'),'unit_measure_idx'); ?>
                <?php echo CHtml::dropDownList('unit_measure_idx','',UnitsMeasurement::model()->listAll()) ?>

                <?php echo CHtml::label(Yii::t('mx','Price'),'pricex'); ?>
                <?php echo CHtml::textField('pricex','',array('readonly'=>'readonly')); ?>

            </div>
            <div class="span4">
                <?php echo CHtml::label(Yii::t('mx','Code'),'codex'); ?>
                <?php echo CHtml::textField('codex','',array('readonly'=>'readonly')); ?>

                <?php echo CHtml::label(Yii::t('mx','Code Store'),'code_storex'); ?>
                <?php echo CHtml::textField('code_storex','',array('readonly'=>'readonly')); ?>

                <?php echo CHtml::label(Yii::t('mx','Code Invoice'),'code_invoicex'); ?>
                <?php echo CHtml::textField('code_invoicex','',array('readonly'=>'readonly')); ?>

                <?php echo CHtml::label(Yii::t('mx','Measure'),'measurex'); ?>
                <?php echo CHtml::textField('measurex','',array('readonly'=>'readonly')); ?>

                <?php echo CHtml::label(Yii::t('mx','Color'),'colorx'); ?>
                <?php echo CHtml::textField('colorx','',array('readonly'=>'readonly')); ?>

                <?php echo CHtml::label(Yii::t('mx','Presentation'),'presentationx'); ?>
                <?php echo CHtml::textField('presentationx','',array('readonly'=>'readonly')); ?>


                <div class="form-actions">
                    <?php  $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'button',
                        'type'=>'primary',
                        'icon'=>'icon-ok icon-white',
                        'label'=>Yii::t('mx','Edit'),
                        'htmlOptions'=>array(
                            'onclick'=>'pruebax();'
                        )
                    )); ?>

                    <?php  $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'button',
                        'type'=>'primary',
                        'icon'=>'icon-plus icon-white',
                        'label'=>Yii::t('mx','New'),
                        'url'=>Yii::app()->createUrl('/articles/newArticle'),
                        'htmlOptions'=>array(
                            'onClick'=>'pruebax();  resetx();'
                        ),

                    )); ?>
                    <?php  $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'ajaxSubmit',
                        'type'=>'primary',
                        'icon'=>'icon-save icon-white',
                        'label'=>Yii::t('mx','Save'),
                        'url'=>Yii::app()->createUrl('/articles/saveArticle'),
                        'ajaxOptions' => array(
                            'dataType'=>'json',
                            'type'=>'POST',
                            'beforeSend' => 'function() { $("#edit-form").addClass("saving"); }',
                            'complete' => 'function() { $("#edit-form").removeClass("saving"); }',
                            'success' =>'function(data){
                                if(data.ok==true){

                                    $("#DirectInvoice_article_id").html(data.articles);

                                    $("#name_articlex").attr("readonly", true);
                                    $("#name_storex").attr("readonly", true);
                                    $("#name_invoicex").attr("readonly", true);
                                    $("#quantityx").attr("readonly", true);
                                    $("#unit_measure_idx").attr("readonly", true);
                                    $("#pricex").attr("readonly", true);
                                    $("#codex").attr("readonly", true);
                                    $("#code_storex").attr("readonly", true);
                                    $("#code_invoicex").attr("readonly", true);
                                    $("#measurex").attr("readonly", true);
                                    $("#colorx").attr("readonly", true);
                                    $("#presentationx").attr("readonly", true);

                                }else{

                                    bootbox.alert(data.msg);
                                }
                            }',
                        ),
                    )); ?>

                </div>
            </div>



</div>


    <?php $this->widget('ext.jqrelcopy.JQRelcopy',array(
        'id' => 'copylink',
        'removeText' => Yii::t('mx','Remove'),
        'removeHtmlOptions' => array(
            'class'=>'btn btn-danger',
        ),
        'jsBeforeClone' => '
            index++;
        ',
        'options' => array(
            'copyClass'=>'newcopy',
            'clearInputs'=>true,
        )
    ));


    ?>

    <div id="direct-invoice-grid" class="grid-view">
        <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
            'title' => Yii::t('mx', 'Direct Invoice'),
            'headerIcon' => 'icon-th-list',
            'htmlOptions' => array('class'=>'bootstrap-widget-table'),
            'htmlContentOptions'=>array('class'=>'box-content nopadding'),

        ));?>
            <table class="items table table-hover table-condensed">
                <thead>
                    <tr>
                        <th><?php echo $a1; ?></th>
                        <th><?php echo $a2; ?></th>
                        <th><?php echo $a3; ?></th>
                        <th><?php echo $a4; ?></th>
                        <th><?php echo $a5; ?></th>
                        <th><?php echo $a6; ?></th>
                        <th><?php echo $a7; ?></th>
                        <th><?php echo $a8; ?></th>
                        <th><?php echo $a9; ?></th>
                        <th><?php echo $a10; ?></th>
                        <th><?php echo $a11; ?></th>
                        <th><?php echo $a12; ?></th>

                    </tr>
                </thead>

                <tbody>
                    <tr class="copy">
                        <?php echo $form->hiddenField($items,"article_id[]",array()); ?>
                        <td><?php echo $form->textField($items,"quantity[]",array('class'=>'span12','placeholder'=>Yii::t('mx','Quantity'))); ?></td>
                        <td><?php echo $form->textField($items,"presentation[]",array('class'=>'span12','placeholder'=>Yii::t('mx','Presentation'))); ?></td>
                        <td><?php echo $form->textField($items,"price[]",array('class'=>'span12','placeholder'=>Yii::t('mx','Price'))); ?></td>
                        <td><?php echo $form->textField($items,"amount[]",array('class'=>'span12','placeholder'=>Yii::t('mx','Amount'))); ?></td>
                        <td>
                            <?php echo $form->textField($items,"discount[]",array('value'=>0,'class'=>'span12','placeholder'=>Yii::t('mx','Discount'))); ?>
                            <?php echo $form->textField($items,"discount_percent[]",array('value'=>0,'class'=>'span12','placeholder'=>Yii::t('mx','Discount Percent'))); ?>
                        </td>
                        <td><?php echo $form->textField($items,"subtotal[]",array('class'=>'span12','placeholder'=>Yii::t('mx','Subtotal'))); ?></td>
                        <td>
                            <?php echo $form->textField($items,"vat[]",array('value'=>0,'class'=>'span12','placeholder'=>Yii::t('mx','VAT'))); ?>
                            <?php echo $form->textField($items,"vat_percent[]",array('value'=>0,'class'=>'span12','placeholder'=>Yii::t('mx','VAT Percent'))); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($items,"ieps[]",array('value'=>0,'class'=>'span12','placeholder'=>Yii::t('mx','IEPS'))); ?>
                            <?php echo $form->textField($items,"ieps_percent[]",array('value'=>0,'class'=>'span12','placeholder'=>Yii::t('mx','IEPS Percent'))); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($items,"retiva[]",array('value'=>0,'class'=>'span12','placeholder'=>Yii::t('mx','Retention VAT'))); ?>
                            <?php echo $form->textField($items,"retiva_percent[]",array('value'=>0,'class'=>'span12','placeholder'=>Yii::t('mx','Retention VAT Percent'))); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($items,"retisr[]",array('value'=>0,'class'=>'span12','placeholder'=>Yii::t('mx','Retention ISR'))); ?>
                            <?php echo $form->textField($items,"retisr_percent[]",array('value'=>0,'class'=>'span12','placeholder'=>Yii::t('mx','Retention ISR Percent'))); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($items,"total[]",array('class'=>'span12','placeholder'=>Yii::t('mx','Total'))); ?>
                        </td>
                        <td><?php echo CHtml::htmlButton('<i class="icon-ok"></i>',array('id'=>'calc','href'=>'#','class'=>'btn btn-primary','onclick'=>'calcula(index);')); ?></td>
                    </tr>
                </tbody>
            </table>
            <?php echo CHtml::button(Yii::t('mx','Add'),array(
                'id'=>'copylink',
                'href'=>'#',
                'rel'=>'.copy',
                'class'=>'btn btn-primary',
            )); ?>
        <?php $this->endWidget();?>

    </div>



    <table align="right" cellpadding="1" cellspacing="1">
        <thead>
        <tr>
            <th scope="col">&nbsp;</th>
            <th scope="col"><?php echo Yii::t('mx','Article'); ?></th>
            <th scope="col"><?php echo Yii::t('mx','Shop'); ?></th>
            <th scope="col"><?php echo Yii::t('mx','Sum'); ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php echo Yii::t('mx','Amount'); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $form->textField($model,'totalAmount',array('readonly'=>'readonly')); ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('mx','Discount'); ?></td>
            <td><?php echo $form->textField($model,'discount_article',array('readonly'=>'readonly')); ?></td>
            <td><?php echo $form->textField($model,'discount',array('value'=>'0.00')); ?></td>
            <td><?php echo $form->textField($model,'discount_sum',array('readonly'=>'readonly')); ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('mx','IEPS'); ?></td>
            <td><?php echo $form->textField($model,'ieps_article',array('readonly'=>'readonly')); ?></td>
            <td><?php echo $form->textField($model,'ieps',array('prepend'=>'$')); ?></td>
            <td><?php echo $form->textField($model,'ieps_sum',array('readonly'=>'readonly')); ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('mx','Retention VAT'); ?></td>
            <td><?php echo $form->textField($model,'retiva_article',array('readonly'=>'readonly')); ?></td>
            <td><?php echo $form->textField($model,'retiva',array('prepend'=>'$')); ?></td>
            <td><?php echo $form->textField($model,'retiva_sum',array('readonly'=>'readonly')); ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('mx','Retention ISR'); ?></td>
            <td><?php echo $form->textField($model,'retisr_article',array('readonly'=>'readonly')); ?></td>
            <td><?php echo $form->textField($model,'retisr',array('prepend'=>'$')); ?></td>
            <td><?php echo $form->textField($model,'retisr_sum',array('readonly'=>'readonly')); ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('mx','VAT'); ?></td>
            <td><?php echo $form->textField($model,'vat_article',array('readonly'=>'readonly')); ?></td>
            <td><?php echo $form->textField($model,'vat',array('prepend'=>'$')); ?></td>
            <td><?php echo $form->textField($model,'vat_sum',array('readonly'=>'readonly')); ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('mx','Others'); ?></td>
            <td><?php echo $form->textField($model,'other_article',array('readonly'=>'readonly')); ?></td>
            <td><?php echo $form->textField($model,'other',array('prepend'=>'$')); ?></td>
            <td><?php echo $form->textField($model,'other_sum',array('readonly'=>'readonly')); ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('mx','Total'); ?></td>
            <td>
                <?php  $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'button',
                    'type'=>'primary',
                    'icon'=>'icon-ok icon-white',
                    'label'=>Yii::t('mx','Calcular'),
                    'htmlOptions'=>array(
                        'onclick'=>'calculaFactura();'
                    )
                )); ?>
            </td>
            <td>
                <?php  $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
                    'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
                )); ?>
            </td>
            <td><?php echo $form->textField($model,'grandTotal',array('readonly'=>'readonly')); ?></td>
        </tr>
        </tbody>
    </table>





<?php $this->endWidget(); ?>
