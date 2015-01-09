<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'HotelAdmon',

    'theme'=>'cocotheme',
    'language'=>'es_mx',
    //'sourceLanguage'=>'es_mx',
    'defaultController' => 'cruge/ui/login',
    'preload'=>array('log','bootstrap'),
    'timeZone' => 'America/Mexico_City',

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.modules.cruge.components.*',
        'application.modules.cruge.extensions.crugemailer.*',
        'application.vendors.phpexcel.PHPExcel',
        'application.modules.auditTrail.models.AuditTrail',
    ),

    'modules'=>array(

        'auditTrail'=>array(
            'userClass' => 'CrugeUser1',
            'userIdColumn' => 'iduser',
            'userNameColumn' => 'username',
        ),

        'cruge'=>array(
            'tableprefix'=>'cruge_',

            'availableAuthMethods'=>array('default'),
            'availableAuthModes'=>array('username','email'),
            'baseUrl'=>'http://hoteladmon.com/',

            'debug'=>false,
            'rbacSetupEnabled'=>true,
            'allowUserAlways'=>false,

            'useEncryptedPassword' => false,

            'hash' => 'md5',

            'afterLoginUrl'=>array('/site/index'),
            'afterLogoutUrl'=>array('/cruge/ui/login'),
            'afterSessionExpiredUrl'=>array('/cruge/ui/login'),

            'loginLayout'=>'//layouts',
            'registrationLayout'=>'//layouts/login',
            'activateAccountLayout'=>'//layouts/login',
            'editProfileLayout'=>'//layouts/column2',

            'generalUserManagementLayout'=>'//layouts/column2',

            'userDescriptionFieldsArray'=>array('email'),

        ),

        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'cocoaventuras',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
            'generatorPaths'=>array(
                'bootstrap.gii',
            ),
        ),

    ),

    // application components
    'components'=>array(

        'format' => array('class' => 'CLocalizedFormatter'),

        'quoteUtil' => array(
            'class' => 'application.components.QuoteDetails',
        ),

        'vCard' => array(
            'class' => 'application.components.vCard',
        ),

        'VcardImport' => array(
            'class' => 'application.components.VcardImport',
        ),

        'ePdf' => array(
            'class'         => 'ext.yii-pdf.EYiiPdf',
            'params'        => array(
                'mpdf'     => array(
                    'librarySourcePath' => 'application.vendors.mpdf.*',
                    'constants'         => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class'=>'mpdf',
                    'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                       'mode'              => 'c', //  This parameter specifies the mode of the new document.
                       'format'            => 'LETTER', // format A4, A5, ...
                       'default_font_size' => 8, // Sets the default document font size in points (pt)
                       'default_font'      => 'arial', // Sets the default font-family for the new document.
                       'mgl'               => 10, // margin_left. Sets the page margins for the new document.
                       'mgr'               => 10, // margin_right
                       'mgt'               => 30, // margin_top
                       'mgb'               => 20, // margin_bottom
                       'mgh'               => 10, // margin_header
                       'mgf'               => 10, // margin_footer
                       'orientation'       => 'P', // landscape or portrait orientation
                   )
                ),
                'HTML2PDF' => array(
                    'librarySourcePath' => 'application.vendors.html2pdf.*',
                    'classFile'         => 'html2pdf.class.php',
                    'defaultParams'     => array(
                        'orientation' => 'P',
                        'format'      => 'A4',
                        'language'    => 'en',
                        'unicode'     => true,
                        'encoding'    => 'UTF-8',
                        'marges'      => array(5, 5, 5, 8),
                    )
                )
            ),
        ),

        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => TRUE,
            'fontAwesomeCss' => TRUE,
        ),

        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
            'class' => 'application.modules.cruge.components.CrugeWebUser',
            'loginUrl' => array('/cruge/ui/login'),
        ),

        'authManager' => array(
            'class' => 'application.modules.cruge.components.CrugeAuthManager',
        ),
        'crugemailer'=>array(
            //'class'=>'application.modules.cruge.components.CrugeMailer',
            'class' => 'application.components.Sendmail',
            'mailfrom' => 'cocoaventura@gmail.com',
            'subjectprefix' => 'CocoAventura - ',
            'debug' => true,
        ),
        'format' => array(
            'datetimeFormat'=>"d-M-Y H:i",
            'dateFormat'=>'yy-M-dd',
            //'timeFormat'=>'H:i',
        ),


        'urlManager'=>array(
            'urlFormat'=>'path',
            /*'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),*/
        ),


        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=chinoixeofadmon',
            'emulatePrepare' => true,
            'username' => 'chinoixeofadmon',
            'password' => 'b44AdmiN150@',
            'charset' => 'utf8',
        ),

        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                // uncomment the following to show log messages on web pages

                		/*array(
                            'class'=>'CWebLogRoute',
                        ),*/

            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'cocoaventura@gmail.com',
        'pagination'=>20,
    ),
);