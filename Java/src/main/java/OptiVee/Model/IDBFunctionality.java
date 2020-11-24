package OptiVee.Model;

import javafx.collections.ObservableList;

/**
 * De klasse IDBFunctionality representeert een interface waarmee DataBase functionaliteiten aangemaakt kunnen worden
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: IDBFunctionality.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */

public interface IDBFunctionality 
{
    public abstract boolean testDBConnection(); 
    public abstract ObservableList getDataFromDB();
    public abstract Boolean setDataToDB(int dmlType); //Parameter 'dmlType' geeft aan welk soort DML-statament uitgevoerd moet worden (0 = INSERT, 1 = UPDATE)
}
