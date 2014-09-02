    <?php

    $this->breadcrumbs=array(
        Yii::t('mx','Assignment')=>array('index'),
         Yii::t('mx','View'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
        array('label'=>Yii::t('mx','Buy'),'icon'=>'icon-plus','url'=>array('/braceletsHistory/buy')),
        array('label'=>Yii::t('mx','Transfer'),'icon'=>'icon-exchange','url'=>array('/braceletsHistory/transfer')),
        array('label'=>Yii::t('mx','Sell'),'icon'=>'icon-minus','url'=>array('/braceletsHistory/create')),
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

    <div id="statusMsg"></div>


    <?php $this->widget('bootstrap.widgets.TbDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                'id',
                array(
                    'name'=>'employeed_id',
                    'value'=>$model->employeed->names
                ),
                array(
                    'name'=>'bracelet_id',
                    'value'=>$model->bracelet->color.' - '.$model->bracelet->use->used
                ),
                'balance',
                'minimum_balance',
                'date_assignment',
            ),
            )); ?>


    <?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
        'id'=>'bracelets-history-grid',
        'type' => 'hover condensed',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Bracelets Histories').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$arrayDataProvider,
        'pager' => array(
            'class' => 'bootstrap.widgets.TbPager',
            'displayFirstAndLast' => true,
            'lastPageLabel'=>Yii::t('mx','Last'),
            'firstPageLabel'=>Yii::t('mx','First'),
        ),
        'columns'=>array(
            'id',
            array(
                'name'=>Yii::t('mx','Date'),
                'value'=>'$data["datex"]',
                'type'=>'raw'
            ),
            array(
                'name'=>Yii::t('mx','Operation'),
                'value'=>'$data["operation"]',
                'type'=>'raw',
            ),
            array(
                'name'=>Yii::t('mx','Register'),
                'value'=>'$data["register"]',
                'type'=>'raw'
            ),
            array(
                'name'=>Yii::t('mx','Movement'),
                'value'=>'$data["movement"]',
                'type'=>'raw'
            ),
            array(
                'name'=>Yii::t('mx','Balance'),
                'value'=>'$data["balance"]',
                'type'=>'raw'
            ),
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                'afterDelete'=>'function(link,success,data){
                    if(success) $("#statusMsg").html(data);
                }',
                'headerHtmlOptions' => array('style' => 'width:150px;'),
                'header'=>Yii::t('mx','Actions'),
                'template'=>'{delete}',
                'buttons'=>array(
                    /*'update'=>array(
                        'url'=>'Yii::app()->createUrl("braceletsHistory/update", array("id"=>$data["id"],"asigmentId"=>$data["assignment_id"]))',
                    ),*/
                    'delete'=>array(
                        'url'=>'Yii::app()->createUrl("braceletsHistory/delete", array("id"=>$data["id"]))',
                    ),
                )
            ),
        ),
    ));

    ?>