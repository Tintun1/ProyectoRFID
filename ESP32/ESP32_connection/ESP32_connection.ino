#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
#include <HTTPClient.h>
#include <WiFi.h>


int contador = 3;

LiquidCrystal_I2C lcd(0x27,16,2);

const char* ssid = "Telecentro-0946";
const char* password =  "2WKMKVT2YUVY";

String LED_id = "1";                  // ID DATABASE
bool toggle_pressed = false;          //Each time we press the push button    
String data_to_send = "";             //Text data to send to the server
unsigned int Actual_Millis, Previous_Millis;
int refresh_time = 1000;               //Refresh rate of connection to website (recommended more than 1s)
int LED = 2; // led pin



void IRAM_ATTR isr() {
  toggle_pressed = true; 
}

void setup() {
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0,0);
  lcd.print("Cargando...");
  delay(10);
  Serial.begin(19200);                   //Start monitor
  pinMode(LED, OUTPUT);
  WiFi.begin(ssid, password);             //Start wifi connection
  Serial.print("Connecting...");
  while (WiFi.status() != WL_CONNECTED) { //Check for the connection
    delay(500);
    Serial.print(".");
  }

  Serial.print("Connected, my IP: ");
  Serial.println(WiFi.localIP());
  Actual_Millis = millis();               //Save time for refresh loop
  Previous_Millis = Actual_Millis;
}

void loop() {

  //We make the refresh loop using millis() so we don't have to sue delay();
  //Actual_Millis = millis();
  //if(Actual_Millis - Previous_Millis > refresh_time){
    //Previous_Millis = Actual_Millis;  
    delay(500);
    if(WiFi.status()== WL_CONNECTED){           
      HTTPClient http;      
      http.begin("http://192.168.0.13/ProyectoRFID/esp32/esp32_update.php");   
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");     
      
      for(int i = 0; i <= contador; i++){
        if (i == 1) {
          int response_code = http.POST("check_LED_status=1");                                //Send the POST. This will giveg us a response co//If the code is higher than 0, it means we received a response
          if(response_code > 0){
            Serial.println("HTTP code " + String(response_code));                     //Print return code
          
            if(response_code == 200){                                                 //If code is 200, we received a good response and we can read the echo data
              String response_body = http.getString();                                //Save the data comming from the website
              Serial.print("Server reply LED: ");                                         //Print data to the monitor for debug
              Serial.println(response_body);

              //If the received data is LED_is_off, we set LOW the LED pin
              if(response_body == "OFF"){
                digitalWrite(LED, LOW);
              } else if (response_body == "ON") {
                    digitalWrite(LED, HIGH);
                }  
              }//End of response_code = 200
            } else{
              Serial.print("Error sending POST to led, code: ");
              Serial.println(response_code);
            }
          http.end();
        }

        if (i == 2) {
          int response_code = http.POST("check_LCD_status=1");                                                                 //End the connection
      
          if(response_code > 0){
            Serial.println("HTTP code " + String(response_code));                     //Print return code
      
            if(response_code == 200){                                                 //If code is 200, we received a good response and we can read the echo data
              String response_body = http.getString();                                //Save the data comming from the website
              Serial.print("Server reply text1: ");                                         //Print data to the monitor for debug
              Serial.println(response_body);
              lcd.clear();
              lcd.setCursor(0,0);
              lcd.print(response_body);

            }//End of response_code = 200
          } else{
          Serial.print("Error sending POST, code: ");
          Serial.println(response_code);
          }
          http.end();
        }

        if (i == 3) {
          int response_code = http.POST("check_LCD_status=2");                                                                 //End the connection
      
            if(response_code > 0){
              Serial.println("HTTP code " + String(response_code));                     //Print return code
        
              if(response_code == 200){                                                 //If code is 200, we received a good response and we can read the echo data
                String response_body = http.getString();                                //Save the data comming from the website
                Serial.print("Server reply text2: ");                                         //Print data to the monitor for debug
                Serial.println(response_body);
                lcd.clear();
                lcd.setCursor(0,1);
                lcd.print(response_body);

              }//End of response_code = 200
            } else{
            Serial.print("Error sending POST, code: ");
            Serial.println(response_code);
            }
            http.end();
          }
        delay(500);
      }

    }//END of WIFI connected
    else{
      Serial.println("WIFI connection error");
    }
  //}
}