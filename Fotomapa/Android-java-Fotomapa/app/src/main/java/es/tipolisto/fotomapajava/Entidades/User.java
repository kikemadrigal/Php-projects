package es.tipolisto.fotomapajava.Entidades;

public class User {
    private int id;
    private String nombre;
    private String clave;
    private String tipo;
    private String correo;
    private String nombrereal;
    private String apellidos;
    private String web;
    private int validado;
    private int contador;
    private String fecha;
    private String datos;

    public User(int id, String nombre, String clave, String tipo, String correo, String nombrereal, String apellidos, String web, int validado, int contador, String fecha, String datos) {
        this.id = id;
        this.nombre = nombre;
        this.clave = clave;
        this.tipo = tipo;
        this.correo = correo;
        this.nombrereal = nombrereal;
        this.apellidos = apellidos;
        this.web = web;
        this.validado = validado;
        this.contador = contador;
        this.fecha = fecha;
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

    public String getClave() {
        return clave;
    }

    public void setClave(String clave) {
        this.clave = clave;
    }

    public String getTipo() {
        return tipo;
    }

    public void setTipo(String tipo) {
        this.tipo = tipo;
    }

    public String getCorreo() {
        return correo;
    }

    public void setCorreo(String correo) {
        this.correo = correo;
    }

    public String getNombrereal() {
        return nombrereal;
    }

    public void setNombrereal(String nombrereal) {
        this.nombrereal = nombrereal;
    }

    public String getApellidos() {
        return apellidos;
    }

    public void setApellidos(String apellidos) {
        this.apellidos = apellidos;
    }

    public String getWeb() {
        return web;
    }

    public void setWeb(String web) {
        this.web = web;
    }

    public int getValidado() {
        return validado;
    }

    public void setValidado(int validado) {
        this.validado = validado;
    }

    public int getContador() {
        return contador;
    }

    public void setContador(int contador) {
        this.contador = contador;
    }

    public String getFecha() {
        return fecha;
    }

    public void setFecha(String fecha) {
        this.fecha = fecha;
    }

    public String getDatos() {
        return datos;
    }

    public void setDatos(String datos) {
        this.datos = datos;
    }


    @Override
    public String toString() {
        return "User{" +
                "id=" + id +
                ", nombre='" + nombre + '\'' +
                ", clave='" + clave + '\'' +
                ", tipo='" + tipo + '\'' +
                ", correo='" + correo + '\'' +
                ", nombrereal='" + nombrereal + '\'' +
                ", apellidos='" + apellidos + '\'' +
                ", web='" + web + '\'' +
                ", validado=" + validado +
                ", contador=" + contador +
                ", fecha='" + fecha + '\'' +
                ", datos='" + datos + '\'' +
                '}';
    }
}
