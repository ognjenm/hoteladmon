<?php


class VCard
{
   
var $_map;
  

function importVcard($file=null){
	$categories_to_display=null;
	$hide=null;
    
    echo "<html>\n<head>\n<title>demo</title>\n";  
    echo "<link href='style.css' type='text/css' rel='stylesheet'>\n";
    echo "</head>\n<body>\n";
    echo "<h1>vCard PHP - A vCard Address Book</h1>\n";

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



    
    echo "</body>\n</html>\n";
}


/**
 * Prints the vCard as HTML.
 */
function print_vcard($card, $hide)
{
    $names = array('N','FN', 'TITLE', 'ORG', 'TEL', 'EMAIL', 'URL', 'ADR', 'BDAY', 'NOTE');
	 $types=null;
    $row = 0;

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
                    $this->print_vcard_property($property, $class, $hide);
                    
                }
            }
        }
    }
}

/**
 * Prints a VCardProperty as HTML.
 */
function print_vcard_property($property, $class, $hide)
{
    $name = $property->name;
    $value = $property->value;
    $types = null;     
    
		$type=null;
      if(isset($property->params['TYPE'])) $type = join(", ",$property->params['TYPE']);
        
    switch ($name) {
    	
    	case 'N' :
    	
    		$personal = $property->getComponents();   	    	
    	
      	$lines = array();
      
      	foreach($personal as $item){
      		$lines[] = $item;
      	}
      
        if (isset($lines[3])){ echo "prefix: ".$lines[3]."<br>"; }       // Mr.
        if (isset($lines[0])){ echo "last name: ".$lines[0]."<br>"; }     // John
        if (isset($lines[1])){ echo "first name: ".$lines[1]."<br>"; }     // John
        if (isset($lines[2])){ echo "middle name: ".$lines[2]."<br>";}       // Quinlan
        if (isset($lines[4])){ echo "suffix: ".$lines[4]."<br>";}      // Esq.
           	
  
  			$html = ""; //join("\n", $lines);
            
      break;
      
      case 'FN' :

      	$fullName = $property->getComponents();
      	if (isset($fullName[0])){ echo "<strong>Full Name:</strong> ".$fullName[0]."<br>"; }
      	$html = "";
      break;
      
      case 'TITLE':

        $title = $property->getComponents();
        if (isset($title[0])){  echo "<strong>Title: </strong> ".$title[0]."<br>";}                       
        $html = "";
     break;
     
     case 'ORG':
        $org= $property->getComponents();

        if (isset($org[0])){  echo "<strong>Organization: </strong> ".$org[0]."<br>";}   
        if (isset($org[1])){  echo "<strong>Depatment: </strong> ".$org[1]."<br>";}                       
        $html = "";
     break;
     
     case 'TEL':
     		
         $tel= $property->getComponents();
         
        
        
        if($type=='WORK' && isset($tel[0])) { echo "<strong>Tel Work: </strong> ".$tel[0]."<br>"; }
        if($type=='HOME' && isset($tel[0])) { echo "<strong>Tel Home: </strong> ".$tel[0]."<br>"; }
        if($type=='CELL' && isset($tel[0])) { echo "<strong>Tel Cell: </strong> ".$tel[0]."<br>"; }
        if($type=='CAR' && isset($tel[0])) { echo "<strong>Tel Car: </strong> ".$tel[0]."<br>"; }
        if($type=='PAGER' && isset($tel[0])) { echo "<strong>Tel Pager: </strong> ".$tel[0]."<br>"; }
        if($type=='ISDN' && isset($tel[0])) { echo "<strong>Tel ISDN: </strong> ".$tel[0]."<br>"; }
        if($type=='MAIN' && isset($tel[0])) { echo "<strong>Tel Main: </strong> ".$tel[0]."<br>"; }
        if($type=='WORK, FAX' && isset($tel[0])) { echo "<strong>Tel Work Fax: </strong> ".$tel[0]."<br>"; }
        if($type=='HOME, FAX' && isset($tel[0])) { echo "<strong>Tel Home Fax: </strong> ".$tel[0]."<br>"; }
    	  if($type=='' && isset($tel[0])) { echo "<strong>aditional telefone: </strong> ".$value."<br>"; }
    	  
        		                       
        $html = "";
     break;
        
    	
        case 'ADR':
        
            $adr = $property->getComponents();
            
            if (isset($adr[0])){ echo "apartado: ".$adr[0]."<br>"; }       // apartado
        		if (isset($adr[1])){ echo "barrio: ".$adr[1]."<br>"; }     // barrio
        		if (isset($adr[2])){ echo "calle: ".$adr[2]."<br>"; }     // calle
        		if (isset($adr[3])){ echo "ciudad: ".$adr[3]."<br>";}       // ciudad
        		if (isset($adr[4])){ echo "Estado/provincia: ".$adr[4]."<br>";}      // Estado/provincia
        		if (isset($adr[5])){ echo "zip/ postal code: ".$adr[5]."<br>";}      // zip/ postal code
        		if (isset($adr[6])){ echo "Pais/region: ".$adr[6]."<br>";}      // Pais/region
            
            $lines = array();
            
            for ($i = 0; $i < 3; $i++) {
                if ($adr[$i]) {
                    $lines[] = $adr[$i];
                    
                }
            }
        
        
            $city_state_zip = array();
            
            for ($i = 3; $i < 6; $i++) {
                if ($adr[$i]) {
                    $city_state_zip[] = $adr[$i];
                }
            }
        
            if ($city_state_zip) {
                // Separate the city, state, and zip with spaces and add
                // it as the last line.
                $lines[] = join("&nbsp;", $city_state_zip);
            }
        
            // Add the country.
            if (isset($adr[6])) {
                $lines[] = $adr[6];
            }
        
            $html = join("\n", $lines);
                        
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
            
            echo "<h1>".$type."</h1>";
            
		
            break;
    }

    echo "<p class='$class'>\n";
    
	       
    
    echo nl2br(stripcslashes($html));
    

	if(isset($property->params['TYPE'])) {
		$types = $property->params['TYPE'];
	}
    
    
    if ($types) {
        $type = join(", ", $types);
        echo " (" . ucwords(strtolower($type)) . ")";
    }
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
    $card = new VCard();
    
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
        $card = new VCard();
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

    /**
     * Returns an array of categories for this card or a one-element array with
     * the value 'Unfiled' if no CATEGORIES property is found.
     */
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

    /**
     * Returns true if the card belongs to at least one of the categories.
     */
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

/**
 * The VCardProperty class encapsulates a single vCard property consisting
 * of a name, zero or more parameters, and a value.
 *
 * The parameters are stored as an associative array where each key is the
 * parameter name and each value is an array of parameter values.
 */
class VCardProperty
{
    var $name;          // string
    var $params;        // params[PARAM_NAME] => value[,value...]
    var $value;         // string

    /**
     * Parses a vCard property from one or more lines. Lines that are not
     * property lines, such as blank lines, are skipped. Returns false if
     * there are no more lines to be parsed.
     */
    function parse(&$lines)
    {
        while (list(, $line) = each($lines)) {
        	
            $line = rtrim($line);
            $tmp = split_quoted_string(":", $line, 2);
            
            if (count($tmp) == 2) {
            	
                $this->value = $tmp[1];
                $tmp = strtoupper($tmp[0]);
                $tmp = split_quoted_string(";", $tmp);
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

    /**
     * Splits the value on unescaped delimiter characters.
     */
    function getComponents($delim = ";")
    {
        $value = $this->value;
        // Save escaped delimiters.
        $value = str_replace("\\$delim", "\x00", $value);
        // Tag unescaped delimiters.
        $value = str_replace("$delim", "\x01", $value);
        // Restore the escaped delimiters.
        $value = str_replace("\x00", "$delim", $value);
        // Split the line on the delimiter tag.
        return explode("\x01", $value);
    }

    // ----- Private methods -----

    /**
     * Parses a parameter string where the parameter string is either in the
     * form "name=value[,value...]" such as "TYPE=WORK,CELL" or is a
     * vCard 2.1 parameter value such as "WORK" in which case the parameter
     * name is determined from the parameter value.
     */
    function _parseParam($param)
    {
        $tmp = split_quoted_string('=', $param, 2);
        if (count($tmp) == 1) {
            $value = $tmp[0]; 
            $name = $this->_paramName($value);
            $this->params[$name][] = $value;
        } else {
            $name = $tmp[0];
            $values = split_quoted_string(',', $tmp[1]); 
            foreach ($values as $value) {
                $this->params[$name][] = $value;
            }
        }
    }

    /**
     * The vCard 2.1 specification allows parameter values without a name.
     * The parameter name is then determined from the unique parameter value.
     */
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

    /**
     * Decodes a quoted printable value spanning multiple lines.
     */
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
}

// ----- Utility Functions -----

/**
 * Splits a string. Similar to the split function but uses a single character
 * delimiter and ignores delimiters in double quotes.
 */
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

?>
