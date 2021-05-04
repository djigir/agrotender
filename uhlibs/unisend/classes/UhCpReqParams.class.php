<?php 
    class UhCpReqParams
    {
        private $_paramsList;

        function __construct()
        {
            $this->_paramsList = array();
        }

        public function addParam($name, $val)
        {
            $this->_paramsList[$name] = $val;
        }
        public function addParamsArr($arr)
        {
            foreach($arr as $name => $val)
            {
                $this->addParam($name, $val);
            }
            //$this->_paramsList += $arr;
        }

        public function getHttpQuery()
        {
            $query = array();
            foreach($this->_paramsList as $name => $val)
            {
                //$query[urlencode($name)] = urlencode($val);
                $query[$name] = $val;
            }
            return http_build_query($query);
            
        }
    }
?>