/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.http;

import com.google.gson.JsonDeserializationContext;
import com.google.gson.JsonDeserializer;
import com.google.gson.JsonElement;
import com.google.gson.JsonPrimitive;
import com.google.gson.JsonSerializationContext;
import com.google.gson.JsonSerializer;
import java.lang.reflect.Type;
import java.time.LocalDate;
import java.time.LocalTime;
import java.time.format.DateTimeFormatter;
import java.util.UUID;
import userclient.model.Animal;
import userclient.model.Category;
import userclient.model.Fat;
import userclient.model.Meat;
import userclient.model.Quality;

/**
 *
 * @author Stephan de Jongh
 */
public class QualityClient extends HttpClient<Quality> {
    
    public QualityClient() {
        super(Quality.class);
        
        builder.registerTypeAdapter(Animal.class, (JsonDeserializer<Animal>) (JsonElement je, Type type, JsonDeserializationContext jdc) -> {
            Animal a = new Animal();
            a.setId(UUID.fromString(je.getAsString()));
            return a;
        });
        
        builder.registerTypeAdapter(Animal.class, (JsonSerializer<Animal>) (Animal t, Type type, JsonSerializationContext jsc) ->
                new JsonPrimitive(t.getId().toString()));
        
        builder.registerTypeAdapter(LocalDate.class, (JsonDeserializer<LocalDate>) (JsonElement je, Type type, JsonDeserializationContext jdc) -> 
                LocalDate.parse(je.getAsString()));
        
        builder.registerTypeAdapter(LocalDate.class, (JsonSerializer<LocalDate>) (LocalDate t, Type type, JsonSerializationContext jsc) -> 
                new JsonPrimitive(t.format(DateTimeFormatter.ISO_LOCAL_DATE)));
        
        builder.registerTypeAdapter(LocalTime.class, (JsonDeserializer<LocalTime>) (JsonElement je, Type type, JsonDeserializationContext jdc) -> 
                LocalTime.parse(je.getAsString()));
        
        builder.registerTypeAdapter(LocalTime.class, (JsonSerializer<LocalTime>) (LocalTime t, Type type, JsonSerializationContext jsc) -> 
                new JsonPrimitive(t.format(DateTimeFormatter.ISO_LOCAL_TIME)));
        
        builder.registerTypeAdapter(Category.class, (JsonDeserializer<Category>) (JsonElement je, Type type, JsonDeserializationContext jdc) -> {
            Category c = new Category();
            c.setName(je.getAsJsonPrimitive().getAsCharacter());
            return c;
        });
        
        builder.registerTypeAdapter(Category.class, (JsonSerializer<Category>) (Category t, Type type, JsonSerializationContext jsc) ->
                new JsonPrimitive(t.getName()));
        
        builder.registerTypeAdapter(Fat.class, (JsonDeserializer<Fat>) (JsonElement je, Type type, JsonDeserializationContext jdc) -> {
            Fat f = new Fat();
            f.setName(je.getAsJsonPrimitive().getAsCharacter());
            return f;
        });
        
        builder.registerTypeAdapter(Fat.class, (JsonSerializer<Fat>) (Fat t, Type type, JsonSerializationContext jsc) ->
                new JsonPrimitive(t.getName()));
        
        builder.registerTypeAdapter(Meat.class, (JsonDeserializer<Meat>) (JsonElement je, Type type, JsonDeserializationContext jdc) -> {
            Meat m = new Meat();
            m.setName(je.getAsJsonPrimitive().getAsCharacter());
            return m;
        });
        
        builder.registerTypeAdapter(Meat.class, (JsonSerializer<Meat>) (Meat t, Type type, JsonSerializationContext jsc) ->
                new JsonPrimitive(t.getName()));
        
        gson = builder.create();
    }

    @Override
    public String getUpdateClause(Quality model) {
        return new StringBuilder("animalid-eq-").append(model.getAnimalid().getId()).toString();
    }

    @Override
    protected Quality removeOverhead(Quality model) {
        return model;
    }
}