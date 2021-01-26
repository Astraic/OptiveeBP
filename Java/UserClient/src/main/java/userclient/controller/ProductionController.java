package userclient.controller;

import java.time.format.DateTimeFormatter;
import java.util.ArrayList;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.scene.chart.LineChart;
import javafx.scene.chart.XYChart.Data;
import javafx.scene.chart.XYChart.Series;
import userclient.model.AIModel;
import userclient.model.Animal;
import userclient.model.Product;
import userclient.model.Production;
import userclient.util.LabelBox;
import userclient.util.LabelField;

public class ProductionController extends SuperController {
	
	@FXML
	protected LabelBox<Animal> cbAnimal;
	
	@FXML 
	protected LabelField tfPrediction;
	
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
		AIModel model = new AIModel();
		model.setId(cbAnimal.getCbLabelField().getSelectionModel().getSelectedItem().getId().toString());
		model.setPassdate(cbAnimal.getCbLabelField().getSelectionModel().getSelectedItem().getPassdate().format(DateTimeFormatter.BASIC_ISO_DATE));
		model.setPortion("77");
		model.setFeedid(3);
		model.setConsumption("67");
		model.setAssigned("88");

		ArrayList<AIModel> prediction = aiClient.select(model);
		System.out.println(prediction.get(0).getResult());
		tfPrediction.getTfLabelField().setText(prediction.get(0).getResult());
	}
	
}
