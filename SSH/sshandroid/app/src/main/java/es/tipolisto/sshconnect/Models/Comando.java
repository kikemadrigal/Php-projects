package es.tipolisto.sshconnect.Models;

public class Comando {
    private int id;
    private String nombre;
    private String datos;

    public Comando(int id, String nombre, String datos) {
        this.id = id;
        this.nombre = nombre;
        this.datos = datos;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
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

    @Override
    public String toString() {
        return "Comando{" +
                "id=" + id +
                ", nombre='" + nombre + '\'' +
                ", datos='" + datos + '\'' +
                '}';
    }
}
