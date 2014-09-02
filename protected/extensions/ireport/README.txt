example

$path=Yii::getPathOfAlias('webroot');

        $parameters=array(
            'source'=>$path.'/jrxml/countries.jrxml',
            'file'=>$path.'/reports/report.pdf',
            'params'=>array(
                'stateid'=>array('int',1),
            )
        );


        $jaspereport= new IREPORT();
        $jaspereport->export($parameters);



configuration (config file)

'import'=>array(
	'application.models.*',
	'application.components.*',
        'application.extensions.ireport.IREPORT',
),

'components'=>array( 
	'IREPORT'=>array('class'=>'IREPORT')
),


