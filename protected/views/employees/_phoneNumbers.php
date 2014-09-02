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
        <div class="control-group ">
            <?php echo $form->label($model,'telephone_work1',array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on">
                        <i class="icon-phone"></i>
                    </span>
                    <?php echo $form->textField($model,'telephone_work1',array('class'=>'span12','maxlength'=>150)); ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model,'telephone_work2',array('class'=>'span12','maxlength'=>25,'prepend'=>'<i class="icon-phone"></i>')); ?>
        <?php echo $form->textFieldRow($model,'fax_work',array('class'=>'span12','maxlength'=>25,'prepend'=>'<i class="icon-phone"></i>')); ?>

        <div class="control-group ">
            <?php echo $form->label($model,'cell_phone',array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on">
                        <i class="icon-mobile-phone"></i>
                    </span>
                    <?php echo $form->textField($model,'cell_phone',array('class'=>'span12','maxlength'=>150)); ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model,'car_phone',array('class'=>'span12','maxlength'=>25,'prepend'=>'<i class="icon-mobile-phone"></i>')); ?>
        <?php echo $form->textFieldRow($model,'pager',array('class'=>'span12','maxlength'=>150,'prepend'=>'<i class="icon-phone"></i>')); ?>

    </div>

    <div class="span4">
        <?php echo $form->textFieldRow($model,'additional_telephone',array('class'=>'span12','maxlength'=>25,'prepend'=>'<i class="icon-phone"></i>')); ?>
        <?php echo $form->textFieldRow($model,'preferred_telephone',array('class'=>'span12','maxlength'=>25,'prepend'=>'<i class="icon-phone"></i>')); ?>
        <?php echo $form->textFieldRow($model,'telephone_home1',array('class'=>'span12','maxlength'=>25,'prepend'=>'<i class="icon-phone"></i>')); ?>
        <?php echo $form->textFieldRow($model,'telephone_home2',array('class'=>'span12','maxlength'=>25,'prepend'=>'<i class="icon-phone"></i>')); ?>
        <?php echo $form->textFieldRow($model,'fax_home',array('class'=>'span12','maxlength'=>25,'prepend'=>'<i class="icon-phone"></i>')); ?>

        <?php echo $form->textFieldRow($model,'isdn',array('class'=>'span12','maxlength'=>25,'prepend'=>'<i class="icon-phone-sign"></i>')); ?>
    </div>
</div>
