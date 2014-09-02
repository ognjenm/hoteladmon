<?php
/**
 * Created by PhpStorm.
 * User: chinux
 * mail: chinuxe@gmail.com
 * Time: 17:57
 */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'direct-invoice-form',
    'enableAjaxValidation'=>false,
)); ?>

<?php
$a1= Yii::t('mx','Quantity');
$a4= Yii::t('mx','Presentation');
$a5= Yii::t('mx','Price');
$a6= Yii::t('mx','Amount');
$a7= Yii::t('mx','Discount');
$a8= Yii::t('mx','Subtotal');
$a9= Yii::t('mx','VAT');
$a10= Yii::t('mx','Total');

?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>


<div id="direct-invoice-grid" class="grid-view">
    <table class="items table table-hover table-condensed">
        <thead>
        <tr>
            <th><?php echo $a1; ?></th>
            <th><?php echo $a4; ?></th>
            <th><?php echo $a5; ?></th>
            <th><?php echo $a6; ?></th>
            <th><?php echo $a7; ?></th>
            <th><?php echo $a8; ?></th>
            <th><?php echo $a9; ?></th>
            <th><?php echo $a10; ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $i=>$item): ?>
        <tr class="copy">
            <?php echo $form->hiddenField($item,"[$i]id",array()); ?>
                <td><?php echo $form->textField($item,"[$i]quantity",array('class'=>'span12','placeholder'=>Yii::t('mx','Quantity'))); ?></td>
                <td><?php echo $form->textField($item,"[$i]presentation",array(
                        'class'=>'span12',
                        'placeholder'=>Yii::t('mx','Presentation'),
                        'value'=>$item->article->presentation,
                        'readonly'=>'readonly'
                    )); ?>
                </td>
                <td><?php echo $form->textField($item,"[$i]price",array(
                        'class'=>'span12',
                        'placeholder'=>Yii::t('mx','Price'),
                        'readonly'=>'readonly'
                    )); ?>
                </td>
                <td><?php echo $form->textField($item,"[$i]amount",array('class'=>'span12','placeholder'=>Yii::t('mx','Amount'))); ?></td>
                <td><?php echo $form->textField($item,"[$i]discount",array('class'=>'span12','placeholder'=>Yii::t('mx','Amount'))); ?></td>
                <td><?php echo $form->textField($item,"[$i]subtotal",array('class'=>'span12','placeholder'=>Yii::t('mx','Amount'))); ?></td>
                <td><?php echo $form->textField($item,"[$i]vat",array('class'=>'span12','placeholder'=>Yii::t('mx','Amount'))); ?></td>
                <td><?php echo $form->textField($item,"[$i]total",array('class'=>'span12','placeholder'=>Yii::t('mx','Amount'))); ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="pull-right">
    <?php echo $form->textFieldRow($model,'discount',array('prepend'=>'$')); ?>
    <?php echo $form->textFieldRow($model,'subtotal',array('prepend'=>'$')); ?>
    <?php echo $form->textFieldRow($model,'vat',array('prepend'=>'$')); ?>
    <?php echo $form->textFieldRow($model,'ieps',array('prepend'=>'$')); ?>
    <?php echo $form->textFieldRow($model,'retiva',array('prepend'=>'$')); ?>
    <?php echo $form->textFieldRow($model,'total',array('prepend'=>'$')); ?>
</div>





    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>


