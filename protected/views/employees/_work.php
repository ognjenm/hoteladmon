<?php
/**
 * Created by PhpStorm.
 * User: chinuxe
 * Date: 16/04/14
 * email: chinuxe@gmail.com
 */
?>


<div class="row-fluid">
    <div class="span6">
        <?php echo $form->textFieldRow($model,'company',array('class'=>'span5','maxlength'=>150)); ?>
        <?php echo $form->textFieldRow($model,'rfc',array('class'=>'span5','maxlength'=>25)); ?>
        <?php echo $form->textFieldRow($model,'curp',array('class'=>'span5','maxlength'=>25)); ?>
        <?php echo $form->textFieldRow($model,'nss',array('class'=>'span5','maxlength'=>25)); ?>
        <?php echo $form->textFieldRow($model,'key_voter',array('class'=>'span5','maxlength'=>50)); ?>
        <?php echo $form->textFieldRow($model,'n_card',array('class'=>'span5','maxlength'=>50)); ?>
        <?php echo $form->textFieldRow($model,'cedula',array('class'=>'span5','maxlength'=>50)); ?>
        <?php echo $form->datepickerRow($model, 'real_ingress',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array(
                'format'=>'dd-M-yyyy',
                'autoclose'=>true
            ),
        ));
        ?>
        <?php echo $form->datepickerRow($model, 'ingress_ss',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array(
                'format'=>'dd-M-yyyy',
                'autoclose'=>true
            ),
        ));
        ?>
        <?php echo $form->textFieldRow($model,'payment_type',array('class'=>'span5','maxlength'=>50)); ?>
    </div>
    <div class="span6">
        <?php echo $form->datepickerRow($model, 'output_date_r',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array(
                'format'=>'dd-M-yyyy',
                'autoclose'=>true
            ),
        ));
        ?>
        <?php echo $form->datepickerRow($model, 'output_date_ss',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array(
                'format'=>'dd-M-yyyy',
                'autoclose'=>true
            ),
        ));
        ?>

        <div class="control-group ">
            <label class="control-label" for="Employees_have_contrac"><?php echo Yii::t('mx','Have Contract'); ?></label>
            <div class="controls">
                <?php $this->widget('bootstrap.widgets.TbToggleButton',array(
                    'model' => $model,
                    'attribute'=>'have_contract',
                    'enabledLabel'=>Yii::t('mx','Yes'),
                    'disabledLabel'=>Yii::t('mx','No'),
                ));
                ?>
            </div>
        </div>

        <?php echo $form->datepickerRow($model, 'contract_start',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array(
                'format'=>'dd-M-yyyy',
                'autoclose'=>true
            ),
        ));
        ?>
        <?php echo $form->datepickerRow($model, 'contract_end',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array(
                'format'=>'dd-M-yyyy',
                'autoclose'=>true
            ),
        ));
        ?>

        <?php echo $form->textFieldRow($model,'contract_duration',array('class'=>'span5','maxlength'=>20)); ?>
        <?php echo $form->textFieldRow($model,'test_period',array('class'=>'span5','maxlength'=>20)); ?>
        <?php echo $form->datepickerRow($model, 'start_test_period',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array(
                'format'=>'dd-M-yyyy',
                'autoclose'=>true
            ),
        ));
        ?>
        <?php echo $form->datepickerRow($model, 'end_test_period',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array(
                'format'=>'dd-M-yyyy',
                'autoclose'=>true
            ),
        ));
        ?>
    </div>

</div>



