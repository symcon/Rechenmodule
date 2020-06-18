# Umrechnen

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

* Berechnet über eine eingerichtete Formel einen Wert aus einer ausgewählten Quellvariable.
* Bei Variablenänderung der Quellvariable wird der Wert automatisch neuberechnet.

### 2. Voraussetzungen

- IP-Symcon ab Version 4.3

### 3. Software-Installation

* Über den Module Store das Modul Rechenmodule installieren.
* Alternativ über das Module Control folgende URL hinzufügen:
`https://github.com/symcon/Rechenmodule`    

### 4. Einrichten der Instanzen in IP-Symcon

- Unter "Instanz hinzufügen" kann das 'Umrechnen'-Modul mithilfe des Schnellfilters gefunden werden.
    - Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

__Konfigurationsseite__:

Name               | Beschreibung
------------------ | ---------------------------------
Quelle             | Quellvariable, die Berechnung genutzt werden soll.
Formel             | Formel, bei der Rechnung genutzt werden soll.
Wert               | Testwert um die Formel zu Testen
Berechne           | Berechnet den Wert anhand des Test-"Wert"


### 5. Statusvariablen und Profile

Die Statusvariablen/Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

##### Statusvariablen

Name  | Typ     | Beschreibung
----- | ------- | ----------------
Value | Float   | Beinhaltet den anhand der eingerichteten Formel berechneten Wert.

##### Profile:

Es werden keine zusätzlichen Profile hinzugefügt

### 6. WebFront

Über das WebFront werden die Variablen angezeigt. Es ist keine weitere Steuerung oder gesonderte Darstellung integriert.

### 7. PHP-Befehlsreferenz

`float UMR_Calculate(integer $InstanzID, float $Value);`  
Berechnet die Rückgabe der Formel für den Wert $Value und gibt diesen zurück.  
Beispiel:  
`UMR_Calculate(12345);`
