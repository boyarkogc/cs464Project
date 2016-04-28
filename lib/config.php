<?php
	
class config {
	public $base_path;
	public $base_url;
	public $project_url = "/Project1";
	public $dev_name = "/~mmillard";
	
	public function __construct() {
		$this->base_path = $_SERVER['HTTP_HOST'];
		$this->base_url = $this->base_path . $this->dev_name . $this->project_url;
	}
}

$config = new config();

?>