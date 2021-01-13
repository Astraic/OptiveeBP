package userclient.controller;

import java.awt.Desktop;
import java.net.URI;
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
        Loader loader;
        switch (button.getId()) {
            case "btnAnimal":
                loader = new Loader("AnimalPane");
                root.setCenter(loader.getView());
                break;
            case "btnDayregister":
                break;
            case "btnFeed":
                loader = new Loader("FeedPane");
                root.setCenter(loader.getView());
                break;
            case "btnProduction":
                break;
            case "btnLogistic":
                break;
            case "btnAdmin":
                break;
        }
    }

    @FXML
    private void linkButtonAction(ActionEvent event) {
        Button button = (Button) event.getSource();
        try {
            URI uri = null;
            switch (button.getId()) {
                case "website":
                    uri = new URI("https://lmgtfy.app/?q=Website");
                    break;
                case "social1":
                    uri = new URI("https://lmgtfy.app/?q=Instagram");
                    break;
                case "social2":
                    uri = new URI("https://lmgtfy.app/?q=Twitter");
                    break;
                case "social3":
                    uri = new URI("https://lmgtfy.app/?q=Facebook");
                    break;
            }
            Desktop.getDesktop().browse(uri);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}