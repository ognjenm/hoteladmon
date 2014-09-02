<?php

class Sendmail extends CrugeMailer {

    public $debug = false;

    public function SendFormat($from,$to,$cc=null,$budget) {

        if($cc !=null) $this->cc=$cc;

        $this->mailfrom=$from;

        $this->sendEmail($to,Yii::t('mx','Budget'),
            $this->render('_ajaxContent', array('table'=>$budget))
        );
    }

    public function sendEmail($to,$subject,$body){
        parent::sendEmail($to,$subject,$body);
    }


}
