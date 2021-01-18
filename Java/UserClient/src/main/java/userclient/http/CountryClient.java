package userclient.http;

import userclient.model.Country;

public class CountryClient extends HttpClient<Country>{

	public CountryClient() {
		super(Country.class);
		gson = builder.create();
	}

	@Override
	public String getUpdateClause(Country model) {
		return "country-eq-" + model.getCode();
	}

	@Override
	protected Country removeOverhead(Country model) {
		return model;
	}
	
	
}
