package es.tipolisto.sshconnect.Models;

import android.content.Context;
import android.view.View;

public class Objects {
    private Conexion conexion;
    private Context context;
    private View view;
    private String mensaje;
    private int entero;

    public Objects(Conexion conexion, Context context, View view, String mensaje, int entero) {
        this.conexion = conexion;
        this.context = context;
        this.view = view;
        this.mensaje = mensaje;
        this.entero = entero;
    }

    public Conexion getConexion() {
        return conexion;
    }

    public void setConexion(Conexion conexion) {
        this.conexion = conexion;
    }

    public Context getContext() {
        return context;
    }

    public void setContext(Context context) {
        this.context = context;
    }

    public View getView() {
        return view;
    }

    public void setView(View view) {
        this.view = view;
    }

    public String getMensaje() {
        return mensaje;
    }

    public void setMensaje(String mensaje) {
        this.mensaje = mensaje;
    }

    public int getEntero() {
        return entero;
    }

    public void setEntero(int entero) {
        this.entero = entero;
    }

    @Override
    public String toString() {
        return "Objects{" +
                "conexion=" + conexion +
                ", context=" + context +
                ", view=" + view +
                ", mensaje='" + mensaje + '\'' +
                ", entero=" + entero +
                '}';
    }
}
