/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.controller;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.function.Predicate;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.chart.BarChart;
import javafx.scene.chart.XYChart.Data;
import javafx.scene.chart.XYChart.Series;
import userclient.model.Quality;

/**
 *
 * @author Stephan de Jongh
 */
public class ButcherController extends SuperController {
    
    @FXML
    protected BarChart<String, Double> barChartCategory, barChartMeat, barChartFat;
    
    private final ArrayList<Quality> dataset;
    
    public ButcherController() {
        dataset = qualityClient.select();
    }
    
    public void initialize() {
        barChartCategory.setData(getData(categoryClient.select()));
        barChartMeat.setData(getData(meatClient.select()));
        barChartFat.setData(getData(fatClient.select()));
    }

    @FXML
    private void selectAnimal(ActionEvent event){
        
    }
    
    @FXML
    private void confirmQuality (ActionEvent event){
        
    }  
           
    private ObservableList<Series<String, Double>> getData(ArrayList qualifiers) {
        ObservableList<Series<String, Double>> data = FXCollections.observableArrayList();
        Series<String, Double> series = new Series<>();
        
        data.add(series);
        
        qualifiers.forEach(q -> {
            double amount = dataset.stream().filter(hasQualifier(q)).mapToDouble(c -> c.getAmount()).sum();
            series.getData().add(new Data<>(q.toString(), amount));
        });
        
        return data;
    }
    
    private Predicate<Quality> hasQualifier(Object qualifier) {
        for(Method m : Quality.class.getMethods()) {
            if(qualifier.getClass().equals(m.getReturnType())){
                return p -> {
                    try {
                        return qualifier.toString().equalsIgnoreCase(m.invoke(p).toString());
                    } catch (IllegalAccessException | IllegalArgumentException | InvocationTargetException e) {

                    }
                    return false;
                };
            }
        }
        return null;
    }
}