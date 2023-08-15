<?php
    $istek = new Crud();
    
    function uye()
    {
        $istek = new Crud();
        $CRM=$istek->listele("personel","where kul='{$_SESSION[kullanici]}' and sif='{$_SESSION[sifre]}'");
        if (isset($CRM))
        {
           foreach ($CRM as $rs) {

           }
        }
        else
        {
            // uye kontrolu burdan bakiyoruz sayfa baglan ise uyelik kontrolu devre disi 
            $sayfa=$_GET[sayfa];
            if ($sayfa=="baglan")
            {
                // herhangi bir islem yapmana gerek yok bu kisim baglan sayasinda ise calisiyor 
            }
            else
            {
                yonlendir("baglan");
            }
            $rs="hata";
        }
        return $rs;
    }


    function baglan($baglan)
    {
        // baglanma verilerini aldim simdi yorumlayip bagli ise balayacak sekilde ayarlariz 
        if (empty($baglan[kul]) or empty($baglan[sif]))
        {
            // bos basarsa geri yonlendirelim 
            yonlendir("baglan");
        }
        else
        {
            // dolu geldi veri ozaman bunlari bir kontrol edelim 
            $istek = new Crud();
            $kul=koruma($baglan[kul]);
            $sif=koruma($baglan[sif]);

            $CRM=$istek->listele("personel","where kul='{$kul}' and sif='{$sif}'");
            if (isset($CRM))
            {
                foreach ($CRM as $uye) {
                    $_SESSION[kullanici]=$uye[kul];
                    $_SESSION[sifre]=$uye[sif];
                    yonlendir(anasayfa);
                }
            }
            else
            {
                yonlendir("baglan");
            }
        }
    }


    function veriAl($veriler)
    {
        $istek = new Crud();
        $ekle=$istek->ekle("sensor",array(
            "konum"=>$veriler[konum],
            "sicaklik"=>$veriler[sicaklik],
            "nem"=>$veriler[nem],
            "gaz"=>$veriler[gaz]
        ));
        echo 'Basarili';
    }

    
    function datalar($veri,$tarih=null)
    {
        $istek= new Crud();
        if($tarih)
        {
            
            $ver=$istek->listele("sensor","where tarih between '{$tarih[basla]} 00:00:01' and '{$tarih[bitir]} 23:59:59' order by id DESC");
            
           

        }
        else
        {
            $ver=$istek->listele("sensor","order by id DESC limit {$veri}");
        }
        
        if (isset($ver))
        {
            foreach ($ver as $gonder) {
                $rs=$gonder;
            }
        }
        return $ver;
    }
    /*
        Mail Gönderme
        1. Parmetre -> Mesaj ( Boşbıraklmaz )
        
    */
      
    function mailGonder($message,$title = "Server Odası Bilgilendirme",$mailAdres = "xemreozdemirx@gmail.com")
    {
        require 'APP/system/mailler/class.phpmailer.php';

    
        $mail               = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug    = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth     = true; // authentication enabled
        $mail->SMTPSecure   = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Host         = "mail.sfps.site";
        $mail->Port         = 465; // or 587
        $mail->IsHTML(true);
        $mail->SetLanguage("tr", "phpmailer/language");
        $mail->CharSet      = "utf-8";
        
        $mail->Username = "no-reply@sfps.site"; // Mail adresi
        $mail->Password = "&xRFH2{IN]*{"; // Parola
        $mail->SetFrom("no-reply@sfps.site", "Durum"); // Mail adresi
        
        $mail->AddAddress( $mailAdres ); // Gönderilecek kişi
        
        $mail->Subject  = $title;
        $mail->Body     = $message;
        
        if(!$mail->Send())
        {
            
                return 0;
                
        } else 
        {
            
                return 1;
        }
    }
?>
