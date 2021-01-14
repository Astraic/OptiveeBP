package userclient.controller;

import java.util.ArrayList;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.scene.chart.LineChart;
import javafx.scene.chart.XYChart.Data;
import javafx.scene.chart.XYChart.Series;
import userclient.http.AnimalClient;
import userclient.http.CountryClient;
import userclient.http.ProductClient;
import userclient.http.ProductionClient;
import userclient.http.ReasonofdeathClient;
import userclient.model.Animal;
import userclient.model.Product;
import userclient.model.Production;
import userclient.util.LabelBox;

public class ProductionController extends SuperController {
	
	@FXML
	protected LabelBox<Animal> cbAnimal;
	
	@FXML
	protected LineChart<Integer, Integer> chartProduction;

	
	public void initialize() {
		ObservableList<Animal> animals = FXCollections.observableArrayList(animalClient.select());
		cbAnimal.getCbLabelField().setItems(animals);
		
		cbAnimal.getCbLabelField().setOnAction(new EventHandler<ActionEvent>() {

			@Override
			public void handle(ActionEvent event) {
				handleAnimalSelect();				
			}
			
		});
	}
	
	public void handleAnimalSelect() {
		ArrayList<Production> production = productionClient.select(cbAnimal.getCbLabelField().getSelectionModel().getSelectedItem());
		ArrayList<Product> products = productClient.select();
		ObservableList<Series<Integer, Integer>> data = FXCollections.observableArrayList();
		for(Product product : products) {
			Series<Integer, Integer> series = new Series<>();
			series.setName(product.getProduct());
			data.add(series);			
		}
		for(Production productionRecord : production) {
			for(Series<Integer, Integer> series : data) {
				if(productionRecord.getProduct().equals(series.getName())) {
					series.getData().add(new Data<Integer, Integer>(productionRecord.getProductiondatetime().getDayOfMonth(), productionRecord.getProduction()));
				}
			}
			
			
		}
		chartProduction.setData(data);
	}
	
}
