#include <Arduino.h>
#include <FeedControl.h>

FeedControl::FeedControl() {
}

// Set uid pointer als nfc_tag
void FeedControl::setNFC(uint8_t *uid) {
    nfcTag = uid;
}

// get nfc_tag als pointer
uint8_t* FeedControl::getNFC() {
    return nfcTag;
}

// vergelijkingsfunctie voor nfc/uid tags
boolean FeedControl::compareNFC(uint8_t *uid) {
    if (memcmp(nfcTag, uid, 4) == 0)
        return true;
    return false;
}

// get feedtype van de fetched data
byte FeedControl::getFeedType() {
    return feedType;
}

/*
 * Fetch voedingspatroon van het dier overeenkomstig met het nfc/uid over LoRa.
 * Check local cache indien geen verbinding over LoRa gemaakt kan worden.
 * TODO: Vervang statische data met network data fetch of locale cache.
 */
void FeedControl::fetchFeedingPattern(uint8_t *uid) {
    setNFC(uid); // Stel nfc_tag gelijk aan het meegegeven uid
    // LoRa fetch van het voedingspatroon
    feedType = 2;
    allocatedAmount = 2000;
    portionSize = 250;
}

/*
 * Vergelijking van de totale consumptie versus de toegekende hoeveelheid en portiegroote.
 * Aansturing van de servo op basis van de voerbehoefte.
 */
boolean FeedControl::distributeFeed(float scale_units) {
    if (distributedAmount < allocatedAmount && scale_units < portionSize / 10) {
        return true;
    } else {
        return false;
    }
}

// Bereken verschil van gewicht in de voerback en toewijzing positieve verandering aan distributie;
void FeedControl::calculateDistributed(float scale_units) {
    float difference = scale_units - previousRead;
    if (difference > 0.2)
        distributedAmount += difference;
    previousRead = scale_units;
}

/*
 * Afsluiting van de voedingstransactie en versturen gegevens over LoRa
 * Restanten worden van het totale hoeveelheid toegekende voer afgehaald.
 * Resetten variabelen naar standaard waarde, voor volgende transactie.
 * TODO: Opsturen data consumptie en nfc tag over LoRa.
 */
void FeedControl::closeTransaction(float scale_units) {
    distributedAmount -= scale_units;
    // LoRa doSend(nfcTag, distributedAmount)
    allocatedAmount = 0;
    portionSize = 0;
    distributedAmount = 0;
    nfcTag = nullptr;
}