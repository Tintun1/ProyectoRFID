#include <HTTPClient.h>
#include <WiFi.h>

const char* ssid = "Telecentro-0946";
const char* password =  "2WKMKVT2YUVY";

String LED_id = "1";                  // ID DATABASE
bool toggle_pressed = false;          //Each time we press the push button    
String data_to_send = "";             //Text data to send to the server
unsigned int Actual_Millis, Previous_Millis;
int refresh_time = 200;               //Refresh rate of connection to website (recommended more than 1s)
int LED = 2; // led pin

void IRAM_ATTR isr() {
  toggle_pressed = true; 
}

void setup() {
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
  delay(500);
  Actual_Millis = millis();
  if(Actual_Millis - Previous_Millis > refresh_time){
    Previous_Millis = Actual_Millis;  
    if(WiFi.status()== WL_CONNECTED){                   //Check WiFi connection status  
      HTTPClient http;                                  //Create new client
      
      data_to_send = "check_LED_status=" + LED_id;    //If button wasn't pressed we send text: "check_LED_status"
      
      //Begin new connection to website       
      http.begin("http://192.168.0.13/ProyectoRFID/esp32/esp32_update.php");   //Indicate the destination webpage 
      http.addHeader("Content-Type", "text/plain");         //Prepare the header
      
      int response_code = http.POST(data_to_send);                                //Send the POST. This will giveg us a response code
      
      //If the code is higher than 0, it means we received a response
      if(response_code > 0){
        Serial.println("HTTP code " + String(response_code));                     //Print return code
  
        if(response_code == 200){                                                 //If code is 200, we received a good response and we can read the echo data
          String response_body = http.getString();                                //Save the data comming from the website
          Serial.print("Server reply: ");                                         //Print data to the monitor for debug
          Serial.println(response_body);

          //If the received data is LED_is_off, we set LOW the LED pin
          if(response_body == "OFF"){
            digitalWrite(LED, LOW);
          }
          //If the received data is LED_is_on, we set HIGH the LED pin
          else if(response_body == "ON"){
            digitalWrite(LED, HIGH);
          }  
        }//End of response_code = 200
      } else{
       Serial.print("Error sending POST, code: ");
       Serial.println(response_code);
      }
      http.end();                                                                 //End the connection
    }//END of WIFI connected
    else{
      Serial.println("WIFI connection error");
    }
  }
}