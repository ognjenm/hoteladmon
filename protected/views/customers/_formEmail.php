<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'policies-form',
    'enableAjaxValidation'=>false,
)); ?>


    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->ckEditorRow($model, 'body', array(
        'options'=>array('fullpage'=>'js:true',
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
            'icon'=>'icon-envelope',
            'label'=>Yii::t('mx','Send'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
