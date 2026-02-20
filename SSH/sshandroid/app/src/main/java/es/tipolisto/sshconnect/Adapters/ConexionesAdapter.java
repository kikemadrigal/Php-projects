package es.tipolisto.sshconnect.Adapters;

import android.Manifest;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.pm.PackageManager;
import android.os.Environment;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.jcraft.jsch.JSch;
import com.jcraft.jsch.JSchException;
import com.jcraft.jsch.Session;

import java.io.File;
import java.util.ArrayList;
import java.util.Properties;

import es.tipolisto.sshconnect.Activities.EjecutarSSHActivity;
import es.tipolisto.sshconnect.Models.Conexion;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.JschClient;
import es.tipolisto.sshconnect.Utils.ShellConnection;
import es.tipolisto.sshconnect.Utils.Util;

public class ConexionesAdapter extends BaseAdapter {
    private ArrayList<Conexion> conexiones;
    private LayoutInflater layoutInflater;
    private Context context;
    private ShellConnection shellConnection;
    private AppCompatActivity activity;
    public ConexionesAdapter(Context context, AppCompatActivity activity, ArrayList<Conexion> conexiones){
        this.activity=activity;
        this.context=context;
        layoutInflater=LayoutInflater.from(context);
        this.conexiones=conexiones;
        this.shellConnection=new ShellConnection();
        //crearProgressDialog();
    }
    @Override
    public int getCount() {
        return conexiones.size();
    }
    @Override
    public Object getItem(int position) {
        return conexiones.get(position);
    }
    @Override
    public long getItemId(int position) {
        return position;
    }
    @Override
    public View getView(int position, View convertView, final ViewGroup parent) {
        final View itemView=layoutInflater.inflate(R.layout.item_conexiones_adapter,null);
        final ImageView imageViewConexionesDataBaseAdapter=itemView.findViewById(R.id.imageViewConexionesDataBaseFragment);
        //final ImageView imageViewConexion=itemView.findViewById(R.id.conexionItemConexionesAdapter);
        //final ImageView imageViewNoConexion=itemView.findViewById(R.id.noConexionItemConexionesAdapter);
        //TextView textViewAliasItemConexionesAdapter=itemView.findViewById(R.id.textViewAliasItemConexionesAdapter);
        TextView textViewUsuarioItemConexionesAdapter=itemView.findViewById(R.id.textViewUsuarioItemConexionesAdapter);
        TextView textViewHostItemConexionesAdapter=itemView.findViewById(R.id.textViewHostItemConexionesAdapter);


        final Conexion conexion=conexiones.get(position);

        //textViewAliasItemConexionesAdapter.setText(conexion.getAlias());
        textViewUsuarioItemConexionesAdapter.setText(conexion.getUsuario());
        textViewHostItemConexionesAdapter.setText(conexion.getHost());

        new Thread(new Runnable() {
            @Override
            public void run() {
                boolean estadoConexion=false;
                JSch jSch=new JSch();
                Session session=null;
                try {
                    session=jSch.getSession(conexion.getUsuario(), conexion.getHost(), conexion.getPuerto());
                    session.setPassword(conexion.getPassword());
                    //Si se elimina esta propiedad no te dejará conectarte ya que te dirá que el host no está en know_host
                    Properties prop = new Properties();
                    prop.put("StrictHostKeyChecking", "no");
                    session.setConfig(prop);
                    File archivoPrivateKey = new File(Environment.getExternalStorageDirectory() + "/ssh/id_rsa");
                    if(archivoPrivateKey.exists()){
                        jSch.addIdentity(archivoPrivateKey.getAbsolutePath(),"frasePrivada");
                    }
                    File archivoKnowHost = new File(Environment.getExternalStorageDirectory() + "/ssh/known_hosts");
                    if (archivoKnowHost.exists()) {
                        jSch.setKnownHosts(archivoKnowHost.getAbsolutePath());
                    }

                    session.connect(3000);
                    Log.d("Mensaje", "Item adapter dice: Se conectó a: "+conexion.getHost());
                    estadoConexion=true;
                } catch (JSchException e) {
                    e.printStackTrace();
                    Log.d("Mensaje", "Item adapter dice:: no se conecta a: "+conexion.getHost()+", error: "+e.getMessage());
                    estadoConexion=false;
                }
                session.disconnect();
                if(estadoConexion){
                    imageViewConexionesDataBaseAdapter.setImageResource(R.drawable.drawable_host_conectado);
                }else{
                    imageViewConexionesDataBaseAdapter.setImageResource(R.drawable.drawable_host_desconectado);
                }
            }
        }).start();






        return itemView;
    }





    /*
    private void crearProgressDialog(){
        final ProgressDialog progressDialog=new ProgressDialog(activity);
        progressDialog.setMessage("Cargando hosts.");
        progressDialog.show();
        new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    Thread.sleep(4000);
                    progressDialog.dismiss();
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
            }
        }).start();
    }*/
}
