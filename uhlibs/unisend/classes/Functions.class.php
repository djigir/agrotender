<?php
    class Functions{

        /*
        public function GetVar($name, $defVal="")
        {
            $val = $defVal;
            if(isset($_GET[$name]))
            {
                $val = $_GET[$name];
            }
            if(isset($_POST[$name]))
            {
                $val = $_POST[$name];
            }
            return $val;
        }
        */

        public function GetVar($parameterName, $defaultValue = "", $replaceQuotes = true, $vartype = "", $sqlInjectClear = true )
        {
            $tmpVal = $defaultValue;
            // Получение значения
            if( isset($_POST[$parameterName]) )
            {
                $tmpVal = $_POST[$parameterName];
            }
            else if( isset($_GET[$parameterName]) )
            {
                $tmpVal = $_GET[$parameterName];
            }
            else
            {
                $tmpVal = $defaultValue;
            }
            
            //Использовать для получения строки для дальнейшей подставки в поля ввода
            if( $replaceQuotes )
            {
                if( !is_array($tmpVal) && ($tmpVal != "") )
                {                  
                    $tmpVal = str_replace ("\"", "&quot;", $tmpVal);
                }
            }

            // Выбор типа данных
            switch($vartype)
            {
                case "boolean":
                case "bool": $tmpVal = boolval($tmpVal); break;
                case "int":  $tmpVal = intval($tmpVal); break;
                case "float": $tmpVal = floatval($tmpVal); break;
                case "string": $tmpVal = strval($tmpVal); break;
                default: break;
            }
            
            // Очистка от возможных sql инъекций
            if( $sqlInjectClear )
            {
                if( ($tmpVal != null) && is_string($tmpVal) )
                {
                    $tmpVal = str_ireplace("union", "", $tmpVal);
                    $tmpVal = str_ireplace("<?php", "", $tmpVal);        
                    if( preg_match("/into\soutfile/i", $tmpVal) )
                    {
                        $tmpVal = str_ireplace("outfile", "", $tmpVal);
                    }
                    $tmpVal = str_ireplace("LOAD_FILE", "", $tmpVal);
                }
            }
            
            return $tmpVal;
        }


    }
?>