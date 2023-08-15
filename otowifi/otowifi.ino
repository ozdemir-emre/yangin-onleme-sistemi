#ifdef ESP32
  #include <WiFi.h>
  #include <HTTPClient.h>
#else
  #include <Arduino.h>
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  #include <WiFiClient.h>
#endif
#include <Wire.h>
#include <DHT.h>
#include <LiquidCrystal_I2C.h> //16x2 ekran kütüphanesi
#include <WiFiManager.h> 
//RGB LED'imizin çıkış pinlerini tanımlıyoruz:
#define led_r 0
#define led_g 14
#define led_b 2
#define role 12  //Rölemize sinyal göndereceğimiz pini tanımlıyoruz.
#define buzzer_pin 3 //Buzzer bağlı pin
#define DHTPIN 13 // NodeMCU'nun D6'i GPIO12'tür
#define DHTTYPE DHT11
#define MQ2pin (A0)
DHT dht(DHTPIN, DHTTYPE);
LiquidCrystal_I2C lcd(0x27, 16, 2);
int degeri; //Sensörden okunan değer
int esikdegeri = 400; //sensör limit değer
int gazSensorValue = 0;
int sicaklikSensorValue = 0;
int nemSensorValue = 0;
unsigned long gecenzaman=0;
const char* serverName = "http://www.sfps.site/data.php";
String token = "Dxdjwe25155da";
String sensorkonum = "Ofis";
void setup(){
// Serial port ekranı
  Serial.begin(115200);
  //Alarm için kullanacağımız buzzer ve LED'leri çıkış olarak tanımlıyoruz
  pinMode(buzzer_pin, OUTPUT);
  pinMode(role, OUTPUT);
  pinMode(led_r, OUTPUT);
  pinMode(led_g, OUTPUT);
  pinMode(led_b, OUTPUT);
  //Varsayılan olarak LED'in sönük kalmasını sağlıyoruz
  digitalWrite(led_g, HIGH);
  digitalWrite(role, HIGH); //ROLE KAPALI
  digitalWrite(buzzer_pin, HIGH);
  lcd.begin();
  dht.begin();
  Serial.println("Server Sistemi");
 int i;
 for(i=0; i<17; i+=2)
{
  lcd.setCursor(i,0);
  lcd.print("Sistem");
  delay(600);
  lcd.setCursor(i,0);
  lcd.print("  ");
}

for(i=0; i<17; i+=2)
{
  lcd.setCursor(i,1);
  lcd.print("Aciliyor");
  delay(600);
  lcd.setCursor(i,1);
  lcd.print("  ");
}
  digitalWrite(led_b, LOW);
  digitalWrite(led_r, LOW);
  delay(2000);
  lcd.clear();
 
  // WiFiYöneticisi
  // Yerel başlatma. İşi bittiğinde, onu etrafta tutmaya gerek yok
  WiFiManager wifiManager;
  
  // Saklanan tüm bilgileri silmek istiyorsanız, açıklamayı kaldırın ve bir kez çalıştırın
  //wifiManager.resetSettings();
  
  // portal için özel ip ayarla
  //wifiManager.setAPConfig(IPAddress(10,0,1,1), IPAddress(10,0,1,1), IPAddress(255,255,255,0));

  // ssid'yi alır ve eeprom'dan geçer ve bağlanmaya çalışır
  // bağlanmazsa, belirtilen adla bir erişim noktası başlatır
  // burada "AutoConnectAP"
  // ve yapılandırmayı bekleyen bir engelleme döngüsüne girer
  //wifiManager.autoConnect("AutoConnectAP");
  // veya bunu otomatik olarak oluşturulan ad ESP + ChipID için kullanın
  wifiManager.autoConnect();
  
  // buraya gelirseniz WiFi'ye bağlandınız
  Serial.println("Bağlandı.");
 
  // ESP32 Yerel IP Adresini Yazdır
  lcd.setCursor(1,0);
  Serial.println(WiFi.localIP());
  //lcd.print(WiFi.localIP());
  delay(3000);  
  //süre tamamlandığında mor LED'i söndürüyoruz:
  digitalWrite(led_b, HIGH);
  digitalWrite(led_r, HIGH);
}
 
void loop(){
  // DUMAN Sensör LCD İşlemleri
  Serial.println("Duman sensor degerleri okunuyor...");
  int degeri = analogRead(0); //Sensörden analog değer okuyoruz.
  lcd.setCursor(0, 0);
  lcd.print("DUMAN:");
  lcd.print(degeri);
  lcd.print(" PPM");
  Serial.println("Duman sensor degerleri ekrana yazildi...");
  Serial.print("Duman sensor degeri : ");
  Serial.print(degeri);
  Serial.println("  ");
  delay(3000);
  // DUMAN Sensör LCD İşlemleri
   
  // Sıcaklık ve Nem Sensör LCD İşlemleri
  Serial.println("Sıcaklık sensor degerleri okunuyor...");
  int sicaklikdegeri = dht.readTemperature();
  int nemdegeri = dht.readHumidity();
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Sicaklik:");
  lcd.print(sicaklikdegeri);
  lcd.print("\xDF");
  lcd.print("C");
  Serial.println("  ");
  
  Serial.println("Sicaklik  sensor degerleri ekrana yazildi...");
  Serial.print("Sicaklik sensor degeri : ");
  Serial.print(sicaklikdegeri);
  Serial.println("  ");
  Serial.print("Nem sensor degeri : ");
  Serial.print(nemdegeri);
  Serial.println("  ");
  // Sıcaklık Sensör LCD İşlemleri
  // nem lcd işlemleri
  lcd.setCursor(0, 1);
  lcd.print("Nem:%");
  lcd.print(nemdegeri);
  Serial.println("  ");
  delay(3000);
  lcd.clear();
//nem lcd işlemleri 
  // Gaz sensör değer okuma
  gazSensorValue = analogRead(0);
  delay(3000);
  // Gaz sensör değer okuma

// Sıcaklık Nem Değer Okuma
sicaklikSensorValue = dht.readTemperature();
nemSensorValue = dht.readHumidity();
// Sıcaklık Nem Değer Okuma

  Serial.println(" KONTROLLER YAPILIYOR "); 

  if (sicaklikdegeri < 15) //mavi
  {
    Serial.println("---> SICAKLIK :  15 ALTINDA "); 

    digitalWrite(role, HIGH); //ROLE KAPALI
    digitalWrite(led_g, HIGH);
    digitalWrite(led_r, HIGH);
    digitalWrite(led_b, LOW);
  }
  else if (sicaklikdegeri > 15 && sicaklikdegeri < 25)//YEŞİL
  {
    Serial.println("---> SICAKLIK :  15 ile 25 degerleri arasinda "); 

    digitalWrite(role, HIGH); //ROLE KAPALI
    digitalWrite(led_g, LOW);
    digitalWrite(led_r, HIGH);
    digitalWrite(led_b, HIGH);
  }

  else if (sicaklikdegeri > 20 && sicaklikdegeri < 25) //YEŞİL 
  {
    
    Serial.println("---> SICAKLIK :  20 ile 25 degerleri arasinda ");

    digitalWrite(role, HIGH); //ROLE KAPALI 
    digitalWrite(led_g, LOW);
    digitalWrite(led_r, HIGH);
    digitalWrite(led_b, HIGH);
  }
  else if (sicaklikdegeri > 25 && sicaklikdegeri < 30) //fan çalışacak ve sarı yanacak
  {
    Serial.println("---> SICAKLIK :  25 ile 30 degerleri arasinda ");
    digitalWrite(role, LOW); //ROLE AÇIK
    digitalWrite(led_r, LOW);
    digitalWrite(led_g, LOW);
    digitalWrite(led_b, HIGH);
  }
 
  if (sicaklikdegeri >= 30 || degeri >= esikdegeri || nemdegeri >= 70) //Buzzer Alarm Seviyesi
  {
    digitalWrite(role, HIGH); //ROLE KAPALI
    digitalWrite(led_r, LOW); 
    digitalWrite(led_g, HIGH);
    digitalWrite(led_b, HIGH);
    Serial.println("---> SICAKLIK :  30 veya Nem : 70 ustunde"); 
    Serial.println("---> Gaz : 600 ustunde");  
    digitalWrite(buzzer_pin, LOW);
  }
  else  // Alarm seviyesi değilse buzzer sustur.
  {
    digitalWrite(buzzer_pin, HIGH);
  }
  //WiFi bağlantı durumunu kontrol et
  if(WiFi.status()== WL_CONNECTED){
    WiFiClient client;
    HTTPClient http;
    
    // URL yolu ile Alan adınız veya yol ile IP adresi
    http.begin(client, serverName);
    
    // İçerik türü başlığını belirtin
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    
   if (millis()-gecenzaman>=15000){ 
   // HTTP POST istek verilerinizi hazırlayın
    String httpRequestData = "token=" + token
                          + "&konum=" + sensorkonum + "&sicaklik=" + String(sicaklikSensorValue)
                          + "&nem=" + String(nemSensorValue) +"&gaz=" + String(gazSensorValue);
                         

    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);
    
    // HTTP POST isteği gönder
    int httpResponseCode = http.POST(httpRequestData);
    gecenzaman=millis();
    if (httpResponseCode>0) {
      Serial.print("HTTP Yanıt kodu: ");
      Serial.println(httpResponseCode);
    }
    else {
      Serial.print("Hata kodu: ");
      Serial.println(httpResponseCode);
    }
    http.end();
    }    
  }
}

  
