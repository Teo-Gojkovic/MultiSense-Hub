import board
import digitalio
import busio
import adafruit_max31856
import time

# -------------------- Variables --------------------
#pins pour le MAX31856
sck = 11
mosi = 10
miso = 9
cs_pin = 'D5'

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

# Essaie de lecture de la température via le thermocouple
try :
    temperature = thermocouple.temperature
    if temperature != 0 :
        print(f"Le thermocouple est opérationel : \nTempérature : {temperature:.2f} °C")
except OSError as e :
    print(f"ERREUR : {e}")
