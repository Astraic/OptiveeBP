package userclient.model;

import java.time.LocalDate;
import java.util.UUID;

public class Animal {

	private UUID id;
	private String product;
	private String environment;
	private String nfc;
	private String reasonofdeath;
	private String country;
	private Integer serial;
	private Integer working;
	private Integer control;
	private LocalDate passdate;
	
	public UUID getId() {
		return id;
	}
	public void setId(UUID id) {
		this.id = id;
	}
	public String getProduct() {
		return product;
	}
	public void setProduct(String product) {
		this.product = product;
	}
	public String getEnvironment() {
		return environment;
	}
	public void setEnvironment(String environment) {
		this.environment = environment;
	}
	public String getNfc() {
		return nfc;
	}
	public void setNfc(String nfc) {
		this.nfc = nfc;
	}
	public String getReasonofdeath() {
		return reasonofdeath;
	}
	public void setReasonofdeath(String reasonofdeath) {
		this.reasonofdeath = reasonofdeath;
	}
	public String getCountry() {
		return country;
	}
	public void setCountry(String country) {
		this.country = country;
	}
	public int getSerial() {
		return serial;
	}
	public void setSerial(int serial) {
		this.serial = serial;
	}
	public int getWorking() {
		return working;
	}
	public void setWorking(int working) {
		this.working = working;
	}
	public int getControl() {
		return control;
	}
	public void setControl(int control) {
		this.control = control;
	}
	public LocalDate getPassdate() {
		return passdate;
	}
	public void setPassdate(LocalDate passdate) {
		this.passdate = passdate;
	}

	@Override
	public String toString() {
		return country + " " + serial + " " + working + " " + control;
	}
	
}