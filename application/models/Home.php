<?php
class Home extends CI_Model{
    function getValue()
    {
        // $data['data_pred'] =  $this->db->query("select tab1.month, tab1.value as arima, tab2.value as hwes, tab3.value as real from
        // (select substring(month from 0 for 8) as month, value  from arima) as tab1 inner join
        // (select substring(month from 0 for 8) as month, value  from hwes) as tab2 on tab1.month = tab2.month inner join
        // (select substring(month from 0 for 8) as month, value from real) as tab3 on tab2.month = tab3.month;");

        $data['data_pred'] =  $this->db->query("select tab1.month, tab1.value as arima, tab2.value as hwes from
        (select substring(month from 0 for 8) as month, value  from arima) as tab1 inner join
        (select substring(month from 0 for 8) as month, value  from hwes) as tab2 on tab1.month = tab2.month;");

        $data['data_real'] =  $this->db->query("SELECT * FROM real");

        $data['data_origin'] =  $this->db->query("SELECT * FROM dummy");
        $data['analysis_error'] =  $this->db->query("SELECT * FROM analysis WHERE analysis = 'error';");
        $data['analysis_time'] =  $this->db->query("SELECT * FROM analysis WHERE analysis = 'time';");
        return $data;
    }
}?>