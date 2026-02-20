package es.tipolisto.sshconnect.Models;

import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.database.sqlite.SQLiteStatement;
import android.util.Log;

import java.util.ArrayList;

public class Sqlite extends SQLiteOpenHelper {
    private static final String DATABASENAME="conexion.db";
    private static final int DATABASEVERSION=2;
    private SQLiteDatabase sqLiteDatabase;
    // String sql5="Select e.id,e.numero,e.nombre,v.matricula,g.nombre,e.observaciones from empleados e INNER JOIN grupos g ON e.grupo=g.id INNER JOIN vehiculos v ON e.matricula=v.id";
    //int id, String alias, String usuario, String password, String host, int puerto
    private static final String createTableConexion="CREATE TABLE conexiones (id INTEGER PRIMARY KEY AUTOINCREMENT, alias TEXT, usuario TEXT, password TEXT, host TEXT, mac TEXT, puerto INTEGER)";
    private static final String insertTablaConexion1="INSERT INTO conexiones (alias, usuario, password, host, mac, puerto) VALUES ('Conexion 2 prueba','enrique','4143','localhost','Sin mac',22)";
    private static final String insertTablaConexion2="INSERT INTO conexiones (alias, usuario, password, host, mac, puerto) VALUES ('Conexion 1 prueba','enrique','4143','10.20.4.7','Sin mac',22)";
    private static final String insertTablaConexion3="INSERT INTO conexiones (alias, usuario, password, host, mac, puerto) VALUES ('Conexion 3 prueba','enrique','4143','127.0.0.1','Sin mac',22)";

    private static final String borrarTablaConexiones="DROP TABLE conexiones";

    //public Sqlite(Context context, String name, SQLiteDatabase.CursorFactory factory, int version) {
    public Sqlite(Context context) {
        //super(context, name, factory, version);
        super(context, DATABASENAME,null, DATABASEVERSION);
        sqLiteDatabase=getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(createTableConexion);
        //db.execSQL(insertTablaConexion1);
        //db.execSQL(insertTablaConexion2);
        //db.execSQL(insertTablaConexion3);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        if(newVersion>oldVersion){
            db.execSQL(borrarTablaConexiones);
            db.execSQL(createTableConexion);
            //db.execSQL(insertTablaConexion1);
            //db.execSQL(insertTablaConexion2);
            //db.execSQL(insertTablaConexion3);
        }
    }


    @Override
    public synchronized void close() {
        super.close();
        sqLiteDatabase.close();
    }

    public ArrayList<Conexion> selectTodosLasConexiones(){
        ArrayList<Conexion> conexiones=new ArrayList<>();
        Cursor cursor=sqLiteDatabase.rawQuery("SELECT * from conexiones", null);
        if(cursor.moveToFirst()){
            do{
                Conexion conexion=new Conexion(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getString(3), cursor.getString(4), cursor.getString(5),cursor.getInt(6));
                conexiones.add(conexion);
            }while(cursor.moveToNext());
        }
        cursor.close();
        return conexiones;
    }

    public Conexion selectUnaConexion(int id){
        //int id, String alias, String usuario, String password, String host, int puerto
        Conexion conexion=null;
        String alias, usuario, password,mac, host="";
        int puerto=0;
        Cursor cursor=sqLiteDatabase.rawQuery("SELECT * FROM conexiones WHERE id='"+id+"'", null);
        if(cursor.moveToFirst()){
            do{
                alias=cursor.getString(1);
                usuario=cursor.getString(2);
                password=cursor.getString(3);
                host=cursor.getString(4);
                mac=cursor.getString(5);
                puerto=cursor.getInt(6);

                conexion=new Conexion(id, alias, usuario,password,host,mac,puerto);
            }while (cursor.moveToNext());

        }
        cursor.close();
        return conexion;
    }


    public long insertarConewxion(String alias, String usuario, String password, String host,String mac, int puerto){
        long ultimoRegistroInsertado=0;
         String sql="INSERT INTO conexiones (alias,usuario, password, host,mac,puerto) VALUES (?,?,?,?,?,?)";
        SQLiteStatement sqLiteStatement=sqLiteDatabase.compileStatement(sql);
        sqLiteStatement.bindString(1,alias);
        sqLiteStatement.bindString(2,usuario);
        sqLiteStatement.bindString(3,password);
        sqLiteStatement.bindString(4,host);
        sqLiteStatement.bindString(5,mac);
        sqLiteStatement.bindLong(6,puerto);

        ultimoRegistroInsertado=sqLiteStatement.executeInsert();
        return ultimoRegistroInsertado;
    }


    public void updateConexion(int id, String alias, String usuario, String password, String host,String mac, int puerto){
        String sql="UPDATE conexiones SET alias='"+alias+"',usuario='"+usuario+"',password='"+password+"',host='"+host+"',mac='"+mac+"',puerto='"+puerto+"' WHERE id='"+id+"' ";
        sqLiteDatabase.execSQL(sql);
    }

    public void deleteConexion(int id){
        String sql="DELETE FROM conexiones WHERE id='"+id+"'";
        sqLiteDatabase.execSQL(sql);
        Log.d("Mensaje","Se ha borrado el "+id);
    }

}
