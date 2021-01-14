package userclient.model;

public class Country {

	private String code;
	private String name;

	public String getCode() {
		return this.code;
	}

	/**
	 * 
	 * @param code
	 */
	public void setCode(String code) {
		this.code = code;
	}

	public String getName() {
		return this.name;
	}

	/**
	 * a
	 * @param name
	 */
	public void setName(String name) {
		this.name = name;
	}
	
	@Override
	public String toString() {
		return name + "(" + code + ")";
	}
}