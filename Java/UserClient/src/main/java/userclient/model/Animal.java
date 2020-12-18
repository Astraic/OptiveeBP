package userclient.model;

import java.time.LocalDate;
import java.util.UUID;

public class Animal {

	private UUID id;
	private Product product;
	private String environment;
	private String nfc;
	private ReasonOfDeath reasonOfDeath;
	private Country country;
	private int serial;
	private int working;
	private int control;
	private LocalDate passdate;

	public UUID getId() {
		return this.id;
	}

	/**
	 * 
	 * @param id
	 */
	public void setId(UUID id) {
		this.id = id;
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

	public String getEnvironment() {
		return this.environment;
	}

	/**
	 * 
	 * @param environment
	 */
	public void setEnvironment(String environment) {
		this.environment = environment;
	}

	public String getNfc() {
		return this.nfc;
	}

	/**
	 * 
	 * @param nfc
	 */
	public void setNfc(String nfc) {
		this.nfc = nfc;
	}

	public ReasonOfDeath getReasonOfDeath() {
		return this.reasonOfDeath;
	}

	/**
	 * 
	 * @param reasonOfDeath
	 */
	public void setReasonOfDeath(ReasonOfDeath reasonOfDeath) {
		this.reasonOfDeath = reasonOfDeath;
	}

	public Country getCountry() {
		return this.country;
	}

	/**
	 * 
	 * @param country
	 */
	public void setCountry(Country country) {
		this.country = country;
	}

	public int getSerial() {
		return this.serial;
	}

	/**
	 * 
	 * @param serial
	 */
	public void setSerial(int serial) {
		this.serial = serial;
	}

	public int getWorking() {
		return this.working;
	}

	/**
	 * 
	 * @param working
	 */
	public void setWorking(int working) {
		this.working = working;
	}

	public int getControl() {
		return this.control;
	}

	/**
	 * 
	 * @param control
	 */
	public void setControl(int control) {
		this.control = control;
	}

	public LocalDate getPassdate() {
		return this.passdate;
	}

	/**
	 * 
	 * @param passdate
	 */
	public void setPassdate(LocalDate passdate) {
		this.passdate = passdate;
	}
}