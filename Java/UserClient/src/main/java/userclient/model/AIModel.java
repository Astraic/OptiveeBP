package userclient.model;

import java.util.UUID;

public class AIModel {
	//Used C# naming conventions to prevent JSON Errors when interfacing with C# API
	protected String Id;
	protected String Reasonofdeath;
	protected String Passdate;
	protected Integer Feedid;
	protected String Portion;
	protected String Assigned;
	protected String Consumption;
	protected String Result;
	
	public String getResult() {
		return Result;
	}
	public void setResult(String result) {
		Result = result;
	}
	public String getId() {
		return Id;
	}
	public void setId(String id) {
		Id = id;
	}
	public String getReasonofdeath() {
		return Reasonofdeath;
	}
	public void setReasonofdeath(String reasonofdeath) {
		Reasonofdeath = reasonofdeath;
	}
	public String getPassdate() {
		return Passdate;
	}
	public void setPassdate(String passdate) {
		Passdate = passdate;
	}
	public Integer getFeedid() {
		return Feedid;
	}
	public void setFeedid(Integer feedid) {
		Feedid = feedid;
	}
	public String getPortion() {
		return Portion;
	}
	public void setPortion(String portion) {
		Portion = portion;
	}
	public String getAssigned() {
		return Assigned;
	}
	public void setAssigned(String assigned) {
		Assigned = assigned;
	}
	public String getConsumption() {
		return Consumption;
	}
	public void setConsumption(String consumption) {
		Consumption = consumption;
	}
	
	
}
