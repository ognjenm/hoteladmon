    <?php

    if(Yii::app()->user->isSuperAdmin){
        $this->breadcrumbs=array(
            Yii::t('mx','Tasks')=>array('index'),
            Yii::t('mx','View'),
        );
    }else{
        $this->breadcrumbs=array(
            Yii::t('mx','Tasks')=>array('myTasks'),
            Yii::t('mx','View'),
        );
    }

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index'),'visible'=>Yii::app()->user->isSuperAdmin),
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('myTasks'),'visible'=>!Yii::app()->user->isSuperAdmin),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx','Update'),'icon'=>'icon-pencil','url'=>array('update','id'=>$model->id)),
        //array('label'=>Yii::t('mx','Delete'),'icon'=>'icon-remove','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('mx','Are you sure you want to delete this item?'))),
        array('label'=>Yii::t('mx','Tracing'),'icon'=>'icon-comments','url'=>array('tracing','id'=>$model->id)),
    );

    $this->pageSubTitle=Yii::t('mx','View');
    $this->pageIcon='icon-list-alt';


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


    ?>

            <?php $this->widget('bootstrap.widgets.TbDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                'id',
                'name',
                'description',
                array(
                    'name'=>'status',
                    'value'=>Tasks::model()->displayStatus($model->status),
                ),
                'priority',
                array(
                    'name'=>'department',
                    'value'=>$model->department!=0 ? $model->department1->department : Yii::t("mx","Not Set")
                ),
                array(
                    'name'=>'zone',
                    'value'=>$model->zone!=0 ? $model->zone1->zone : Yii::t("mx","Not Set")
                ),
                'date_entered',
                'date_due',
                'duration',
                'days_after_date_due',

                /*array(
                    'name'=>'accepted_by',
                    'value'=>$model->accepted_by !=0 ? $model->user->username : Yii::t("mx","Not Accepted"),
                ),*/
                array(
                    'name'=>Yii::t('mx','Assigned'),
                    'value'=>$model->isgroup ==0 ? $model->employee->first_name : $model->group->name
                ),
                array(
                    'name'=>'created_by',
                    'value'=>$model->created_by!=0 ? $model->created->username : Yii::t("mx","Not Set")
                ),
            ),
            )); ?>

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Comments'),
        'headerIcon' => 'icon-comments',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
    ));
    ?>

    <div class="inner" id="tasks-grid-inner">

    <?php $this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'comment-grid',
        'type' => 'hover condensed',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Comments').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$comments,
        'columns'=>array(
            array(
                'name'=>Yii::t('mx','Date'),
                'value'=>'$data->tracing_date'
            ),
            array(
                'name'=>Yii::t('mx','Created By'),
                'value'=>'$data->user_id !=0 ? $data->user->username : Yii::t("mx","Not Accepted")'
            ),
            array(
                'name'=>Yii::t('mx','Reason'),
                'value'=>'$data->reason_id!=0 ? $data->reason->reason : Yii::t("mx","Not Set")'
            ),
            array(
                'name'=>Yii::t('mx','Comments'),
                'value'=>'$data->comment'
            ),
            array(
                'name'=>Yii::t('mx','Tracing Delay'),
                'value'=>'$data->tracing_delay'
            ),
            array(
                'name'=>Yii::t('mx','Tracing Expiration'),
                'value'=>'$data->tracing_expiration'
            ),

            array(
                'name'=>Yii::t('mx','Task Expiration'),
                'value'=>'$data->task_expiration'
            ),

        ),
    ));
    ?>
    </div>


    <?php $this->endWidget();?>
