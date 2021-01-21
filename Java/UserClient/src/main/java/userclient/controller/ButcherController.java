/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.controller;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.time.LocalDate;
import java.time.LocalTime;
import java.util.ArrayList;
import java.util.NoSuchElementException;
import java.util.Objects;
import java.util.function.Predicate;
import java.util.stream.Collectors;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.chart.BarChart;
import javafx.scene.chart.XYChart.Data;
import javafx.scene.chart.XYChart.Series;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.ButtonType;
import userclient.model.Animal;
import userclient.model.Category;
import userclient.model.Country;
import userclient.model.Fat;
import userclient.model.Meat;
import userclient.model.Quality;
import userclient.util.LabelBox;
import userclient.util.LabelField;

/**
 *
 * @author Stephan de Jongh
 */
public class ButcherController extends SuperController {

    @FXML
    protected BarChart<String, Double> barChartCategory, barChartMeat, barChartFat;
    @FXML
    protected LabelBox<Country> cbLand;
    @FXML
    protected LabelBox<Animal> cbDier;
    @FXML
    protected LabelBox<Category> cbCategorie;
    @FXML
    protected LabelBox<Fat> cbVetheid;
    @FXML
    protected LabelBox<Meat> cbBevleesdheid;
    @FXML
    protected LabelField tfDatum, tfTijd, tfHoeveelheid;

    private ArrayList<Quality> dataset;
    private final ArrayList<Animal> animals;
    private final ArrayList<Category> categories;
    private final ArrayList<Meat> meat;
    private final ArrayList<Fat> fat;

    private boolean state;

    public ButcherController() {
        dataset = qualityClient.select();
        animals = animalClient.select();
        categories = categoryClient.select();
        meat = meatClient.select();
        fat = fatClient.select();
    }

    public void initialize() {
        barChartCategory.setData(getData(categories));
        barChartMeat.setData(getData(meat));
        barChartFat.setData(getData(fat));

        cbCategorie.getCbLabelField().setItems(FXCollections.observableArrayList(categories));
        cbVetheid.getCbLabelField().setItems(FXCollections.observableArrayList(fat));
        cbBevleesdheid.getCbLabelField().setItems(FXCollections.observableArrayList(meat));

        tfDatum.getTfLabelField().setEditable(false);
        tfTijd.getTfLabelField().setEditable(false);

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
            Quality q = getOldModel();

            tfDatum.getTfLabelField().setText(q.getDate().toString());
            tfTijd.getTfLabelField().setText(q.getTime().toString());
            tfHoeveelheid.getTfLabelField().setText(Double.toString(q.getAmount()));
            cbCategorie.getCbLabelField().getSelectionModel().select(q.getCatname());
            cbVetheid.getCbLabelField().getSelectionModel().select(q.getFatname());
            cbBevleesdheid.getCbLabelField().getSelectionModel().select(q.getMeatname());

            state = true;

        } catch (NullPointerException e) {
            (new Alert(AlertType.ERROR, "Er is geen dier geselecteerd, gelieve een keuze te maken.")).show();
        } catch (NoSuchElementException e) {
            tfDatum.getTfLabelField().setText(LocalDate.now().toString());
            tfTijd.getTfLabelField().setText(LocalTime.now().withNano(0).toString());
            tfHoeveelheid.getTfLabelField().clear();
            cbCategorie.getCbLabelField().getSelectionModel().select(null);
            cbVetheid.getCbLabelField().getSelectionModel().select(null);
            cbBevleesdheid.getCbLabelField().getSelectionModel().select(null);

            state = false;
        }
    }

    @FXML
    private void confirm(ActionEvent event) {
        try {
            if (state) {
                Alert a = new Alert(AlertType.CONFIRMATION);
                a.setHeaderText(null);
                a.setContentText("U staat op het punt bestaande gegevens bij te werken, weet u dit zeker?");
                if (a.showAndWait().get() == ButtonType.OK) {
                    qualityClient.update(getUpdateModel(), getOldModel());
                    a.setAlertType(AlertType.INFORMATION);
                    a.setContentText("Bewerking succesvol uitgevoerd.");
                    //a.show();
                }
            } else {
                qualityClient.insert(getInsertModel());
                dataset = qualityClient.select();
                Alert a = new Alert(AlertType.INFORMATION);
                a.setHeaderText(null);
                a.setContentText("Gegevens succesvol ingevoerd.");
                //a.show();
            }
        } catch (NullPointerException e) {
            (new Alert(AlertType.ERROR, "Een of meerdere waarden zijn niet ingevoerd.")).show();
        } catch (NumberFormatException e) {
            (new Alert(AlertType.ERROR, "De ingevoerde hoeveelheid is geen correcte waarde.")).show();
        } catch (NoSuchElementException e) {
            state = false;
            (new Alert(AlertType.ERROR, "Er is geen eerdere invoer voor dit dier gevonden.")).show();
        }
    }

    private Quality getOldModel() throws NullPointerException, NoSuchElementException {
        Animal a = Objects.requireNonNull(cbDier.getCbLabelField().getSelectionModel().getSelectedItem());
        return dataset.stream().filter(p -> p.getAnimalid().getId().compareTo(a.getId()) == 0).findFirst().orElseThrow();
    }

    private Quality getUpdateModel() throws NullPointerException, NumberFormatException {
        Quality q = new Quality();
        q.setAmount(Objects.requireNonNull(Double.parseDouble(tfHoeveelheid.getTfLabelField().getText())));
        q.setCatname(Objects.requireNonNull(cbCategorie.getCbLabelField().getSelectionModel().getSelectedItem()));
        q.setMeatname(Objects.requireNonNull(cbBevleesdheid.getCbLabelField().getSelectionModel().getSelectedItem()));
        q.setFatname(Objects.requireNonNull(cbVetheid.getCbLabelField().getSelectionModel().getSelectedItem()));
        return q;
    }

    private Quality getInsertModel() throws NullPointerException, NumberFormatException {
        Quality q = getUpdateModel();
        q.setAnimalid(Objects.requireNonNull(cbDier.getCbLabelField().getSelectionModel().getSelectedItem()));
        q.setDate(Objects.requireNonNull(LocalDate.parse(tfDatum.getTfLabelField().getText())));
        q.setTime(Objects.requireNonNull(LocalTime.parse(tfTijd.getTfLabelField().getText())));
        return q;
    }

    private Predicate<Quality> hasQualifier(Object qualifier) {
        for (Method m : Quality.class.getMethods()) {
            if (qualifier.getClass().equals(m.getReturnType())) {
                return p -> {
                    try {
                        return qualifier.toString().equalsIgnoreCase(m.invoke(p).toString());
                    } catch (IllegalAccessException | IllegalArgumentException | InvocationTargetException e) {

                    }
                    return false;
                };
            }
        }
        return null;
    }

    private ObservableList<Series<String, Double>> getData(ArrayList qualifiers) {
        ObservableList<Series<String, Double>> data = FXCollections.observableArrayList();
        Series<String, Double> series = new Series<>();

        data.add(series);

        qualifiers.forEach(q -> {
            double amount = dataset.stream().filter(hasQualifier(q)).mapToDouble(c -> c.getAmount()).sum();
            series.getData().add(new Data<>(q.toString(), amount));
        });

        return data;
    }
}