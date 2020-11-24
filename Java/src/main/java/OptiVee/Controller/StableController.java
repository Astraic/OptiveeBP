/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package OptiVee.Controller;

/**
 * De klasse StableController representeert een concrete entiteit waarmee DataBase functionaliteiten op een of meerdere stallen uitgevoerd kan worden, binnen de applicatie
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: StableController.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */
public class StableController 
{
   //Er mag slechts 1 instantie(exemplaar) bestaan uit deze klasse, binnen de gehele applicatie
    private static StableController instance = new StableController();
    
    private StableController() {};
    //Via deze methode kan het exemplaar van deze klasse opgehaald worden
    protected static StableController getInstance()
    {
        return instance;
    } 
}
