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
 * De klasse DBStableRoom representeert een concrete entiteit waaruit DataBase activiteiten geprogrameerd kunnen worden voor het aanmaken en bijhouden van meerdere hokken, binnen de applicatie
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: DBStableRoom.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */
public abstract class DBStableRoom extends DBFunctionality
{
    private StableRoom currentStableRoom;
    
    public ObservableList getDataFromDB()
    {
        return null;
    }
    
    private ObservableList getStableRoomDataFromDB()
    {
        ObservableList<StableRoom> selectieLijst = FXCollections.observableArrayList();
        dbConnection = null;
        dbStatements.clear();
        
        try 
        {
            dbConnection = DBCPDataSource.getConnection();
            Statement stat = dbConnection.createStatement();
            ResultSet result = stat.executeQuery("SELECT * FROM Hok;");
            while(result.next())
            {	
                StableRoom selectedStableRoom = new StableRoom();
                selectedStableRoom.setStableID(result.getInt("stalID"));
                selectedStableRoom.setStableRoomID(result.getInt("hokID"));
                selectedStableRoom.setName(result.getString("hokNaam"));
                selectedStableRoom.setCountPresentLiveStock(result.getInt("aantalAanwezigeDieren"));
                selectedStableRoom.setSurface(result.getDouble("oppervlakte"));
                selectedStableRoom.setStatus(result.getString("status"));
                selectedStableRoom.setLiveStock_number_limit(result.getInt("vee_aantal_limiet"));
                selectedStableRoom.setDescription(result.getString("Omschrijving"));
                selectedStableRoom.setFloor(result.getInt("verdieping"));
                selectieLijst.add(selectedStableRoom);
            }
        }
        catch(SQLException se) 
        {
            System.out.println("SQL-error in DBStableRoom.getDataFromDB(): " + se.getMessage());
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
                System.out.println("SQL-error in DBStableRoom.getDataFromDB(): " + se.getMessage());
            }
        }
                
        return selectieLijst;
    }
    
    @Override
    public Boolean setDataToDB(int dmlType)
    {
        return null;
    }
    
    private Boolean setStableRoomDataToDB(int dmlType)
    {
        dbResult = false;
        dbConnection = null;
        dbStatements.clear();
        Integer dbResultInt = 0;
        sqlLog = "\n";        
        
        if(this.currentStableRoom != null)
        {
            try
            {
                dbConnection = DBCPDataSource.getConnection();
                Statement stat = dbConnection.createStatement();
                
                switch(dmlType)
                {
                    case 0:
                        dbStatements.add("INSERT INTO Hok VALUES ('" + currentStableRoom.getName()+ "', " + currentStableRoom.getStableID()
                        + "," + currentStableRoom.getCountPresentLiveStock() + ", " + currentStableRoom.getLiveStock_number_limit() + ", " + currentStableRoom.getSurface() + ", "
                        + currentStableRoom.getFloor() + ", '" + currentStableRoom.getStatus() + "', '"
                        + currentStableRoom.getDescription() + "'," + currentStableRoom.getUserID() + ");");
                        break;
                    case 1:
                        dbStatements.add("UPDATE Hok SET hokNaam = '" + currentStableRoom.getName()+ "', stalID = " + currentStableRoom.getStableID()
                        + ", aantalAanwezigeDieren = " + currentStableRoom.getCountPresentLiveStock() + ", vee_aantal_limiet = " + currentStableRoom.getLiveStock_number_limit()+ ", oppervlakte = " + currentStableRoom.getSurface() + ", verdieping = " + currentStableRoom.getFloor()
                        + ", status = '" + currentStableRoom.getStatus() + "', omschrijving = '" + currentStableRoom.getDescription() + "', gebruikerID = " + currentStableRoom.getUserID()
                        + " WHERE hokID =" + currentStableRoom.getStableRoomID() + ";");
                        break;
                }
                
                int i = 0; //rangtelnummer lusiteratie
                for(String sqlString : dbStatements)
                {                    
                    ++i;
                    dbResultInt = stat.executeUpdate(sqlString);
                    if(dbResultInt > 0)
                        sqlLog += "\nStatement " + i + " op tabel 'Hok' is succesvol uitgevoerd.";
                    else
                        sqlLog += "\nStatement " + i + " op tabel 'Hok' is mislukt!";                                        
                }
            }
            catch(SQLException se)
            {
                    System.out.println("SQL-error in DBStableRoom.setDataToDB(): " + se.getMessage());
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
                    System.out.println("SQL-error in DBStableRoom.setDataToDB(): " + se.getMessage());
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
    
    public void setStableRoom(StableRoom selectedStableRoom)
    {
        this.currentStableRoom = selectedStableRoom;  
    }
}
