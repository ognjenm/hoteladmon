<?php
/**
 * Created by PhpStorm.
 * User: chinuxe
 * Date: 16/04/14
 * email: chinuxe@gmail.com
 */
?>

<?php echo $form->textFieldRow($model,'name_wife',array('class'=>'span5','maxlength'=>100)); ?>

<?php echo $form->textAreaRow($model,'name_children',array('rows'=>6, 'cols'=>50, 'class'=>'span5')); ?>

<?php echo $form->textFieldRow($model,'name_father',array('class'=>'span5','maxlength'=>100)); ?>

<?php echo $form->textFieldRow($model,'name_mother',array('class'=>'span5','maxlength'=>100)); ?>