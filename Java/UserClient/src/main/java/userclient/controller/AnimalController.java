package userclient.controller;

import java.time.LocalDate;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.ButtonType;
import javafx.scene.control.TableView;
import javafx.scene.input.MouseEvent;
import userclient.model.Animal;
import userclient.model.Country;
import userclient.model.Product;
import userclient.model.Reasonofdeath;
import userclient.util.LabelBox;
import userclient.util.LabelField;

public class AnimalController extends SuperController{
	
	@FXML
	protected TableView<Animal> tvAnimal;
	
	@FXML
	protected LabelField tfNFC,
							tfSerial,
							tfWork,
							tfControl;

	@FXML
	protected LabelBox<Object> cbEnvironment;
	@FXML
	protected LabelBox<Country> cbCountry;
	@FXML
	protected LabelBox<Product> cbProduct;
	@FXML
	protected LabelBox<Reasonofdeath> cbReasonofdeath;
	@FXML
	protected Button btnAddAnimal;
	@FXML
	protected Button btnUpdateAnimal;
	
	public void initialize() {
		ObservableList<Animal> data = FXCollections.observableArrayList(animalClient.select());
		tvAnimal.setItems(data);
		
		ObservableList<Country> countries = FXCollections.observableArrayList(countryClient.select());
		
		cbCountry.getCbLabelField().setItems(countries);
		
		ObservableList<Product> products = FXCollections.observableArrayList(productClient.select());
		cbProduct.getCbLabelField().setItems(products);
		
		ObservableList<Reasonofdeath> reasonofdeath = FXCollections.observableArrayList(reasonofdeathClient.select());
		cbReasonofdeath.getCbLabelField().setItems(reasonofdeath);
		
		btnAddAnimal.setOnMouseClicked(new EventHandler<MouseEvent>() {
			@Override
			public void handle(MouseEvent event) {
				add();
			}
		});
		
		btnUpdateAnimal.setOnMouseClicked(new EventHandler<MouseEvent>() {
			@Override
			public void handle(MouseEvent event) {
				update();
			}
		});
	}
	
	public void add() {
		try {
			Animal animal = new Animal();
			animal.setNfc(tfNFC.getTfLabelField().getText());
			animal.setSerial(Integer.parseInt(tfSerial.getTfLabelField().getText()));
			animal.setWorking(Integer.parseInt(tfWork.getTfLabelField().getText()));
			animal.setControl(Integer.parseInt(tfControl.getTfLabelField().getText()));
			animal.setProduct(cbProduct.getCbLabelField().getSelectionModel().getSelectedItem().getProduct());
			animal.setCountry(cbCountry.getCbLabelField().getSelectionModel().getSelectedItem().getCode());
			animalClient.insert(animal);
			ObservableList<Animal> data = FXCollections.observableArrayList(animalClient.select());
			tvAnimal.setItems(data);
		}catch(NumberFormatException e) {
			(new Alert(AlertType.ERROR, "Een van de velden is niet ingevuld", ButtonType.OK)).show();
		}
	}
	
	public void update() {
		try {
			Animal animal = new Animal();
			animal.setPassdate(LocalDate.now());
			animal.setReasonofdeath(cbReasonofdeath.getCbLabelField().getSelectionModel().getSelectedItem().getReasonofdeath());

			animalClient.update(animal, tvAnimal.getSelectionModel().getSelectedItem());
			ObservableList<Animal> data = FXCollections.observableArrayList(animalClient.select());
			tvAnimal.setItems(data);
		}catch(NumberFormatException e) {
			(new Alert(AlertType.ERROR, "Een van de velden is niet ingevuld", ButtonType.OK)).show();
		}catch(NullPointerException e) {
			e.printStackTrace();
			(new Alert(AlertType.ERROR, "Klik een dier aan", ButtonType.OK)).show();
		}
	}
	
	
	
	
	
	

}
