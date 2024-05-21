#include <Wire.h>
#include <PN532_I2C.h>
#include <PN532.h>
#include <NfcAdapter.h>
#include <LiquidCrystal_I2C.h>
#include <HTTPClient.h>
#include <WiFi.h>

// Declaración del objeto lcd para controlar la pantalla LCD I2C HEX VALUE = 0x27
LiquidCrystal_I2C lcd(0x27,16,2);

// Configuración de la red WiFi
const char* ssid = "Estudiantes";
const char* password =  "educar_2018";

// Pin para el relé
const int rele = 32;

// Definición de los estados posibles del sistema
#define noAutorizado 0
#define espera 1
#define autorizado 2
#define subiendo 3
#define subido 4

// Inicialización de variables de estado
bool estado_rele = false;
int estado_Tarjeta = espera;
int estado_uid = espera;

// Variables para el manejo de tiempo
unsigned long tiempo_actual;
unsigned long tiempo_anterior = 0;

// Inicialización del objeto NFC
PN532_I2C pn532_i2c(Wire);
NfcAdapter nfc = NfcAdapter(pn532_i2c);
String tagId = "None";
byte nuidPICC[4];

// Configuración inicial del sistema
void setup(void) {
  // Inicialización y encendido del LCD
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0,0);
  lcd.print("Iniciado");

  // Inicialización de la comunicación serial
  Serial.begin(115200);
  Serial.println("System initialized");

  // Configuración del pin del relé como salida
  pinMode(rele, OUTPUT);

  // Inicialización del módulo NFC
  nfc.begin();

  // Conexión a la red WiFi
  WiFi.begin(ssid, password);
  
  Serial.print("Conectando...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.print("Conectado con éxito, mi IP es: ");
  Serial.println(WiFi.localIP());
}

// Función principal del programa
void loop(void) {
  // Comprobación de la conexión WiFi
  if(WiFi.status()== WL_CONNECTED){
    HTTPClient http;
    
    http.begin("http://10.0.9.125/ProyectoRFID/esp32/esp32_update.php");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Refrescar el tiempo actual
    tiempo_actual = millis();

    // Comprobación y manejo de estados
    if (estado_rele && estado_Tarjeta == autorizado) {
      resetEstado(4000);
    }

    if (!estado_rele && estado_Tarjeta == espera) {
      // Configuración de la pantalla LCD y espera de tarjeta
      lcd.clear();
      lcd.setCursor(0,0);
      lcd.print("Cerrado");
      lcd.setCursor(0,1);
      lcd.print("Apoyar tarjeta");
      digitalWrite(rele, LOW);

      // Lectura de la tarjeta NFC
      if (nfc.tagPresent()) {
        NfcTag tag = nfc.read();
        Serial.println("ID:" + tag.getUidString());

        // Envío de la UID al servidor para comprobación
        int codigo_respuesta = http.POST("check_uid_code=" + tag.getUidString());
        if (codigo_respuesta == 200){
          String mensaje_respuesta = http.getString();
          Serial.println("Servidor responde:" + mensaje_respuesta);
          if (tag.getUidString() == mensaje_respuesta){
            actualizarEstado(autorizado);
          } else {
            actualizarEstado(noAutorizado);
          }
        } else {
          Serial.println("Error al mandar el POST verificativo");
        }
      }

      // Verificación del estado de la tarjeta en el servidor
      int codigo_respuesta2 = http.POST("check_uid_status=1");
      if (codigo_respuesta2 == 200){
        String mensaje_respuesta2 = http.getString();
        Serial.println("Servidor responde al estado:" + mensaje_respuesta2);
        if (mensaje_respuesta2 == "1"){
          estado_Tarjeta = subiendo;
          lcd.clear();
          lcd.setCursor(0,0);
          lcd.print("Acerque tarjeta");
          lcd.setCursor(0,1);
          lcd.print("Para registro");
        }
      } else {
        Serial.println("Error al mandar el POST verificativo");
      }
    }

    if (estado_Tarjeta == noAutorizado){
      // Acciones a realizar si la tarjeta no está autorizada
      resetEstado(4000);
    }

    if (estado_Tarjeta == subiendo){
      // Acciones a realizar si la tarjeta está en proceso de subida al servidor
      if (nfc.tagPresent()) {
            NfcTag tag = nfc.read();
            Serial.println("ID:" + tag.getUidString());
            int codigo_respuesta3 = http.POST("submit_uid=" + tag.getUidString());

            if (codigo_respuesta3 == 200){
              lcd.clear();
              lcd.setCursor(0,0);
              lcd.print("Subido");
              actualizarMillis();
              estado_Tarjeta = subido;
            }
          }
    }

    if (estado_Tarjeta == subido){
      // Acciones a realizar si la tarjeta ya ha sido subida al servidor
      resetEstado(2000);
    }
    http.end(); // Liberación de recursos
  }
}

// Función para reiniciar los estados del sistema
void resetEstado(unsigned long tiempo_espera) {
  if (tiempo_actual - tiempo_anterior >= tiempo_espera){
    tiempo_anterior = tiempo_actual;
    estado_rele = false;
    estado_Tarjeta = espera;
    Serial.println("Reset");
  }
}

// Función para actualizar el tiempo actual
void actualizarMillis(){
  tiempo_actual = millis();
  tiempo_anterior = tiempo_actual;
}

// Función para actualizar el estado del sistema y mostrarlo en la pantalla LCD
void actualizarEstado(int nuevo_estado) {
  lcd.clear();
  lcd.setCursor(0,0);
  estado_Tarjeta = nuevo_estado;
  tiempo_actual = millis();
  tiempo_anterior = tiempo_actual;
  if (nuevo_estado == autorizado) {
    lcd.print("Autorizado");
    estado_rele = true;
    digitalWrite(rele, HIGH);
  } else {
    lcd.print("No autorizado");
  }
}
