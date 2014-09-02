    <?php

    $this->breadcrumbs=array(
        Yii::t('mx','Providers')=>array('index'),
         Yii::t('mx','View'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx','Update'),'icon'=>'icon-pencil','url'=>array('update','id'=>$model->id)),
        array('label'=>Yii::t('mx','Delete'),'icon'=>'icon-remove','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('mx','Are you sure you want to delete this item?'))),
        array('label'=>Yii::t('mx','Export'),'icon'=>'icon-book','url'=>array('export','id'=>$model->id)),
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
                array(
                    'name'=>Yii::t('mx','Map'),
                    'value'=>($model->latitude!='' && $model->longitude!='') ? Providers::linkMap($model->latitude,$model->longitude) : Yii::t('mx','Not set'),
                    'type'=>'raw'
                ),
                'first_name',
                'middle_name',
                'last_name',
                'prefix',
                'suffix',
                'education_title',
                'nickname',
                'company',
                'department',
                'job_title',
                'note',
                'telephone_work1',
                'telephone_work2',
                'telephone_home1',
                'telephone_home2',
                'cell_phone',
                'car_phone',
                'pager',
                'additional_telephone',
                'fax_work',
                'fax_home',
                'isdn',
                'preferred_telephone',
                'telex',
                'work_street',
                'work_neighborhood',
                'work_city',
                'work_region',
                'work_country',
                'work_zip',
                'home_street',
                'home_zip',
                'home_city',
                'home_region',
                'home_country',
                'postal_street',
                'postal_zip',
                'postal_city',
                'postal_region',
                'postal_country',
                'url_work',
                'role',
                array(
                    'name'=>'birthday',
                    'value'=>$model->birthday=='31-Dic-1969' ? Yii::t('mx','Not set') : $model->birthday
                ),
                'email',
                'email_work',
                'email_home',
                'rfc',
                'outside_number',
                'internal_number',
                'reference',
                'account_number',
                'municipality',
                array(
                    'name'=>'zone',
                    'value'=>$model->zone=='' ? Yii::t('mx','Not set') : $model->zone1->zone
                )
            ),
            )); ?>

    <?php

    $this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'Operations-History',
        'type' => 'hover condensed striped',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Providers History').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'pager' => array(
            'class' => 'bootstrap.widgets.TbPager',
            'displayFirstAndLast' => true,
            'lastPageLabel'=>Yii::t('mx','Last'),
            'firstPageLabel'=>Yii::t('mx','First'),
        ),
        'dataProvider'=>$providersHistory,
        'columns'=>array(
            'field',
            'old_value',
            'new_value',
            'stamp',
            array(
                'name'=>'user_id',
                'value'=>'$data->users->username'
            ),
        ),
    ));
    ?>
