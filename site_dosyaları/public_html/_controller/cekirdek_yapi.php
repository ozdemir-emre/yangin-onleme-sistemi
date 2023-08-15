<?php 
$url=$_SERVER['REQUEST_URI'];
include 'ayarlar.php';
include 'database.php';
session_start();
ob_start();
class Crud extends DbConfig
{

    public function __construct()
    {
        parent::__construct();


    }

public function listele($tablo,$parametre=null)
{
    $islem = $this->baglan->query("SELECT * FROM {$tablo} {$parametre}");
    if($islem->execute()) {
        while($rows = $islem->fetch()) {
            $fetch[] = $rows;
        }
        return $fetch;
    }
    else 
    {
        return false;
    }
}

public function grupla($tablo,$parametre=null)
{
    // personel where DEPARTMAN_NO=12 gibi 
    $islem = $this->baglan->query("SELECT DISTINCT {$tablo} FROM {$parametre}");
    if($islem->execute()) {
        while($rows = $islem->fetch()) {
            $fetch[] = $rows;
        }
        return $fetch;
    }
    else 
    {
        return false;
    }
}


function topla($tablo,$sutun,$parametre)
{
    // bu fonksiyon tablo dan gelıp sutunun genel toplamını verır muhasebe ozellıgı tasır 

    $islem = $this->baglan->prepare('SELECT sum('.$sutun.') AS sonuc FROM '.$tablo.' '.$parametre.'');
    $islem->execute();
    $sonuc=$islem->fetchColumn();
    return $sonuc;
    /*
    Fonksiyonda kullanım seklı alttakı gıbıdır 
    
    $istek=new Crud();
    $alinanPuan=$istek->topla("teklifler","puan_sofor","where uye_id='{$uye}'");
    */
}







public function ekle ($tablo,$data=array(),$geri=null)
{

foreach ($data as $key => $value) {
    // code...
    $sutun[]=$key;
    $deger[]="'".$value."'"; // sql kayıt ıcın 'deger' seklınde olması ıcın bu sekılde yapıyoruz
}
    $sutun=implode(",", $sutun); // , ile bır bırlerınden ayırma methodunu kullanıyoruz
    $deger=implode(",", $deger); // , ile bır bırlerınden ayırma methodunu kullanıyoruz

    // veriler istediğimiz gibi array olarak alındıkdan sonra insert into methodumuzu yazıyoruz
    $islem = $this->baglan->prepare("INSERT INTO {$tablo} ({$sutun}) VALUES ({$deger}) ");
      if($islem->execute()) {
            while($rows = $islem->fetch()) {
                $fetch[] = $rows;
            }
            // geri eklentisi işlemden sonra gerı donmek ıstedıgımız sayfayı belırlememıze yarar ekle ıslemınden sonra hangı sayfaya gıdeceksın ?
            if(empty($geri))
            {
                return $fetch;
            }
            else
            {
               yonlendir("{$geri}");
            }
            
        }
        else 
        {
            return false;
        }
}


public function kaldir($tablo,$data,$geri=null)
{
   $islem = $this->baglan->prepare("DELETE FROM {$tablo} WHERE id={$data}");
      if($islem->execute()) {
            while($rows = $islem->fetch()) {
                $fetch[] = $rows;
            }
             // geri eklentisi işlemden sonra gerı donmek ıstedıgımız sayfayı belırlememıze yarar ekle ıslemınden sonra hangı sayfaya gıdeceksın ?
             if(empty($geri))
             {
                 return $fetch;
             }
             else
             {
                yonlendir("{$geri}");
             }
        }
        else 
        {
            return false;
        } 
}


public function guncelle ($tablo,$set,$id,$geri=null)
{

      $islem = $this->baglan->prepare('UPDATE '.$tablo.' SET '.$set.' WHERE id='.$id.'');
      if($islem->execute()) {
            while($rows = $islem->fetch()) {
                $fetch[] = $rows;
            }
             // geri eklentisi işlemden sonra gerı donmek ıstedıgımız sayfayı belırlememıze yarar ekle ıslemınden sonra hangı sayfaya gıdeceksın ?
             if(empty($geri))
             {
                 return $fetch;
             }
             else
             {
                yonlendir("{$geri}");
             }
        }
        else 
        {
            return false;
        } 
        
}


public function sayac($tablo,$parametre=null)
{
    $islem = $this->baglan->prepare('SELECT COUNT(*) AS sonuc FROM '.$tablo.' '.$parametre.'');
    $islem->execute();
    $sonuc=$islem->fetchColumn();
    return $sonuc;
    echo "sayac";
}





}
include '_model/fonksiyon.php';
include '_model/site_fonksiyon.php';