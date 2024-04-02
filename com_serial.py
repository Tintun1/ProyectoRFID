import serial
import MySQLdb
import time

dbconn = MySQLdb.connect("localhost","root","","registro")
cursor = dbconn.cursor()

device = 'COM6'
try:
    print ("Trying..."),device
    esp32 = serial.Serial(device, 9600)
except:
    print("Failed to connect on"),device
while True:
    time.sleep(1)
    try:
        data=esp32.readline()
        print (data)
        pieces=data.split(" ")
        try:
            cursor=dbconn.cursor()
            cursor.execute("""INSERT INTO prueba (id,nombre,hex,fecha_reg,dato) VALUES (NULL,%s,%s,%s.%s)""", (pieces[0],pieces[1],pieces[2],pieces[3]))
            dbconn.commit()
            cursor.close()
        except MySQLdb.IntegrityError:
            print ("failed to insert data")
        finally:
            cursor.close()
    except:
        print ("Processing")
