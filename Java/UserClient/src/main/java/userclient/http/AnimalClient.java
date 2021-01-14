package userclient.http;

import java.lang.reflect.Type;
import java.time.LocalDate;
import java.time.format.DateTimeFormatter;

import com.google.gson.JsonDeserializationContext;
import com.google.gson.JsonDeserializer;
import com.google.gson.JsonElement;
import com.google.gson.JsonParseException;
import com.google.gson.JsonPrimitive;
import com.google.gson.JsonSerializationContext;
import com.google.gson.JsonSerializer;

import userclient.model.Animal;

public class AnimalClient extends HttpClient<Animal>{

	public AnimalClient() {
		super(Animal.class);
		builder.registerTypeAdapter(LocalDate.class, new JsonDeserializer<LocalDate>() {
			@Override
			public LocalDate deserialize(JsonElement json, Type typeOfT, JsonDeserializationContext context)
					throws JsonParseException {
				return LocalDate.parse(json.toString().replace("\"" , ""));
			}
		});
		
		builder.registerTypeAdapter(LocalDate.class, new JsonSerializer<LocalDate>() {

			@Override
			public JsonElement serialize(LocalDate src, Type typeOfSrc, JsonSerializationContext context) {
				return new JsonPrimitive(src.format(DateTimeFormatter.ISO_LOCAL_DATE));
			}
			
		});
		gson = builder.create(); 
	}
	
	public String getUpdateClause(Animal model) {
		return "id-eq-" + model.getId();
	}

}
