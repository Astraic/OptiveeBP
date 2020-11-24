package OptiVee.Model;

import java.sql.*;
import java.sql.SQLException;
import java.sql.Connection;
import org.apache.commons.dbcp2.BasicDataSource;

/**
 * De klasse DBCPDataSource representeert een entiteit waaruit DataBase verbindingen aangemaakt en onderhouden kunnen worden
 * <br>
 * <br>
 * Auteur: Adam Oubelkas
 * Aanmaakdatum: 30-09-2020
 * Project: Beroepsproduct 5 & 6 - OptiVee
 * Bestandsnaam: DBCPDataSource.java
 * @author Adam Oubelkas
 * @version 0.1
 * @since Aanmaakdatum: 30-09-2020
 */

public class DBCPDataSource 
{	
    private static Connection myConnection;
    
    private static BasicDataSource ds = new BasicDataSource();
    
    static
    {
        ds.setUrl("jdbc:mysql://localhost:3306/OptiVeeDB?useSSL=false");
        ds.setUsername("root");
        ds.setPassword("tre!h9587sty#e");
        ds.setMinIdle(5);
        ds.setMaxIdle(10);
        ds.setMaxOpenPreparedStatements(100);
    }
    
    public static Connection getConnection() throws SQLException
    {
        return ds.getConnection();
    }
	
    public DBCPDataSource()
    {

    }
}
