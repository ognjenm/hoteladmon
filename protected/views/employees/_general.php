<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 15/02/14
 * Time: 10:24
 */
?>


<div class="row-fluid">

    <div class="span6">

        <div class="control-group ">
            <?php echo $form->label($model,'company',array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <div class="controls">
                <?php echo $form->textField($model,'company',array('class'=>'span12','maxlength'=>150)); ?>
            </div>
        </div>

        <div class="control-group ">
            <?php echo $form->label($model,'first_name',array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <div class="controls">
                <?php echo $form->textField($model,'first_name',array('class'=>'span12','maxlength'=>150)); ?>
            </div>
        </div>

        <div class="control-group ">
            <?php echo $form->label($model,'middle_name',array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <div class="controls">
                <?php echo $form->textField($model,'middle_name',array('class'=>'span12','maxlength'=>150)); ?>
            </div>
        </div>

        <div class="control-group ">
            <?php echo $form->label($model,'last_name',array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <div class="controls">
                <?php echo $form->textField($model,'last_name',array('class'=>'span12','maxlength'=>150)); ?>
            </div>
        </div>

        <div class="control-group ">
            <?php echo $form->label($model,'initials',array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <div class="controls">
                <?php echo $form->textField($model,'initials',array('class'=>'span12','maxlength'=>20)); ?>
            </div>
        </div>

        <div class="control-group ">
            <?php echo $form->label($model,'suffix',array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <div class="controls">
                <?php echo $form->textField($model,'suffix',array('class'=>'span12','maxlength'=>255)); ?>
            </div>
        </div>


        <?php echo $form->textFieldRow($model,'prefix',array('class'=>'span12','maxlength'=>255)); ?>
        <?php echo $form->textFieldRow($model,'nickname',array('class'=>'span12','maxlength'=>20)); ?>
        <?php echo $form->textFieldRow($model,'department',array('class'=>'span12','maxlength'=>50)); ?>
    </div>

    <div class="span6">
        <?php echo $form->textFieldRow($model,'job_title',array('class'=>'span12','maxlength'=>50,'prepend'=>'<i class="icon-user"></i>')); ?>
        <?php echo $form->textFieldRow($model,'url_work',array('class'=>'span12','maxlength'=>150,'prepend'=>'<i class="icon-globe"></i>')); ?>
        <?php echo $form->textFieldRow($model,'role',array('class'=>'span12','maxlength'=>50,'prepend'=>'<i class="icon-group"></i>')); ?>

        <?php echo $form->datepickerRow($model, 'birthday',array(
            'value'=>$model->isNewRecord ? '0000-00-00' : $model->birthday,
            'prepend'=>'<i class="icon-calendar"></i>',
            'options'=>array('format'=>'dd-M-yyyy'),
            //'class'=>'span4',
        ));
        ?>

        <?php echo $form->textFieldRow($model,'civil_status',array('class'=>'span12','maxlength'=>50)); ?>
        <?php echo $form->textFieldRow($model,'nationality',array('class'=>'span12','maxlength'=>50)); ?>


        <div class="control-group ">
            <?php echo $form->label($model,'email',array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on">
                        <i class="icon-envelope"></i>
                    </span>
                    <?php echo $form->textField($model,'email',array('class'=>'span12','maxlength'=>100,'prepend'=>'<i class="icon-envelope"></i>')); ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model,'email_work',array('class'=>'span12','maxlength'=>100,'prepend'=>'<i class="icon-envelope"></i>')); ?>
        <?php echo $form->textFieldRow($model,'email_home',array('class'=>'span12','maxlength'=>100,'prepend'=>'<i class="icon-envelope"></i>')); ?>
        <?php echo $form->textAreaRow($model,'note',array('rows'=>6, 'cols'=>50, 'class'=>'span12')); ?>
    </div>
</div>