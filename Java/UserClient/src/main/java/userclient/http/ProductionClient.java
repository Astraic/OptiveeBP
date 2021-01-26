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
			ArrayList<Production> production = super.bufferToModel(this.resultToBuffer(connection));
			ArrayList<Production> newproduction = new ArrayList<>();
            LocalDateTime current =  LocalDateTime.now();
            System.out.println(current.getYear());
        	System.out.println(current.getMonthValue());
        	System.out.println(current.getYear());
        	System.out.println(current.getMonthValue());
        	
            for(Production product : production) {
            	if(product.getProductiondatetime().getYear() == 2020 && product.getProductiondatetime().getMonthValue() == 12) {
            		newproduction.add(product);
            	}
            }
            for(Production product : newproduction) {
            	System.out.println(product.getProduction());
            	System.out.println(product.getProduct());
            	System.out.println(product.getProductiondatetime());
            	System.out.println(product.getAnimal());
            }
            return newproduction;
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
        
    public ArrayList<Production> selectMilkProduction(Animal animal) {
        try {
            super.setupConnection(new StringBuilder(super.getBaseURL())
                    .append("?where=animal-eq-")
                    .append(animal.getId())
                    .append(".product-eq-Melk")
                    .toString());
            connection.connect();
            ArrayList<Production> production = super.bufferToModel(this.resultToBuffer(connection));
            LocalDateTime current =  LocalDateTime.now();
            System.out.println(current.getYear());
        	System.out.println(current.getMonthValue());
        	System.out.println(current.getYear());
        	System.out.println(current.getMonthValue());
            for(Production product : production) {
            	if(product.getProductiondatetime().getMonthValue() != current.getMonthValue() || product.getProductiondatetime().getYear() != current.getYear()) {
            		production.remove(product);
            	}
            }
            return production;
        } catch (MalformedURLException e) {
            return null;
        } catch (IOException | ParseException e) {
            return null;
        } finally {
            connection.disconnect();
        }
    }

	@Override
	protected Production removeOverhead(Production model) {
		return model;
	}

}