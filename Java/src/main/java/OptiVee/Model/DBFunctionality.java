/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package OptiVee.Model;

import java.sql.Connection;
import java.sql.SQLException;
import java.util.ArrayList;
import javafx.collections.ObservableList;

/**
 * De klasse DBFunctionality representeert een abstracte entiteit waaruit DataBase functionaliteiten geprogrammeerd kunnen worden
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: DBFunctionality.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */
public abstract class DBFunctionality implements IDBFunctionality 
{
    protected Boolean dbResult = false; //Bewaar het resultaat van de meest recent uitgevoerde SQL-opdracht
    protected Connection dbConnection;
    protected ArrayList<String> dbStatements;
    protected String sqlLog;  

    @Override
    public abstract ObservableList getDataFromDB();
    
    @Override
    public abstract Boolean setDataToDB(int dmlType); //Parameter 'dmlType' geeft aan welk soort DML-statament uitgevoerd moet worden (0 = INSERT, 1 = UPDATE)

    @Override
    public boolean testDBConnection()
    {
        try
        {
            dbConnection = DBCPDataSource.getConnection();
            if(dbConnection.isValid(10))
                dbResult = true;
            else
                dbResult = false;            
        }
        catch(SQLException se)
        {
            System.out.println("SQL-error in DBFunctionaliteit.testDBConnection(): " + se.getMessage());
            dbResult = false;
        }
        finally
        {
            return dbResult;
        }
    }
}
