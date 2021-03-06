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
        'value'=>$format,
        'editorOptions'=>array(
            'height'=>'400',
            //'contentsCss'=> Yii::app()->theme->baseUrl.'/css/ckeditor.css',
        ),

    ) );
?>




<div class="form-actions">
    <?php

    $this->widget('bootstrap.widgets.TbButton', array(
        'id'=>'sendmail',
        'url' => $this->createUrl('reservation/changeStatus'),
        'buttonType'=>'ajaxSubmit',
        'type'=>'primary',
        'icon'=>'icon-ok',
        'label'=>Yii::t('mx','Format Send'),
        'ajaxOptions' => array(
            'type'=>'POST',
            'dataType'=>'json',
            'data'=>array('id'=>$customerReservationId,'status'=>$status,'formatId'=>$requestFormat),
            'beforeSend' => 'function() {  $("#maindiv").addClass("loading"); }',
            'complete' => 'function() { $("#maindiv").removeClass("loading"); }',
            'success' =>'function(data){ window.location.href=data.url }',
        ),
    ));

    ?>
</div>



<?php $this->endWidget(); ?>

    <pre><span style="color:#FF0000;font-size:14px;">
        <strong><?php echo Yii::t('mx','Before I click, copy this format and send our email'); ?></strong>
    </span></pre>




