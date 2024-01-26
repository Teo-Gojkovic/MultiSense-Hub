import board
import busio
import adafruit_sht31d
import time
import mysql.connector

# -------------------- Variables --------------------
multiplexer_address = 0x70 # Adresse I2C du multiplexeur TCA9548A

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

def insert_data(sensor_id, temperature, humidity):
    query = f"INSERT INTO SHT{sensor_id} (TIME, temp, hum) VALUES (NOW(), {temperature}, {humidity})"
    cursor.execute(query)
    conn.commit()

# -------------------- BDD --------------------
# Initialisation de la connexion à la base de données
conn = mysql.connector.connect(**db_config)
cursor = conn.cursor()

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
    try :
        if sht1:
            select_channel(0)
            temp1 = sht1.temperature
            hum1 = sht1.relative_humidity
            print(f"Capteur 1 : {temp1}°C, {hum1}%")
            insert_data(0, temp1, hum1)
        else:
            print("Capteur 1 non détecté. Pas de lecture.")

        if sht2:
            select_channel(1)
            temp2 = sht2.temperature
            hum2 = sht2.relative_humidity
            print(f"Capteur 2 : {temp2}°C, {hum2}%")
            insert_data(1, temp2, hum2)
        else:
            print("Capteur 2 non détecté. Pas de lecture.")

        if sht3:
            select_channel(2)
            temp3 = sht3.temperature
            hum3 = sht3.relative_humidity
            print(f"Capteur 3 : {temp3}°C, {hum3}%")
            insert_data(2, temp3, hum3)
        else:
            print("Capteur 3 non détecté. Pas de lecture.")

        if sht4:
            select_channel(3)
            temp4 = sht4.temperature
            hum4 = sht4.relative_humidity
            print(f"Capteur 4 : {temp4}°C, {hum4}%")
            insert_data(1, temp4, hum4)
        else:
            print("Capteur 4 non détecté. Pas de lecture.")
            print("--------------------------------------")

    except OSError as a :
        print(f"ERREUR : {a}")
        
        # Fermeture de la connexion à la base de données
        cursor.close() ; conn.close()

    time.sleep(300) # Attendre 300 secondes / 5 minutes avant la prochaine lecture


