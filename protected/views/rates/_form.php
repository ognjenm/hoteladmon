<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'rates-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php

$pricesForm = array(

    'elements'=>array(
        'pax'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Pax'),
            'class'=>'span3'
        ),
        'price'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Price'),
            'size'=>'10',
            'class'=>'span3',
        ),
    ));

?>

	<p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->dropDownListRow($model,'service_type',Rates::model()->listServiceType(),array(
        'class'=>'span5',
        'prompt'=>Yii::t('mx','Select'),
        ));
    ?>

    <?php echo $form->dropDownListRow($model,'room_type_id',RoomsType::model()->listAllRoomsTypes(),array(
            'class'=>'span5',
            'prompt'=>Yii::t('mx','Select'),
            ));
    ?>

    <?php echo $form->dropDownListRow($model,'season',array('ALTA'=>'ALTA','BAJA'=>'BAJA'),array(
            'class'=>'span5',
            'prompt'=>Yii::t('mx','Select Season')
        ));
    ?>

    <?php echo $form->dropDownListRow($model,'type_reservation_id',TypeReservation::model()->listAllTypeReservations(),array(
            'class'=>'span5',
            'prompt'=>Yii::t('mx','Select'),
            'onchange'=>"

                    var reservationType=$(this).val();

                    if(reservationType==1){
                        $('#pricexpax').show();
                        $('#childrendiv').hide();
                        $('#pricexroom').hide();
                    }

                    if(reservationType==2){
                        $('#pricexroom').show();
                        $('#pricexpax').hide();
                        $('#childrendiv').hide();
                    }

                    if(reservationType==3){
                        $('#childrendiv').show();
                        $('#pricexpax').hide();
                        $('#pricexroom').hide();
                    }
                "
            ));
    ?>

    <?php if($model->isNewRecord): ?>

        <div class="control-group" style="display: none;" id="pricexroom">
            <?php echo $form->textFieldRow($model,'price',array('class'=>'span10','maxlength'=>10,'prepend'=>'$')); ?>
        </div>

        <div class="control-group" style="display: none;" id="childrendiv">
            <?php echo $form->textFieldRow($model,'adults',array('class'=>'span10','maxlength'=>10,'prepend'=>'$')); ?>
            <?php echo $form->textFieldRow($model,'children',array('class'=>'span10','maxlength'=>10,'prepend'=>'$')); ?>
        </div>


        <div class="control-group" style="display: none;" id="pricexpax">

            <?php 	$this->widget('ext.multimodelform.MultiModelForm',array(
                        'id' => 'id_member',
                        'formConfig' => $pricesForm,
                        'model' =>$prices,
                        'tableView' => true,
                        'validatedItems' => $validatedMembers,
                        'removeText' =>Yii::t('mx','Remove'),
                        'removeConfirm'=>Yii::t('mx','Delete this item?'),
                        'addItemText'=>Yii::t('mx','Add Item'),
                        'tableView'=>true,
                        'tableHtmlOptions'=>array('class'=>'items table table-hover table-condensed'),
                        'data' => $prices->findAll('rate_id=:groupId', array(':groupId'=>$model->id)),
                        'showErrorSummary'=>true
                    ));
            ?>

        </div>

        <?php

                elseif($model->type_reservation_id==1):

                    $this->widget('ext.multimodelform.MultiModelForm',array(
                        'id' => 'id_member',
                        'formConfig' => $pricesForm,
                        'model' =>$prices,
                        'tableView' => true,
                        'validatedItems' => $validatedMembers,
                        'removeText' =>Yii::t('mx','Remove'),
                        'removeConfirm'=>Yii::t('mx','Delete this item?'),
                        'addItemText'=>Yii::t('mx','Add Item'),
                        'tableView'=>true,
                        'tableHtmlOptions'=>array('class'=>'items table table-hover table-condensed'),
                        'data' => $prices->findAll('rate_id=:groupId', array(':groupId'=>$model->id)),
                        'showErrorSummary'=>true
                    ));

                elseif($model->type_reservation_id==2): echo $form->textFieldRow($model,'price',array('class'=>'span10','maxlength'=>10,'prepend'=>'$'));
                elseif($model->type_reservation_id==3): {
                    echo  $form->textFieldRow($model,'adults',array('class'=>'span10','maxlength'=>10,'prepend'=>'$'));
                    echo  $form->textFieldRow($model,'children',array('class'=>'span10','maxlength'=>10,'prepend'=>'$'));
                }

                endif;

        ?>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>$model->isNewRecord ? 'icon-plus' : 'icon-ok',
        'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save')
    )); ?>
</div>


<?php $this->endWidget(); ?>
