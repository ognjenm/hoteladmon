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
    Yii::t('mx','Operations')=>array('index'),
    Yii::t('mx','Payment'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Cuenta Bancaria Pago');
$this->pageIcon='icon-ok';


    Yii::app()->clientScript->registerScript('selectx', "

            $('.select-on-check').click(function(){

                alert('hola...');

            });
    ");

?>

<?php echo Yii::app()->user->setFlash('info',"<h3>".$display."</h3>"); ?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true,
    'fade'=>true,
    'closeText'=>'×',
    'alerts'=>array('info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×')),
));
?>


<div class="row-fluid">
    <div class="span4">

        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'operations-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <?php echo $form->errorSummary($model); ?>


        <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
            <span class="required">*</span>
            <?php echo Yii::t('mx','are required');?>.
        </p>

        <?php echo $form->datepickerRow($model,'datex',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array(
                'format'=>'yyyy-M-dd',
                'autoclose'=>true
            )
        )); ?>

        <?php echo $form->dropDownListRow($model,'payment_type',PaymentsTypes::model()->listAll(),array(
            'class'=>'span12',
            'prompt'=>Yii::t('mx','Select')
        )); ?>

        <?php /*echo $form->dropDownListRow($model,'account_id',BankAccounts::model()->listAll(),array(
    'class'=>'span5',
    'prompt'=>Yii::t('mx','Select')
));*/  ?>

        <?php echo CHtml::label(Yii::t('mx','Payment To'),'pagar_a'); ?>
        <?php echo CHtml::dropDownList('pagar_a','',array(1=>Yii::t('mx','Provider'),2=>Yii::t('mx','Other')),array(
            'class'=>'span12',
            'prompt'=>Yii::t('mx','Select'),
            'onchange'=>'
                    if($(this).val()==1){
                        $("#divperson").show();
                        $("#divother").hide();
                    }else{
                            $("#divother").show();
                            $("#divperson").hide();
                    }
                '
        )); ?>

        <div id="divperson" style="display: none">

            <?php echo $form->select2Row($model, 'released',
                array(
                    'data' =>Providers::model()->listAllOrganization(),
                    'options' => array(
                        'placeholder' =>Yii::t('mx','Select'),
                        'allowClear' => true,
                        'width' => '100%'
                    ),
                    'events' =>array(
                        'change'=>'js:function(e){
                            $.fn.yiiGridView.update("direct-invoice-grid", {
                                data: { provider_id: $(this).val()  }
                            })
                        }'
                    ),
                )
            );

            ?>


        </div>

        <div id="divother" style="display: none">
            <?php echo CHtml::label(Yii::t('mx','Released To'),'name'); ?>
            <?php echo CHtml::textField('name','',array('class'=>'span12')); ?>
        </div>

        <?php echo $form->textFieldRow($model,'concept',array('class'=>'span12','maxlength'=>100)); ?>

        <?php echo $form->textFieldRow($model,'bank_concept',array('class'=>'span12','maxlength'=>100)); ?>

        <?php echo $form->textFieldRow($model,'retirement',array('class'=>'span12','prepend'=>'$')); ?>


        <div class="form-actions">
            <?php  $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
                'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
            )); ?>
        </div>


        <?php $this->endWidget(); ?>

    </div>
    <div class="span6">
        <?php $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'direct-invoice-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no invoices to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Direct Invoices').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$invoice,
            //'rowHtmlOptionsExpression'=>'array("data-id"=>$data->id)',
            'pager' => array(
                'class' => 'bootstrap.widgets.TbPager',
                'displayFirstAndLast' => true,
                'lastPageLabel'=>Yii::t('mx','Last'),
                'firstPageLabel'=>Yii::t('mx','First'),
            ),
            'selectableRows'=>1,
            'columns'=>array(
                array(
                    'id'=>'chk',
                    'class'=>'CCheckBoxColumn'
                ),
                'datex',
                'n_invoice',
                array(
                    'name'=>'total',
                    'value'=>'"$".number_format($data->total,2)'
                ),

            ),
        ));
        ?>
    </div>
</div>