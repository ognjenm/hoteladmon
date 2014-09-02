<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'type' => 'null', // null or 'inverse'
    'brand'=>Yii::t('mx', 'Home'),
    'brandUrl'=>array('/site/index'),
    'collapse'=>true, // requires bootstrap-responsive.css
    'fixed' => false,
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>Yii::t('mx', 'Home'), 'url'=>array('/site/index')),
                array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                array('label'=>'Contact', 'url'=>array('/site/contact')),

                array(  'label' =>Yii::t('mx','Reservations'),
                    'url' => '#',
                    'items' => array(
                        array('label'=>'Rooms', 'url'=>array('/rooms')),
                        array('label'=>'Rates', 'url'=>array('/rates')),
                        array('label'=>'Type Reservation', 'url'=>array('/typeReservation')),
                        array('label'=>'Seasons', 'url'=>array('/seasons')),
                        array('label'=>'Reservation', 'url'=>array('/reservation')),
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
                    array('label'=>'Profile','icon'=>'user','url'=>array('#')),
                    '---',
                    array('label'=>'Logout', 'url'=>array('/site/login'),'icon'=>'icon-white icon-off','visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                )),
            ),
        ),

    ),
));
?>