<?php


class VcardImport extends CApplicationComponent {

    public $controllerId = "providers";
    private $_controller = null;
    private $_module = null;
    private $_map;

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


    function importVcard($file=null){
        $categories_to_display=null;
        $hide=null;


        $lines = file($file);

        $cards = $this->parse_vcards($lines);


        $all_categories = $this->get_vcard_categories($cards);

        if (!$categories_to_display) {
            $categories_to_display = array('All');
        } else if ($categories_to_display == '*') {
            $categories_to_display = $all_categories;
        } else {
            $categories_to_display = explode(',', $categories_to_display);
        }

        if ($hide) {
            $hide = explode(',', $hide);
        } else {
            $hide = array();
        }

        echo "<p class='categories'>\nCategories: ";
        echo join(', ', $categories_to_display);
        echo "<br />\n</p>\n";

        $i = 0;

        foreach ($cards as $card_name => $card) {
            if (!$card->inCategories($categories_to_display)) {
                continue;
            }
            if ($i == 0) {
                echo "<table width='100%' cellspacing='4' border='0'>\n";
                echo "<tr>\n";
            }
            echo "<td class='vcard' width='50%' valign='top'>\n";
            echo "<p class='name'><strong>$card_name</strong>";
            // Add the categories (if present) after the name.
            $property = $card->getProperty('CATEGORIES');


            if ($property) {
                // Replace each comma by a comma and a space.
                $categories = $property->getComponents(',');
                $categories = join(', ', $categories);
                echo "&nbsp;($categories)";
            }



            echo "</p>\n";
            $this->print_vcard($card, $hide);

            echo "</td>\n";
            $i = ($i + 1) % 2;
            if ($i == 0) {
                echo "</tr>\n";
                echo "</table>\n";
            }
        }

        if ($i != 0) {
            echo "<td>&nbsp;</td>\n";
            echo "</tr>\n";
            echo "</table>\n";
        }


    }

    function print_vcard($card, $hide)
    {
        $names = array('N','FN', 'TITLE', 'ORG', 'TEL', 'EMAIL', 'URL', 'ADR', 'BDAY', 'NOTE');
        $types=null;
        $row = 0;
        $model=new Providers;


        foreach ($names as $name) {
            if ($this->in_array_case($name, $hide)) {
                continue;
            }
            $properties = $card->getProperties($name);


            if ($properties) {
                foreach ($properties as $property) {
                    $show = true;


                    if(isset($property->params['TYPE'])){
                        $types = $property->params['TYPE'];
                    }

                    if ($types) {
                        foreach ($types as $type) {
                            if ($this->in_array_case($type, $hide)) {
                                $show = false;
                                break;
                            }
                        }
                    }

                    if ($show) {
                        $class = ($row++ % 2 == 0) ? "property-even" : "property-odd";

                        $value = $property->value;
                        $name = $property->name;
                        $types = null;
                        $type=null;

                        if(isset($property->params['TYPE'])) $type = join(", ",$property->params['TYPE']);

                        switch ($name) {

                            case 'N' :
                                $personal = $property->getComponents();
                                if (isset($personal[3])){ $model->prefix=$personal[3];  }
                                if (isset($personal[0])){ $model->first_name=$personal[0];  }
                                if (isset($personal[1])){ $model->last_name=$personal[1];  }
                                if (isset($personal[2])){ $model->middle_name=$personal[2]; }
                                //if (isset($personal[4])){  echo "<strong>suffix:</strong> ".$personal[4]."<br>";}
                                $html = "";
                                break;

                            case 'FN' :
                                    $fullName = $property->getComponents();
                                    if (isset($fullName[0])){ $model->full_name=$fullName[0]; }
                                    $html = "";
                                    break;

                            case 'TITLE':
                                    $title = $property->getComponents();
                                    if (isset($title[0])){  $model->education_title=$title[0];}
                                    $html = "";
                                    break;
                            case 'ORG':
                                    $org= $property->getComponents();
                                    if (isset($org[0])){  $model->organization=$org[0];}
                                    if (isset($org[1])){  $model->department=$org[1];}
                                    $html = "";
                                    break;

                            case 'TEL':

                                $tel= $property->getComponents();

                                if($type=='WORK' && isset($tel[0])) { $model->telephone_work1; $tel[0]; }
                                if($type=='HOME' && isset($tel[0])) { $model->telephone_work1;  $tel[0]; }
                                if($type=='CELL' && isset($tel[0])) { $model->cell_phone=$tel[0]; }
                                if($type=='CAR' && isset($tel[0])) {  $model->car_phone=$tel[0]; }
                                if($type=='PAGER' && isset($tel[0])) { $model->pager=$tel[0]; }
                                if($type=='ISDN' && isset($tel[0])) {  $model->isdn=$tel[0]; }
                                if($type=='MAIN' && isset($tel[0])) {  $model->preferred_telephone=$tel[0]; }
                                if($type=='WORK, FAX' && isset($tel[0])) { $model->fax_work=$tel[0]; }
                                if($type=='HOME, FAX' && isset($tel[0])) { $model->fax_home=$tel[0]; }
                                if($type=='' && isset($tel[0])) {  $model->additional_telephone=$value; }

                                $html = "";
                            break;

                            case 'ADR':

                                $adr = $property->getComponents();

                                if($type=='WORK'){

                                    if (isset($adr[0])){ echo "<strong>Trabajo Apartado:</strong> ".$adr[0]."<br>"; }
                                    if (isset($adr[1])){ echo "<strong>Trabajo Barrio:</strong> ".$adr[1]."<br>"; }
                                    if (isset($adr[2])){ $model->work_street=$adr[2];  echo "<strong>Trabajo Calle:</strong> ".$adr[2]."<br>"; }
                                    if (isset($adr[3])){ $model->work_city=$adr[3]; echo "<strong>Trabajo Ciudad:</strong> ".$adr[3]."<br>";}
                                    if (isset($adr[4])){ $model->work_region=$adr[4]; echo "<strong>Trabajo Estado/provincia:</strong> ".$adr[4]."<br>";}
                                    if (isset($adr[5])){ $model->work_zip=$adr[5]; echo "<strong>Trabajo Zip/ postal code:</strong> ".$adr[5]."<br>";}
                                    if (isset($adr[6])){ $model->work_country=$adr[6]; echo "<strong>Trabajo Pais/region:</strong> ".$adr[6]."<br>";}

                                }

                                if($type=='HOME'){

                                    if (isset($adr[0])){  echo "<strong>Casa Apartado:</strong> ".$adr[0]."<br>"; }
                                    if (isset($adr[1])){  echo "<strong>Casa Barrio:</strong> ".$adr[1]."<br>"; }
                                    if (isset($adr[2])){ $model->home_street=$adr[2]; echo "<strong>Casa Calle:</strong> ".$adr[2]."<br>"; }
                                    if (isset($adr[3])){ $model->home_city=$adr[3]; echo "<strong>Casa Ciudad:</strong> ".$adr[3]."<br>";}
                                    if (isset($adr[4])){ $model->home_region=$adr[4]; echo "<strong>Casa Estado/provincia:</strong> ".$adr[4]."<br>";}
                                    if (isset($adr[5])){ $model->home_zip=$adr[5]; echo "<strong>Casa Zip/ postal code:</strong> ".$adr[5]."<br>";}
                                    if (isset($adr[6])){ $model->home_country=$adr[6]; echo "<strong>Casa Pais/region:</strong> ".$adr[6]."<br>";}

                                }

                                if($type=='POSTAL'){

                                    if (isset($adr[0])){  echo "<strong>Casa Apartado:</strong> ".$adr[0]."<br>"; }
                                    if (isset($adr[1])){  echo "<strong>Casa Barrio:</strong> ".$adr[1]."<br>"; }
                                    if (isset($adr[2])){ $model->postal_street=$adr[2]; echo "<strong>Casa Calle:</strong> ".$adr[2]."<br>"; }
                                    if (isset($adr[3])){ $model->postal_city=$adr[3]; echo "<strong>Casa Ciudad:</strong> ".$adr[3]."<br>";}
                                    if (isset($adr[4])){ $model->postal_region=$adr[4]; echo "<strong>Casa Estado/provincia:</strong> ".$adr[4]."<br>";}
                                    if (isset($adr[5])){ $model->postal_zip=$adr[5]; echo "<strong>Casa Zip/ postal code:</strong> ".$adr[5]."<br>";}
                                    if (isset($adr[6])){ $model->postal_country=$adr[6]; echo "<strong>Casa Pais/region:</strong> ".$adr[6]."<br>";}

                                }

                                $html = "";

                                break;

                            case 'EMAIL':
                                $model->email=$value;
                                $html = "";
                                break;

                            case 'URL':
                                $model->url_work=$value;
                                $html = "";
                                break;
                            case 'BDAY':
                                $model->birthday=$value;
                                $html = "";
                                break;
                            case 'NOTE':
                                $model->note=$value;
                                $html = "";
                                break;

                            default:
                                $components = $property->getComponents();
                                $lines = array();
                                foreach ($components as $component) {
                                    if ($component) {
                                        $lines[] = $component;
                                    }
                                }
                                $html = join("\n", $lines);


                                break;
                        }

                        $model->save();

                        echo "<p class='$class'>\n";

                        echo nl2br(stripcslashes($html));

                        if($type) echo " (" .$type . ")";

                        echo "\n</p>\n";


                        //$this->print_vcard_property($property, $class, $hide);



                    }
                }
            }
        }
    }

    function print_vcard_property($property, $class, $hide)
    {
        $value = $property->value;
        $name = $property->name;
        $types = null;
        $type=null;
        $model=new Providers;

        if(isset($property->params['TYPE'])) $type = join(", ",$property->params['TYPE']);

        switch ($name) {

            case 'N' :

                $personal = $property->getComponents();

                if (isset($personal[3])){ $model->prefix=$personal[3]; echo "<strong>prefix:</strong> ".$personal[3]."<br>"; }
                if (isset($personal[0])){ $model->first_name=$personal[0]; echo "<strong>last name:</strong> ".$personal[0]."<br>"; }
                if (isset($personal[1])){ $model->last_name=$personal[1]; echo "<strong>first name:</strong> ".$personal[1]."<br>"; }
                if (isset($personal[2])){ $model->middle_name=$personal[2]; echo "<strong>middle name:</strong> ".$personal[2]."<br>";}
                if (isset($personal[4])){  echo "<strong>suffix:</strong> ".$personal[4]."<br>";}

                $html = "";
                break;


            case 'ADR':

                $adr = $property->getComponents();

                if($type=='WORK'){

                    if (isset($adr[0])){ echo "<strong>Trabajo Apartado:</strong> ".$adr[0]."<br>"; }
                    if (isset($adr[1])){ echo "<strong>Trabajo Barrio:</strong> ".$adr[1]."<br>"; }
                    if (isset($adr[2])){ $model->work_street=$adr[2];  echo "<strong>Trabajo Calle:</strong> ".$adr[2]."<br>"; }
                    if (isset($adr[3])){ $model->work_city=$adr[3]; echo "<strong>Trabajo Ciudad:</strong> ".$adr[3]."<br>";}
                    if (isset($adr[4])){ $model->work_region=$adr[4]; echo "<strong>Trabajo Estado/provincia:</strong> ".$adr[4]."<br>";}
                    if (isset($adr[5])){ $model->work_zip=$adr[5]; echo "<strong>Trabajo Zip/ postal code:</strong> ".$adr[5]."<br>";}
                    if (isset($adr[6])){ $model->work_country=$adr[6]; echo "<strong>Trabajo Pais/region:</strong> ".$adr[6]."<br>";}

                }

                if($type=='HOME'){

                    if (isset($adr[0])){  echo "<strong>Casa Apartado:</strong> ".$adr[0]."<br>"; }
                    if (isset($adr[1])){  echo "<strong>Casa Barrio:</strong> ".$adr[1]."<br>"; }
                    if (isset($adr[2])){ $model->home_street=$adr[2]; echo "<strong>Casa Calle:</strong> ".$adr[2]."<br>"; }
                    if (isset($adr[3])){ $model->home_city=$adr[3]; echo "<strong>Casa Ciudad:</strong> ".$adr[3]."<br>";}
                    if (isset($adr[4])){ $model->home_region=$adr[4]; echo "<strong>Casa Estado/provincia:</strong> ".$adr[4]."<br>";}
                    if (isset($adr[5])){ $model->home_zip=$adr[5]; echo "<strong>Casa Zip/ postal code:</strong> ".$adr[5]."<br>";}
                    if (isset($adr[6])){ $model->home_country=$adr[6]; echo "<strong>Casa Pais/region:</strong> ".$adr[6]."<br>";}

                }

                $html = "";

                break;

            case 'EMAIL':

                $html = "<a href='mailto:$value'>$value</a>";

                break;
            case 'URL':
                $html = "<a href='$value' target='_base'>$value</a>";
                break;
            case 'BDAY':
                $html = "Birthdate: $value";
                break;
            default:
                $components = $property->getComponents();
                $lines = array();
                foreach ($components as $component) {
                    if ($component) {
                        $lines[] = $component;
                    }
                }
                $html = join("\n", $lines);


                break;
        }

        $model->save();

        echo "<p class='$class'>\n";

        echo nl2br(stripcslashes($html));

        if($type) echo " (" .$type . ")";

        echo "\n</p>\n";
    }

    function get_vcard_categories(&$cards)
    {
        $unfiled = false;   // set if there is at least one unfiled card
        $result = array();
        foreach ($cards as $card_name => $card) {
            $properties = $card->getProperties('CATEGORIES');
            if ($properties) {
                foreach ($properties as $property) {
                    $categories = $property->getComponents(',');
                    foreach ($categories as $category) {
                        if (!in_array($category, $result)) {
                            $result[] = $category;
                        }
                    }
                }
            } else {
                $unfiled = true;
            }
        }
        if ($unfiled && !in_array('Unfiled', $result)) {
            $result[] = 'Unfiled';
        }
        return $result;
    }


    function parse_vcards(&$lines)
    {
        $cards = array();
        $card = new VcardImport();

        while ($card->parse($lines)) {

            $tmp = array();
            $ret = array();

            $property = $card->getProperty('N');

            if (!$property) {
                return "";
            }

            $n = $property->getComponents();


            if (isset($n[3])) $tmp[] = $n[3];      // Mr.
            if (isset($n[1])) $tmp[] = $n[1];      // John
            if (isset($n[2])) $tmp[] = $n[2];      // Quinlan
            if (isset($n[4])) $tmp[] = $n[4];      // Esq.
            if (isset($n[0])) $ret[] = $n[0];



            $tmp = join(" ", $tmp);
            if ($tmp) $ret[] = $tmp;
            $key = join(", ", $ret);
            $cards[$key] = $card;
            // MDH: Create new VCard to prevent overwriting previous one (PHP5)
            $card = new VcardImport();
        }

        ksort($cards);

        return $cards;
    }


    function in_array_case($str, $arr)
    {
        foreach ($arr as $s) {
            if (strcasecmp($str, $s) == 0) {
                return true;
            }
        }
        return false;
    }


    /*=======================termina================================*/


    function parse(&$lines)
    {
        $this->_map = null;
        $property = new VCardProperty();
        while ($property->parse($lines)) {
            if (is_null($this->_map)) {
                if ($property->name == 'BEGIN') {
                    $this->_map = array();
                }
            } else {
                if ($property->name == 'END') {
                    break;
                } else {
                    $this->_map[$property->name][] = $property;
                }
            }
            // MDH: Create new property to prevent overwriting previous one
            // (PHP5)
            $property = new VCardProperty();
        }
        return $this->_map != null;
    }


    function getProperty($name)
    {

        if (isset($this->_map[$name][0])) {
            return $this->_map[$name][0];
        }
        else{
            return null;
        }


    }

    function getProperties($name)
    {

        if (isset($this->_map[$name])) {
            return $this->_map[$name];
        }
        else{
            return null;
        }

    }


    function getCategories()
    {
        $property = $this->getProperty('CATEGORIES');
        // The Mac OS X Address Book application uses the CATEGORY property
        // instead of the CATEGORIES property.
        if (!$property) {
            $property = $this->getProperty('CATEGORY');
        }
        if ($property) {
            $result = $property->getComponents(',');
        } else {
            $result = array('Unfiled');
        }
        $result[] = "All";      // Each card is always a member of "All"
        return $result;
    }


    function inCategories(&$categories)
    {
        $our_categories = $this->getCategories();
        foreach ($categories as $category) {
            if ($this->in_array_case($category, $our_categories)) {
                return true;
            }
        }
        return false;
    }


}

class VCardProperty
{
    var $name;          // string
    var $params;        // params[PARAM_NAME] => value[,value...]
    var $value;         // string


    function parse(&$lines)
    {
        while (list(, $line) = each($lines)) {

            $line = rtrim($line);
            $tmp = $this->split_quoted_string(":", $line, 2);

            if (count($tmp) == 2) {

                $this->value = $tmp[1];
                $tmp = strtoupper($tmp[0]);
                $tmp = $this->split_quoted_string(";", $tmp);
                $this->name = $tmp[0];
                $this->params = array();

                for ($i = 1; $i < count($tmp); $i++) {
                    $this->_parseParam($tmp[$i]);
                }

                if(isset($this->params['ENCODING'][0])){
                    if ($this->params['ENCODING'][0] == 'QUOTED-PRINTABLE') {
                        $this->_decodeQuotedPrintable($lines);
                    }
                }

                if(isset($this->params['CHARSET'][0])){
                    if ($this->params['CHARSET'][0] == 'UTF-8') {
                        $this->value = utf8_decode($this->value);
                    }
                }

                return true;
            }
        }
        return false;
    }


    function getComponents($delim = ";")
    {
        $value = $this->value;
        $value = str_replace("\\$delim", "\x00", $value);
        $value = str_replace("$delim", "\x01", $value);
        $value = str_replace("\x00", "$delim", $value);
        return explode("\x01", $value);
    }


    function _parseParam($param)
    {
        $tmp = $this->split_quoted_string('=', $param, 2);
        if (count($tmp) == 1) {
            $value = $tmp[0];
            $name = $this->_paramName($value);
            $this->params[$name][] = $value;
        } else {
            $name = $tmp[0];
            $values = $this->split_quoted_string(',', $tmp[1]);
            foreach ($values as $value) {
                $this->params[$name][] = $value;
            }
        }
    }


    function _paramName($value)
    {
        static $types = array (
            'DOM', 'INTL', 'POSTAL', 'PARCEL','HOME', 'WORK',
            'PREF', 'VOICE', 'FAX', 'MSG', 'CELL', 'PAGER',
            'BBS', 'MODEM', 'CAR', 'ISDN', 'VIDEO',
            'AOL', 'APPLELINK', 'ATTMAIL', 'CIS', 'EWORLD',
            'INTERNET', 'IBMMAIL', 'MCIMAIL',
            'POWERSHARE', 'PRODIGY', 'TLX', 'X400',
            'GIF', 'CGM', 'WMF', 'BMP', 'MET', 'PMB', 'DIB',
            'PICT', 'TIFF', 'PDF', 'PS', 'JPEG', 'QTIME',
            'MPEG', 'MPEG2', 'AVI',
            'WAVE', 'AIFF', 'PCM',
            'X509', 'PGP');
        static $values = array (
            'INLINE', 'URL', 'CID');
        static $encodings = array (
            '7BIT', 'QUOTED-PRINTABLE', 'BASE64');
        $name = 'UNKNOWN';
        if (in_array($value, $types)) {
            $name = 'TYPE';
        } elseif (in_array($value, $values)) {
            $name = 'VALUE';
        } elseif (in_array($value, $encodings)) {
            $name = 'ENCODING';
        }
        return $name;
    }


    function _decodeQuotedPrintable(&$lines)
    {
        $value = &$this->value;
        while ($value[strlen($value) - 1] == "=") {
            $value = substr($value, 0, strlen($value) - 1);
            if (!(list(, $line) = each($lines))) {
                break;
            }
            $value .= rtrim($line);
        }
        $value = quoted_printable_decode($value);
    }

    function split_quoted_string($d, $s, $n = 0)
    {
        $quote = false;
        $len = strlen($s);
        for ($i = 0; $i < $len && ($n == 0 || $n > 1); $i++) {
            $c = $s{$i};
            if ($c == '"') {
                $quote = !$quote;
            } else if (!$quote && $c == $d) {
                $s{$i} = "\x00";
                if ($n > 0) {
                    $n--;
                }
            }
        }
        return explode("\x00", $s);
    }

}



?>