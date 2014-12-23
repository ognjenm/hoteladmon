<?php

    $this->breadcrumbs=array(
        Yii::t('mx','Purchase Order')=>array('index'),
        Yii::t('mx','Create'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
    );

    $this->pageSubTitle=Yii::t('mx','Create');
    $this->pageIcon='icon-ok';

    $order=Yii::getPathOfAlias('ext.tableorder');
    $assets =Yii::app()->assetManager->publish($order);

    $cs = Yii::app()->getClientScript();

    $cs->registerScriptFile($assets.'/js/jquery.tablednd.0.7.min.js');
    $cs->registerCssFile($assets.'/css/tablednd.css');

?>

<script type="text/javascript">

    var index=1;
    var itemCount = 0;
    var html = "";
    var providers=0;
    var items=[];
    var orders=[];
    var notes=[];
    var purchaseOrders=[];
    var aux=new Array();
    var note=new Array();
    var noteIndex=0;
    var noteIndexArray=0;


    $(document).ready(function() {


        $("#bill_table").tableDnD();

        $("#bill_table tr").hover(function() {
            $(this.cells[0]).addClass('showDragHandle');

        }, function() {
            $(this.cells[0]).removeClass('showDragHandle');
        });


    });


</script>

<div id="content">
    <fieldset>
        <legend>Busqueda:</legend>
        <div class="checkbox">
            <label>
                <?php echo CHtml::radioButtonList('choice','',array('provider'=>Yii::t('mx','Provider'),'article'=>Yii::t('mx','Article')), array(
                        'labelOptions'=>array('style'=>'display:inline'),
                        'separator' => "",
                        'onClick'=>"

                            var search=$(\"input:radio[name='choice']:checked\").val();

                            if(search=='provider'){
                               $('#providersDiv').show();
                               $('#articlesDiv').hide();
                            }else{
                                $('#articlesDiv').show();
                                $('#providersDiv').hide();
                            }
                        "
                    )
                ); ?>
            </label>
        </div>

            <div id="providersDiv" style="display: none">
                <?php echo $form->render(); ?>
            </div>
            <div id="articlesDiv" style="display: none">
                <?php echo $formArticle->render(); ?>
            </div>

    </fieldset>
    <?php echo $this->renderPartial('_form', array('model'=>$model,'items'=>$items)); ?>
</div>