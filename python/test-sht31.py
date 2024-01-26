import time
import busio
from adafruit_bus_device.i2c_device import I2CDevice
from adafruit_sht31d import SHT31D

# Adresse I2C du multiplexeur TCA9548A
TCA9548A_ADDRESS = 0x70

# Configurer le bus I2C du Raspberry Pi
i2c = busio.I2C(3, 2)  # Utilise les broches physiques 3 (SCL) et 2 (SDA) du Raspberry Pi

# Fonction pour configurer le multiplexeur pour un canal spécifique
def select_i2c_channel(channel):
    with I2CDevice(i2c, TCA9548A_ADDRESS) as tca:
        tca.write(bytes([1 << channel]))

# Nombre de capteurs connectés au multiplexeur
nombre_capteurs = 8

# Adresses I2C des capteurs connectés à chaque canal du multiplexeur
adresses_capteurs = [0x44, 0x45, 0x46, 0x47, 0x48, 0x49, 0x4A, 0x4B]

# Configuration des capteurs SHT31-D
capteurs = [SHT31D(i2c, address=adresse) for adresse in adresses_capteurs]

# Lecture des données de tous les capteurs
for canal in range(nombre_capteurs):
    select_i2c_channel(canal)
    temp, humidite = capteurs[canal].measurements
    print(f"Capteur n°{canal + 1} est opérationel : \nTempérature = {temp:.2f}°C, \nHumidité = {humidite:.2f}%\n")
    time.sleep(1)
