<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'type' => 'null', // null or 'inverse'
    'brand'=>Yii::t('mx', 'Home'),
    //'brandUrl'=>array('/site/index'),
    'collapse'=>true, // requires bootstrap-responsive.css
 	'fixed' => false,
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'encodeLabel'=>false,
            'items'=>array(

               /* array(  'label' =>Yii::t('mx','Home'),
                    'url'=>array('/site/index'),
                    'icon'=>'icon-home',
                    'items' => array(
                        array('label'=>Yii::t('mx','About'), 'url'=>array('/site/page', 'view'=>'about')),
                        array('label'=>Yii::t('mx','Contact Us'), 'url'=>array('/site/contact')),
                    )
                ),*/

                array(  'label' =>Yii::t('mx','Reservations'),
                    'url' => '#',
                    //'visible'=>Yii::app()->user->isSuperAdmin,
                    'items' => array(
                        array('label'=>Yii::t('mx','Type Room'), 'url'=>array('/roomsType')),
                        array('label'=>Yii::t('mx','Rooms'), 'url'=>array('/rooms')),
                        array('label'=>Yii::t('mx','Reservation Type'), 'url'=>array('/typeReservation')),
                        array('label'=>Yii::t('mx','Seasons'), 'url'=>array('/seasons')),
                        array('label'=>Yii::t('mx','Reservations'), 'url'=>array('/reservation')),
                        array('label'=>Yii::t('mx','Holidays'), 'url'=>array('/holidays')),
                        array('label'=>Yii::t('mx','Expiration day pre booking'), 'url'=>array('/expirationdayPrebooking')),

                    )
                ),

                array(  'label' =>Yii::t('mx','Rates'),
                    //'visible'=>Yii::app()->user->isSuperAdmin,
                    'url' => '#',
                    'items' => array(
                        array('label'=>Yii::t('mx','Rates'), 'url'=>array('/rates')),
                        array('label'=>Yii::t('mx','Sales Agents'), 'url'=>array('/salesAgents'),'visible'=>Yii::app()->user->isSuperAdmin),
                        array('label'=>Yii::t('mx','Reservation Channel'), 'url'=>array('/reservationChannel'),'visible'=>Yii::app()->user->isSuperAdmin),
                        //array('label'=>Yii::t('mx','Camped And Daypass'), 'url'=>array('/campedAndDaypass')),
                    )
                ),
                array(  'label' =>Yii::t('mx','Discounts'),
                    'url' => '#',
                    'visible'=>Yii::app()->user->isSuperAdmin,
                    'items' => array(
                        array('label'=>Yii::t('mx','Camped'), 'url'=>array('/campedDiscount')),
                        array('label'=>Yii::t('mx','Cabana'), 'url'=>array('/cabanaDiscount')),
                    )
                ),

                array(  'label' =>Yii::t('mx','Formats'),
                    'url' => '#',
                    'items' => array(
                        array('label'=>Yii::t('mx','Formats'), 'url'=>array('/budgetFormat')),
                        array('label'=>Yii::t('mx','Field Formats Text'), 'url'=>array('/policies')),
                    )
                ),

                /*array(  'label' =>Yii::t('mx','Reports'),
                    'url' => '#',
                    'items' => array(
                        array('label'=>Yii::t('mx','Daily Report'), 'url'=>array('/reports')),

                    )
                ),*/

                array(  'label' =>Yii::t('mx','Bracelets'),
                    'url' => '#',
                    'visible'=>Yii::app()->user->isSuperAdmin,
                    'items' => array(
                        array('label'=>Yii::t('mx','Manage'), 'url'=>array('/assignment')),
                        array('label'=>Yii::t('mx','Uses'), 'url'=>array('/uses')),
                        //array('label'=>Yii::t('mx','Employees'), 'url'=>array('/employees')),
                        array('label'=>Yii::t('mx','Types Report'), 'url'=>array('/typesReport')),
                        array('label'=>Yii::t('mx','Bracelets'), 'url'=>array('/bracelets')),
                    )
                ),

                array(  'label' =>Yii::t('mx','Task'),
                    'url' => '#',
                    //'visible'=>Yii::app()->user->isSuperAdmin,
                    'items' => array(
                        array('label'=>Yii::t('mx','Manage'), 'url'=>array('/tasks'),'visible'=>Yii::app()->user->isSuperAdmin),
                        array('label'=>Yii::t('mx','My Tasks'), 'url'=>array('/tasks/myTasks'),'visible'=>!Yii::app()->user->isSuperAdmin),
                    )
                ),

                array(  'label' =>Yii::t('mx','Providers'),
                    'url' => '#',
                    //'visible'=>Yii::app()->user->isSuperAdmin,
                    'items' => array(
                        array('label'=>Yii::t('mx','Providers'), 'url'=>array('/providers')),
                        array('label'=>Yii::t('mx','Units Of Measurement'), 'url'=>array('/unitsMeasurement')),
                        array('label'=>Yii::t('mx','Articles'), 'url'=>array('/articles')),
                        array('label'=>Yii::t('mx','Concept of payments'), 'url'=>array('/conceptPayments')),
                        array('label'=>Yii::t('mx','Type Check'), 'url'=>array('/typeCheck')),
                        array('label'=>Yii::t('mx','Invoices'), 'url'=>array('/directInvoice')),
                        array('label'=>Yii::t('mx','Purchase Order'), 'url'=>array('/purchaseOrder')),
                    )
                ),

                array('label' =>Yii::t('mx','Customers'),
                    'url' => '#',
                    'visible'=>Yii::app()->user->isSuperAdmin,
                    'items' => array(
                        array('label'=>Yii::t('mx','Customers'), 'url'=>array('/customers')),
                    )
                ),

                array(  'label' =>Yii::t('mx','Operations'),
                    'url' => '#',
                    'visible'=>Yii::app()->user->isSuperAdmin,
                    'items' => array(
                        array('label'=>Yii::t('mx','Assign Petty Cash'), 'url'=>array('/pettyCash')),
                        array('label'=>Yii::t('mx','Employees - Cash'), 'url'=>array('/cash')),
                    )
                ),

                array('label' =>Yii::t('mx','Banks'),
                    'url' => '#',
                    //'visible'=>Yii::app()->user->isSuperAdmin,
                    'items' => array(
                        //

                        //array('label'=>Yii::t('mx','Deposits'), 'url'=>array('/operations/deposit')),
                        //array('label'=>Yii::t('mx','Payments'), 'url'=>array('/operations/payment')),
                        //array('label'=>Yii::t('mx','Transfers'), 'url'=>array('/operations/transfer')),

                        array('label'=>Yii::t('mx','Balances'), 'url'=>array('/operations')),
                        array('label'=>Yii::t('mx','Banks'), 'url'=>array('/banks')),
                        array('label'=>Yii::t('mx','Accounts'), 'url'=>array('/bankAccounts')),

                        //array('label'=>Yii::t('mx','Account Credit'), 'url'=>array('/creditOperations')),
                        //array('label'=>Yii::t('mx','Account Debit'), 'url'=>array('/debitOperations')),
                        //'---',
                        array('label'=>Yii::t('mx','Account Types'), 'url'=>array('/accountTypes')),
                        array('label'=>Yii::t('mx','Payment Type'), 'url'=>array('/paymentsTypes')),
                        array('label'=>Yii::t('mx','Persons authorized checks'), 'url'=>array('/authorizingPersons'),'visible'=>Yii::app()->user->isSuperAdmin),

                    )
                ),

                array('label' =>Yii::t('mx','Billing'),
                    'url' => '#',
                    //'visible'=>Yii::app()->user->isSuperAdmin,
                    'items' => array(
                        array('label'=>Yii::t('mx','Currency'), 'url'=>array('/currencies')),
                        array('label'=>Yii::t('mx','Payment Terms'), 'url'=>array('/paymentTerms')),
                        array('label'=>Yii::t('mx','Payment Methods'), 'url'=>array('/paymentMethods')),
                        array('label'=>Yii::t('mx','Document Types'), 'url'=>array('/documentTypes')),
                        array('label'=>Yii::t('mx','Concepts'), 'url'=>array('/concepts')),

                        //array('label'=>Yii::t('mx','Invoices'), 'url'=>array('/invoices')),

                    )
                ),

                array(  'label' => Yii::t('mx','Access Control'),
                    'url' => '#',
                    'items' =>array(
                        array('label'=>Yii::t('mx','Update Profile'), 'url'=>array('/cruge/ui/editprofile')),
                        array('label'=>Yii::t('mx','Manage Users'), 'url'=>array('/cruge/ui/usermanagementadmin')),
                        array('label'=>Yii::t('mx','Manage Employees'), 'url'=>array('/employees')),
                        array('label'=>Yii::t('mx','Roles'), 'url'=>array('/cruge/ui/rbaclistroles')),
                        //array('label'=>Yii::t('mx','Tasks'), 'url'=>array('/cruge/ui/rbaclisttasks')),
                        //array('label'=>Yii::t('mx','Operations'), 'url'=>array('/cruge/ui/rbaclistops')),
                        array('label'=>Yii::t('mx','Assign Roles to user'), 'url'=>array('/cruge/ui/rbacusersassignments')),
                        array('label'=>Yii::t('mx','Sessions'), 'url'=>array('/cruge/ui/sessionadmin')),
                        array('label'=>Yii::t('mx','System Variables'), 'url'=>array('/cruge/ui/systemupdate')),
                    ),
                    'visible'=>Yii::app()->user->isSuperAdmin
                ),

                array('label' => Yii::t('mx','Audit Trail'),
                    'url' => array('/auditTrail/admin'),
                    'visible'=>Yii::app()->user->isSuperAdmin
                ),

                array('label' =>Yii::t('mx','Contracts'),
                    'url' => '#',
                    //'visible'=>Yii::app()->user->isSuperAdmin,
                    'items' => array(
                        array('label'=>Yii::t('mx','Contracts'), 'url'=>array('/contractInformation')),
                        array('label'=>Yii::t('mx','Services'), 'url'=>array('/services'),'visible'=>Yii::app()->user->isSuperAdmin),
                        array('label'=>Yii::t('mx','Property Types'), 'url'=>array('/propertyTypes'),'visible'=>Yii::app()->user->isSuperAdmin),
                        array('label'=>Yii::t('mx','Contracts Employees'), 'url'=>array('/contractEmployees')),
                    )
                ),
                array(  'label' =>Yii::t('mx','Notes'),
                    'url' => '#',
                    'items' => array(
                        array('label'=>Yii::t('mx','Notes'), 'url'=>array('/keep')),
                    )
                ),
            ),
        ),

        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                //'---',
                array('label'=>Yii::app()->user->name, 'url'=>'#','icon'=>'user','items'=>array(
                    array('label'=>Yii::t('mx','Profile'),'icon'=>'user','url'=>array('/cruge/ui/editprofile')),
                    '---',
                    array('label'=>Yii::t('mx','Logout'), 'url'=>array('/cruge/ui/login'),'icon'=>'icon-white icon-off','visible'=>!Yii::app()->user->isGuest),
                    array('label'=>Yii::t('mx','Login'), 'url'=>array('/cruge/ui/login'), 'visible'=>Yii::app()->user->isGuest),
                )),
            ),
        ),

    ),
));
?>