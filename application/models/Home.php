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
        $percentData = $this->db->query("SELECT value::int FROM datarange")->row('value');
        $totalData = $this->db->query("SELECT COUNT(*) FROM dummy")->row('count');
        if ($totalData == 0){
            $limitData = $totalData;
        }
        else{
            $limitData = $percentData/100*$totalData;
        }
        // LIMIT {$limitData}
        $data['data_origin'] =  $this->db->query("SELECT * FROM dummy order by month asc;");
        $data['analysis_error'] =  $this->db->query("SELECT * FROM analysis WHERE analysis = 'error';");
        $data['analysis_time'] =  $this->db->query("SELECT * FROM analysis WHERE analysis = 'time';");
        $data['analysis_cpuUsage'] =  $this->db->query("SELECT * FROM analysis WHERE analysis = 'cpuUsage';");
        $data['analysis_cpuMax'] =  $this->db->query("SELECT * FROM analysis WHERE analysis = 'cpuMax';");
        $data['analysis_ram'] =  $this->db->query("SELECT * FROM analysis WHERE analysis = 'ram';");
        $data['analysis_accuracy'] =  $this->db->query("select tab1.month as month, tab1.value as sarimax, tab2.value as hwes from
        (select * from accuracy where algo = 'Sarimax') as tab1 inner join
        (select * from accuracy where algo = 'Hwes') as tab2 on tab1.month = tab2.month;");
        return $data;
    }
}?>