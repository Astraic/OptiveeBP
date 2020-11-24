/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package OptiVee.Model;

/**
 * De klasse StableRoom representeert een concrete entiteit waaruit meerdere hokken aangemaakt en bijgehouden kunnen worden, binnen de applicatie
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: StableRoom.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */
public class StableRoom extends Shelter
{
    private Integer stableRoomID, stableID, userID, countPresentLiveStock, floor;

    public Integer getStableRoomID() {
        return stableRoomID;
    }

    public void setStableRoomID(Integer stableRoomID) {
        this.stableRoomID = stableRoomID;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
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

    public Integer getCountPresentLiveStock() {
        return countPresentLiveStock;
    }

    public void setCountPresentLiveStock(Integer countPresentLiveStock) {
        this.countPresentLiveStock = countPresentLiveStock;
    }

    public Integer getFloor() {
        return floor;
    }

    public void setFloor(Integer floor) {
        this.floor = floor;
    }

    public Integer getStableID() {
        return stableID;
    }

    public void setStableID(Integer stableID) {
        this.stableID = stableID;
    }

    public Integer getUserID() {
        return userID;
    }

    public void setUserID(Integer userID) {
        this.userID = userID;
    }
    
    
    
    public StableRoom() {};
}
