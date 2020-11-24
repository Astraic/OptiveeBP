/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package OptiVee.Model;

/**
 * De klasse Stable representeert een concrete entiteit waaruit meerdere stallen aangemaakt en bijgehouden kunnen worden, binnen de applicatie
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: Stable.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */
public class Stable extends Shelter
{
    private Integer stableID;
    
    public Integer getStableID() {
        return stableID;
    }

    public void setStableID(Integer stableID) {
        this.stableID = stableID;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getOwner() {
        return owner;
    }

    public void setOwner(String owner) {
        this.owner = owner;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public double getSurface() {
        return surface;
    }

    public void setSurface(double surface) {
        this.surface = surface;
    }

    public Integer getLiveStock_number_limit() {
        return liveStock_number_limit;
    }

    public void setLiveStock_number_limit(Integer liveStock_number_limit) {
        this.liveStock_number_limit = liveStock_number_limit;
    }
    public Stable() {};
}
