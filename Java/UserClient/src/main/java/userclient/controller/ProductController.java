package userclient.controller;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import userclient.http.AnimalClient;
import userclient.http.CountryClient;
import userclient.http.ProductClient;
import userclient.http.ReasonofdeathClient;
import userclient.model.Product;
import userclient.util.LabelBox;
import userclient.util.LabelField;

public class ProductController extends SuperController{
	@FXML
	protected LabelBox<Product> cbProductExist;
	@FXML
	protected LabelField tfProduct;
	@FXML
	protected Button tfButton;
	
	public void initialize() {
		reloadData();
		
		cbProductExist.getCbLabelField().setOnAction(new EventHandler<ActionEvent>() {

			@Override
			public void handle(ActionEvent event) {
				switchButton();				
			}
		});
		
		tfButton.setOnAction(new EventHandler<ActionEvent>() {

			@Override
			public void handle(ActionEvent event) {
				executeButton();				
			}
		});
	}
	
	public void switchButton() {
		if(cbProductExist.getCbLabelField().getSelectionModel().getSelectedIndex() == 0) {
			tfButton.setText("Toevoegen");
		}else {
			tfButton.setText("Aanpassen");
		}
	}
	
	public void executeButton() {
		Product product = new Product();
		product.setProduct(tfProduct.getTfLabelField().getText());
		if(cbProductExist.getCbLabelField().getSelectionModel().getSelectedIndex() == 0){
			productClient.insert(product);
		}else {
			Product old = cbProductExist.getCbLabelField().getSelectionModel().getSelectedItem();
			productClient.update(product, old);
		}
		
		reloadData();

	}
	
	public void reloadData() {
		Product emptyProduct = new Product();
		emptyProduct.setProduct("(Nieuw)");
		ObservableList<Product> data = FXCollections.observableArrayList(productClient.select());
		data.add(0, emptyProduct);
		cbProductExist.getCbLabelField().setItems(data);
		tfProduct.getTfLabelField().setText("");
		cbProductExist.getCbLabelField().getSelectionModel().select(0);
		tfButton.setText("Toevoegen");
	}
}
