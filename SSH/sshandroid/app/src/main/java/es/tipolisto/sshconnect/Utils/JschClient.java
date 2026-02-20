package es.tipolisto.sshconnect.Utils;

import android.Manifest;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.content.pm.PackageManager;
import android.os.Environment;
import android.support.v4.content.ContextCompat;
import android.text.TextUtils;
import android.util.Log;
import android.widget.EditText;
import android.widget.TextView;


import com.jcraft.jsch.ChannelExec;
import com.jcraft.jsch.JSch;
import com.jcraft.jsch.JSchException;
import com.jcraft.jsch.KeyPair;
import com.jcraft.jsch.Session;
import com.jcraft.jsch.UIKeyboardInteractive;
import com.jcraft.jsch.UserInfo;


import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;

import es.tipolisto.sshconnect.Models.Conexion;

public class JschClient {
    private AppCompatActivity activity;
    private JSch jsch;
    private Session session;
    private Conexion conexion;
    private TextView textViewResultado;
    private EditText editTextEjecutarComando;
    private final int MY_PERMISSIONS_REQUEST_EXTERNAL_SD=103;
    private boolean estadoConexion;


    private final String LOG="Mensaje";
    public JschClient(AppCompatActivity activity, Conexion conexion, TextView textViewResultado, EditText editTextEjecutarComando){
        //La activity la usaremos para mostrar mensajes en Toast  en AlertDialog
        this.activity=activity;
        this.jsch=new JSch();
        this.conexion=conexion;
        //txtResultado es un texView que viene de la activity en el que mostraremos los mensajes de resultado
        this.textViewResultado=textViewResultado;
        //editTextEjecutarComando, es donde está el string para coger los comandos
        this.editTextEjecutarComando=editTextEjecutarComando;
        this.estadoConexion=false;
    }


    public boolean isEstadoConexion() {
        return estadoConexion;
    }

    public void setEstadoConexion(boolean estadoConexion) {
        this.estadoConexion = estadoConexion;
    }


    //Este método solo se utiliza en el onCreate del EjecutarActivity
    public void probarEstadoConexion(){
        new Thread(new Runnable() {
            @Override
            public void run() {
                try{
                    //1.Creamos el jsch
                    final JSch jSch=new JSch();
                    //Comprobamos los permisos
                    int permissionCheckRead = ContextCompat.checkSelfPermission(activity,
                            Manifest.permission.READ_EXTERNAL_STORAGE);
                    if (permissionCheckRead!= PackageManager.PERMISSION_GRANTED ) {
                        activity.requestPermissions(new String[]{Manifest.permission.READ_EXTERNAL_STORAGE,Manifest.permission.WRITE_EXTERNAL_STORAGE },MY_PERMISSIONS_REQUEST_EXTERNAL_SD);
                    }else{
                        //2.Comprobamos si está la clave privada creada y la añadimos al jsch
                        File archivoPrivateKey = new File(Environment.getExternalStorageDirectory() + "/ssh/id_rsa");
                        if(archivoPrivateKey.exists()){
                            jSch.addIdentity(archivoPrivateKey.getAbsolutePath(),"frasePrivada");
                            Log.d("Mensaje","Clave privada encontrada, añadida a las identidades del jsch: "+archivoPrivateKey.getAbsolutePath());
                        }else{
                            Log.d("Mensaje","Clave publica no encontrada");
                        }
                    }
                    //3.Obetenemos la sesion
                    final Session session=jSch.getSession(conexion.getUsuario(),conexion.getHost(),conexion.getPuerto());
                    //4.Le indicamos al JSch cual es nuestro archivo de host conocidos para que pueda escribir en él
                    File archivoKnowHost = new File(Environment.getExternalStorageDirectory() + "/ssh/known_hosts");
                    if(archivoKnowHost.exists()) {
                        jSch.setKnownHosts(archivoKnowHost.getAbsolutePath());
                        Log.d("Mensaje", "Los host conocidos fueron añadidos al jsch");
                    }else{
                        Log.d("Mensaje", "Hubo un problema al añadir los host");
                    }
                    //5.Le asignamos la interface de usuariu para que salgan los mensajes
                    MyUserInfo myUserInfo=new MyUserInfo(){

                        public boolean promptYesNo(final String str){
                            final Boolean[] siONO={false, false};
                            activity.runOnUiThread(
                                    new Runnable() {
                                        @Override
                                        public void run() {
                                            AlertDialog.Builder builder = new AlertDialog.Builder(activity);
                                            builder.setMessage(str);
                                            builder.setCancelable(false);
                                            builder.setPositiveButton("Si", new DialogInterface.OnClickListener() {
                                                @Override
                                                public void onClick(DialogInterface dialog, int which) {

                                                }
                                            });
                                            builder.setNegativeButton("No", new DialogInterface.OnClickListener() {
                                                @Override
                                                public void onClick(DialogInterface dialog, int which) {

                                                }
                                            });

                                            builder.create().show();
                                        }
                                    });
                            return true;
                        }
                    };
                    session.setPassword(conexion.getPassword());
                    session.setUserInfo(myUserInfo);
                    //6.Nos conectamos
                    session.connect();
                    Util.crearToast(activity, "Conexión exitosa");
                    session.disconnect();
                    if(textViewResultado!=null) textViewResultado.setText("Éxito al conectar.");
                    estadoConexion=true;
                }catch(Exception e){
                    Util.crearToast(activity, "Error: "+ e.getMessage());
                    Log.d("Mensaje","error: "+e.getMessage());
                    if(textViewResultado!=null) textViewResultado.setText("Fracaso al conectar.");
                    estadoConexion=false;
                }
            }
        }).start();
    }




    //Este método es solo para el spinner con los strings de comandos
    public void conectarYEjecutarComando(final ProgressDialog progressDialog) {
        new Thread(new Runnable() {
            @Override
            public void run() {
                try {

                    final JSch jSch = new JSch();
                    int permissionCheckRead = ContextCompat.checkSelfPermission(activity,
                            Manifest.permission.READ_EXTERNAL_STORAGE);
                    if (permissionCheckRead != PackageManager.PERMISSION_GRANTED) {
                        activity.requestPermissions(new String[]{Manifest.permission.READ_EXTERNAL_STORAGE, Manifest.permission.WRITE_EXTERNAL_STORAGE}, MY_PERMISSIONS_REQUEST_EXTERNAL_SD);
                    } else {
                        File archivoPrivateKey = new File(Environment.getExternalStorageDirectory() + "/ssh/id_rsa");
                        if (archivoPrivateKey.exists()) {
                            jSch.addIdentity(archivoPrivateKey.getAbsolutePath(), "frasePrivada");
                            Log.d("Mensaje", "Clave privada encontrada, añadida a las identidades del jsch: " + archivoPrivateKey.getAbsolutePath());
                        } else {
                            Log.d("Mensaje", "Clave publica no encontrada");
                        }
                    }
                    final Session session = jSch.getSession(conexion.getUsuario(), conexion.getHost(), conexion.getPuerto());
                    File archivoKnowHost = new File(Environment.getExternalStorageDirectory() + "/ssh/known_hosts");
                    //jSch.setKnownHosts(archivoKnowHost.getAbsolutePath());
                    if (archivoKnowHost.exists()) {
                        jSch.setKnownHosts(archivoKnowHost.getAbsolutePath());
                        Log.d("Mensaje", "Los host conocidos fueron añadidos al jsch");
                    } else {
                        Log.d("Mensaje", "Hubo un problema al añadir los host");
                    }

                    MyUserInfo myUserInfo = new MyUserInfo() {
                        @Override
                        public boolean promptPassword(final String message) {
                            return false;
                        }
                        public boolean promptYesNo(final String str) {
                            final Boolean[] siONO = {false, false};
                            activity.runOnUiThread(
                                    new Runnable() {
                                        @Override
                                        public void run() {
                                            AlertDialog.Builder builder = new AlertDialog.Builder(activity);
                                            builder.setMessage(str);
                                            builder.setCancelable(false);
                                            builder.setPositiveButton("Si", new DialogInterface.OnClickListener() {
                                                @Override
                                                public void onClick(DialogInterface dialog, int which) {

                                                }
                                            });
                                            builder.setNegativeButton("No", new DialogInterface.OnClickListener() {
                                                @Override
                                                public void onClick(DialogInterface dialog, int which) {

                                                }
                                            });

                                            builder.create().show();
                                        }
                                    });
                            return true;
                        }
                    };
                    if(!TextUtils.isEmpty(conexion.getPassword())){
                        session.setPassword(conexion.getPassword());
                    }else{

                    }
                    session.setUserInfo(myUserInfo);
                    session.connect();
                    if(TextUtils.isEmpty(conexion.getPassword())){

                    }

                    ChannelExec channelssh = (ChannelExec) session.openChannel("exec");
                    ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
                    channelssh.setOutputStream(byteArrayOutputStream);
                    channelssh.setCommand(editTextEjecutarComando.getText().toString());
                    channelssh.connect();
                    InputStream in = channelssh.getInputStream();

                    byte[] tmp = new byte[1024];

                    while (true) {
                        while (in.available() > 0) {
                            int i = in.read(tmp, 0, 1024);
                            if (i < 0) {
                                break;
                            }
                            Log.d("Mensaje", new String(tmp, 0, i));
                            final String palabra = new String(tmp, 0, i);
                            activity.runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    textViewResultado.append(textViewResultado.getText() + palabra + "\n");
                                }
                            });
                        }
                        if (channelssh.isClosed()) {
                            if (in.available() > 0) {
                                continue;
                            }
                            System.out
                                    .println("exit-status: " + channelssh.getExitStatus());
                            break;
                        }
                        try {
                            Thread.sleep(1000);
                        } catch (Exception ee) {
                        }
                    }
                    activity.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            if(textViewResultado.getText().toString().equalsIgnoreCase("")){
                                textViewResultado.setText("Este comando no devolvió resultados");
                            }
                        }
                    });
                    progressDialog.dismiss();
                    channelssh.disconnect();
                    session.disconnect();
                    estadoConexion=true;
                } catch (Exception e) {
                    progressDialog.dismiss();
                    Util.crearToast(activity, "Error: " + e.getMessage());
                    Log.d("Mensaje", "error: " + e.getMessage());
                    textViewResultado.setText("Fracaso al conectar.");
                    estadoConexion=false;
                }
            }
        }).start();
    }

















    //Éste método es solo para el spinner con los clientesComanos
    public void conectarYEjecutarComandoConSpinner(final ProgressDialog progressDialog, final String valorItemSpinner) {
        new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    final JSch jSch = new JSch();
                    int permissionCheckRead = ContextCompat.checkSelfPermission(activity,
                            Manifest.permission.READ_EXTERNAL_STORAGE);
                    if (permissionCheckRead != PackageManager.PERMISSION_GRANTED) {
                        activity.requestPermissions(new String[]{Manifest.permission.READ_EXTERNAL_STORAGE, Manifest.permission.WRITE_EXTERNAL_STORAGE}, MY_PERMISSIONS_REQUEST_EXTERNAL_SD);
                    } else {
                        File archivoPrivateKey = new File(Environment.getExternalStorageDirectory() + "/ssh/id_rsa");
                        if (archivoPrivateKey.exists()) {
                            jSch.addIdentity(archivoPrivateKey.getAbsolutePath(), "frasePrivada");
                            Log.d("Mensaje", "Clave privada encontrada, añadida a las identidades del jsch: " + archivoPrivateKey.getAbsolutePath());
                        } else {
                            Log.d("Mensaje", "Clave publica no encontrada");
                        }

                    }
                    final Session session = jSch.getSession(conexion.getUsuario(), conexion.getHost(), conexion.getPuerto());
                    File archivoKnowHost = new File(Environment.getExternalStorageDirectory() + "/ssh/known_hosts");
                    if (archivoKnowHost.exists()) {
                        jSch.setKnownHosts(archivoKnowHost.getAbsolutePath());
                        Log.d("Mensaje", "Los host conocidos fueron añadidos al jsch");
                    } else {
                        Log.d("Mensaje", "Hubo un problema al añadir los host");
                    }
                    MyUserInfo myUserInfo = new MyUserInfo() {
                        @Override
                        public boolean promptPassword(final String message) {
                            return false;
                        }
                        /**
                         *Este mensaje sale diciendote que la autenticidad no puede ser establecida si desea continuar
                         */
                        public boolean promptYesNo(final String str) {
                            final Boolean[] siONO = {false, false};
                            activity.runOnUiThread(
                                    new Runnable() {
                                        @Override
                                        public void run() {
                                            AlertDialog.Builder builder = new AlertDialog.Builder(activity);
                                            builder.setMessage(str);
                                            builder.setCancelable(false);
                                            builder.setPositiveButton("Si", new DialogInterface.OnClickListener() {
                                                @Override
                                                public void onClick(DialogInterface dialog, int which) {

                                                }
                                            });
                                            builder.setNegativeButton("No", new DialogInterface.OnClickListener() {
                                                @Override
                                                public void onClick(DialogInterface dialog, int which) {

                                                }
                                            });

                                            builder.create().show();
                                        }
                                    });
                            return true;
                        }
                    };
                    session.setPassword(conexion.getPassword());
                    session.setUserInfo(myUserInfo);
                    session.connect();

                    ChannelExec channelssh = (ChannelExec) session.openChannel("exec");
                    //Abrimos un canal de salida para poder ejecutar un comando

                    ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
                    channelssh.setOutputStream(byteArrayOutputStream);
                    channelssh.setCommand(valorItemSpinner);
                    channelssh.connect();
                    InputStream in = channelssh.getInputStream();

                    byte[] tmp = new byte[1024];
                    while (true) {
                        while (in.available() > 0) {
                            int i = in.read(tmp, 0, 1024);
                            if (i < 0) {
                                break;
                            }
                            Log.d("Mensaje", new String(tmp, 0, i));
                            final String palabra = new String(tmp, 0, i);
                            activity.runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    textViewResultado.append(textViewResultado.getText() + palabra + "\n");
                                }
                            });
                        }
                        if (channelssh.isClosed()) {
                            if (in.available() > 0) {
                                continue;
                            }
                            System.out
                                    .println("exit-status: " + channelssh.getExitStatus());
                            break;
                        }
                        try {
                            Thread.sleep(1000);
                        } catch (Exception ee) {
                        }
                    }
                    progressDialog.dismiss();
                    activity.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            if(textViewResultado.getText().toString().equalsIgnoreCase("")){
                                textViewResultado.setText("Este comando no devolvió resultados");
                            }
                        }
                    });
                    channelssh.disconnect();
                    session.disconnect();
                    estadoConexion=true;
                } catch (Exception e) {
                    activity.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            if(textViewResultado.getText().toString().equalsIgnoreCase("")){
                                textViewResultado.setText("Este comando no devolvió resultados");
                            }
                        }
                    });
                    progressDialog.dismiss();
                    Util.crearToast(activity, "Error: " + e.getMessage());
                    Log.d("Mensaje", "error: " + e.getMessage());
                    textViewResultado.setText("Fracaso al conectar.");
                    estadoConexion=false;
                }
            }
        }).start();

    }



    public void generarClaves(){
        Log.d("Mensaje", "Has pinchado en crear claves");
        JSch jsch=new JSch();
        String estadoSD= Environment.getExternalStorageState();
        if(estadoSD.equals(Environment.MEDIA_MOUNTED)){
            try {
                //Comprobamos los permisos
                int permissionCheckRead = ContextCompat.checkSelfPermission(activity,
                        Manifest.permission.READ_EXTERNAL_STORAGE);
                int permissionCheckWrite = ContextCompat.checkSelfPermission(activity,
                        Manifest.permission.WRITE_EXTERNAL_STORAGE);
                if (permissionCheckRead!= PackageManager.PERMISSION_GRANTED && permissionCheckWrite!= PackageManager.PERMISSION_GRANTED) {
                    activity.requestPermissions(new String[]{Manifest.permission.READ_EXTERNAL_STORAGE,Manifest.permission.WRITE_EXTERNAL_STORAGE },MY_PERMISSIONS_REQUEST_EXTERNAL_SD);
                }else{
                    File directorio = new File(Environment.getExternalStorageDirectory() + "/ssh/");
                    directorio.mkdir();
                    File rutaArchivoPrivateKey = new File(directorio + "/id_rsa");
                    rutaArchivoPrivateKey.createNewFile();
                    File rutaArchivoPublicKey = new File(directorio + "/id_rsa.pub");
                    rutaArchivoPublicKey.createNewFile();

                    KeyPair kpair=KeyPair.genKeyPair(jsch, KeyPair.RSA);
                    int tipo=kpair.getKeyType();
                    kpair.setPassphrase("frasePrivada");
                    kpair.writePrivateKey(rutaArchivoPrivateKey.getAbsolutePath());
                    kpair.writePublicKey(rutaArchivoPublicKey.getAbsolutePath(), "SSHpublickey@movil");
                    kpair.dispose();
                    Util.crearToast(activity, "Creada clave pública");
                    Log.d("Mensaje", "Creada public key, el tipo es el "+tipo+"\nruta clave privada "+rutaArchivoPrivateKey.getAbsolutePath()+"\nRuta clave publica "+rutaArchivoPublicKey.getAbsolutePath());

                    /* KeyPairGenerator keyPairGenerator=KeyPairGenerator.getInstance("RSA");
                    keyPairGenerator.initialize(2048);
                    keyPairGenerator.generateKeyPair();
                    KeyPair keyPair=keyPairGenerator.generateKeyPair();
                    PublicKey publicKey=keyPair.getPublic();
                    PrivateKey privateKey=keyPair.getPrivate();
                    Log.d("Mensaje", "public key: "+publicKey);
                    Log.d("Mensaje", "private key: "+privateKey);*/
                }

            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSchException e) {
                e.printStackTrace();
            }
        }else if(estadoSD.equals(Environment.MEDIA_MOUNTED_READ_ONLY)){
            Util.crearToast(activity,"No se puede escribir");
        }else{
            Util.crearToast(activity, "No se puede ni leer ni escribir");
        }
    }







    public static abstract class MyUserInfo
            implements UserInfo, UIKeyboardInteractive {
        public String getPassword(){

            return null;
        }
        public boolean promptYesNo(String str){

            return false;
        }
        public String getPassphrase(){ return null; }
        public boolean promptPassphrase(String message){ return false; }
        public boolean promptPassword(String message){

            return false;
        }
        public void showMessage(String message){

        }
        public String[] promptKeyboardInteractive(String destination,
                                                  String name,
                                                  String instruction,
                                                  String[] prompt,
                                                  boolean[] echo){
            return null;
        }
    }




}
