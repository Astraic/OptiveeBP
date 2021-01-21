/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.controller;

import java.time.LocalDate;
import java.util.ArrayList;
import java.util.NoSuchElementException;
import java.util.Objects;
import java.util.stream.Collectors;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.chart.LineChart;
import javafx.scene.chart.XYChart.Data;
import javafx.scene.chart.XYChart.Series;
import javafx.scene.control.Alert;
import javafx.scene.control.ButtonType;
import userclient.model.Animal;
import userclient.model.Consumption;
import userclient.model.Country;
import userclient.model.Distribution;
import userclient.model.Feed;
import userclient.model.Production;
import userclient.util.LabelBox;
import userclient.util.LabelField;

/**
 *
 * @author Stephan de Jongh
 */
public class FeedController extends SuperController {

    @FXML
    protected LineChart<String, Double> feedChart;
    @FXML
    protected LabelBox<Country> cbLand;
    @FXML
    protected LabelBox<Animal> cbDier;
    @FXML
    protected LabelBox<Feed> cbVoeding;
    @FXML
    protected LabelField tfPortiegroote, tfHoeveelheid;

    private final ArrayList<Animal> animals;
    private final ArrayList<Feed> feed;

    public FeedController() {
        animals = animalClient.select();
        feed = feedClient.select();
    }

    public void initialize() {
        cbVoeding.getCbLabelField().setItems(FXCollections.observableArrayList(feedClient.select()));
        cbLand.getCbLabelField().setItems(FXCollections.observableArrayList(countryClient.select()));
        cbLand.getCbLabelField().getSelectionModel().selectedItemProperty().addListener((observed, oldvalue, newvalue) -> {
            if (newvalue != null) {
                cbDier.getCbLabelField().getItems().clear();
                cbDier.getCbLabelField().setItems(FXCollections.observableArrayList(animals.stream().filter(p
                        -> p.getCountry().equalsIgnoreCase(newvalue.getCode())).collect(Collectors.toList())));
                cbDier.getCbLabelField().getSelectionModel().selectFirst();
            }
        });
    }

    @FXML
    private void select(ActionEvent event) {
        try {
            Animal a = Objects.requireNonNull(cbDier.getCbLabelField().getSelectionModel().getSelectedItem());
            ArrayList<Production> production = productionClient.selectMilkProduction(a);
            ArrayList<Consumption> consumption = consumptionClient.select(a);
            feedChart.setData(getData(production, consumption));
        } catch (NullPointerException e) {
            (new Alert(Alert.AlertType.ERROR, "Er is geen dier geselecteerd, gelieve een keuze te maken.")).show();
        } catch (NoSuchElementException e) {
            
        }
    }

    @FXML
    private void confirm(ActionEvent event) {
        try {
            Animal a = Objects.requireNonNull(cbDier.getCbLabelField().getSelectionModel().getSelectedItem());
            Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
                alert.setHeaderText(null);
                alert.setContentText("U staat op het punt bestaande gegevens bij te werken, weet u dit zeker?");
                if (alert.showAndWait().get() == ButtonType.OK) distributionClient.update(getUpdateModel(), getOldModel());
        } catch (NullPointerException e) {
            (new Alert(Alert.AlertType.ERROR, "Een of meerdere waarden zijn niet ingevoerd.")).show();
        } catch (NumberFormatException e) {
            (new Alert(Alert.AlertType.ERROR, "De ingevoerde hoeveelheid en/of portiegroote is geen correcte waarde.")).show();
        } catch (NoSuchElementException e) {
            Distribution d = getUpdateModel();
            d.setAnimalid(cbDier.getCbLabelField().getSelectionModel().getSelectedItem());
            distributionClient.insert(d);
        }
    }
    
    private ObservableList<Series<String, Double>> getData(ArrayList<Production> production, ArrayList<Consumption> consumption) {
        ObservableList<Series<String, Double>> data = FXCollections.observableArrayList();

        feed.forEach(f -> {
            Series<String, Double> series = new Series<>();
            series.setName(new StringBuilder("Voer: ").append(f.getName()).toString());
            consumption.stream().filter(p -> p.getFeedid().getId() == f.getId()).forEach(c -> {
                series.getData().add(new Data<>(c.getDate().toString(), c.getConsumption()));
            });
            if(!series.getData().isEmpty()) data.add(series);
        });
        
        Series<String, Double> series = new Series<>();
        production.stream().filter(p -> p.getProductiondatetime().toLocalDate().isAfter(LocalDate.now().minusMonths(1))).forEach(p -> {
            series.setName("Melkproductie");
            series.getData().add(new Data<>(p.getProductiondatetime().toLocalDate().toString(), (double) p.getProduction()));
            
        });
        if(!series.getData().isEmpty()) data.add(series);
        
        return data;
    }
    
    private Distribution getOldModel() throws NullPointerException, NoSuchElementException {
        Animal a = Objects.requireNonNull(cbDier.getCbLabelField().getSelectionModel().getSelectedItem());
        return distributionClient.select(a).stream().filter(p -> p.getAnimalid().getId().compareTo(a.getId()) == 0).findFirst().orElseThrow();
    }
    
    private Distribution getUpdateModel() throws NullPointerException, NumberFormatException {
        Distribution d = new Distribution();
        d.setFeedid(Objects.requireNonNull(cbVoeding.getCbLabelField().getSelectionModel().getSelectedItem()));
        d.setAssigned(Objects.requireNonNull(Double.parseDouble(tfHoeveelheid.getTfLabelField().getText())));
        d.setPortion(Objects.requireNonNull(Double.parseDouble(tfPortiegroote.getTfLabelField().getText())));
        return d;
    }
}