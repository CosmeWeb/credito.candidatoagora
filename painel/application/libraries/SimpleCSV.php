<?php
class SimpleCSV {
	
	public $sheets = array();
	public $file = "";
	public $delimitator = ';';
	
	###################################################################################################################
	public function __construct( $filename, $is_data = false, $debug = false ) {
		$this->file   = $filename;
		$this->read($this->file);
	}
	###################################################################################################################
	public function &rows( $worksheetIndex = 0 ) {
		return $this->sheets;
	}
	###################################################################################################################
	public function rowsEx( $worksheetIndex = 0 ) {
		return false;
	}
	###################################################################################################################
	public function toHTML( $worksheetIndex = 0 ) {
		$s = '<table class="excel">';
		foreach( $this->rows( $worksheetIndex ) as $r ) {
			$s .= '<tr>';
			foreach ( $r as $c ) {
				$s .= '<td>'.( $c === '' ? '&nbsp' : htmlspecialchars( $c, ENT_QUOTES )).'</td>';
			}
			$s .= "</tr>\r\n";
		}
		$s .= '</table>';
		return $s;
	}
	###################################################################################################################
	public function dimension( $worksheetIndex = 0 ) {

		if (empty($this->sheets) )
		{
			return array(0,0);
		}
		/* @var SimpleXMLElement $ws */

		$colunas = count($this->sheets[0]);
		$linhas = count($this->sheets);

		return array( $colunas, $linhas);
	}
	###################################################################################################################
	public function &sheets() {
		return $this->sheets;
	}
	###################################################################################################################
	public function sheetsCount() {
		return count( $this->sheets );
	}
	###################################################################################################################
	#função adicionadas
	public function &read($sFileName = "")
	{
		$retorno = false;
		if(empty($sFileName))
			return $retorno;
		if(!file_exists($sFileName))
			return $retorno;
		$this->file = $sFileName;
		$file = fopen($sFileName, 'r');
		unset($this->sheets);
		$this->sheets = array();
		while (($line = fgetcsv($file)) !== false)
		{
			$this->sheets[] = explode($this->delimitator, $line[0]);
		}
		fclose($file);
		return $this;
	}
	###################################################################################################################
	public function TotaldeLinhas($worksheetIndex = 0, $comprimeiralinha = false)
	{
		if (empty($this->sheets)) {
			return 0;
		}
		list( $numCols, $numRows) = $this->dimension( $worksheetIndex );
		if($comprimeiralinha)
			return $numRows;
		else
			return $numRows - 1;
	}
	###################################################################################################################
	public function TotaldeColunas($worksheetIndex = 0, $comprimeiralinha = false)
	{
		if (empty($this->sheets)) {
			return 0;
		}
		list( $numCols, $numRows) = $this->dimension( $worksheetIndex );
		return $numCols;
	}
	###################################################################################################################
	public function &GetInstancia()
	{
		return $this;
	}
}