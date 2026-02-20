package es.tipolisto.sshconnect.Models;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

public class Conexion {
    private int id;
    private String alias;
    private String usuario;
    private String password;
    private String host;
    private String mac;
    private int puerto;
    private boolean estado;
    private String tipo;
    private Date fechaUltimaConexion;

    public Conexion(int id, String alias, String usuario, String password, String host,String mac, int puerto) {
        this.id = id;
        this.alias = alias;
        this.usuario = usuario;
        this.password = password;
        this.host = host;
        this.mac=mac;
        this.puerto = puerto;
        this.estado = false;
        this.tipo = "ssh";
        // La cadena de formato de fecha se pasa como un argumento al objeto simpleDateFormat que devulve un date
        //SimpleDateFormat simpleDateFormat = new SimpleDateFormat("dd-MMM-aaaa a hh: mm: ss");
        SimpleDateFormat simpleDateFormat = new SimpleDateFormat("dd-MMM-aaaa");
        try {
            this.fechaUltimaConexion = simpleDateFormat.parse("01/01/2019");
        } catch (ParseException e) {
            e.printStackTrace();
        }
    }


    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getAlias() {
        return alias;
    }

    public void setAlias(String alias) {
        this.alias = alias;
    }

    public String getUsuario() {
        return usuario;
    }

    public void setUsuario(String usuario) {
        this.usuario = usuario;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getHost() {
        return host;
    }


    public String getMac() {
        return mac;
    }

    public void setMac(String mac) {
        this.mac = mac;
    }

    public void setHost(String host) {
        this.host = host;
    }

    public int getPuerto() {
        return puerto;
    }

    public void setPuerto(int puerto) {
        this.puerto = puerto;
    }

    public boolean isEstado() {
        return estado;
    }

    public void setEstado(boolean estado) {
        this.estado = estado;
    }

    public String getTipo() {
        return tipo;
    }

    public void setTipo(String tipo) {
        this.tipo = tipo;
    }

    public Date getFechaUltimaConexion() {
        return fechaUltimaConexion;
    }

    public void setFechaUltimaConexion(Date fechaUltimaConexion) {
        this.fechaUltimaConexion = fechaUltimaConexion;
    }

    @Override
    public String toString() {
        return "Conexion{" +
                "id=" + id +
                ", alias='" + alias + '\'' +
                ", usuario='" + usuario + '\'' +
                ", password='" + password + '\'' +
                ", host='" + host + '\'' +
                ", mac='" + mac + '\'' +
                ", puerto=" + puerto +
                ", estado=" + estado +
                ", tipo='" + tipo + '\'' +
                ", fechaUltimaConexion=" + fechaUltimaConexion +
                '}';
    }
}
