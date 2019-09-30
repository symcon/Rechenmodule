# Rechen-Modul
Dieses Modul kann verschiedene Hilfsberechnungen auf einer Menge von Variablen durchführen, beispielsweise die Summe oder den Durchschnitt.

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

* Berechnungen verschiedener Werte basierend auf einer Gruppe von Variablen:
  * Summe
  * Minimum
  * Maximum
  * Durchschnitt
  * Anzahl der Variablen
* Ausgabe der berechneten Werte in Variablen
* Aktualisierung der Werte sobald sich eine der Variablen ändert

### 2. Voraussetzungen

- IP-Symcon ab Version 4.3

### 3. Software-Installation

* Über den Module Store das Modul Rechenmodule installieren.
* Alternativ über das Module Control folgende URL hinzufügen:
`https://github.com/symcon/Rechenmodule`  

### 4. Einrichten der Instanzen in IP-Symcon

- Unter "Instanz hinzufügen" ist das 'Rechen-Modul' unter dem Hersteller '(Gerät)' aufgeführt.  

__Konfigurationsseite__:

Name       | Beschreibung
---------- | ---------------------------------
Berechnung | Auswahl der durchgeführten Berechnung(en)
Variablen  | VariablenIDs der Variablen auf denen die Berechnung(en) durchgeführt werden; Für alle Berechnungen außer _Anzahl_ müssen alle Variablen vom Typ Float oder Integer sein

___Mögliche Berechnungen___:

Name         | Beschreibung
------------ | ---------------------------------
Alles        | Alle in dieser Tabelle vorgestellten Berechnungen werden durchgeführt
Summe        | Die Summe aller ausgewählten Variablen wird in der Statusvariablen _Summe_ gespeichert
Minimum      | Der minimale Wert der ausgewählten Variablen wird in der Statusvariablen _Minimum_ gespeichert
Maximum      | Der maximale Wert der ausgewählten Variablen wird in der Statusvariablen _Maximum_ gespeichert
Durchschnitt | Der Durchschnitt der ausgewählten Variablen wird in der Statusvariablen _Durchschnitt_ gespeichert
Anzahl       | Die Anzahl der ausgewählten Variablen wird in der Statusvariablen _Anzahl_ gespeichert

### 5. Statusvariablen und Profile

Die Statusvariablen werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

##### Statusvariablen

Für jede Berechnung wird eine dazugehörige Statusvariable angelegt.

Name         | Typ   | Beschreibung
------------ | ----- | ----------------
Summe        | Float | Die Summe aller ausgewählten Variablen
Minimum      | Float | Der minimale Wert der ausgewählten Variablen
Maximum      | Float | Der maximale Wert der ausgewählten Variablen
Durchschnitt | Float | Der Durchschnitt der ausgewählten Variablen
Anzahl       | Float | Die Anzahl der ausgewählten Variablen

##### Profile:

Es werden keine zusätzlichen Profile hinzugefügt.

### 6. WebFront

Über das WebFront werden die Variablen angezeigt. Es ist keine weitere Steuerung oder gesonderte Darstellung integriert.

### 7. PHP-Befehlsreferenz

`boolean RM_Update(integer $InstanzID);`  
Aktualisiert die berechneten Werte
Beispiel:  
`RM_Update(12345);`