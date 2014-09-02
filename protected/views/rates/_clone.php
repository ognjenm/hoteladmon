
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'columns',

    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'class' => 'form',
    ),
)); ?>

        <?php

        $this->widget('ext.multiselects.XMultiSelects',array(
            'leftTitle'=>Yii::t('mx','Rooms'),
            'leftName'=>'Rooms[source][]',
            'leftList'=> Rooms::model()->listAllRooms(),
            'rightTitle'=>Yii::t('mx','Apply Rates In'),
            'rightName'=>'Rooms[destination][]',
            'rightList'=>array(),
            'size'=>20,
            'width'=>'100%',
        ));
        ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>'icon-random icon-white',
            'label'=>Yii::t('mx','clone'),
        )); ?>
    </div>

<?php $this->endWidget(); ?>