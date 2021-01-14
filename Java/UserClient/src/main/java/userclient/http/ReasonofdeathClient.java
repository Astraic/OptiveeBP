package userclient.http;

import userclient.model.Reasonofdeath;

public class ReasonofdeathClient extends HttpClient<Reasonofdeath> {

	public ReasonofdeathClient() {
		super(Reasonofdeath.class);
		gson = builder.create();
	}

	@Override
	public String getUpdateClause(Reasonofdeath model) {
		return "reasonofdeath-eq-" + model.getReasonofdeath();
	}
	
	

}
