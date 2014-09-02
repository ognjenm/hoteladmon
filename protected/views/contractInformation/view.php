    <?php
$this->breadcrumbs=array(
        Yii::t('mx','Contracts')=>array('index'),
         Yii::t('mx','View'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx','Update'),'icon'=>'icon-pencil','url'=>array('update','id'=>$model->id)),
        array('label'=>Yii::t('mx','Delete'),'icon'=>'icon-remove','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('mx','Are you sure you want to delete this item?'))),
    );


    $this->pageSubTitle=Yii::t('mx','View');
    $this->pageIcon='icon-list-alt';


    if(Yii::app()->user->hasFlash('success')):
        Yii::app()->user->setFlash('success', '<strong>done!</strong> '.Yii::app()->user->getFlash('success'));
    endif;

    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'×', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
        ),
    ));

?>

    <?php

    $this->widget(
        'bootstrap.widgets.TbCKEditor',
        array(
            'model'=>$model,
            'attribute'=>'content',
            'editorOptions'=>array(
                'fullpage'=>'js:true',
                'width'=>'800',
                'height'=>'500',
                'resize_maxWidth'=>'640',
                'resize_minWidth'=>'320',
                'toolbar'=>'js:[
                    ["Source","Copy","SelectAll","DocProps","-","PasteText","PasteFromWord"],
                    ["Undo","Redo","-","RemoveFormat"],
                    ["Bold","Italic","Underline","Strike","Subscript","Superscript"],
                    ["NumberedList","BulletedList","-","Outdent","Indent"],
                    ["JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock"],
                    ["Link","Unlink"],
                    ["Image","Flash","Table","HorizontalRule","SpecialChar"],
                    ["Format","Font","FontSize","Styles"],
                    ["TextColor","BGColor"],
                    ["Maximize","ShowBlocks"]
                ],'
            )
        )
    );

    ?>


