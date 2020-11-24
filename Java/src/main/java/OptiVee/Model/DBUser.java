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
 * De klasse DBUser representeert een concrete entiteit waaruit DataBase activiteiten geprogrameerd kunnen worden voor het aanmaken en bijhouden van meerdere applicatiegebruikers, binnen de applicatie
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: DBUser.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */
public abstract class DBUser extends DBFunctionality
{
    private User currentUser;
    
    public ObservableList getDataFromDB()
    {
        return this.getUserDataFromDB();
    }
    
    private ObservableList getUserDataFromDB()
    {
        ObservableList<User> selectieLijst = FXCollections.observableArrayList();
        dbConnection = null;
        dbStatements.clear();
        
        try 
        {
            dbConnection = DBCPDataSource.getConnection();
            Statement stat = dbConnection.createStatement();
            ResultSet result = stat.executeQuery("SELECT * FROM Gebruiker;");
            while(result.next())
            {	
                User selectedUser = new User();
                selectedUser.setUserID(result.getInt("gebruikerID"));
                selectedUser.setUserName(result.getString("gebruikersNaam"));
                selectedUser.setEmailAdress(result.getString("email"));            
                selectieLijst.add(selectedUser);
            }
        }
        catch(SQLException se) 
        {
            System.out.println("SQL-error in DBUser.getDataFromDB(): " + se.getMessage());
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
                System.out.println("SQL-error in DBUser.getDataFromDB(): " + se.getMessage());
            }
        }
                
        return selectieLijst;
    }
    
    @Override
    public Boolean setDataToDB(int dmlType)
    {
        return this.setUserDataToDB(dmlType);
    }
    
    public void setUser(User selectedUser)
    {
        this.currentUser = selectedUser;
    }
    
    private Boolean setUserDataToDB(int dmlType)
    {
        dbResult = false;
        dbConnection = null;
        dbStatements.clear();
        Integer dbResultInt = 0;
        sqlLog = "\n";        
        
        if(this.currentUser != null)
        {
            try
            {
                dbConnection = DBCPDataSource.getConnection();
                Statement stat = dbConnection.createStatement();
                
                switch(dmlType)
                {
                    case 0:
                        dbStatements.add("INSERT INTO Gebruiker VALUES ('" + currentUser.getUserName()+ "', '" + currentUser.getEmailAdress() + "','" + currentUser.getPassWord() + "');");
                        break;
                    case 1:
                        dbStatements.add("UPDATE Gebruiker SET gebruikersNaam = '" + currentUser.getUserName()+ "', email = '" + currentUser.getEmailAdress()
                        + "', wachtwoord = '" + currentUser.getPassWord()
                        + " WHERE gebruikerID =" + currentUser.getUserID() + ";");
                        break;
                }
                
                int i = 0; //rangtelnummer lusiteratie
                for(String sqlString : dbStatements)
                {                    
                    ++i;
                    dbResultInt = stat.executeUpdate(sqlString);
                    if(dbResultInt > 0)
                        sqlLog += "\nStatement " + i + " op tabel 'Gebruiker' is succesvol uitgevoerd.";
                    else
                        sqlLog += "\nStatement " + i + " op tabel 'Gebruiker' is mislukt!";                                        
                }
            }
            catch(SQLException se)
            {
                    System.out.println("SQL-error in DBUser.setDataToDB(): " + se.getMessage());
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
                    System.out.println("SQL-error in DBUser.setDataToDB(): " + se.getMessage());
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
