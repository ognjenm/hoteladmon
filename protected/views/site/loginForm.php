<?php
/**
 * Created by chinux.
 * Email: chinuxe@gmail.com
 * Date: 10/3/13
 * Time: 4:19 PM
 */
 ?>


<?php

return array(
    'title'=>'Please provide your login credential',

    'elements'=>array(

        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
            'class'=>'span10'
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),



        'rememberMe'=>array(
            'type'=>'checkbox',
        ),


    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'link',
            'label'=>'Login',
            'class'=>'btn btn-primary'
        ),
        'reset' => array(
            'type' => 'reset',
            'label' => 'Reset',
            'class'=>'btn'
        ),
    ),
);

?>