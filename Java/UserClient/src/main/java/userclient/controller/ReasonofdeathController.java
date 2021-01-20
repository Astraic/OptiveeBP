package userclient.controller;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import userclient.model.Country;
import userclient.model.Reasonofdeath;
import userclient.util.LabelBox;
import userclient.util.LabelField;

public class ReasonofdeathController extends SuperController {
	@FXML
	protected LabelBox<Reasonofdeath> cbReasonofdeathExist;
	@FXML
	protected LabelField tfReasonofdeath;
	@FXML
	protected Button tfButton;
	
	public void initialize() {
		reloadData();
		
		cbReasonofdeathExist.getCbLabelField().setOnAction(new EventHandler<ActionEvent>() {

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
		if(cbReasonofdeathExist.getCbLabelField().getSelectionModel().getSelectedIndex() == 0) {
			tfButton.setText("Toevoegen");
		}else {
			tfButton.setText("Aanpassen");
		}
	}
	
	public void executeButton() {
		Reasonofdeath reasonofdeath = new Reasonofdeath();
		reasonofdeath.setReasonofdeath(tfReasonofdeath.getTfLabelField().getText());
		if(cbReasonofdeathExist.getCbLabelField().getSelectionModel().getSelectedIndex() == 0){
			reasonofdeathClient.insert(reasonofdeath);
		}else {
			Reasonofdeath old = cbReasonofdeathExist.getCbLabelField().getSelectionModel().getSelectedItem();
			reasonofdeathClient.update(reasonofdeath, old);
		}
		
		reloadData();
	}
	
	public void reloadData() {
		Reasonofdeath empty = new Reasonofdeath();
		empty.setReasonofdeath("(Nieuw)");
		ObservableList<Reasonofdeath> data = FXCollections.observableArrayList(reasonofdeathClient.select());
		data.add(0, empty);
		cbReasonofdeathExist.getCbLabelField().setItems(data);
		tfReasonofdeath.getTfLabelField().setText("");
		cbReasonofdeathExist.getCbLabelField().getSelectionModel().select(0);
		tfButton.setText("Toevoegen");
	}
}
