/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.model;

/**
 *
 * @author Stephan de Jongh
 */
public class Distribution {
    
    private Animal animalid;
    private Feed feedid;
    private double portion;
    private double assigned;

    public Distribution() {
    }

    public Animal getAnimalid() {
        return animalid;
    }

    public void setAnimalid(Animal animalid) {
        this.animalid = animalid;
    }

    public Feed getFeedid() {
        return feedid;
    }

    public void setFeedid(Feed feedid) {
        this.feedid = feedid;
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
}