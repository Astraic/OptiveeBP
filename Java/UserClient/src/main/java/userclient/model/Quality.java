/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.model;

import java.time.LocalDate;
import java.time.LocalTime;
import java.util.UUID;

/**
 *
 * @author Stephan de Jongh
 */
public class Quality {
    
    private UUID animalId;
    private LocalDate date;
    private LocalTime time;
    private Category catName;
    private Fat fatName;
    private Meat meatName;
    private double amount;

    public Quality() {
    }

    public UUID getAnimalId() {
        return animalId;
    }

    public void setAnimalId(UUID animalId) {
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

    public Category getCatName() {
        return catName;
    }

    public void setCatName(Category catName) {
        this.catName = catName;
    }

    public Fat getFatName() {
        return fatName;
    }

    public void setFatName(Fat fatName) {
        this.fatName = fatName;
    }

    public Meat getMeatName() {
        return meatName;
    }

    public void setMeatName(Meat meatName) {
        this.meatName = meatName;
    }

    public double getAmount() {
        return amount;
    }

    public void setAmount(double amount) {
        this.amount = amount;
    }
}