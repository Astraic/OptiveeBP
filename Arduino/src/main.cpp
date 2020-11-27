#include <Arduino.h>
#include <HX711.h>
#include <EEPROM.h>
#include <Servo.h>

#define DOUT_PIN 2
#define SCK_PIN 3
#define SERVO_PIN 11
#define BTN_PIN 7
#define CAL_ADDRESS 0
#define CAL_WEIGHT 290
#define CAL_PRECISION 10

HX711 scale;
Servo servo;
String nfcTag;
byte feed = 0;
float allocated = 0;
float portionsize = 0;
float distributed = 0;
float lastWeight = 0;
float slope = 0.00f;

void setup() {
  EEPROM.get(CAL_ADDRESS, slope);
  pinMode(BTN_PIN, INPUT_PULLUP);
  scale.begin(DOUT_PIN, SCK_PIN);
  scale.set_scale(slope);
  scale.tare(CAL_PRECISION);
  servo.attach(SERVO_PIN);
  servo.write(0);
}

/*
 * De calibratie kan worden beschreven als een  liniear verband volgens y = ax + b.
 * Calculatie van de slope a, de calibratiefactor, wordt beschreven als a = (y - b) / x.
 * Hier is de y het gewicht in de gewenste eenheid, b is de offset/tara, en x de gemeten waarde.
 * De gebruike library van Bogde wijkt af van deze conventie https://github.com/bogde/HX711 
 * Gebruik van de get_units() functie vereist dat de waarde x en y omgewisseld worden.
 */
void calibrate() {
  slope = scale.get_value(CAL_PRECISION) / CAL_WEIGHT; // get_value() = read_average() - offset
  scale.set_scale(slope); // Calibreert de load cell op basis van de berekende factor
  EEPROM.put(CAL_ADDRESS, slope); // Plaats de calibratiewaarde in het EEPROM voor later gebruik
}

/*
 * Deze switch bepaald welke servo aangestuurd dient te worden. Indien er meerdere soorten voer
 * beschikbaar zijn in het systeem zal het systeem per voersoort een ander servo aansturen.
 * De hoek parameter wordt vergeleken met servo.read() om dubbele instructie tegen voorkomen.
 */
void servoSwitch(int hoek) {
  switch (feed) {
    case 1:
      if (servo.read() != hoek) servo.write(hoek);
      break;
    case 2:
      if (servo.read() != hoek) servo.write(hoek); // Dit zou ik de praktijk een tweede servo zijn.
      break;
    case 3:
      if (servo.read() != hoek) servo.write(hoek); // Dit zou ik de praktijk een derde servo zijn.
      break;
  }
}

/*
 * Fetch voedingspatroon van het dier overeenkomstig met het nfcTag over LoRa.
 * Check local cache indien geen verbinding over LoRa gemaakt kan worden.
 * TODO: Vervang statische data met network data fetch of locale cache.
 */
void fetchFeedingPattern() {
  feed = 2; 
  allocated = 2000;
  portionsize = 250;
}

/*
 * Vergelijking van de totale consumptie versus de allocated amount.
 * Vergelijking van het gewicht in de voerbak ten opzichte van de portiegroote.
 * Aansturing van de servo voor open/sluiten van de voer toevoer.
 */
void feedDistribution() {
  float currentWeight = scale.get_units();
  if (distributed < allocated && currentWeight < portionsize / 10) {
      servoSwitch(180);
  } else if (distributed >= allocated || currentWeight >= portionsize) {
      servoSwitch(0);
  }

  // Berekend het verschil in gewicht ten opzichte van het laatste gewicht.
  // Indien het verschil groter dan 0 is zal dit bij het verstrekte totaal worden gevoegd.
  // Indien dat niet het geval is, heeft het dier een deel van het voer opgegeten.
  // Tot slot wordt het huidige gewicht het laatste gewicht.
  float difference = currentWeight - lastWeight;
  if (difference > 0.2) {
    distributed += difference;
  }
  lastWeight = currentWeight;
}

/*
 * Afsluiten van de voedingstransactie ter voorbereiding op het volgende dier.
 * Door van de verstrekte hoeveelheid voer het overgebleven voer af te halen
 * kan het totale geconsumeerde voer worden berekened alvorens dit op te sturen.
 * Opslaan van de voerconsumptie in de cloud database via LoRa.
 * Tot slot worden de gebruikte variabele leeg gemaakt voor de volgende transactie.
 * TODO: opsturen data consumptie en nfc tag over LoRa.
 */
void feedTransaction() {
  distributed -= scale.get_units();
  // send data
  allocated = 0;
  portionsize = 0;
  distributed = 0;
  nfcTag = "";
}

/*
 * Dummmy functie ter simulatie van het uitlezen van een nfc tag.
 */
String nfcRead() {
  String nfcRead = "ABCDE";
  return nfcRead;
} 

/*
 * Dummmy functie ter simulatie voor controle op een aanwezig nfc tag.
 */
boolean nfcPresent() {
  return true;
}

void loop() {
  if(nfcPresent()) {  // Controle of er op het moment een nfctag aanwezig is.
    /*
     * Er is sprake van een nieuw tag indien de uitgelezen waarde ongelijk is aan nfcTag.
     * Indien dat het geval is wordt het nieuw ncf tag uitgelezen en opgeslagen.
     * Er wordt eenmalig een opvraag gedaan naar het voedingspatroon van het dier dat 
     * overeenkomt met het waargenomen nfc tag en de load cell wordt getarreerd.
     */
    if (nfcRead() != nfcTag) {
      nfcTag = nfcRead();
      fetchFeedingPattern();
      scale.tare();
    }

    // Indien hetzelfde dier nogsteeds aanwezig is zal nfcRead() overeenkomen met nfcTag.
    if (nfcRead() == nfcTag) {
      feedDistribution();
    }
  } 

  /* 
   * De aanname is dat het niet mogelijk is een ander nfc tag waar te nemen voordat
   * de nfc reader het ontbreken van het voorgaande tag waarneemt.
   * Dieren kunnen namelijk niet nagenoeg direct op dezelfde locate aanwezig zijn.
   */
  if (!nfcPresent() && nfcTag != "") { 
    feedTransaction();
  }  

  if (digitalRead(BTN_PIN) == LOW) calibrate();
}