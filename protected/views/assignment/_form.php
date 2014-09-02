<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'assignment-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

    <?php  if($model->isNewRecord){

       echo $form->datepickerRow($model, 'date_assignment',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array(
                'format'=>'dd-M-yyyy',
                'autoclose'=>true
            ),
        ));

        echo $form->select2Row($model, 'employeed_id',
            array(
                'data' => Employees::model()->listAll(),
                'options' => array(
                    'placeholder' =>Yii::t('mx','Select'),
                    'allowClear' => true,
                ),

            )
        );


         echo $form->select2Row($model, 'bracelet_id',
            array(
                'data' => Bracelets::model()->listAll(),
                'options' => array(
                    'placeholder' =>Yii::t('mx','Select'),
                    'allowClear' => true,
                ),

            )
        );

    }

    ?>

	<?php echo $form->textFieldRow($model,'minimum_balance',array('prepend'=>'#',)); ?>



    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'encodeLabel'=>false,
            'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
