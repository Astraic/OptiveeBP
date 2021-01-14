package userclient.http;

import java.io.IOException;
import java.lang.reflect.Type;
import java.net.MalformedURLException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.UUID;

import org.json.simple.parser.ParseException;

import com.google.gson.JsonDeserializationContext;
import com.google.gson.JsonDeserializer;
import com.google.gson.JsonElement;
import com.google.gson.JsonParseException;
import com.google.gson.JsonPrimitive;
import com.google.gson.JsonSerializationContext;
import com.google.gson.JsonSerializer;

import userclient.model.Animal;
import userclient.model.Production;

public class ProductionClient extends HttpClient<Production>{

	public ProductionClient() {
		super(Production.class);
		builder.registerTypeAdapter(LocalDateTime.class, new JsonDeserializer<LocalDateTime>() {
			@Override
			public LocalDateTime deserialize(JsonElement json, Type typeOfT, JsonDeserializationContext context)
					throws JsonParseException {
				return LocalDateTime.parse(json.toString().replace("\"" , "").substring(0, 19), DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss"));
			}
		});
		
		builder.registerTypeAdapter(LocalDateTime.class, new JsonSerializer<LocalDateTime>() {

			@Override
			public JsonElement serialize(LocalDateTime src, Type typeOfSrc, JsonSerializationContext context) {
				return new JsonPrimitive(src.format(DateTimeFormatter.ISO_LOCAL_DATE_TIME));
			}
			
		});
		
		builder.registerTypeAdapter(Animal.class, new JsonDeserializer<Animal>() {
			@Override
			public Animal deserialize(JsonElement json, Type typeOfT, JsonDeserializationContext context)
					throws JsonParseException {
				Animal animal = new Animal();
				animal.setId(UUID.fromString(json.toString().replace("\"" , "")));
				return animal;
			}
		});
		
		builder.registerTypeAdapter(Animal.class, new JsonSerializer<Animal>() {

			@Override
			public JsonElement serialize(Animal src, Type typeOfSrc, JsonSerializationContext context) {
				return new JsonPrimitive(src.getId().toString());
			}
			
		});
		gson = builder.create(); 
	}
	
	public String getUpdateClause(Production model) {
		return null;
	}
	
	public ArrayList<Production> select(Animal animal){
		try {
			super.setupConnection(super.getBaseURL() + "?where=animal-eq-" + animal.getId());
			connection.connect();
			return super.bufferToModel(this.resultToBuffer(connection));
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

}