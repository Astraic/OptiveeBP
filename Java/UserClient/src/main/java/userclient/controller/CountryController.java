//package userclient.controller;
//
//import javafx.collections.FXCollections;
//import javafx.collections.ObservableList;
//import javafx.event.ActionEvent;
//import javafx.event.EventHandler;
//import javafx.fxml.FXML;
//import javafx.scene.control.Button;
//import userclient.model.Country;
//import userclient.model.Product;
//import userclient.util.LabelBox;
//import userclient.util.LabelField;
//
//public class CountryController extends SuperController{
//	@FXML
//	protected LabelBox<Country> cbCountryExist;
//	@FXML
//	protected LabelField tfCountrycode, tfCountryname;
//	@FXML
//	protected Button tfButton;
//	
//	public void initialize() {
//		reloadData();
//		
//		cbCountryExist.getCbLabelField().setOnAction(new EventHandler<ActionEvent>() {
//
//			@Override
//			public void handle(ActionEvent event) {
//				switchButton();				
//			}
//		});
//		
//		tfButton.setOnAction(new EventHandler<ActionEvent>() {
//
//			@Override
//			public void handle(ActionEvent event) {
//				executeButton();				
//			}
//		});
//	}
//	
//	public void switchButton() {
//		if(cbCountryExist.getCbLabelField().getSelectionModel().getSelectedIndex() == 0) {
//			tfButton.setText("Toevoegen");
//		}else {
//			tfButton.setText("Aanpassen");
//		}
//	}
//	
//	public void executeButton() {
//		Country country = new Country();
//		country.setName(tfCountryname.getTfLabelField().getText());
//		country.setCode(tfCountrycode.getTfLabelField().getText());
//		if(cbCountryExist.getCbLabelField().getSelectionModel().getSelectedIndex() == 0){
//			countryClient.insert(country);
//		}else {
//			Product old = cbCountryExist.getCbLabelField().getSelectionModel().getSelectedItem();
//			countryClient.update(country, old);
//		}
//		
//		reloadData();
//
//	}
//	
//	public void reloadData() {
//		Country empty = new Country();
//		empty.setCode("Nieuw");
//		ObservableList<Country> data = FXCollections.observableArrayList(countryClient.select());
//		data.add(0, empty);
//		cbCountryExist.getCbLabelField().setItems(data);
//		tfCountrycode.getTfLabelField().setText("");
//		tfCountryname.getTfLabelField().setText("");
//		cbCountryExist.getCbLabelField().getSelectionModel().select(0);
//		tfButton.setText("Toevoegen");
//	}
//}
