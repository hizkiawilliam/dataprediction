<?php
exec("python python/delete.py",$return);
$this->load->view('pages/backHome');
?>