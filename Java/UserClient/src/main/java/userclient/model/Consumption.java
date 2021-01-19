/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.model;

import java.time.LocalDate;
import java.time.LocalTime;

/**
 *
 * @author Stephan de Jongh
 */
public class Consumption {
    
    private Animal animalId;
    private LocalDate date;
    private LocalTime time;
    private Feed feedId;
    private double portion;
    private double assigned;
    private double consumption;

    public Consumption() {
    }

    public Animal getAnimalId() {
        return animalId;
    }

    public void setAnimalId(Animal animalId) {
        this.animalId = animalId;
    }

    public LocalDate getDate() {
        return date;
    }

    public void setDate(LocalDate date) {
        this.date = date;
    }

    public LocalTime getTime() {
        return time;
    }

    public void setTime(LocalTime time) {
        this.time = time;
    }

    public Feed getFeedId() {
        return feedId;
    }

    public void setFeedId(Feed feedId) {
        this.feedId = feedId;
    }

    public double getPortion() {
        return portion;
    }

    public void setPortion(double portion) {
        this.portion = portion;
    }

    public double getAssigned() {
        return assigned;
    }

    public void setAssigned(double assigned) {
        this.assigned = assigned;
    }

    public double getConsumption() {
        return consumption;
    }

    public void setConsumption(double consumption) {
        this.consumption = consumption;
    }
}