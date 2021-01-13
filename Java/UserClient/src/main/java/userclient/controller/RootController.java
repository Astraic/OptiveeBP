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
                Loader loader = null;
		switch(button.getId()) {
			case "btnAnimal":
				loader = new Loader("AnimalPane");
				break;
			case "btnDayregister":
				break;
			case "btnFeed":
                                loader = new Loader("FeedPane");
				break;
			case "btnProduction":
				break;
			case "btnLogistic":
				break;
			case "btnAdmin":
				break;
		}
                root.setCenter(loader.getView()); 
    }

}
