<?php
/**
 * Created by PhpStorm.
 * User: chinux
 * email: chinuxe@gmail.com
 * Date: 15/02/14
 * Time: 10:24
 */
?>



<div class="row-fluid">
    <div class="span4">
        <?php echo $form->textFieldRow($model,'home_street',array('class'=>'span12','maxlength'=>100)); ?>
        <?php echo $form->textFieldRow($model,'home_city',array('class'=>'span12','maxlength'=>30)); ?>
        <?php echo $form->textFieldRow($model,'home_region',array('class'=>'span12','maxlength'=>30)); ?>
        <?php echo $form->textFieldRow($model,'home_country',array('class'=>'span12','maxlength'=>30)); ?>
        <?php echo $form->textFieldRow($model,'home_zip',array('class'=>'span12','maxlength'=>20)); ?>
    </div>

    <div class="span4">
        <?php echo $form->textFieldRow($model,'postal_street',array('class'=>'span12','maxlength'=>100)); ?>
        <?php echo $form->textFieldRow($model,'postal_city',array('class'=>'span12','maxlength'=>30)); ?>
        <?php echo $form->textFieldRow($model,'postal_region',array('class'=>'span12','maxlength'=>30)); ?>
        <?php echo $form->textFieldRow($model,'postal_country',array('class'=>'span12','maxlength'=>30)); ?>
        <?php echo $form->textFieldRow($model,'postal_zip',array('class'=>'span12','maxlength'=>20)); ?>
    </div>
</div>