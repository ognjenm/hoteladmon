<?php
/**
 * Created by chinux.
 * Email: chinuxe@gmail.com
 * Date: 9/19/13
 * Time: 3:35 PM
 */
?>

<?php $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'sendReservation',
    'type'=>'horizontal',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

    <?php echo CHtml::HiddenField('e_room_id',''); ?>
    <?php echo CHtml::HiddenField('e_checkin',''); ?>
    <?php echo CHtml::HiddenField('e_checkout',''); ?>
    <?php echo CHtml::HiddenField('e_adults',''); ?>
    <?php echo CHtml::HiddenField('e_children',''); ?>
    <?php echo CHtml::HiddenField('e_pets',''); ?>

    <?php echo CHtml::label('Email','to',array('class'=>'span2')); ?>

        <div class="input-prepend">
            <span class="add-on"><i class="icon-envelope"></i></span>
            <?php echo CHtml::textField('to','',array('class'=>'span10','placeholder'=>'Email address')); ?>
        </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
       // 'buttonType'=>'ajaxSubmit',
        'label' => 'Send',
        'type' => 'primary',
        'htmlOptions' => array(
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('reservation/sendByEmail'),
                'success' => 'function(data) { alert(data) }',
            ),
        ),
    )); ?>

<?php $this->endWidget(); ?>