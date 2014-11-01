<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'new-customer-information-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>


<div class="container-fluid">
    <div class="span3">

        <fieldset>
            <legend>Información Nueva:</legend>

        <?php echo $form->errorSummary($model); ?>

            <div class="input-append">
                <?php echo $form->textFieldRow($model,'alternative_email',array('maxlength'=>100)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('alternative_email_New',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($model,'first_name',array('maxlength'=>100)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('first_name_New',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($model,'last_name',array('maxlength'=>100)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('last_name_New',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($model,'country',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('country_New',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($model,'state',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('state_New',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($model,'city',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('city_New',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($model,'home_phone',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('home_phone_New',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($model,'work_phone',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('work_phone_New',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($model,'cell_phone',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('cell_phone_New',false,array()); ?></span>
            </div>

        </fieldset>

    </div>

    <div class="span3">
        <fieldset>
            <legend>Información Guardada:</legend>

            <div class="input-append">
            <?php echo $form->textFieldRow($customer,'alternative_email',array('maxlength'=>100)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('alternative_email_Old',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($customer,'first_name',array('maxlength'=>100)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('first_name_Old',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($customer,'last_name',array('maxlength'=>100)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('last_name_Old',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($customer,'country',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('country_Old',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($customer,'state',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('country_Old',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo $form->textFieldRow($customer,'city',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('country_Old',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo CHtml::label(Yii::t('mx','Home Phone'),'home_phone'); ?>
                <?php echo $form->textField($customer,'home_phone',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('home_phone_Old',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo CHtml::label(Yii::t('mx','Work Phone'),'work_phone'); ?>
                <?php echo $form->textField($customer,'work_phone',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('work_phone_Old',false,array()); ?></span>
            </div>

            <div class="input-append">
                <?php echo CHtml::label(Yii::t('mx','Cell Phone'),'cell_phone'); ?>
                <?php echo $form->textField($customer,'cell_phone',array('maxlength'=>50)); ?>
                <span class="add-on"><?php echo CHtml::checkBox('cell_phone_Old',false,array()); ?></span>
            </div>

        </fieldset>

    </div>

    <div class="span3">
        <fieldset>
            <legend>Guardar Información:</legend>

            <?php echo CHtml::label(Yii::t('mx','Alternative Email'),'alternative_email_Save'); ?>
            <?php echo $form->textField($model,'alternative_email_Save',array('class'=>'span12','maxlength'=>100)); ?>

            <?php echo CHtml::label(Yii::t('mx','First Name'),'first_name_Save'); ?>
            <?php echo $form->textField($model,'first_name_Save',array('class'=>'span12','maxlength'=>100)); ?>

            <?php echo CHtml::label(Yii::t('mx','Last Name'),'last_name_Save'); ?>
            <?php echo $form->textField($model,'last_name_Save',array('class'=>'span12','maxlength'=>100)); ?>

            <?php echo CHtml::label(Yii::t('mx','Country'),'country_Save'); ?>
            <?php echo $form->textField($model,'country_Save',array('class'=>'span12','maxlength'=>50)); ?>

            <?php echo CHtml::label(Yii::t('mx','State'),'state_Save'); ?>
            <?php echo $form->textField($model,'state_Save',array('class'=>'span12','maxlength'=>50)); ?>

            <?php echo CHtml::label(Yii::t('mx','City'),'city_Save'); ?>
            <?php echo $form->textField($model,'city_Save',array('class'=>'span12','maxlength'=>50)); ?>

            <?php echo CHtml::label(Yii::t('mx','Home Phone'),'home_phone_Save'); ?>
            <?php echo $form->textField($model,'home_phone_Save',array('class'=>'span12','maxlength'=>50)); ?>

            <?php echo CHtml::label(Yii::t('mx','Work Phone'),'work_phone_Save'); ?>
            <?php echo $form->textField($model,'work_phone_Save',array('class'=>'span12','maxlength'=>50)); ?>

            <?php echo CHtml::label(Yii::t('mx','Cell Phone'),'cell_phone_Save'); ?>
            <?php echo $form->textField($model,'cell_phone_Save',array('class'=>'span12','maxlength'=>50)); ?>

        </fieldset>

        <div class="form-actions">
            <?php  $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
                'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
            )); ?>
        </div>

    </div>

</div>



<?php $this->endWidget(); ?>
