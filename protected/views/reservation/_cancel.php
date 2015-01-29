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

    <div class="row">
        <?php echo CHtml::label('Fecha','fecha',array()) ?>
        <?php echo CHtml::TextField('username','',array()) ?>
    </div>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>'icon-ok',
            'label'=>Yii::t('mx','Save')
        )); ?>
    </div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->