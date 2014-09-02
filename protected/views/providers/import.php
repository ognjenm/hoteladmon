<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 19/02/14
 * Time: 10:05
 */
?>



<?php
$this->breadcrumbs=array(
    'Providers'=>array('import'),
    Yii::t('mx','Import'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Import');
$this->pageIcon='icon-download-alt';


?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
)); ?>


        <?php echo $form->fileFieldRow($vcard, 'filex'); ?>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>'icon-download',
            'label'=>Yii::t('mx','Import'),
        )); ?>

        <?php echo CHtml::link('Cancel', array('index'), array('class' => 'btn')); ?>

    </div>

<?php $this->endWidget(); ?>

