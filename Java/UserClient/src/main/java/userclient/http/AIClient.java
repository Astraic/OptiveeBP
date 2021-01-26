package userclient.http;

import java.io.IOException;
import java.net.MalformedURLException;
import java.util.ArrayList;

import userclient.model.AIModel;

public class AIClient extends HttpClient<AIModel>{

	public AIClient() {
		super(AIModel.class);
		gson = builder.create(); 
	}
	
	public ArrayList<AIModel> select(AIModel model){
		try {
			super.setupConnection(this.getBaseURL() + "?json=" + gson.toJson(model));
			System.out.println(this.getBaseURL() + "?json=" + gson.toJson(model));
			connection.connect();
			AIModel result = new AIModel();
			//System.out.println(this.resultToBuffer(connection));
			System.out.println(connection.getResponseCode());
			result.setResult(this.resultToBuffer(connection));
			ArrayList<AIModel> resultList = new ArrayList<AIModel>();
			resultList.add(result);
			return resultList;
		} catch (MalformedURLException e) {
			e.printStackTrace();
			return null;
		} catch (IOException e) {
			e.printStackTrace();
			return null;
		} finally {
			connection.disconnect();
		}		
	}

	@Override
	public String getUpdateClause(AIModel model) {
		return "";
	}

	@Override
	protected AIModel removeOverhead(AIModel model) {
		return model;
	}
	
	protected String getBaseURL() {
		return "https://optiveeprodml.azurewebsites.net/api/production";
	}

}
