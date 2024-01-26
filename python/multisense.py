import board
import busio
import digitalio
import adafruit_sht31d
import adafruit_max31856
import time
import mysql.connector

# -------------------- Variables --------------------
multiplexer_address = 0x70 # Adresse I2C du multiplexeur TCA9548A

#pins pour le MAX31856
sck = 11
mosi = 10
miso = 9
cs_pin = 'D5'

# Init capteurs
sht1 = None ; sht2 = None
sht3 = None ; sht4 = None

#base de données MySQL
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': 'password',
    'database': 'data'
}

i2c = busio.I2C(board.SCL, board.SDA) #inisialisation du I2C

# -------------------- Fonctions --------------------
def select_channel(channel):
    i2c.writeto(multiplexer_address, bytes([1 << channel]))
    time.sleep(0.5)  # Attends un moment pour laisser le temps au multiplexeur de changer de canal

# Fonction pour détecter les capteurs
def detect_sensor(channel):
    select_channel(channel)
    try:
        sht = adafruit_sht31d.SHT31D(i2c)
        temperature = sht.temperature
        humidity = sht.relative_humidity
        print(f"Capteur Adafruit SHT31-D détecté sur le canal {channel}")
        return sht
    except (ValueError, OSError) as e:
        print(f"Erreur de communication avec le capteur sur le canal {channel}: {e}")
        return None

def insert_data_sht(sensor_id, temperature, humidity):
    query = f"INSERT INTO SHT{sensor_id} (TIME, temp, hum) VALUES (NOW(), {temperature}, {humidity})"
    cursor.execute(query)
    conn.commit()

def insert_data_max(temperature):
    query = f"INSERT INTO thermocouple (TIME, temp) VALUES (NOW(), {temperature})"
    cursor.execute(query)
    conn.commit()

# -------------------- BDD --------------------
# Initialisation de la connexion à la base de données
conn = mysql.connector.connect(**db_config)
cursor = conn.cursor()

# -------------------- bus SPI --------------------
# Configuration du bus SPI
print("config SPI")
spi = busio.SPI(sck, MOSI=mosi, MISO=miso)

# Configuration du chip select (CS)
print("ship select")
cs = digitalio.DigitalInOut(getattr(board, cs_pin))
cs.direction = digitalio.Direction.OUTPUT

# Création de l'objet MAX31856 à partir du bus SPI et du CS
print("Objet")
thermocouple = adafruit_max31856.MAX31856(spi, cs)

# -------------------- Boucles --------------------
# Boucle pour détecter les capteurs
for channel in range(4):
    if channel == 0:
        sht1 = detect_sensor(channel)
    elif channel == 1:
        sht2 = detect_sensor(channel)
    elif channel == 2:
        sht3 = detect_sensor(channel)
    elif channel == 3:
        sht4 = detect_sensor(channel)

print(f"Status du capteur sur les canaux : \n- 1 : {sht1} \n- 2 : {sht2} \n- 3 : {sht3} \n- 4 : {sht4}")
# Boucle pour la lecture et l'envoi des données
while True :
    try : #SHT31 1 - 2 - 3 - 4
        if sht1:
            select_channel(0)
            temp1 = sht1.temperature
            hum1 = sht1.relative_humidity
            print(f"Capteur 1 : {temp1}°C, {hum1}%")
            try :
                insert_data_sht(0, temp1, hum1)
                print('envoi MySQL : ok')
            except :
                print('envoi MySQL : erreur')

        else:
            print("Capteur 1 non détecté. Pas de lecture.")

        if sht2:
            select_channel(1)
            temp2 = sht2.temperature
            hum2 = sht2.relative_humidity
            print(f"Capteur 2 : {temp2}°C, {hum2}%")
            try :
                insert_data_sht(1, temp2, hum2)
                print('envoi MySQL : ok')
            except :
                print('envoi MySQL : erreur')
        else:
            print("Capteur 2 non détecté. Pas de lecture.")

        if sht3:
            select_channel(2)
            temp3 = sht3.temperature
            hum3 = sht3.relative_humidity
            print(f"Capteur 3 : {temp3}°C, {hum3}%")
            try :
                insert_data_sht(2, temp3, hum3)
                print('envoi MySQL : ok')
            except :
                print('envoi MySQL : erreur')
        else:
            print("Capteur 3 non détecté. Pas de lecture.")

        if sht4:
            select_channel(3)
            temp4 = sht4.temperature
            hum4 = sht4.relative_humidity
            print(f"Capteur 4 : {temp4}°C, {hum4}%")
            try :
                insert_data_sht(3, temp4, hum4)
                print('envoi MySQL : ok')
            except :
                print('envoi MySQL : erreur')
        else:
            print("Capteur 4 non détecté. Pas de lecture.")
            print("--------------------------------------")

    except OSError as a :
        print(f"ERREUR : {a}")

    try : #MAX31856 thermocouple
        temperature = thermocouple.temperature
        print(f"Température : {temperature:.2f} °C")
        insert_data_max(temperature)
        time.sleep(300)  # Attendre 300 secondes / 5 minutes avant la prochaine lecture
    except OSError as a :
        print(f"ERREUR : {a}")

    time.sleep(300) # Attendre 300 secondes / 5 minutes avant la prochaine lecture