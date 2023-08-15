<?php
  $istek = new Crud(); // db den bir sey istersek bu sekilde fonksionunun icine koymamiz yeterli oluyor 

function koruma($xyz)
  {
    // guvenlik Prosedürü TAMAM eski içerisinde gecen
    $tehlikeli   = array("and","union","delete","like","'","where","AND","UNİON","DELETE","LIKE");// gelıstır burayı
    $kaldir   = "";
    $xyz = str_replace($tehlikeli, $kaldir, $xyz);
    return $xyz;
  }



function linkci($text)
  {
    $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
      $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
      $text = strtolower(str_replace($find, $replace, $text));
      $text = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $text);
      $text = trim(preg_replace('/\s+/', ' ', $text));
      $text = str_replace(' ', '-', $text);
      return $text;
  }

  function yonlendir($sayfa)
  {
    $yonlendir=''.$sayfa.'';
    echo "<script>window.location.href='".$yonlendir."';</script>";
    return $sayfa;
  }

  function cikis($sayfa=null)
  {
    if ($sayfa=="")
      {
        session_start();
        session_destroy();
        yonlendir("anasayfa");
      }
      else
      {
        session_start();
        session_destroy();
        yonlendir("{$sayfa}");
      }
  }
    
    

?>
