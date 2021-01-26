package userclient.http;

import userclient.model.Product;

public class ProductClient extends HttpClient<Product> {

	public ProductClient() {
		super(Product.class);
		gson = builder.create();
	}

	@Override
	public String getUpdateClause(Product model) {
		return "product-eq-" + model.getProduct();
	}

	@Override
	protected Product removeOverhead(Product model) {
		return model;
	}
	
	

}
