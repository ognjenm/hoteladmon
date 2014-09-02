<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'type' => 'null', // null or 'inverse'
    //'brand'=>Yii::t('mx', 'Home'),
    //'brandUrl'=>array('/site/index'),
    'collapse'=>true, // requires bootstrap-responsive.css
    'fixed' => false,
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(

                array(  'label' =>Yii::t('mx','Home'),
                    'url'=>array('/site/index'),
                    'icon'=>'icon-home',
                    'items' => array(
                        array('label'=>Yii::t('mx','Home'), 'url'=>array('/site')),
                        array('label'=>Yii::t('mx','About'), 'url'=>array('/site/page', 'view'=>'about')),
                        array('label'=>Yii::t('mx','Contact Us'), 'url'=>array('/site/contact')),
                    )
                ),

                array(  'label' =>Yii::t('mx','Cabanas And Tent'),
                    'url' => '#',
                    'items' => array(
                        array('label'=>Yii::t('mx','Type Room'), 'url'=>array('/roomsType')),
                        array('label'=>Yii::t('mx','Rooms'), 'url'=>array('/rooms')),
                        array('label'=>Yii::t('mx','Reservation Type'), 'url'=>array('/typeReservation')),
                        array('label'=>Yii::t('mx','Seasons'), 'url'=>array('/seasons')),
                        array('label'=>Yii::t('mx','Reservations'), 'url'=>array('/reservation')),

                    )
                ),

                array(  'label' =>Yii::t('mx','Rates'),
                    'url' => '#',
                    'items' => array(
                        array('label'=>Yii::t('mx','Rates'), 'url'=>array('/rates')),
                        array('label'=>Yii::t('mx','Sales Agents'), 'url'=>array('/salesAgents')),
                        array('label'=>Yii::t('mx','Reservation Channel'), 'url'=>array('/reservationChannel')),
                        //array('label'=>Yii::t('mx','Camped And Daypass'), 'url'=>array('/campedAndDaypass')),
                    )
                ),
                array(  'label' =>Yii::t('mx','Discounts'),
                    'url' => '#',
                    'items' => array(
                        array('label'=>Yii::t('mx','Camped'), 'url'=>array('/campedDiscount')),
                        array('label'=>Yii::t('mx','Cabana'), 'url'=>array('/cabanaDiscount')),
                    )
                ),

                array(  'label' =>Yii::t('mx','Formats'),
                    'url' => '#',
                    'items' => array(
                        array('label'=>Yii::t('mx','Formats Budgets'), 'url'=>array('/budgetFormat')),
                        array('label'=>Yii::t('mx','Others Formats'), 'url'=>array('/emailFormats')),
                        array('label'=>Yii::t('mx','Field Formats Text'), 'url'=>array('/policies')),
                    )
                ),

                array(  'label' =>Yii::t('mx','Reports'),
                    'url' => '#',
                    'items' => array(
                        array('label'=>Yii::t('mx','Daily Report'), 'url'=>array('/reports')),

                    )
                ),

                array(  'label' =>Yii::t('mx','Operations'),
                    'url' => '#',
                    'items' => array(
                        array('label' => Yii::t('mx','CATALOGS')),
                        array('label'=>Yii::t('mx','Customers'), 'url'=>array('/customers')),
                        array('label'=>Yii::t('mx','Providers'), 'url'=>array('/providers')),
                        array('label'=>Yii::t('mx','Concepts'), 'url'=>array('/concepts')),
                        array('label'=>Yii::t('mx','Banks'), 'url'=>array('/banks')),
                        array('label'=>Yii::t('mx','Payments Types'), 'url'=>array('/paymentsTypes')),
                        '--',
                        array('label' => Yii::t('mx','OPERATIONS')),
                        array('label'=>Yii::t('mx','Payments'), 'url'=>array('/operations/payment')),
                        array('label'=>Yii::t('mx','Deposits'), 'url'=>array('/operations/deposit')),
                        //array('label'=>Yii::t('mx','Transfer between accounts'), 'url'=>array('/operations/transfer')),
                        array('label'=>Yii::t('mx','Balance'), 'url'=>array('/operations')),
                    )
                ),

                array(  'label' => Yii::t('mx','Access Control'),
                    'url' => '#',
                    'items' =>Yii::app()->user->ui->adminItems,
                    'visible'=>Yii::app()->user->isSuperAdmin
                ),

                array('label' => Yii::t('mx','Audit Trail'),
                    'url' => array('/auditTrail/admin'),
                    'visible'=>Yii::app()->user->isSuperAdmin
                ),


            ),
        ),

        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                //'---',
                array('label'=>Yii::app()->user->name, 'url'=>'#','icon'=>'user','items'=>array(
                    array('label'=>'Profile','icon'=>'user','url'=>array('/cruge/ui/editprofile')),
                    '---',
                    array('label'=>Yii::t('mx','Logout'), 'url'=>array('/cruge/ui/login'),'icon'=>'icon-white icon-off','visible'=>!Yii::app()->user->isGuest),
                    array('label'=>Yii::t('mx','Login'), 'url'=>array('/cruge/ui/login'), 'visible'=>Yii::app()->user->isGuest),
                )),
            ),
        ),

    ),
));
?>