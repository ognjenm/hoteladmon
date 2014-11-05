
<?php
$this->breadcrumbs=array(
    Yii::t('mx','Reservations')=>array('index'),
    Yii::t('mx','Daily Report'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('campedCalendar')),
);

$this->pageSubTitle=Yii::t('mx','Daily Report');
$this->pageIcon='icon-ok';

if(Yii::app()->user->hasFlash('success')):
    Yii::app()->user->setFlash('success', '<strong>done!</strong> '.Yii::app()->user->getFlash('success'));
endif;

$this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true,
    'fade'=>true,
    'closeText'=>'×',
    'alerts'=>array(
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
    ),
));


Yii::app()->clientScript->registerScript('reportDaily', '

     $("#updateReport").click(function(){

            var datex=$("#date").val();

             $.ajax({
                url: "'.CController::createUrl('/reservation/getCampedReport').'",
                data: {date: datex},
                dataType: "json",
                type: "POST",
                beforeSend: function() {
                    $("#maindiv").addClass("loading");
                }
            })

            .done(function(data) {
                CKEDITOR.instances.ckeditor.updateElement();
                CKEDITOR.instances.ckeditor.setData(data.report);
             })

            .fail(function() { bootbox.alert("error"); })
            .always(function() { $("#maindiv").removeClass("loading"); });

            return false;
     });

');

?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'dailyReport-form',
    'enableAjaxValidation'=>false,
    'type'=>'inline',
    'htmlOptions'=>array('class'=>'well')
    //'class'=>'well'
)); ?>

<?php $this->widget(
    'bootstrap.widgets.TbDatePicker',
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

$this->widget('bootstrap.widgets.TbButton', array(
    'id'=>'updateReport',
    'url' => $this->createUrl('reservation/getDailyReport'),
    'buttonType'=>'button',
    'type'=>'primary',
    'icon'=>'icon-ok',
    'label'=>'ok',
));

?>

<?php $this->endWidget(); ?>

<div id="maindiv">

    <?php

    $this->widget('bootstrap.widgets.TbCKEditor',array(
        'name'=>'ckeditor',
        'value'=>$tabla,
        'editorOptions'=>array(
            'height'=>'400',
            'contentsCss'=> Yii::app()->theme->baseUrl.'/css/ckeditor.css',
            //'stylesSet'=> '[]'
        ),

    ) );

    ?>

</div>