<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 8/05/14
 * Email: chinuxe@gmail.com
 */
?>

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

<div class="container-fluid">
    <div class="span6">
        <?php echo $form->dropDownListRow($model,'reason_id',Reasons::model()->listAll(),
            array('prompt'=>Yii::t('mx','Select'))
        ); ?>

        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'button',
            'type'=>'primary',
            'icon'=>'icon-legal',
            'htmlOptions' => array(
                'data-toggle' => 'modal',
                'data-target' => '#modal-tracing',
            ),
        )); ?>

        <?php echo $form->textAreaRow($model,'comment',array('class'=>'span12','rows'=>6, 'cols'=>50, 'maxlength'=>500)); ?>

    </div>
    <div class="span6">
        <fieldset>
            <legend><?php echo Yii::t('mx','Remember Tracing'); ?></legend>


            <?php echo $form->dropDownListRow($model,'duration_unit',TracingTask::model()->listDurationUnit(),
                array('prompt'=>Yii::t('mx','Select'),
                    'onchange'=>'

                            var valor=$(this).val();

                            $.ajax({
                                        url: "'.CController::createUrl('/tasks/getDays').'",
                                        data: { valor: valor  },
                                        dataType: "json",
                                        type: "POST",
                                        beforeSend: function() {
                                            $("#container-fluid").addClass("loading");
                                        }
                                })

                                .done(function(data) { $("#TracingTask_unit").html(data.list); })
                                .fail(function(data) { alert(data); })
                                .always(function() { $("#container-fluid").removeClass("loading"); });
                    '
                )
            ); ?>

            <?php echo $form->dropDownListRow($model,'unit',array(),array('prompt'=>Yii::t('mx','Select'))); ?>
            <?php //echo $form->textFieldRow($model,'unit',array('prepend'=>'#')); ?>


        </fieldset>
    </div>
</div>

<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'icon'=>'icon-ok',
        'label'=>Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-tracing')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-ok"></i> <?php echo Yii::t('mx','New Reason'); ?></h4>
</div>

<div class="modal-body"><?php echo $reason->render(); ?></div>

<div class="modal-footer">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>
