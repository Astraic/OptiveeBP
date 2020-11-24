/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package OptiVee.Model;

import java.time.LocalDate;

/**
 * De klasse LiveStockRelation representeert een concrete entiteit waaruit meerdere veerelaties aangemaakt en bijgehouden kunnen worden, binnen de applicatie
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: LiveStockRelation.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */
public class LiveStockRelation 
{
    private Integer parentID, childID;
    private String birthDate_Parent, birthDate_Child;

    public Integer getParentID() {
        return parentID;
    }

    public void setParentID(Integer parentID) {
        this.parentID = parentID;
    }

    public Integer getChildID() {
        return childID;
    }

    public void setChildID(Integer childID) {
        this.childID = childID;
    }

    public String getBirthDate_Parent() {
        return birthDate_Parent;
    }

    public void setBirthDate_Parent(String birthDate_Parent) {
        this.birthDate_Parent = birthDate_Parent;
    }

    public String getBirthDate_Child() {
        return birthDate_Child;
    }

    public void setBirthDate_Child(String birthDate_Child) {
        this.birthDate_Child = birthDate_Child;
    }
    
    public LiveStockRelation() {};
}
