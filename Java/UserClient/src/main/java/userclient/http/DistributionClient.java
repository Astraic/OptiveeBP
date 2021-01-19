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
import java.util.UUID;
import userclient.model.Animal;
import userclient.model.Distribution;
import userclient.model.Feed;

/**
 *
 * @author Stephan de Jongh
 */
public class DistributionClient extends HttpClient<Distribution> {
    
    public DistributionClient() {
        super(Distribution.class);
        
        builder.registerTypeAdapter(Animal.class, (JsonDeserializer<Animal>) (JsonElement je, Type type, JsonDeserializationContext jdc) -> {
            Animal a = new Animal();
            a.setId(UUID.fromString(je.getAsJsonPrimitive().getAsString()));
            return a;
        });
        
        builder.registerTypeAdapter(Animal.class, (JsonSerializer<Animal>) (Animal t, Type type, JsonSerializationContext jsc) ->
                new JsonPrimitive(t.getId().toString()));
        
        builder.registerTypeAdapter(Feed.class, (JsonDeserializer<Feed>) (JsonElement je, Type type, JsonDeserializationContext jdc) -> {
            Feed f = new Feed();
            f.setId(je.getAsJsonPrimitive().getAsInt());
            return f;
        });
        
        builder.registerTypeAdapter(Feed.class, (JsonSerializer<Feed>) (Feed t, Type type, JsonSerializationContext jsc) ->
                new JsonPrimitive(t.getId()));
        
        gson = builder.create();
    }

    @Override
    public String getUpdateClause(Distribution model) {
        return new StringBuilder("animalid-eq-").append(model.getAnimalId()).toString();
    }
}