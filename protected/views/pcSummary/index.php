    <?php
    $this->breadcrumbs=array(
        Yii::t('mx','Pc Summary')=>array('index'),
        Yii::t('mx','Manage'),
    );


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

    $url=Yii::app()->createUrl('pcSummary/index');


    Yii::app()->clientScript->registerScript('filters', '


        function userClicks(){
            var summaryIds = $.fn.yiiGridView.getSelection("pc-summary-grid");

            $.ajax({
                    url: "'.CController::createUrl('/pcSummary/getQuantity').'",
                    data: { ids: summaryIds  },
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $("#suma").addClass("loading");
                    }
            })

            .done(function(data) { $("#suma h1").html(data.quantity); })
            .fail(function(data) { alert(data); })
            .always(function() { $("#suma").removeClass("loading"); });

        }


        function generateCheck(){
            var summaryIds = $.fn.yiiGridView.getSelection("pc-summary-grid");

            $.ajax({
                    url: "'.CController::createUrl('/pcSummary/generateCheck').'",
                    data: { ids: summaryIds  },
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        $("#suma").addClass("loading");
                    }
            })

            .done(function(data) { $("#suma h1").html(data.quantity); })
            .fail(function(data) { alert(data); })
            .always(function() { $("#suma").removeClass("loading"); });

        }


    ');

    ?>

    <?php if($pettyCash->isconfirmed==1){ ?>

        <?php

        $this->menu=array(
            array('label'=>Yii::t('mx', 'PcSummary'),'icon'=>'icon-refresh','url'=>array('index')),
            array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
            array('label'=>Yii::t('mx','Generate Check'),'icon'=>'icon-plus','url'=>array('generateCheck')),

        );

        $this->pageSubTitle=Yii::t('mx','Manage');
        $this->pageIcon='icon-cogs';

        ?>

        <div id="amount" class="pull-left"><h1><?php  echo Yii::t('mx','Balance').': $'.number_format($pettyCash->amount,2); ?></h1></div>
        <div id="suma" class="pull-right"><h1></h1></div>
         <?php $this->renderPartial('_grid', array(
                'model' => $model,
            ));
         ?>

    <?php }else{ ?>

        <div class="alert in alert-block fade alert-success">
            <a href="#" class="close" data-dismiss="alert">×</a>
            <strong>done! </strong><?php echo Yii::t('mx','For Please, Confirm The Petty Cash'); ?>
        </div>

        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'ajaxSubmit',
            'type'=>'primary',
            'icon'=>'icon-ok icon-white',
            'label'=>Yii::t('mx','Confirmed'),
            'url'=>Yii::app()->createUrl('/pettyCash/confirmed'),
            'ajaxOptions' => array(
                'type'=>'POST',
                'dataType'=>'json',
                'data'=>array('isconfirmed'=>1),
                'beforeSend' => 'function() { $("#messages").addClass("saving"); }',
                'complete' => 'function() { $("#messages").removeClass("saving"); }',
                'success' =>"function(data){
                            if(data.ok==false){
                                alert(data.msg);
                            }

                            if(data.ok==true){
                                document.location.href='{$url}';
                            }
                }",
            ),
        )); ?>

    <?php } ?>









