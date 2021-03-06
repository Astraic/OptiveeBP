package userclient.http;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;

import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.ButtonType;

public abstract class HttpClient<T> {
	protected HttpURLConnection connection = null;
	protected GsonBuilder builder;
	protected Gson gson;
	protected Class<T> entity;
	protected JSONParser parser;
	
	protected HttpClient(Class<T> entity) {
		this.entity = entity;
		builder = new GsonBuilder(); 
		parser = new JSONParser();
	}
	
	public ArrayList<T> select() {
		try {
			this.setupConnection(getBaseURL());
			connection.connect();
			if(connection.getResponseCode() != 200) {
				(new Alert(AlertType.ERROR, "De server kan niet bereikt worden, probeer het later nog een keer", ButtonType.OK)).show();
				return new ArrayList<>();
			}
			return this.bufferToModel(this.resultToBuffer(connection));
			
		} catch (MalformedURLException e) {
			e.printStackTrace();
			return null;
		} catch (IOException e) {
			e.printStackTrace();
			return null;
		} catch (ParseException e) {
			e.printStackTrace();
			return null;
		} finally {
			connection.disconnect();
		}		
	}
	
	public void insert(T model) {
		try {
			this.setupConnection(getBaseURL() + "?json=[" + gson.toJson(model) + "]");
		    connection.connect();
		    if(connection.getResponseCode() == 400) {
		    	(new Alert(AlertType.ERROR, "De ingevoerde data is fout, probeer eens iets anders", ButtonType.OK)).show();
		    	return;
			}else if(connection.getResponseCode() == 200) {
				(new Alert(AlertType.INFORMATION, "Handeling is succesvol verwerkt", ButtonType.OK)).show();
				return;
			}else {
				(new Alert(AlertType.ERROR, "De server kan niet bereikt worden, probeer het later nog een keer", ButtonType.OK)).show();
				return;
			}
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	public void update(T model, T modelOld) {
		try {
			T overheadlessModel = this.removeOverhead(model);
			this.setupConnection(getBaseURL() + "?json=[" + gson.toJson(overheadlessModel) + "]" + "&where=" + getUpdateClause(modelOld));
		    connection.connect();
		    if(connection.getResponseCode() == 400) {
		    	(new Alert(AlertType.ERROR, "De ingevoerde data is fout, probeer eens iets anders", ButtonType.OK)).show();
			}else if(connection.getResponseCode() == 200) {
				(new Alert(AlertType.INFORMATION, "Handeling is succesvol verwerkt", ButtonType.OK)).show();
			}else {
				(new Alert(AlertType.ERROR, "De server kan niet bereikt worden, probeer het later nog een keer", ButtonType.OK)).show();
			}
		    System.out.println(connection.getResponseCode());
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	public abstract String getUpdateClause(T model);
	
	
	
	protected void setupConnection(String urlString) throws IOException {
		System.out.println(urlString);
		URL url = new URL(urlString);
		connection = (HttpURLConnection) url.openConnection();
	      
	    connection.setRequestMethod("GET");
	    connection.setDoOutput(true);
	    

	}
	
	protected String resultToBuffer(HttpURLConnection connection) throws IOException {
		BufferedReader reader = new BufferedReader(new InputStreamReader(connection.getInputStream()));
		String line;
		StringBuilder result = new StringBuilder();
		    
		while ((line = reader.readLine()) != null)
		{
			result.append(line + "\n");
		}
		   
		return result.toString();
	}
	
	protected ArrayList<T> bufferToModel(String json) throws ParseException {		
		ArrayList<T> results = new ArrayList<>();
		JSONArray array = (JSONArray) parser.parse(json);
		for(int i = 0; i < array.size(); i++) {
			JSONObject object = (JSONObject) array.get(i);
			results.add((T) gson.fromJson(object.toJSONString(), entity));
		}
		
		return results;
	}
	
	protected abstract T removeOverhead(T model);
	
	protected String getBaseURL() {
		return "https://optivee-api.azurewebsites.net/app/entity/api/" + entity.getSimpleName().toLowerCase() + ".php";
	}
}
