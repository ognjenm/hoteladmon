<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'policies-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>




	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255)); ?>




    <?php echo $form->ckEditorRow($model, 'content', array(
        'options'=>array('fullpage'=>'js:true',
                'filebrowserBrowseUrl'=>Yii::app()->createUrl('/policies/browse.php'),
                'filebrowserUploadUrl'=> Yii::app()->createUrl('/policies/upload.php'),
                'width'=>'800',
                'height'=>'500',
                'resize_maxWidth'=>'640',
                'resize_minWidth'=>'320',
                'toolbar'=>'js:[
                    ["Source","Copy","SelectAll","DocProps","-","PasteText","PasteFromWord"],
                    ["Undo","Redo","-","RemoveFormat"],
                    ["Bold","Italic","Underline","Strike","Subscript","Superscript"],
                    ["NumberedList","BulletedList","-","Outdent","Indent"],
                    ["JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock"],
                    ["Link","Unlink"],
                    ["Image","Flash","Table","HorizontalRule","SpecialChar"],
                    ["Format","Font","FontSize","Styles"],
                    ["TextColor","BGColor"],
                    ["Maximize","ShowBlocks"]
                ],'
        )
    ));
    ?>




	<?php //echo $form->TbCKEditor($model, 'content', array('class'=>'span4', 'rows'=>5,'id'=>'content')); ?>


<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'encodeLabel'=>false,
        'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
