<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tasks-form',
	'enableAjaxValidation'=>false,
));

?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

<?php echo $form->errorSummary($model); ?>

<div class="fluid">
    <div class="span6">
        <?php echo $form->textFieldRow($model,'name',array('class'=>'span12','maxlength'=>100)); ?>
        <?php echo CHtml::label(Yii::t('mx','Aditional Comments'),'providers',array()); ?>
        <?php echo $form->textArea($model,'description',array('class'=>'span12','rows'=>6, 'cols'=>50, 'maxlength'=>500)); ?>

        <?php echo CHtml::label(Yii::t('mx','Providers'),'providers',array()); ?>
        <?php $this->widget(
            'bootstrap.widgets.TbSelect2',
            array(
                'model'=>$model,
                'attribute' => 'providers',
                'data' => Providers::model()->listAllOrganization(),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                ),
                'options' => array(
                    'width' => '100%',
                )
            )
        );
        ?>


        <?php echo $form->dropDownListRow($model,'department',Departments::model()->listAll(),
            array('prompt'=>Yii::t('mx','Select'))
        ); ?>
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'button',
            'type'=>'primary',
            'icon'=>'icon-home',
            'htmlOptions' => array(
                'data-toggle' => 'modal',
                'data-target' => '#modal-department',
            ),
        )); ?>

        <?php echo $form->dropDownListRow($model,'zone',Zones::model()->listAll(),
            array('prompt'=>Yii::t('mx','Select'))
        ); ?>
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'button',
            'type'=>'primary',
            'icon'=>'icon-map-marker',
            'htmlOptions' => array(
                'data-toggle' => 'modal',
                'data-target' => '#modal-zones',
            ),
        )); ?>


    </div>
    <div class="span6">
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

        <?php
        echo $form->datepickerRow($model, 'date_due',array(
            'prepend'=>'<i class="icon-calendar"></i>',
            'value'=>date('d-M-Y'),
            'options'=>array(
                'format'=>'dd-M-yyyy',
                'autoclose'=>true
            ),
        ));
        ?>

        <?php echo $form->dropDownListRow($model, 'priority',Tasks::model()->listPriority());?>
        <?php echo $form->dropDownListRow($model, 'frecuency',Tasks::model()->listFrecuency()); ?>

        <div class="form-actions">
            <?php  $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'icon'=>$model->isNewRecord ? 'icon-plus' : 'icon-ok',
                'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
            )); ?>
        </div>

    </div>

</div>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-department')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><i class="icon-home"></i> <?php echo Yii::t('mx','New Deparment'); ?></h4>
    </div>

    <div class="modal-body"><?php echo $department->render(); ?></div>

    <div class="modal-footer">

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('mx','Return'),
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )); ?>

    </div>
<?php $this->endWidget(); ?>


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-zones')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-map-marker"></i> <?php echo Yii::t('mx','New Zone'); ?></h4>
</div>

<div class="modal-body"><?php echo $zones->render(); ?></div>

<div class="modal-footer">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>
