<?php
/**
 * Created by PhpStorm.
 * User: usof03
 * Date: 28/01/2015
 * Time: 05:48 PM
 */
?>

<div class="form">
    <?php echo CHtml::beginForm(); ?>

            <?php echo CHtml::label('Fecha','date',array()) ?>
            <?php //echo CHtml::TextField('username','',array()) ?>

            <?php $this->widget('bootstrap.widgets.TbDatePicker',
                array('name' => 'date',
                    'htmlOptions' => array('placeholder'=>Yii::t('mx','Date')),
                    'options'=>array(
                        'format'=>'dd-M-yyyy',
                        'autoclose' => true,

                    )
                )
            );
            ?>
    <?php

    /*$this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',array(
        'model'=>0,
        'attribute'=>'datex',
        'mode'=>'datetime' ,
        'options'=>array(
            'showAnim'=>'slide',
            'changeYear' => true,
            'changeMonth' => true,
            'dateFormat'=>Yii::app()->format->dateFormat,
            'timeText'=> Yii::t('mx','Schedule'),
            'hourText'=> Yii::t('mx','Hour'),
            'minuteText'=>Yii::t('mx','Minute'),
            'timeOnlyTitle'=>Yii::t('mx','Choose Time'),
            'minDate'=>0,
            'hour'=>15,
            'minute'=>0,
        )
    ));*/


    ?>

        <div class="form-actions">
            <?php  $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'icon'=>'icon-ok',
                'label'=>Yii::t('mx','Cancel')
            )); ?>
        </div>

    <?php echo CHtml::endForm(); ?>
</div><!-- form -->