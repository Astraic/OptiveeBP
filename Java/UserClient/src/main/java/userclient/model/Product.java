package userclient.model;

public class Product {

	private String product;

	public String getProduct() {
		return this.product;
	}

	/**
	 * 
	 * @param product
	 */
	public void setProduct(String product) {
		this.product = product;
	}

	@Override
	public String toString() {
		return product;
	}
}