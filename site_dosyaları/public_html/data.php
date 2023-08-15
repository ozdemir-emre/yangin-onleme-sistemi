<?php
include '_controller/cekirdek_yapi.php';

if ($_POST[token]=="Dxdjwe25155da")
{
    
    $veriler=array(
        "konum"=>$_POST["konum"],
        "sicaklik"=>$_POST["sicaklik"],
        "nem"=>$_POST["nem"],
        "gaz"=>$_POST["gaz"],
    );
    veriAl($veriler);

    
    // 2. SMTP Sınıfını yüklemek.
    
        

    /*
        Kullanıcı adı:	no-reply@sfps.site
        Şifre:	E-posta hesabının şifresini kullanın.
        Gelen Posta Sunucusu:	mail.sfps.site
        IMAP Port: 993 POP3 Port: 995
        Giden Sunucu:	mail.sfps.site
        SMTP Port: 465
    */
        
        foreach ($veriler as $rs=>$value) {
            
            if ($rs=="sicaklik")
            {
                if ($value >= 30)
                {
                    // sicaklik asti maili
                    $metin.=" Sıcaklık {$value} Değerine Ulaştı";
                }
            }
            
            if ($rs=="nem")
            {
                if ($value >= 70)
                {
                    // nem asti maili
                   
                    $metin.=" Nem {$value} Değerine Ulaştı";
                }
            }
            
            if ($rs=="gaz")
            {
                if ($value >= 500)
                {
                    // gaz asti maili
                    
                $metin.="Gaz {$value} Değerine Ulaştı"; 
                }
            }
        }
        
       
        // kosullar mail atmaya musait ise 
        if (isset($metin))
        {
           mailgonder($metin);
        }
     

}
?>