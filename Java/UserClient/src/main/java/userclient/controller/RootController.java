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
        switch (id) {
            case "btnAnimal":
                return new Loader("AnimalPane");
            case "btnProduction":
                return new Loader("ProductionPane");
            case "btnReasonofdeath":
                return new Loader("ReasonofdeathPane");
            case "btnFeed":
                return new Loader("FeedPane");    
            case "btnButcher":
                return new Loader("ButcherPane");
            case "btnCountry":
                return new Loader("CountryPane");
            case "btnProduct":
                return new Loader("ProductPane");
            default:
                return null;
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