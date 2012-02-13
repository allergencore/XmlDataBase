<?php

/*##############################################
# XmlDataBase table class 
# This code is under GNU GPL v3.
# Original XmlDataBase source by Allergencore
# (Allergencore@gmail.com [Alex])
###############################################*/

class tableXmlDB {
	
	private $DomXmlDoc = null;
	//private $;
	
	public function __construct($table) {
		$this->DomXmlDoc = $table;
	}
	public function getRow($i) {
		$xml = $this->DomXmlDoc;
		$nl = $xml->getElementsByTagName("row");
		if ($nl->length < $i) return false;
		return $nl->item($i);
	}
	public function addRow($arr) {
		$xml = $this->DomXmlDoc;
		$rowr = new DOMElement("row");
		$xml->appendChild($rowr);
		foreach($arr as $k => $v) {
			$col = new DOMElement($k, $v);
			$rowr->appendChild($col);
		}
	}
	public function existsRow($vals, $columns) {
		$rows = $this->DomXmlDoc->getElementsByTagName("row");
		$cols = explode(",", $columns);
		for ($i = 0; $i < $rows->length; $i++) {
			$row = $rows->item($i);
			for ($j = 0; $j < count($cols); $j++)	{
				$ret[$j] = $row->getElementsByTagName($cols[$j])->item(0)->nodeValue;
			}
			$rval = true;
			foreach($ret as $k => $v) {
				if ($vals[$k] != $v) $rval = false;
			}
			if ($rval) return true;
		}
		return false;
	}
}

?>