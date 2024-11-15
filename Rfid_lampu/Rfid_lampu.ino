#include <ESP8266WiFi.h>
#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266HTTPClient.h>

#define RST_PIN D3       // Reset pin untuk RFID reader
#define SS_PIN D4        // Pin SS untuk RFID reader
#define GREEN_LED D0     // LED Hijau untuk absen berhasil
#define RED_LED D1       // LED Merah untuk absen gagal

const char* ssid = "aa";
const char* password = "123456789";
const char* server = "http://192.168.43.13/agendaKelas/api/cek_uid1.php";

MFRC522 mfrc522(SS_PIN, RST_PIN);
WiFiClient client;

void setup() {
  Serial.begin(115200);
  SPI.begin();
  mfrc522.PCD_Init();

  pinMode(GREEN_LED, OUTPUT);
  pinMode(RED_LED, OUTPUT);
  
  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nConnected to WiFi");
}

// Fungsi untuk menyalakan LED hijau
void greenLedSuccess() {
  digitalWrite(GREEN_LED, HIGH); // LED hijau nyala selama 1 detik
  delay(1000);
  digitalWrite(GREEN_LED, LOW);
}

// Fungsi untuk membuat LED hijau berkedip dua kali
void greenLedDoubleBlink() {
  for (int i = 0; i < 2; i++) {  // Kedip 2 kali
    digitalWrite(GREEN_LED, HIGH);
    delay(1000);
    digitalWrite(GREEN_LED, LOW);
    delay(1000);
  }
}

// Fungsi untuk menyalakan LED merah
void redLedFailure() {
  digitalWrite(RED_LED, HIGH); // LED merah nyala selama 1 detik
  delay(1000);
  digitalWrite(RED_LED, LOW);
}

// Fungsi untuk membuat LED merah berkedip dua kali
void redLedDoubleBlink() {
  for (int i = 0; i < 2; i++) {  // Kedip 2 kali
    digitalWrite(RED_LED, HIGH);
    delay(1000);
    digitalWrite(RED_LED, LOW);
    delay(1000);
  }
}

void loop() {
  // Periksa apakah ada kartu baru
  if (!mfrc522.PICC_IsNewCardPresent() || !mfrc522.PICC_ReadCardSerial()) {
    delay(50);
    return;
  }

  // Baca UID dan konversi ke kapital tanpa spasi
  String uid = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    String hexByte = String(mfrc522.uid.uidByte[i], HEX);
    if (hexByte.length() < 2) {
        hexByte = "0" + hexByte;
    }
    uid += hexByte;
  }
  uid.toUpperCase();

  Serial.print("UID: ");
  Serial.println(uid);

  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    String url = String(server) + "?uid=" + uid;
    http.begin(client, url);
    int httpCode = http.GET();

    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      Serial.print("Response from server: ");
      Serial.println(payload);
      
      // Tampilkan pesan berdasarkan respons
      if (payload == "inserted") {
        Serial.println("Absen Masuk Berhasil");
        greenLedSuccess(); // Nyalakan LED hijau 1 detik

      } else if (payload == "updated") {
        Serial.println("Absen Pulang Berhasil");
        greenLedDoubleBlink(); // LED hijau berkedip dua kali

      } else if (payload == "belumWaktuPulang") {
        Serial.println("Belum Saatnya Pulang");
        redLedDoubleBlink(); // LED merah berkedip dua kali

      } else if (payload == "sudahAbsenLengkap") {
        Serial.println("Anda Sudah Absen Untuk Hari Ini");
       redLedFailure();
       delay(1000);
       redLedFailure();
        
      } else if (payload == "false") {
        Serial.println("Kartu Tidak Terdaftar");
        redLedFailure(); // Nyalakan LED merah 1 detik
        
      } else if (payload == "error") {
        Serial.println("Terjadi Kesalahan pada Server");
        redLedFailure(); // Nyalakan LED merah 1 detik
        
      } else {
        Serial.println("Respon Tidak Dikenali");
        redLedFailure(); // Nyalakan LED merah 1 detik
      }
    } else {
      Serial.println("Gagal terhubung ke server");
      redLedFailure(); // Nyalakan LED merah 1 detik
    }
    http.end();
  } else {
    Serial.println("WiFi tidak terhubung");
    redLedFailure(); // Nyalakan LED merah 1 detik
  }

  mfrc522.PICC_HaltA();
  delay(1000);
}
