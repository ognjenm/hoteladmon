<?php
/**
 * Created by chinux.
 * Email: chinuxe@gmail.com
 * Date: 9/20/13
 * Time: 1:40 PM
 */
 ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'reservation-form',
    'enableAjaxValidation'=>false,
)); ?>


<?php echo $form->errorSummary($model); ?>


<?php echo $form->dropDownListRow($model,'statux',Reservation::model()->listStatus(),
    array(
        'class'=>'span5',
        'prompt'=>Yii::t('mx','Select Status')
    )
);
?>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>'icon-ok icon-white',
            'label'=>Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>