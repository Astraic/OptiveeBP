/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package OptiVee.Model;

/**
 * De Klasse Shelter representeert een abstracte entiteit waaruit meerdere hokken en/of stallen aangemaakt en bijgehouden kunnen worden, binnen de applicatie
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: Shelter.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */

public abstract class Shelter 
{
    protected String name, owner, status, description;
    protected double surface;
    protected Integer liveStock_number_limit;
}
