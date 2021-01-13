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
public class V_Distribution {
    
    private String nfc;
    private Feed feedId;
    private double portion;
    private double assigned;

    public V_Distribution() {
    }

    public String getNfc() {
        return nfc;
    }

    public void setNfc(String nfc) {
        this.nfc = nfc;
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
}