<?php
/**
 * Created by chinux.
 * Email: chinuxe@gmail.com
 * Date: 9/19/13
 * Time: 3:35 PM
 */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'book-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo CHtml::activeHiddenField($model,'room_id'); ?>
<?php echo CHtml::activeHiddenField($model,'checkin'); ?>
<?php echo CHtml::activeHiddenField($model,'checkout'); ?>
<?php echo CHtml::activeHiddenField($model,'adults'); ?>
<?php echo CHtml::activeHiddenField($model,'children'); ?>
<?php echo CHtml::activeHiddenField($model,'pets'); ?>


<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span10','maxlength'=>100)); ?>
<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span10','maxlength'=>100)); ?>
<?php echo $form->textFieldRow($model,'phone',array('class'=>'span10','maxlength'=>30)); ?>
<?php echo $form->textFieldRow($model,'email',array('class'=>'span10','maxlength'=>100)); ?>
<?php echo $form->textFieldRow($model,'country',array('class'=>'span10','maxlength'=>100)); ?>
<?php echo $form->textFieldRow($model,'state',array('class'=>'span10','maxlength'=>100)); ?>
<?php echo $form->textFieldRow($model,'city',array('class'=>'span10','maxlength'=>100)); ?>
<?php echo $form->textFieldRow($model,'zipcode',array('class'=>'span10','maxlength'=>100)); ?>
<?php echo $form->textAreaRow($model,'address',array('rows'=>5,'class'=>'span10','maxlength'=>255)); ?>
<?php echo $form->textAreaRow($model,'annotations',array('rows'=>5,'class'=>'span10','maxlength'=>255)); ?>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            //'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>'icon-ok',
            'label'=>Yii::t('mx','Ok'),
            'htmlOptions' => array(
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('reservation/book'),
                    'success' => 'function(data) { alert(data) }',
                ),
            ),
        )); ?>
    </div>


<?php $this->endWidget(); ?>