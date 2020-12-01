#include <Arduino.h>
#include <Loadcell.h>
#include <EEPROM.h>

Loadcell::Loadcell() {
}

void Loadcell::begin(byte dout, byte pd_sck, byte gain) {
	HX711::begin(dout, pd_sck);
	EEPROM.get(SLOPE_ADDRESS, slope);
	set_scale(slope);
}

/*
 * De calibratie kan worden beschreven als een liniear verband volgens y = ax + b.
 * Calculatie van de slope a, de calibratiefactor, wordt beschreven als a = (y - b) / x.
 * Hier is de y het gewicht in de gewenste eenheid, b is de offset/tara, en x de gemeten waarde.
 * De gebruike library van Bogde wijkt af van deze conventie https://github.com/bogde/HX711.
 * Gebruik van de get_units() functie vereist dat de waarde x en y omgewisseld worden.
 */
void Loadcell::calibrate(float calibration_weight ,byte precision) {
	slope = get_value(precision) / calibration_weight; // get_value() = read_average() - offset.
	set_scale(slope); // Calibreert de load cell op basis van de berekende factor.
	EEPROM.put(SLOPE_ADDRESS, slope); // Plaats de calibratiewaarde in het EEPROM voor later gebruik.
}