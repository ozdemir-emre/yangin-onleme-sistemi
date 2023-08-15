<?php
class DbConfig 
{	
	private $_host = 'localhost';
	private $_kullanici = 'sfpssite_admin';
	private $_sifre = 'Emre4801.';
	private $_mdb = 'sfpssite_sensorler';
	protected $baglan;
	
	public function __construct()
	{
		//$this->baglan = new mysqli($this->_host, $this->_kullanici, $this->_sifre, $this->_mdb);

	if (extension_loaded("PDO")) {
      try {
$this->baglan = new PDO('mysql:host='.$this->_host.';dbname='.$this->_mdb.';charset=utf8',$this->_kullanici, $this->_sifre);
$this->baglan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          }
      catch(PDOException $e)
          {
          echo "HATA : " . $e->getMessage();
          }
    } 
    else 
    {
        echo "PDO kurulu değil Bu Yüzden PDO Baglantısı yapılamıyor.";
    }

		return $this->baglan;
	}

}
?>