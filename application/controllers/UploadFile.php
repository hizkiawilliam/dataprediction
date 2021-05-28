<?php
class UploadFile extends CI_Controller{

    public function index()
	{
		$this->load->view('csvToMySQL');
	}

    public function uploadData(){
		$csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
	       if(is_uploaded_file($_FILES['file']['tmp_name'])){
	            
	            //open uploaded csv file with read only mode
	            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
	            
	            // skip first line
	            // if your csv file have no heading, just comment the next line
				fgetcsv($csvFile);
				
	             //check whether dummy already exists in database with same periode
				$this->db->query("DELETE FROM dummy");
				while(($line = fgetcsv($csvFile)) !== FALSE){
					$this->db->insert("dummy", array("month"=>$line[0], "passengers"=>$line[1]));
				}
	            //close opened csv file
	            fclose($csvFile);
		   }
		   $this->load->view('pages/run');
		}

	public function uploadDataReal(){
		$csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
			if(is_uploaded_file($_FILES['file']['tmp_name'])){
				
				//open uploaded csv file with read only mode
				$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
				
				// skip first line
				// if your csv file have no heading, just comment the next line
				fgetcsv($csvFile);
				
					//check whether dummy already exists in database with same periode
				$this->db->query("DELETE FROM real");
				while(($line = fgetcsv($csvFile)) !== FALSE){
					$this->db->insert("real", array("month"=>$line[0], "value"=>$line[1]));
				}
				//close opened csv file
				fclose($csvFile);
			}
			$this->load->view('pages/uploadreal');
		}
}