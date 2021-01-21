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
import java.io.IOException;
import java.lang.reflect.Type;
import java.net.MalformedURLException;
import java.time.LocalDate;
import java.time.LocalTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.UUID;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.json.simple.parser.ParseException;
import userclient.model.Animal;
import userclient.model.Consumption;
import userclient.model.Feed;

/**
 *
 * @author Stephan de Jongh
 */
public class ConsumptionClient extends HttpClient<Consumption> {
    
    public ConsumptionClient() {
        super(Consumption.class);
        
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
        
        builder.registerTypeAdapter(Feed.class, (JsonDeserializer<Feed>) (JsonElement je, Type type, JsonDeserializationContext jdc) -> {
            Feed f = new Feed();
            f.setId(je.getAsInt());
            return f;
        });
        
        builder.registerTypeAdapter(Feed.class, (JsonSerializer<Feed>) (Feed t, Type type, JsonSerializationContext jsc) ->
                new JsonPrimitive(t.getId()));

        gson = builder.create();
    }

    @Override
    public String getUpdateClause(Consumption model) {
        return new StringBuilder("animalid-eq-")
                .append(model.getAnimalid())
                .append(".date-eq-")
                .append(model.getDate())
                .append(".time-eq-")
                .append(model.getTime())
                .toString();
    }
    
    public ArrayList<Consumption> select(Animal animal) {
        try {
            super.setupConnection(new StringBuilder(super.getBaseURL())
                    .append("?where=animalid-eq-")
                    .append(animal.getId())
                    .append(".date-gr-")
                    .append(LocalDate.now().minusMonths(1))
                    .toString());
            connection.connect();
            return super.bufferToModel(this.resultToBuffer(connection));
        } catch (MalformedURLException e) {
            return null;
        } catch (IOException | ParseException e) {
            return null;
        } finally {
            connection.disconnect();
        }
    }

    @Override
    protected Consumption removeOverhead(Consumption model) {
        return model;
    }
}