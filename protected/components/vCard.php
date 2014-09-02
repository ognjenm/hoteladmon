<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 15/02/14
 * Time: 11:23
 */

class vCard extends CApplicationComponent{
    public $controllerId = "providers";
    private $_controller = null;
    private $_module = null;
    private $first_name;
    private $middle_name;
    private $last_name;
    private $edu_title;
    private $prefix;
    private $suffix;
    private $nickname;
    private $company;
    private $organisation;
    private $department;
    private $job_title;
    private $note;
    private $tel_work1_voice;
    private $tel_home1_voice;
    private $tel_cell_voice;
    private $tel_car_voice;
    private $tel_pager_voice;
    private $tel_additional;
    private $tel_work_fax;
    private $tel_home_fax;
    private $tel_isdn;
    private $tel_preferred;
    private $tel_telex;
    private $work_street;
    private $work_zip;
    private $work_city;
    private $work_region;
    private $work_country;
    private $home_street;
    private $home_zip;
    private $home_city;
    private $home_region;
    private $home_country;
    private $postal_street;
    private $postal_zip;
    private $postal_city;
    private $postal_region;
    private $postal_country;
    private $url_work;
    private $role;
    private $birthday;
    private $email;
    private $email_work;
    private $email_home;
    private $rev;
    private $lang;
    private $download_dir="";
    private $card_filename="";
    private $output;
    private $output1;
    private $id;

    public function init()
    {
        parent::init();
        $this->_module = Yii::app(); // si no se quiere usar como modulo, apuntar a app()
    }

    public function setModule(CModule $module)
    {
        $this->_module = $module;
    }

    protected function getController()
    {
        if ($this->_controller == null) {
            $this->_controller = new CController($this->controllerId, $this->_module);
            $this->_controller->layout = $this->controllerId;
        }
        return $this->_controller;
    }

    protected function render($viewname, $data = array())
    {
        return $this->getController()->renderPartial($viewname, $data, true);
    }

    function vCard($downloaddir = '', $lang = '')
    {
        $this->download_dir = (string) ((strlen(trim($downloaddir)) > 0) ? $downloaddir : 'vcard');
        $this->card_filename = $this->controllerId.'-'.$this->first_name. '.vcf';
        $this->rev = (string) date('Ymd\THi00\Z',time());
        $this->setLanguage($lang);
        if ($this->checkDownloadDir() == false){
            die('error creating download directory');
        }
    }


    function checkDownloadDir()
    {
        if (!is_dir($this->download_dir)){
            if (!mkdir($this->download_dir, 0700)){
                return (boolean) false;
            }
            else{
                return (boolean) true;
            }
        }
        else{
            return (boolean) true;
        }
    }


    function setLanguage($isocode = ''){
        if ($this->isValidLanguageCode($isocode) == true){
            $this->lang = (string) ';LANGUAGE=' . $isocode;
        }
        else{
            $this->lang = (string) '';
        }
    }


    function quotedPrintableEncode($quotprint){

        return (string) preg_replace("~([\x01-\x1F\x3D\x7F-\xFF])~e", "sprintf('=%02X', ord('\\1'))", $quotprint);
    }

    function isValidLanguageCode($code)  // PHP5: protected
    {
        $isvalid = (boolean) false;
        if (preg_match('(^([a-z]{2})$|^([a-z]{2}_[a-z]{2})$|^([a-z]{2}-[a-z]{2})$)',trim($code)) > 0){
            $isvalid = (boolean) true;
        }
        return (boolean) $isvalid;
    }

    public function setId($input){ $this->id = $input; }
    public function setFirstName($input){ $this->first_name = (string) $input; }
    public function setMiddleName($input){ $this->middle_name = (string) $input; }
    public function setLastName($input){  $this->last_name = (string) $input; }
    public function setEducationTitle($input){ $this->edu_title = (string) $input; }
    public function setPrefix($input){  $this->prefix = (string) $input; }
    public function setSuffix($input){  $this->suffix = (string) $input; }
    public function setNickname($input){ $this->nickname = (string) $input;}
    public function setCompany($input){  $this->company = (string) $input; }
    public function setOrganisation($input){ $this->organisation = (string) $input; }
    public function setDepartment($input) { $this->department = (string) $input; }
    public function setJobTitle($input){ $this->job_title = (string) $input; }
    public function setNote($input){ $this->note = (string) $input; }
    public function setTelephoneWork1($input){ $this->tel_work1_voice = (string) $input; }
    public function setTelephoneHome1($input){ $this->tel_home1_voice = (string) $input; }
    public function setCellphone($input){ $this->tel_cell_voice = (string) $input; }
    public function setCarphone($input) { $this->tel_car_voice = (string) $input; }
    public function setPager($input) { $this->tel_pager_voice = (string) $input; }
    public function setAdditionalTelephone($input) {  $this->tel_additional = (string) $input; }
    public function setFaxWork($input) {  $this->tel_work_fax = (string) $input; }
    public function setFaxHome($input){  $this->tel_home_fax = (string) $input; }
    public function setISDN($input) {  $this->tel_isdn = (string) $input; }
    public function setPreferredTelephone($input){ $this->tel_preferred = (string) $input; }
    public function setWorkStreet($input) {  $this->work_street = (string) $input; }
    public function setWorkZIP($input){  $this->work_zip = (string) $input; }
    public function setWorkCity($input) {  $this->work_city = (string) $input; }
    public function setWorkRegion($input) { $this->work_region = (string) $input; }
    public function setWorkCountry($input){ $this->work_country = (string) $input; }
    public function setHomeStreet($input) { $this->home_street = (string) $input; }
    public function setHomeZIP($input){ $this->home_zip = (string) $input; }
    public function setHomeCity($input){ $this->home_city = (string) $input; }
    public function setHomeRegion($input){  $this->home_region = (string) $input; }
    public function setHomeCountry($input){  $this->home_country = (string) $input; }
    public function setPostalStreet($input) {  $this->postal_street = (string) $input;  }
    public function setPostalZIP($input){  $this->postal_zip = (string) $input; }
    public function setPostalCity($input){  $this->postal_city = (string) $input; }
    public function setPostalRegion($input){  $this->postal_region = (string) $input; }
    public function setPostalCountry($input) {  $this->postal_country = (string) $input; }
    public function setURLWork($input) {  $this->url_work = (string) $input; }
    public function setRole($input){  $this->role = (string) $input; }
    public function setEMail($input){  $this->email = (string) $input; }
    public function setEMailWork($input){  $this->email_work = (string) $input; }
    public function setEMailHome($input){  $this->email_home = (string) $input; }

    public function setBirthday($timestamp){
        $bday=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($timestamp);
        $this->birthday=date("Y-m-d",strtotime($bday));
    }


    function setData($model=array()){

        $this->setId($model->id);
        $this->setFirstName($model->first_name);
        $this->setMiddleName($model->middle_name);
        $this->setLastName($model->last_name);
        $this->setEducationTitle($model->education_title);
        $this->setPrefix($model->prefix);
        $this->setSuffix($model->suffix);
        $this->setNickname($model->nickname);
        $this->setCompany($model->company);
        $this->setOrganisation($model->organization);
        $this->setDepartment($model->department);
        $this->setJobTitle($model->job_title);
        $this->setNote($model->note);
        $this->setTelephoneWork1($model->telephone_work1);
        $this->setTelephoneHome1($model->telephone_home1);
        $this->setCellphone($model->cell_phone);
        $this->setCarphone($model->car_phone);
        $this->setPager($model->pager);
        $this->setAdditionalTelephone($model->additional_telephone);
        $this->setFaxWork($model->fax_work);
        $this->setFaxHome($model->fax_home);
        $this->setISDN($model->isdn);
        $this->setPreferredTelephone($model->preferred_telephone);
        $this->setWorkStreet($model->work_street);
        $this->setWorkZIP($model->work_zip);
        $this->setWorkCity($model->work_city);
        $this->setWorkRegion($model->work_region);
        $this->setWorkCountry($model->work_country);
        $this->setHomeStreet($model->home_street);
        $this->setHomeZIP($model->home_zip);
        $this->setHomeCity($model->home_city);
        $this->setHomeRegion($model->home_region);
        $this->setHomeCountry($model->home_country);
        $this->setPostalStreet($model->postal_street);
        $this->setPostalZIP($model->postal_zip);
        $this->setPostalCity($model->postal_city);
        $this->setPostalRegion($model->postal_region);
        $this->setPostalCountry($model->postal_country);
        $this->setURLWork($model->url_work);
        $this->setRole($model->role);
        $this->setBirthday($model->birthday);
        $this->setEMail($model->email);
        $this->setEMailWork($model->email);
        $this->setEMailHome($model->email);
    }

    function generateCardOutputAll($model=array()){


        foreach($model as $item){

            $this->output .= (string) "BEGIN:VCARD\r\n";
            $this->output .= (string) "VERSION:2.1\r\n";
            $this->output .= (string) "N;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($item->last_name . ";" . $item->first_name . ";" . $item->middle_name . ";" . $item->prefix.";" . $item->suffix). "\r\n";
            $this->output .= (string) "FN;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->prefix. " " .$this->last_name . " " .$this->first_name . " " . $this->middle_name . " " .  $this->suffix) . "\r\n";

            if (strlen(trim($item->nickname)) > 0)
                $this->output .= (string) "NICKNAME;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($item->nickname) . "\r\n";

            $this->output .= (string) "ORG" . $this->lang . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($item->company) . ";" . $this->quotedPrintableEncode($item->department) . "\r\n";

            if (strlen(trim($item->job_title)) > 0)
                $this->output .= (string) "TITLE" . $this->lang . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($item->job_title) . "\r\n";

            if (strlen(trim($item->note)) > 0)
                $this->output .= (string) "NOTE" . $this->lang . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($item->note) . "\r\n";

            if (strlen(trim($item->telephone_work1)) > 0)
                $this->output .= (string) "TEL;TYPE=WORK:" . $item->telephone_work1 . "\r\n";

            if (strlen(trim($item->telephone_home1)) > 0)
                $this->output .= (string) "TEL;TYPE=HOME:" . $item->telephone_home1 . "\r\n";

            if (strlen(trim($item->car_phone)) > 0)
                $this->output .= (string) "TEL;TYPE=CAR:" . $item->car_phone . "\r\n";

            if (strlen(trim($item->additional_telephone)) > 0)
                $this->output .= (string) "TEL:" . $item->additional_telephone . "\r\n";

            if (strlen(trim($item->pager)) > 0)
                $this->output .= (string) "TEL;TYPE=PAGER:" . $item->pager . "\r\n";

            if (strlen(trim($item->fax_home)) > 0)
                $this->output .= (string) "TEL;TYPE=WORK;TYPE=FAX:" . $item->fax_home . "\r\n";

            if (strlen(trim($item->fax_work)) > 0)
                $this->output .= (string) "TEL;TYPE=HOME;TYPE=FAX:" . $item->fax_work . "\r\n";

            if (strlen(trim($item->telephone_home2)) > 0)
                $this->output .= (string) "TEL;TYPE=HOME:" . $item->telephone_home2 . "\r\n";

            if (strlen(trim($item->isdn)) > 0)
                $this->output .= (string) "TEL;TYPE=ISDN:" . $item->isdn . "\r\n";

            if (strlen(trim($item->preferred_telephone)) > 0)
                $this->output .= (string) "TEL;TYPE=MAIN:" . $item->preferred_telephone . "\r\n";

            $this->output .= (string) "ADR;WORK:;;" . $item->work_street . ";" . $item->work_city . ";" . $item->work_region . ";" . $item->work_zip . ";" . $item->work_country . "\r\n";
            $this->output .= (string) "LABEL;WORK;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($item->work_street) . "=0D=0A" . $this->quotedPrintableEncode($item->work_street) . "=0D=0A" . $this->quotedPrintableEncode($item->work_city) . ", " . $this->quotedPrintableEncode($item->work_region) . " " . $this->quotedPrintableEncode($item->work_zip) . "=0D=0A" . $this->quotedPrintableEncode($item->work_country) . "\r\n";
            $this->output .= (string) "ADR;HOME:;;" . $item->home_street . ";" . $item->home_city . ";" . $item->home_region . ";" . $item->home_zip . ";" . $item->home_country . "\r\n";
            $this->output .= (string) "LABEL;WORK;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($item->home_street) . "=0D=0A" . $this->quotedPrintableEncode($item->home_city) . ", " . $this->quotedPrintableEncode($item->home_region) . " " . $this->quotedPrintableEncode($item->home_zip) . "=0D=0A" . $this->quotedPrintableEncode($item->home_country) . "\r\n";
            $this->output .= (string) "ADR;POSTAL:;;" . $item->postal_street . ";" . $item->postal_city . ";" . $item->postal_region . ";" . $item->postal_zip . ";" . $item->postal_country . "\r\n";
            $this->output .= (string) "LABEL;POSTAL;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($item->postal_street) . "=0D=0A" . $this->quotedPrintableEncode($item->postal_city) . ", " . $this->quotedPrintableEncode($item->postal_region) . " " . $this->quotedPrintableEncode($item->postal_zip) . "=0D=0A" . $this->quotedPrintableEncode($item->postal_country) . "\r\n";

            if (strlen(trim($item->url_work)) > 0)
                $this->output .= (string) "URL;WORK:" . $item->url_work . "\r\n";

            if (strlen(trim($item->role)) > 0)
                $this->output .= (string) "ROLE" . $this->lang . ":" . $item->role . "\r\n";


            if ($item->birthday != '31-Dic-1969'){
                $bday=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($item->birthday);
                $bday=date("Y-m-d",strtotime($bday));
                $this->output .= (string) "BDAY:" . $bday . "\r\n";
            }

            if (strlen(trim($item->email)) > 0)
                $this->output .= (string) "EMAIL;TYPE=INTERNET:" . $item->email . "\r\n";

            if (strlen(trim($item->email_work)) > 0)
                $this->output .= (string) "EMAIL;TYPE=INTERNET;TYPE=WORK:" . $item->email_work . "\r\n";

            if (strlen(trim($item->email_home)) > 0)
                $this->output .= (string) "EMAIL;TYPE=INTERNET;TYPE=HOME:" . $item->email_home . "\r\n";


            if (strlen(trim($item->telex)) > 0)
                $this->output .= (string) "EMAIL;TLX:" . $item->telex . "\r\n";

            $this->output .= (string) "REV:" . $this->rev . "\r\n";
            $this->output .= (string) "END:VCARD\r\n";

        }


    }


    function generateCardOutput()
    {
        $this->card_filename=$this->id.'-'.$this->first_name.'.vcf';

        $this->output  = (string) "BEGIN:VCARD\r\n";
        $this->output .= (string) "VERSION:2.1\r\n";
        $this->output .= (string) "N;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->last_name . ";" . $this->first_name . ";" . $this->middle_name . ";" . $this->prefix. ";" . $this->suffix) . "\r\n";
        $this->output .= (string) "FN;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode( $this->prefix. " " .$this->last_name . " " .$this->first_name . " " . $this->middle_name . " " .  $this->suffix) . "\r\n";

        if (strlen(trim($this->nickname)) > 0)
            $this->output .= (string) "NICKNAME;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->nickname) . "\r\n";

        $this->output .= (string) "ORG" . $this->lang . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->company) . ";" . $this->quotedPrintableEncode($this->department) . "\r\n";

        if (strlen(trim($this->job_title)) > 0)
            $this->output .= (string) "TITLE" . $this->lang . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->job_title) . "\r\n";

        if (strlen(trim($this->note)) > 0)
            $this->output .= (string) "NOTE" . $this->lang . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->note) . "\r\n";

        if (strlen(trim($this->tel_work1_voice)) > 0)
            $this->output .= (string) "TEL;TYPE=WORK:" . $this->tel_work1_voice . "\r\n";

        if (strlen(trim($this->tel_home1_voice)) > 0)
            $this->output .= (string) "TEL;TYPE=HOME:" . $this->tel_home1_voice . "\r\n";

        if (strlen(trim($this->tel_cell_voice)) > 0)
            $this->output .= (string) "TEL;TYPE=CELL:" . $this->tel_cell_voice . "\r\n";

        if (strlen(trim($this->tel_car_voice)) > 0)
            $this->output .= (string) "TEL;TYPE=CAR:" . $this->tel_car_voice . "\r\n";

        if (strlen(trim($this->tel_additional)) > 0)
            $this->output .= (string) "TEL:" . $this->tel_additional . "\r\n";

        if (strlen(trim($this->tel_pager_voice)) > 0)
            $this->output .= (string) "TEL;TYPE=PAGER:" . $this->tel_pager_voice . "\r\n";

        if (strlen(trim($this->tel_work_fax)) > 0)
            $this->output .= (string) "TEL;TYPE=WORK;TYPE=FAX:" . $this->tel_work_fax . "\r\n";

        if (strlen(trim($this->tel_home_fax)) > 0)
            $this->output .= (string) "TEL;TYPE=HOME;TYPE=FAX:" . $this->tel_home_fax . "\r\n";

        if (strlen(trim($this->tel_isdn)) > 0)
            $this->output .= (string) "TEL;TYPE=ISDN:" . $this->tel_isdn . "\r\n";

        if (strlen(trim($this->tel_preferred)) > 0)
            $this->output .= (string) "TEL;TYPE=MAIN:" . $this->tel_preferred . "\r\n";

        $this->output .= (string) "ADR;WORK:;;" . $this->work_street . ";" . $this->work_city . ";" . $this->work_region . ";" . $this->work_zip . ";" . $this->work_country . "\r\n";
        $this->output .= (string) "LABEL;WORK;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->work_street) . "=0D=0A" . $this->quotedPrintableEncode($this->work_street) . "=0D=0A" . $this->quotedPrintableEncode($this->work_city) . ", " . $this->quotedPrintableEncode($this->work_region) . " " . $this->quotedPrintableEncode($this->work_zip) . "=0D=0A" . $this->quotedPrintableEncode($this->work_country) . "\r\n";
        $this->output .= (string) "ADR;HOME:;;" . $this->home_street . ";" . $this->home_city . ";" . $this->home_region . ";" . $this->home_zip . ";" . $this->home_country . "\r\n";
        $this->output .= (string) "LABEL;WORK;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->home_street) . "=0D=0A" . $this->quotedPrintableEncode($this->home_city) . ", " . $this->quotedPrintableEncode($this->home_region) . " " . $this->quotedPrintableEncode($this->home_zip) . "=0D=0A" . $this->quotedPrintableEncode($this->home_country) . "\r\n";
        $this->output .= (string) "ADR;POSTAL:;;" . $this->postal_street . ";" . $this->postal_city . ";" . $this->postal_region . ";" . $this->postal_zip . ";" . $this->postal_country . "\r\n";
        $this->output .= (string) "LABEL;POSTAL;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->postal_street) . "=0D=0A" . $this->quotedPrintableEncode($this->postal_city) . ", " . $this->quotedPrintableEncode($this->postal_region) . " " . $this->quotedPrintableEncode($this->postal_zip) . "=0D=0A" . $this->quotedPrintableEncode($this->postal_country) . "\r\n";

        if (strlen(trim($this->url_work)) > 0)
            $this->output .= (string) "URL;WORK:" . $this->url_work . "\r\n";

        if (strlen(trim($this->role)) > 0)
            $this->output .= (string) "ROLE" . $this->lang . ":" . $this->role . "\r\n";

        if ($this->birthday != '1969-12-31')
            $this->output .= (string) "BDAY:" . $this->birthday . "\r\n";

        if (strlen(trim($this->email)) > 0)
            $this->output .= (string) "EMAIL;TYPE=INTERNET:" . $this->email . "\r\n";

        if (strlen(trim($this->email_work)) > 0)
            $this->output .= (string) "EMAIL;TYPE=INTERNET;TYPE=WORK:" . $this->email_work . "\r\n";

        if (strlen(trim($this->email_home)) > 0)
            $this->output .= (string) "EMAIL;TYPE=INTERNET;TYPE=HOME:" . $this->email_home . "\r\n";

        if (strlen(trim($this->tel_telex)) > 0)
            $this->output .= (string) "EMAIL;TLX:" . $this->tel_telex . "\r\n";

        $this->output .= (string) "REV:" . $this->rev . "\r\n";
        $this->output .= (string) "END:VCARD\r\n";
    }


    function getCardOutput()
    {
        if (!isset($this->output))
        {
            $this->generateCardOutput();
        } // end if
        return (string) $this->output;
    } // end function


    public function writeCardFile() {
       /* if (!isset($this->output))
        {
            $this->generateCardOutput();
        }*/

        $handle = fopen($this->download_dir . '/' . $this->card_filename, 'w');
        fputs($handle, $this->output);
        fclose($handle);
        $this->deleteOldFiles(30);
        if (isset($handle)) { unset($handle); }
    }

    function deleteOldFiles($time = 300)
    {
        if (!is_int($time) || $time < 1)
        {
            $time = (int) 300;
        } // end if
        $handle = opendir($this->download_dir);
        while ($file = readdir($handle))
        {
            if (!is_dir($this->download_dir . '/' . $file) &&  ((time() - filemtime($this->download_dir . '/' . $file)) > $time))
            {
                unlink($this->download_dir . '/' . $file);
            } // end if
        } // end while
        closedir($handle);
        if (isset($handle)) { unset($handle); }
        if (isset($file)) { unset($file); }
    } // end function


    public function downloadCardFile(){
        $dir_path = Yii::getPathOfAlias('webroot').'/'.$this->download_dir;
        $fileSize=filesize($dir_path.'/'.$this->card_filename);
        Yii::app()->quoteUtil->Download($dir_path.'/'.$this->card_filename,$fileSize);
        Yii::app()->end();
    }


} 