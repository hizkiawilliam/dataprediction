<?php
exec("python python/delete.py",$return);
exec("python python/run_algorithm.py",$return);
$this->load->view('pages/backHome');
?>