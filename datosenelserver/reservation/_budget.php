<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 23/11/13
 * Time: 13:29
 */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'labels-form',
    'enableAjaxValidation'=>false,
)); ?>

    <?php echo CHtml::hiddenField('email',$email); ?>
    <?php echo CHtml::hiddenField('cc',$cc); ?>
    <?php echo CHtml::hiddenField('from',$from); ?>



    <?php $this->widget('bootstrap.widgets.TbCKEditor',array(
        'name'=>'ckeditor',
        'value'=>$cotizacion,
        'editorOptions'=>array(
            'height'=>'400',
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
        ),

    ) ); ?>



    <div class="form-actions">
        <?php

       /* $this->widget('bootstrap.widgets.TbButton', array(
            'id'=>'sendmail',
            'url' => $this->createUrl('reservation/SendByEmail'),
            'buttonType'=>'ajaxSubmit',
            'type'=>'primary',
            'icon'=>'icon-envelope',
            'label'=>Yii::t('mx','Send Budget'),
            'ajaxOptions' => array(
                'beforeSend' => 'function() {

                    $("#maindiv").addClass("loading");

                }',
                'complete' => 'function() {
                    $("#maindiv").removeClass("loading");
                }',
                'success' =>'function(data){
                    alert(data);
                }',
            ),
        ));*/

        ?>
    </div>



<?php $this->endWidget(); ?>




