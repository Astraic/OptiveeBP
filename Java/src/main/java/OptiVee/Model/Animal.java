/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package BP56_OptiVee.Model;

import java.time.LocalDate;
import java.util.UUID;

/**
 * De Klasse Animal representeert een concrete entiteit waaruit meerdere dieren (vee) aangemaakt en bijgehouden kunnen worden, binnen de applicatie
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: Animal.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */
public class Animal 
{
    private UUID animalID;
    private String nfcTag, product, environment, reasonOfDeath, countryCode;
    private LocalDate passDate;
    private Integer workNumber, serialNumber, controlNumber, stableRoomID;

    public UUID getAnimalID() {
        return animalID;
    }

    public void setAnimalID(UUID animalID) {
        this.animalID = animalID;
    }

    public String getNfcTag() {
        return nfcTag;
    }

    public void setNfcTag(String nfcTag) {
        this.nfcTag = nfcTag;
    }

    public String getProduct() {
        return product;
    }

    public void setProduct(String product) {
        this.product = product;
    }

    public String getEnvironment() {
        return environment;
    }

    public void setEnvironment(String environment) {
        this.environment = environment;
    }

    public String getReasonOfDeath() {
        return reasonOfDeath;
    }

    public void setReasonOfDeath(String reasonOfDeath) {
        this.reasonOfDeath = reasonOfDeath;
    }

    public String getCountryCode() {
        return countryCode;
    }

    public void setCountryCode(String countryCode) {
        this.countryCode = countryCode;
    }

    public LocalDate getPassDate() {
        return passDate;
    }

    public void setPassDate(LocalDate passDate) {
        this.passDate = passDate;
    }

    public Integer getWorkNumber() {
        return workNumber;
    }

    public void setWorkNumber(Integer workNumber) {
        this.workNumber = workNumber;
    }

    public Integer getSerialNumber() {
        return serialNumber;
    }

    public void setSerialNumber(Integer serialNumber) {
        this.serialNumber = serialNumber;
    }

    public Integer getControlNumber() {
        return controlNumber;
    }

    public void setControlNumber(Integer controlNumber) {
        this.controlNumber = controlNumber;
    }

    public Integer getStableRoomID() {
        return stableRoomID;
    }

    public void setStableRoomID(Integer stableRoomID) {
        this.stableRoomID = stableRoomID;
    }
    public Animal() {};
}
