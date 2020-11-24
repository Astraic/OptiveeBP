/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package OptiVee.Model;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

/**
 * De klasse DBStable representeert een concrete entiteit waaruit DataBase activiteiten geprogrameerd kunnen worden voor het aanmaken en bijhouden van meerdere stallen, binnen de applicatie
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: DBStable.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */
public abstract class DBStable extends DBFunctionality
{
    private Stable currentStable;
    
    public ObservableList getDataFromDB()
    {
        return this.getStableDataFromDB();
    }
    
    private ObservableList getStableDataFromDB()
    {
        ObservableList<Stable> selectieLijst = FXCollections.observableArrayList();
        dbConnection = null;
        dbStatements.clear();
        
        try 
        {
            dbConnection = DBCPDataSource.getConnection();
            Statement stat = dbConnection.createStatement();
            ResultSet result = stat.executeQuery("SELECT * FROM Stal;");
            while(result.next())
            {	
                Stable selectedStable = new Stable();
                selectedStable.setStableID(result.getInt("stalID"));
                selectedStable.setName(result.getString("stalNaam"));
                selectedStable.setOwner(result.getString("eigenaar"));
                selectedStable.setSurface(result.getDouble("oppervlakte"));
                selectedStable.setStatus(result.getString("status"));
                selectedStable.setLiveStock_number_limit(result.getInt("vee_aantal_limiet"));
                selectedStable.setDescription(result.getString("Omschrijving"));             
                selectieLijst.add(selectedStable);
            }
        }
        catch(SQLException se) 
        {
            System.out.println("SQL-error in DBStable.getDataFromDB(): " + se.getMessage());
        }
        finally
        {
            try 
            {
                if(dbConnection != null)
                    dbConnection.close();
            }
            catch(SQLException se)
            {
                System.out.println("SQL-error in DBStable.getDataFromDB(): " + se.getMessage());
            }
        }
                
        return selectieLijst;
    }
    
    @Override
    public Boolean setDataToDB(int dmlType)
    {
        return this.setStableDataToDB(dmlType);
    }
    
    public void setStableRoom(Stable selectedStableRoom)
    {
        this.currentStable = selectedStableRoom;                
    }
    
    private Boolean setStableDataToDB(int dmlType)
    {
        dbResult = false;
        dbConnection = null;
        dbStatements.clear();
        Integer dbResultInt = 0;
        sqlLog = "\n";        
        
        if(this.currentStable != null)
        {
            try
            {
                dbConnection = DBCPDataSource.getConnection();
                Statement stat = dbConnection.createStatement();
                
                switch(dmlType)
                {
                    case 0:
                        dbStatements.add("INSERT INTO Stal VALUES ('" + currentStable.getOwner()+ "', '" + currentStable.getName()
                        + "'," + currentStable.getSurface() + ", '" + currentStable.getStatus() + "', " + currentStable.getLiveStock_number_limit()+ ", '" 
                        + currentStable.getDescription() + "');");
                        break;
                    case 1:
                        dbStatements.add("UPDATE Stal SET eigenaar = '" + currentStable.getOwner()+ "', stalNaam = '" + currentStable.getName()
                        + "', oppervlakte = " + currentStable.getSurface() + ", status ='" + currentStable.getStatus()+ "', vee_aantal_limiet = " + currentStable.getLiveStock_number_limit() + ", omschrijving ='" + currentStable.getDescription()
                        + " WHERE stalID =" + currentStable.getStableID() + ";");
                        break;
                }
                
                int i = 0; //rangtelnummer lusiteratie
                for(String sqlString : dbStatements)
                {                    
                    ++i;
                    dbResultInt = stat.executeUpdate(sqlString);
                    if(dbResultInt > 0)
                        sqlLog += "\nStatement " + i + " op tabel 'Stal' is succesvol uitgevoerd.";
                    else
                        sqlLog += "\nStatement " + i + " op tabel 'Stal' is mislukt!";                                        
                }
            }
            catch(SQLException se)
            {
                    System.out.println("SQL-error in DBStable.setDataToDB(): " + se.getMessage());
            }
            finally
            {
                try 
                {
                    if(dbConnection != null)
                        dbConnection.close();
                }
                catch(SQLException se)
                {                            
                    System.out.println("SQL-error in DBStable.setDataToDB(): " + se.getMessage());
                }
                finally
                {
                    System.out.println(sqlLog);
                    return dbResult;
                }
            }
        }
        else
            return dbResult;
    }
}
