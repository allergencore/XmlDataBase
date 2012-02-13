<?php

/*##############################################
# XmlDataBase crypted database class 
# This code is under GNU GPL v3.
# Original XmlDataBase source by Allergencore
# (Allergencore@gmail.com [Alex])
###############################################*/

require_once("class.xmldb.php");

final class cXmlDB extends xmlDB {
	
	private $pubkey = null;
	private $privkey = null;
	
	public function __construct($fname, $puk, $prk) {
		$this->fname = $fname;
		$this->file = @fopen($this->fname, "r");
		$this->privkey = openssl_get_privatekey($prk);
		$this->pubkey = openssl_get_publickey($puk);
		if ($this->file === false ||
			$this->pubkey === false ||
			$this->privkey === false) return false;
	}
	public function load(){
	}
}

?>