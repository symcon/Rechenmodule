# WertebereichSkalieren
Skalierung eines Wertes innerhalb eines Wertebereiches.

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

* Eingabe vom Eingabewertebereich 
* Eingabe vom Ausgabewertebereich
* Umrechnung von einem Eingabewert
* Berechnung bei Wertänderung des Eingabewertes 

### 2. Voraussetzungen

- IP-Symcon ab Version 6.4

### 3. Software-Installation

* Über den Module Store das 'WertebereichSkalieren'-Modul installieren.
* Alternativ über das Module Control folgende URL hinzufügen

### 4. Einrichten der Instanzen in IP-Symcon

 Unter 'Instanz hinzufügen' kann das 'WertebereichSkalieren'-Modul mithilfe des Schnellfilters gefunden werden.  
	- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

__Konfigurationsseite__:

Name                  | Beschreibung
--------------------- | ------------------
Eingabevariable       | Variable, welche als Eingabewert dient
Minimaler Eingabewert | Die untere Wertgrenze der Eingabe
Maximaler Eingabewert | Die obere Wertgrenze der Eingabe
Minimaler Ausgabewert | Die untere Wertgrenze der Ausgabe
Maximaler Ausgabewert | Die obere Wertgrenze der Ausgabe

### 5. Statusvariablen

Die Statusvariablen/Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

#### Statusvariablen

Name    | Typ     | Beschreibung
------- | ------- | ------------
Ausgabe | float   | Ausgabewert der Berechnung 

### 6. WebFront

Das Module hat im Webfront keine Funktion.

### 7. PHP-Befehlsreferenz

`boolean VRC_Scale(integer $InstanzID);`
Skaliert den Wert der Eingabevariable nach den gesetzten Grenzen mit einer linearen Funktion.

Beispiel:
`VRC_BeispielFunktion(12345);`