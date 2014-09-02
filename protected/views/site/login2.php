<?php
/**
 * Created by chinux.
 * Email: chinuxe@gmail.com
 * Date: 10/3/13
 * Time: 4:21 PM
 */
 ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array(
    'id' => 'login',
    'autoOpen'=>true
));
?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4><?php echo Yii::t('mx','Login'); ?></h4>
    </div>

    <div class="modal-body">
        <p><?php echo $form; ?></p>
    </div>

    <div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('mx','Cancel'),
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )); ?>
    </div>

<?php $this->endWidget(); ?>