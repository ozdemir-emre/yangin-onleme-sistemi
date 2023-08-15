<meta http-equiv="refresh" content="60">
<?php
if ($_POST[getir])
{
    $getir=$_POST["getir"];
}
else
{
    $getir=10;
}

    if ($_POST[tarih])
    {
        $tarih=$_POST[tarih];
        $sensorData=datalar($getir,$tarih);
    }
    else
    
    {
        $sensorData=datalar($getir);
    }


$tarihler="";
$sicakliklar="";
$nemler="";
$gazlar="";
foreach($sensorData as $datam){
    $deger=date("d.m.Y <br>H:i:s",strtotime($datam["tarih"]));
    $tarihler = empty($tarihler) ? "'".$deger."'" : "'".$deger."',".$tarihler;
    $sicakliklar = empty($sicakliklar) ? $datam["sicaklik"] : $datam["sicaklik"].",".$sicakliklar;
    $nemler = empty($nemler) ? $datam["nem"] : $datam["nem"].",".$nemler;
    $gazlar = empty($gazlar) ? $datam["gaz"] : $datam["gaz"].",".$gazlar;
}
?>
<html>
 <head>
     
     <h2 align="center">Uzaktan Yangın ve Nem Tehlike-Uyarı-Önleme Sistemi</h2>
     <div class="form-group" style="width:100%;">
     <form action="" method="post">
    <div class="form-group" style="width:33%;>
    <label for="baslamatarihi" style="text-align:center">Başlama Tarihi</label>
    <input type="date" class="form-control" style="float:left;padding-right: 0px; text-align: center;" id="exampleInputEmail1" aria-describedby="emailHelp" name="tarih[basla]" required>
    </div>
    <div class="form-group" style="width:33%;>
    <label for="bitistarihi" style="text-align:center">Bitiş Tarihi</label>
    <input type="date" class="form-control" style="float:left;padding-right: 0px; text-align: center;" id="exampleInputEmail1" aria-describedby="emailHelp" name="tarih[bitir]" required>
    </div>
     <div class="form-group">
    <button type="submit" class="btn btn-warning form-control" style="float:left;padding-right: 0px;font-size:11pt;color:white;background-color:#333;border:2px solid #333;padding:5px">İki Tarih Arası</button>
    </div>
</div>
  </form>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <figure class="highcharts-figure">
    <div id="container"></div>
    <div id="container1"></div>
    <div id="container2"></div>
    <p class="highcharts-description">
    </p>
</figure>
 </head>
 <style>
  .highcharts-figure #container, #container1,#container2  {
    width: 33% !important;
    float: left;
  }
  @media screen and (max-width:770px) {
    .highcharts-figure #container, #container1,#container2  {
    width: 100% !important;
    float: none;
  }
  }
.form-group {
   
    float: left;width: 33%;padding: 20px;
}
.form-group .btn {
   
    margin-top:20px;
}
.navbar-right {
    float: right!important;
    margin-right: -15px;
}
.navbar-nav>li {
    float: left;
}
.navbar-header {
    float: left;
}
.container-fluid>.navbar-header{margin-right: 0; margin-left: 0; }
@media screen and (max-width:500px) {.form-group {padding: 10px;
}}
</style>
 <body>

<script> 
Highcharts.chart('container', {
  chart: {
    type: 'line'
  },
  title: {
    text: '<p style="font-size: 20px; color: #ff0000; font-weight: normal">Sicaklik</p>'
  },
  xAxis: {
    categories: [<?php echo $tarihler; ?>]
  },
  yAxis: {
    title: {
      text: 'Sicaklik (°C)'
    }
  },
  plotOptions: {
    line: {
      dataLabels: {
        enabled: true
      },
      enableMouseTracking: true
    }
  },
  
  series: [{
    name: 'Sicaklik',
    color:'#ff0000',
    data: [<?php echo $sicakliklar; ?>],
  }],
});
Highcharts.chart('container1', {
  chart: {
    type: 'line'
  },
  title: {
    text: '<span style="font-size: 20px; color: #0000ff; font-weight: normal">Nem</span>'
  },
  
  xAxis: {
    categories: [<?php echo $tarihler; ?>]
  },
  yAxis: {
    title: {
      text: 'Nem (%)'
    }
  },
  plotOptions: {
    line: {
      dataLabels: {
        enabled: true
      },
      enableMouseTracking: true
    }
  },
  series: [{
    name: 'Nem',
    color:'#0000ff',
    data: [<?php echo $nemler; ?>],
  }],
  
});
Highcharts.chart('container2', {
  chart: {
    type: 'line'
  },
  title: {
    text: '<span style="font-size: 20px; color: #000000; font-weight: normal">Gaz</span>'
  },
  xAxis: {
    categories: [<?php echo $tarihler; ?>]
  },
  yAxis: {
    title: {
      text: 'Gaz (PPM)'
    }
  },
  plotOptions: {
    line: {
      dataLabels: {
        enabled: true
      },
      enableMouseTracking: true
    }
  },
  series: [{
    name: 'Gaz',
    color:'#000000',
    data: [<?php echo $gazlar; ?>],
  }],
});
</script>
 </body>
</html>


