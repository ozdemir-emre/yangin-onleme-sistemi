<?php
// bu direk uyelik ile calisacak bir sistem oldugu icin gosterim ekranini burada ayarla
    $uye=uye();
    if ($uye=="hata")
    {
        include 'APP/baglan.php';
    }
    else
    {
        if (empty($_GET[sayfa]))
        {
            include 'APP/header.php';
            include 'APP/anasayfa.php';
            include 'APP/footer.php';
        }
        else
        {
            include 'APP/header.php';
            $sayfa=koruma($_GET[sayfa]);// router sayfalarini buradan koruma ile cekelim
            {
                $kont = file_exists("APP/{$sayfa}.php"); // klasorde sayfa yok ise 404 yapilandirmasi
                if ($kont)
                {
                    include "APP/{$sayfa}.php";
                }
                    else
                {
                    include "APP/404.php";
                }
            }
            include 'APP/footer.php';
        }
        
    }


    


?>
