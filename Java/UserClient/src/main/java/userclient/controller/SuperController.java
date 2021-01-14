package userclient.controller;

import userclient.http.AnimalClient;
import userclient.http.CountryClient;
import userclient.http.ProductClient;
import userclient.http.ProductionClient;
import userclient.http.ReasonofdeathClient;

public abstract class SuperController {
	
	protected AnimalClient animalClient;
	protected ProductionClient productionClient;
	protected CountryClient countryClient;
	protected ProductClient productClient;
	protected ReasonofdeathClient reasonofdeathClient;
	
	public SuperController() {
		animalClient = new AnimalClient();
		countryClient = new CountryClient();
		productClient = new ProductClient();
		reasonofdeathClient = new ReasonofdeathClient();
		productionClient = new ProductionClient();
	}
}
