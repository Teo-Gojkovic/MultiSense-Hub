import board
import digitalio
import busio
import adafruit_max31856
import time
import mysql.connector

# -------------------- Variables --------------------
#pins pour le MAX31856
sck = 11
mosi = 10
miso = 9
cs_pin = 'D5'

#base de données MySQL
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': 'password',
    'database': 'data'
}

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

# -------------------- Fonctions --------------------
def insert_data(temperature):
    query = f"INSERT INTO thermocouple (TIME, temp) VALUES (NOW(), {temperature})"
    cursor.execute(query)
    conn.commit()

# -------------------- Boucles --------------------
# Boucle pour lire la température toutes les 5 minutes
while True:
    try :
        temperature = thermocouple.temperature
        print(f"Température : {temperature:.2f} °C")
        insert_data(temperature)
        time.sleep(300)  # Attendre 300 secondes / 5 minutes avant la prochaine lecture
    except OSError as e :
        print(f"ERREUR : {e}")
