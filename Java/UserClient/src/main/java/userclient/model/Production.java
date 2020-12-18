package userclient.model;

import java.time.LocalDateTime;

public class Production {

	private Animal animal;
	private int production;
	private Product product;
	private LocalDateTime productiondatetime;

	public Animal getAnimal() {
		return this.animal;
	}

	/**
	 * 
	 * @param animal
	 */
	public void setAnimal(Animal animal) {
		this.animal = animal;
	}

	public int getProduction() {
		return this.production;
	}

	/**
	 * 
	 * @param production
	 */
	public void setProduction(int production) {
		this.production = production;
	}

	public Product getProduct() {
		return this.product;
	}

	/**
	 * 
	 * @param product
	 */
	public void setProduct(Product product) {
		this.product = product;
	}

	public LocalDateTime getDate() {
		return this.productiondatetime;
	}

	/**
	 * 
	 * @param date
	 */
	public void setDate(LocalDateTime date) {
		this.productiondatetime = date;
	}
}