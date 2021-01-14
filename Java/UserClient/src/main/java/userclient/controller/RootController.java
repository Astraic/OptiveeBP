package userclient.controller;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.ProgressIndicator;
import javafx.scene.layout.BorderPane;
import javafx.scene.layout.HBox;
import userclient.util.Loader;

public class RootController {
	
	@FXML
	private BorderPane root;
	
	@FXML
	private HBox header;
	@FXML
	private HBox footer;

	public RootController() {

	}
	
	public void initialize() {
		
	}
	
	@FXML
    private void handleButtonAction(ActionEvent event) {
		Button button = (Button) event.getSource();
		Loader loader = getCenterPane(button.getId());
		root.setCenter(loader.getView());
    }
	
	private Loader getCenterPane(String id) {
		switch(id) {
			case "btnAnimal":
				return new Loader("AnimalPane");
			case "btnProduction":
				return new Loader("ProductionPane");
			case "btnReasonofdeath":
				return new Loader("ReasonofdeathPane");
			case "btnCountry":
				return new Loader("CountryPane");
			case "btnProduct":
				return new Loader("ProductPane");
			default:
				return null;
	}
	}

}
