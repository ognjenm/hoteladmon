<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'tasks-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

<?php echo $form->errorSummary($model); ?>


    <?php echo $form->radioButtonListRow($model, 'isgroup',array(
            Yii::t('mx','No'),
            Yii::t('mx','Yes'),
        ),array(
            'onchange'=>'
                if($(this).val()== 1){
                    $("#divsubgroup").show();
                    $("#divemployee").hide();
                }
                if($(this).val()== 0){
                    $("#divemployee").show();
                    $("#divsubgroup").hide();
                }
            '
        )
    );

    ?>

    <div id="divsubgroup" style="display: none">
        <?php echo $form->dropDownListRow($model,'group_assigned_id',Groups::model()->listAll(),
            array('prompt'=>Yii::t('mx','Select'),
                'ajax' => array(
                    'type'=>'POST',
                    'dataType'=>'json',
                    'url'=>Yii::app()->createUrl('employees/getEmployees'),
                    'success' => 'function(data){
                            $("#employees").html(data.lista);
                        }',
                    'data'=>array('groupId'=>'js:this.value'),
                )
            )
        ); ?>

        <div id="employees"></div>

    </div>

    <div id="divemployee">
        <?php echo $form->select2Row($model, 'employee_id',
            array(
                'data' => Employees::model()->listAll(),
                'options' => array(
                    'allowClear' => true,
                ),
            )
        );
        ?>
    </div>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>$model->isNewRecord ? 'icon-plus' : 'icon-ok',
        'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
