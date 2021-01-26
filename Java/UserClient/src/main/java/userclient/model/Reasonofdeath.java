package userclient.model;

public class Reasonofdeath {

	private String reasonofdeath;

	public String getReasonofdeath() {
		return this.reasonofdeath;
	}

	/**
	 * 
	 * @param reasonOfDeath
	 */
	public void setReasonofdeath(String reasonofdeath) {
		this.reasonofdeath = reasonofdeath;
	}
	
	@Override
	public String toString() {
		return reasonofdeath;
	}
}