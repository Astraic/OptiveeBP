package userclient.controller;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.layout.BorderPane;
import javafx.scene.layout.HBox;
import userclient.util.Loader;

public class RootController {
	
	@FXML
	private BorderPane root;
	
	@FXML
	private HBox header;
	private HBox footer;

	public RootController() {

	}
	
	public void initialize() {
		
	}
	
	@FXML
    private void handleButtonAction(ActionEvent event) {
		Button button = (Button) event.getSource();
		switch(button.getId()) {
			case "btnAnimal":
				Loader loader = new Loader("AnimalPane");
				root.setCenter(loader.getView());
				break;
			case "btnDayregister":
				break;
			case "btnFeed":
				break;
			case "btnProduction":
				break;
			case "btnLogistic":
				break;
			case "btnAdmin":
				break;
		}
    }

}
