package userclient.model;

import java.time.LocalDateTime;

public class Production {

	private Animal animal;
	private int production;
	private String product;
	private LocalDateTime productiondatetime;

	public Animal getAnimal() {
		return this.animal;
	}

	public int getProduction() {
		return production;
	}

	public void setProduction(int production) {
		this.production = production;
	}

	public String getProduct() {
		return product;
	}

	public void setProduct(String product) {
		this.product = product;
	}

	public LocalDateTime getProductiondatetime() {
		return productiondatetime;
	}

	public void setProductiondatetime(LocalDateTime productiondatetime) {
		this.productiondatetime = productiondatetime;
	}

	public void setAnimal(Animal animal) {
		this.animal = animal;
	}
}