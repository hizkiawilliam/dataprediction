<?php
exec("python python/run_errorCheck.py",$return);
$this->load->view('pages/backHome');
?>