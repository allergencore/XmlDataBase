<?php

/*##############################################
# XmlDataBase database class 
# This code is under GNU GPL v3.
# Original XmlDataBase source by Allergencore
# (Allergencore@gmail.com [Alex])
###############################################*/

// table manipulation class
//require_once("class.xmldb.table.php");
// row manipulation class
//require_once("class.xmldb.row.php");

class xmlDB {
	
	protected $file = null;
	protected $fname = "";
	protected $DomXmlDoc = null;
	
	public function __construct($fname) {
		$this->fname = $fname;
		$this->file = @fopen($this->fname, "r");
		if ($this->file === false ) return false;
	}
	public function load($login = "default", $pass = "1234") {
		$xmlDoc = new DOMDocument("1.0", "windows-1251");
		$fcont = @fread($this->file, filesize($this->fname));
		if (!$fcont) return false;
		$xmlDoc->loadXML($fcont);
		$userlist = $xmlDoc->getElementsByTagName("user");
		for($i = 0; $i < $userlist->length; $i++) {
			$user = $userlist->item($i);
			$xlogin = $user->getElementsByTagName("login")->
				item(0)->nodeValue;
			$xpass = $user->getElementsByTagName("pass")->
				item(0)->nodeValue;
			if ($login == $xlogin && $xpass == md5($pass)) {
				$valid = true;
				break;
			}
		}
		if (!$valid) return false;
		$this->DomXmlDoc = $xmlDoc;
	}
	public function save() {
		$fcont = $this->DomXmlDoc->saveXML();
		$this->file = @fopen($this->fname, "w+");
		if ($this->file === false ) return false;
		if (@fwrite($this->file, $fcont) === false) return false;
	}
	public function create($login = "default", $pass = "1234") {
		$this->DomXmlDoc = new DOMDocument("1.0", "windows-1251");
		$xmlDoc = $this->DomXmlDoc;
		$xmlRoot = $xmlDoc->createElement("database");
		$xmlDoc->appendChild($xmlRoot);
		$users = $xmlRoot->createElement("users");
		$xmlRoot->appendChild($users);
		$du = $users->createElement("user");
		$users->appendChild($du);
		$du_l = $du->createElement("login", $login);
		$du_p = $du->createElement("pass", md5($pass));
		$du->appendChild($du_l);
		$du->appendChild($du_p);
		$this->save();
	}
	public function createTable($tname) {
		
	}
	public function getTable($name) {
		$xmlDoc = $this->DomXmlDoc;
		$tl = $xmlDoc->getElementsByTagName("table");
		for($i = 0; $i < $tl->length; $i++) {
			$table = $tl->item($i);
			if ($table->getAttribute("name") == $name)
				return new tableXmlDB($table);
		}
		return false;
	}
	public function applyTable($table) {
		$this->dropTable($table->getAttribute("name"));
		$this->DomXmlDoc->appendChild($table);
	}
	public function dropTable($name) {
		$xml = $this->DomXmlDoc;
		$tl = $xml->getElementsByTagName("table");
		for($i = 0; $i < $tl->length; $i++) {
			$this->
		}
	}
	// change to 'protected' if not-dev mode
	public function getXmlDoc() {
		return ($this->DomXmlDoc) ? $this->DomXmlDoc : false;
	}
	// ^^^^^^^
}

?>