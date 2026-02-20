package es.tipolisto.sshconnect.Models;

public class ClienteComando {
    private int id;
    private int idCliente;
    private int idComando;
    private String nombre;

    public ClienteComando(int id, int idCliente, int idComando, String nombre) {
        this.id = id;
        this.idCliente = idCliente;
        this.idComando = idComando;
        this.nombre = nombre;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getIdCliente() {
        return idCliente;
    }

    public void setIdCliente(int idCliente) {
        this.idCliente = idCliente;
    }

    public int getIdComando() {
        return idComando;
    }

    public void setIdComando(int idComando) {
        this.idComando = idComando;
    }

    public String getNombre() {
        return nombre;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    @Override
    public String toString() {
        return "ClienteComando{" +
                "id=" + id +
                ", idCliente=" + idCliente +
                ", idComando=" + idComando +
                '}';
    }
}
