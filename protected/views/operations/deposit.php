<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 26/02/14
 * Time: 17:58
 */
?>


<?php
$this->breadcrumbs=array(
    'Operations'=>array('index'),
    Yii::t('mx','Deposit'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Bank Account Deposit');
$this->pageIcon='icon-ok';

?>

<?php echo Yii::app()->user->setFlash('info',"<h3>".$display."</h3>"); ?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true,
    'fade'=>true,
    'closeText'=>'×',
    'alerts'=>array('info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×')),
));
?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'operations-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

    <?php echo $form->errorSummary($model); ?>


    <?php echo $form->datepickerRow($model,'datex',array(
        'prepend'=>'<i class="icon-calendar"></i>',
        'options'=>array(
            'format'=>'yyyy-M-dd',
            'autoclose'=>true
        )
    )); ?>

    <?php echo $form->dropDownListRow($model,'payment_type',PaymentsTypes::model()->listAll(),array(
        'class'=>'span5',
        'prompt'=>Yii::t('mx','Select'),
        'onchange'=>'
            if($(this).val()==3 || $(this).val()==4){
               $("#commissionDiv").show();
            }else{
                $("#commissionDiv").hide();
            }
        '
    )); ?>

    <?php echo $form->textFieldRow($model,'person',array('class'=>'span5','maxlength'=>100)); ?>

    <?php echo $form->textFieldRow($model,'concept',array('class'=>'span5','maxlength'=>100)); ?>

    <?php echo $form->textFieldRow($model,'bank_concept',array('class'=>'span5','maxlength'=>100)); ?>

    <div class="control-group">
        <div class="input-append">
            <?php echo $form->textFieldRow($model,'deposit',array('prepend'=>'$')); ?>
            <?php  $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'button',
                'label'=>'*',
                'type'=>'primary',
                'icon'=>'icon-cogs',
                'htmlOptions' => array(
                    'title'=>Yii::t('mx','Calculate commission'),
                    'onclick' => '

                        if($("#Operations_payment_type").val()==3){ //debito

                            var cantidad=$("#Operations_deposit").val();
                            var commission=(cantidad*2)/100;
                            commission=commission.toFixed(2);

                            $("#Operations_commission_fee").val(commission);
                            var vat_commission=(commission*16)/100;
                            vat_commission=vat_commission.toFixed(2);

                            $("#Operations_vat_commission").val(vat_commission);
                        }

                         if($("#Operations_payment_type").val()==4){ //credito

                            var cantidad=$("#Operations_deposit").val();
                            var commission=(cantidad*2.5)/100;
                            commission=commission.toFixed(2);

                            $("#Operations_commission_fee").val(commission);
                            var vat_commission=(commission*16)/100;
                            vat_commission=vat_commission.toFixed(2);

                            $("#Operations_vat_commission").val(vat_commission);

                        }

                    '
                ),
            )); ?>
        </div>
    </div>

    <div id="commissionDiv" style="display: none">
        <?php echo $form->textFieldRow($model,'commission_fee',array('prepend'=>'$')); ?>
        <?php echo $form->textFieldRow($model,'vat_commission',array('prepend'=>'$')); ?>
    </div>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
