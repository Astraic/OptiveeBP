package userclient.controller;

import userclient.http.AnimalClient;
import userclient.http.CategoryClient;
import userclient.http.ConsumptionClient;
import userclient.http.CountryClient;
import userclient.http.DistributionClient;
import userclient.http.FatClient;
import userclient.http.FeedClient;
import userclient.http.MeatClient;
import userclient.http.ProductClient;
import userclient.http.ProductionClient;
import userclient.http.QualityClient;
import userclient.http.ReasonofdeathClient;

public abstract class SuperController {
	
	protected AnimalClient animalClient;
	protected ProductionClient productionClient;
	protected CountryClient countryClient;
	protected ProductClient productClient;
	protected ReasonofdeathClient reasonofdeathClient;
        protected CategoryClient categoryClient;
        protected ConsumptionClient consumptionClient;
        protected DistributionClient distributionClient;
        protected FatClient fatClient;
        protected FeedClient feedClient;
        protected MeatClient meatClient;
        protected QualityClient qualityClient;
	
	public SuperController() {
		animalClient = new AnimalClient();
		countryClient = new CountryClient();
		productClient = new ProductClient();
		reasonofdeathClient = new ReasonofdeathClient();
		productionClient = new ProductionClient();
                categoryClient = new CategoryClient();
                consumptionClient = new ConsumptionClient();
                distributionClient = new DistributionClient();
                fatClient = new FatClient();
                feedClient = new FeedClient();
                meatClient = new MeatClient();
                qualityClient = new QualityClient();
	}
}
