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
public class Quality {
    
    private Animal animalid;
    private LocalDate date;
    private LocalTime time;
    private Category catname;
    private Fat fatname;
    private Meat meatname;
    private double amount;

    public Quality() {
    }

    public Animal getAnimalid() {
        return animalid;
    }

    public void setAnimalid(Animal animalid) {
        this.animalid = animalid;
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

    public Category getCatname() {
        return catname;
    }

    public void setCatname(Category catname) {
        this.catname = catname;
    }

    public Fat getFatname() {
        return fatname;
    }

    public void setFatname(Fat fatname) {
        this.fatname = fatname;
    }

    public Meat getMeatname() {
        return meatname;
    }

    public void setMeatname(Meat meatname) {
        this.meatname = meatname;
    }

    public double getAmount() {
        return amount;
    }

    public void setAmount(double amount) {
        this.amount = amount;
    }
}