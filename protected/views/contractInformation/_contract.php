<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'contract-information-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal'
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

    <br>

    <?php echo $form->errorSummary($contract); ?>

    <?php echo $form->textFieldRow($contract,'title',array('class'=>'span8')); ?>


<?php echo $form->ckEditorRow($contract, 'content', array(
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

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$contract->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
            'label'=>$contract->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
