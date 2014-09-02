    <?php
$this->breadcrumbs=array(
        Yii::t('mx','Assignment')=>array('index'),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Refresh'),'icon'=>'icon-refresh','url'=>array('index')),
        array('label'=>Yii::t('mx','Buy'),'icon'=>'icon-plus','url'=>array('/braceletsHistory/buy')),
        array('label'=>Yii::t('mx','Transfer'),'icon'=>'icon-exchange','url'=>array('/braceletsHistory/transfer')),
        array('label'=>Yii::t('mx','Sell'),'icon'=>'icon-minus','url'=>array('/braceletsHistory/create')),
        array('label'=>Yii::t('mx','Minimum Balance'),'icon'=>'icon-share-alt','url'=>array('minimum')),
        array('label'=>Yii::t('mx','Reports'),'icon'=>'icon-file-alt','url'=>array('reports')),

    );

    $this->pageSubTitle=Yii::t('mx','Manage');
    $this->pageIcon='icon-cogs';

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

    Yii::app()->clientScript->registerScript('search', "

        $('#button-minimos').click(function(){

           $('#allassignments').hide();
           $('#minimos').show();

        });

        $('#button-reset').click(function(){

           $('#allassignments').show();
           $('#minimos').hide();

        });

    ");


    ?>

    <div class="form-actions">

        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'id'=>'button-minimos',
            'buttonType'=>'button',
            'type'=>'primary',
            'icon'=>'icon-filter',
            'label'=>Yii::t('mx','Minimum'),

        )); ?>

        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'id'=>'button-reset',
            'buttonType'=>'button',
            'type'=>'primary',
            'icon'=>'icon-ok',
            'label'=>Yii::t('mx','Reset'),

        )); ?>

    </div>

    <div id="minimos" style="display: none">
        <?php $this->renderPartial('minimos', array(
            'minimos'=>$minimos
        ));
        ?>
    </div>

    <div id="allassignments">
         <?php $this->renderPartial('_grid', array(
                'model' => $model,
            ));
         ?>
    </div>





