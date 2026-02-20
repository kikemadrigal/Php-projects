package es.tipolisto.sshconnect.Models;

public class Cliente {
    private int id;
    private String cif;
    private String nombre;
    private String datos;

    public Cliente(int id, String cif, String nombre, String datos) {
        this.id = id;
        this.cif = cif;
        this.nombre = nombre;
        this.datos = datos;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getCif() {
        return cif;
    }

    public void setCif(String cif) {
        this.cif = cif;
    }

    public String getNombre() {
        return nombre;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public String getDatos() {
        return datos;
    }

    public void setDatos(String datos) {
        this.datos = datos;
    }

    /*@Override
    public String toString() {
        return "Cliente{" +
                "id=" + id +
                ", cif='" + cif + '\'' +
                ", nombre='" + nombre + '\'' +
                ", datos='" + datos + '\'' +
                '}';
    }*/
    @Override
    public String toString() {
        return nombre;
    }
}
