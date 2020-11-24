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
 * De klasse DBLiveStockRelation representeert een abstracte entiteit waaruit DataBase activiteiten geprogrameerd kunnen worden voor het aanmaken en bijhouden van meerdere veerelaties, binnen de applicatie
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: DBLiveStockRelation.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */
public abstract class DBLiveStockRelation extends DBFunctionality
{
    private LiveStockRelation currentLSRelation, newLSRelation;
    
    public ObservableList getDataFromDB()
    {
        return this.getLSRelationDataFromDB();
    }
    
    private ObservableList getLSRelationDataFromDB()
    {
        ObservableList<LiveStockRelation> selectieLijst = FXCollections.observableArrayList();
        dbConnection = null;
        dbStatements.clear();
        
        try 
        {
            dbConnection = DBCPDataSource.getConnection();
            Statement stat = dbConnection.createStatement();
            ResultSet result = stat.executeQuery("SELECT * FROM Vee-relatie;");
            while(result.next())
            {	
                LiveStockRelation selectedLSRelation = new LiveStockRelation();
                selectedLSRelation.setParentID(result.getInt("ouderID"));
                selectedLSRelation.setChildID(result.getInt("childID"));
                selectedLSRelation.setBirthDate_Parent(result.getString("geboorteDatum_Ouder"));
                selectedLSRelation.setBirthDate_Child(result.getString("geboorteDatum_Kind"));          
                selectieLijst.add(selectedLSRelation);
            }
        }
        catch(SQLException se) 
        {
            System.out.println("SQL-error in DBLiveStockRelation.getDataFromDB(): " + se.getMessage());
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
                System.out.println("SQL-error in DBDBLiveStockRelation.getDataFromDB(): " + se.getMessage());
            }
        }
                
        return selectieLijst;
    }
    
    @Override
    public Boolean setDataToDB(int dmlType)
    {
        return null;
    }
    
    private Boolean setLSRelationDataToDB(int dmlType)
    {
        dbResult = false;
        dbConnection = null;
        dbStatements.clear();
        Integer dbResultInt = 0;
        sqlLog = "\n";        
        
        if(this.currentLSRelation != null)
        {
            try
            {
                dbConnection = DBCPDataSource.getConnection();
                Statement stat = dbConnection.createStatement();
                
                switch(dmlType)
                {
                    case 0:
                        dbStatements.add("INSERT INTO Vee-relatie VALUES (" + newLSRelation.getParentID()+ ", " + newLSRelation.getChildID() + ",'" 
                        + newLSRelation.getBirthDate_Child() + "', '" + newLSRelation.getBirthDate_Parent() + "');");
                        break;
                    case 1:
                        dbStatements.add("UPDATE Vee-relatie SET ouderID = " + newLSRelation.getParentID()+ ", kindID = " + newLSRelation.getChildID()
                        + ", geboorteDatum_Kind = '" + newLSRelation.getBirthDate_Child() + "', geboorteDatum_Ouder = '" + newLSRelation.getBirthDate_Parent()
                        + "' WHERE ouderID =" + currentLSRelation.getParentID() + " AND kindID = " + currentLSRelation.getBirthDate_Child() + ";");
                        break;
                }
                
                int i = 0; //rangtelnummer lusiteratie
                for(String sqlString : dbStatements)
                {                    
                    ++i;
                    dbResultInt = stat.executeUpdate(sqlString);
                    if(dbResultInt > 0)
                        sqlLog += "\nStatement " + i + " op tabel 'Vee-relatie' is succesvol uitgevoerd.";
                    else
                        sqlLog += "\nStatement " + i + " op tabel 'Vee-relatie' is mislukt!";                                        
                }
            }
            catch(SQLException se)
            {
                    System.out.println("SQL-error in DBLiveStockRelation.setDataToDB(): " + se.getMessage());
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
                    System.out.println("SQL-error in DBLiveStockRelation.setDataToDB(): " + se.getMessage());
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
    
    public void setLSRelation(LiveStockRelation newLSRelation, LiveStockRelation selectedLSRelation)
    {
        this.currentLSRelation = selectedLSRelation;
        this.newLSRelation = newLSRelation;
    }
}
