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

    <div class="span6">
        <div class="span12">
            <fieldset>
                <legend><?php echo Yii::t('mx','North'); ?></legend>

                    <?php echo $form->textFieldRow($model,'n_degrees',array('append' =>'º','placeholder'=>Yii::t('mx','Degrees'))); ?>
                    <?php echo $form->textFieldRow($model,'n_minuts',array('append' =>'\'','placeholder'=>Yii::t('mx','Minuts'))); ?>
                    <?php echo $form->textFieldRow($model,'n_seconds',array('append' =>'"','placeholder'=>Yii::t('mx','Seconds'))); ?>
            </fieldset>
        </div>

        <div class="span12">
            <fieldset>
                <legend><?php echo Yii::t('mx','West'); ?></legend>

                    <?php echo $form->textFieldRow($model,'w_degrees',array('append' =>'º','placeholder'=>Yii::t('mx','Degrees'))); ?>
                    <?php echo $form->textFieldRow($model,'w_minuts',array('append' =>'\'','placeholder'=>Yii::t('mx','Minuts'))); ?>
                    <?php echo $form->textFieldRow($model,'w_seconds',array('append' =>'"','placeholder'=>Yii::t('mx','Seconds'))); ?>
            </fieldset>
        </div>
    </div>

    <div class="span6">

        <div class="span12">
            <fieldset>
                <legend><?php echo Yii::t('mx','Coordinates'); ?></legend>
                <?php echo $form->textFieldRow($model,'latitude',array('placeholder'=>Yii::t('mx','Latitude'))); ?>
                <?php echo $form->textFieldRow($model,'longitude',array('placeholder'=>Yii::t('mx','Longitude'))); ?>
            </fieldset>
        </div>

        <div class="span12">
            <fieldset>
                <legend><?php echo Yii::t('mx','Zones'); ?></legend>


                <div class="control-group">
                    <label class="control-label" for="Providers_zone"><?php echo Yii::t('mx','Zone'); ?></label>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'zone',Zones::model()->listAll(),
                            array('prompt'=>Yii::t('mx','Select'))
                        ); ?>
                        <?php  $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType'=>'button',
                            'type'=>'primary',
                            'icon'=>'icon-map-marker',
                            'htmlOptions' => array(
                                'data-toggle' => 'modal',
                                'data-target' => '#modal-zones',
                            ),
                        )); ?>
                    </div>
                </div>

            </fieldset>
        </div>

    </div>
</div>




