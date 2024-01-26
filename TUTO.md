# Mise en place du projet MultiSense Hub

Le projet MultiSense Hub a comme objectif de permmettre la capture de données a l'aide de plusieurs capteurs SHT31-D et d'un thermocouple.

## Sommaire

## Prérequis

Il est préférable d'avoir un client SFTP pour l'importation de tout les code même si une clé USB pourra également accomplir se rôle.

## Mise en place du serveur web *Apache2*

il faut commencer par mettre a jour le système :

```bash
sudo apt-get update -y
```

ensuite on va télécharger Apache2 :

```bash
sudo apt install apache2 -y
```

*la condition "-y" permet d'accepter le téléchargement*

Il faut maintenant importer les fichiers du site dans le répertoire de apache2. Il se trouve dans `/var/www/html` dans se répertoire il se trouve un fichier nommé `index.html` il faut le supprimer a l'aide de la commande suivante :

```bash
rm index.html
```

ensuite avec il faudra importer les fichiers du site c'est a dire le ``index.php`` et ``style.ccs`` via une clé usb ou par un client SFTP (Secure FIle Transfer Protocol) comme [WinSCP](https://winscp.net/eng/download.php)

## Mise en place de la Base De Données (BDD) MySQL

Les commandes à faire pour avoir une BDD MySQL (MariaDB) avec PhpMyAdmin

```bash
sudo apt install mariadb-server mariadb-client
```

```bash
sudo apt install phpmyadmin apache2 php-zip php-gd php-json php-curl libapache2-mod-php
```
Il faudra sélectionez **Oui**.

Puis vous devez choisir votre mot de passe.

Et pour finir il faudra à nouveaux choisir **Oui**.

```bash
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
```

```bash
sudo a2enconf phpmyadmin.conf
```

```bash
sudo systemctl reload apache2.service
```

Vous pouvez désormé vous connecter a l'interfae PhpMyAdmin, rendez vous sur le navigateur internet depuis un ordinateur qui est connecter au même réseau et taper :

"`IP-SERVEUR`/phpmyadmin"

*faudra bien remplacer `IP-SERVEUR` par l'IP du serveur*

User : root

Mot de passe : *votre mot de passe*


### **Si** le mot de passe que vous avez rentrer ne marche pas :

```bash
mysql
```

```mysql
SET PASSWORD FOR 'root'@'localhost' = PASSWORD('NouveauMotDePasse');
```
*Bien remplacer NouveauMotDePasse par le mot de passe de votre choix.*

## Code Python

Il y a plusieurs code python qui sont nécessaire au projet, il y a des code de test et le code qui permet d'executer la lecture en simultatné des capteurs et du thermocouple et l'envoi dans la BDD, c'est le fichier ``multisense.py``.

