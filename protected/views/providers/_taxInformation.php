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
        <?php echo $form->textFieldRow($model,'rfc',array('class'=>'span12','maxlength'=>25)); ?>
        <?php echo $form->textFieldRow($model,'work_street',array('class'=>'span12','maxlength'=>100)); ?>
        <?php echo $form->textFieldRow($model,'outside_number',array('class'=>'span12','maxlength'=>20)); ?>
        <?php echo $form->textFieldRow($model,'internal_number',array('class'=>'span12','maxlength'=>20)); ?>
        <?php echo $form->textFieldRow($model,'work_neighborhood',array('class'=>'span12','maxlength'=>100)); ?>
        <?php echo $form->textFieldRow($model,'work_city',array('class'=>'span12','maxlength'=>30)); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model,'reference',array('class'=>'span12','maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'municipality',array('class'=>'span12','maxlength'=>30)); ?>
        <?php echo $form->textFieldRow($model,'work_region',array('class'=>'span12','maxlength'=>30)); ?>
        <?php echo $form->textFieldRow($model,'work_country',array('class'=>'span12','maxlength'=>30)); ?>
        <?php echo $form->textFieldRow($model,'work_zip',array('class'=>'span12','maxlength'=>20)); ?>
        <?php echo $form->textFieldRow($model,'account_number',array('class'=>'span12','maxlength'=>50)); ?>
    </div>
</div>