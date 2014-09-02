<?php
    class IREPORT {
        var $path="";
        var $jrxml="";
        var $file="";
        var $parametros="";
        var $command="";
        var $params="";


        function get_params($param) {
            $this->path=Yii::getPathOfAlias('webroot');
            $this->jrxml= $param['source'];
            $this->file=$param['file'];    
            $this->parametros=array_keys($param['params']);
            $this->command="java -jar ";
            $this->command.=$this->path."/protected/extensions/ireport/reportsXml.jar";
            
             foreach($this->parametros as $field){
                    $this->params.=$field;
                    foreach($param['params']["$field"] as $value){
                       $this->params.="-".$value;
                    }
                   $this->params.=",";
            }


        }
        
        function export($array){
            $this->get_params($array);
            $this->run_command();
        }
    
        function run_command(){

            exec($this->command." ".$this->jrxml." ".$this->file." ".$this->params);

            if (file_exists($this->file)) {

                $mime=$this->get_mime_type($this->file);

                if($mime == '') $mime = "application/force-download";

                $fileSize=(string)(filesize($this->file));
                $fileName=basename($this->file);

                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private",false);
                header("Content-Type: $mime");
                header('Content-Disposition: attachment; filename="'.$fileName.'"');
                header("Content-Length: ".$fileSize);
                header("Content-Transfer-Encoding: binary");


                readfile($this->file);

                exit();

            }

        }

        function get_mime_type($filename, $mimePath = '/etc') {
            $fileext = substr(strrchr($filename, '.'), 1);
            if (empty($fileext)) return (false);
            $regex = "/^([\w\+\-\.\/]+)\s+(\w+\s)*($fileext\s)/i";
            $lines = file("$mimePath/mime.types");
            foreach($lines as $line) {
                if (substr($line, 0, 1) == '#') continue; // skip comments
                $line = rtrim($line) . " ";
                if (!preg_match($regex, $line, $matches)) continue; // no match to the extension
                return ($matches[1]);
            }
            return (false); // no match at all
        }
    }

?>