package es.tipolisto.sshconnect.Activities.Conexiones;

import android.Manifest;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;


import android.content.SharedPreferences;
import android.content.pm.PackageManager;

import android.net.Uri;
import android.os.Environment;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.jcraft.jsch.JSch;
import com.jcraft.jsch.Session;
import com.jcraft.jsch.UIKeyboardInteractive;
import com.jcraft.jsch.UserInfo;


import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;

import es.tipolisto.sshconnect.Activities.EjecutarSSHActivity;
import es.tipolisto.sshconnect.Models.Conexion;
import es.tipolisto.sshconnect.Models.Sqlite;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.JschClient;
import es.tipolisto.sshconnect.Utils.MagicPacket;
import es.tipolisto.sshconnect.Utils.RetrofitClient;
import es.tipolisto.sshconnect.Utils.Util;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;





public class UpdateConexionActivity extends AppCompatActivity implements View.OnClickListener {

    private Conexion conexion;
    private EditText editTextAlias,editTextUsuario,editTextPassword, editTextHost, editTextMac, editTextPuerto;
    private TextView textViewResultado, textViewMensajeAlias, textViewMensajeUsuario, textViewMensajePassword,textViewMensajeHost,textViewMensajeMac,textViewMensajePuerto,textViewEnlaceDescargarClavePublica;
    private Button buttonActualizar, buttonVolver, buttonEliminar, buttonConectar, buttonProbarConexion, buttonCrearClave, buttonDescargarClaves,buttonDespertar;
    private ProgressBar progressBar;
    private EditText[] editTexts;
    private TextView[] textViews;
    private int id;
    boolean vengoDeMainActivity;
    private boolean estadoConexion;
    private boolean authentyHost;
    private final String TAG="Mensaje";


    private final int MY_PERMISSIONS_REQUEST_EXTERNAL_SD=103;
    private boolean isEstadoConexion;


    /**
     * UI
     */

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_conexion);
        Util.crearToolbar(this);

        estadoConexion=false;
        Bundle extras = getIntent().getExtras();
        if(extras!=null){
            vengoDeMainActivity= extras.getBoolean("vengoDeMainActivity", false);
            id = extras.getInt("id",0);
            //Log.d("Mensaje", "escibido el "+id+", vengo de activity "+vengoDeMainActivity);
            if(vengoDeMainActivity){
                bindUI();
                buttonActualizar.setVisibility(View.INVISIBLE);
                buttonEliminar.setVisibility(View.INVISIBLE);
            }else if(id!=0){
                Sqlite sqlite=new Sqlite(this);
                conexion=sqlite.selectUnaConexion(id);
                bindUI();
                rellenarEditText(conexion);
                probarEstadoConexion();
                Log.d("Mensaje", "El estado es "+estadoConexion);
            }
        }




    }


    private void bindUI(){

        //progressBar=findViewById(R.id.progressBar);
        //Los EditText son atributos globales de la clase
        editTextAlias=findViewById(R.id.editTextAliasActualizarConexion);
        editTextUsuario=findViewById(R.id.editTextUsuarioActualizarConexion);
        editTextPassword=findViewById(R.id.editTextPasswordActualizarConexion);
        editTextHost=findViewById(R.id.editTextHostActualizarConexion);
        editTextMac=findViewById(R.id.editTextMacActualizarConexion);
        editTextPuerto=findViewById(R.id.editTextPuertoActualizarConexion);

        textViewResultado=findViewById(R.id.textViewResultadoActualizarConexion);
        textViewMensajeAlias=findViewById(R.id.textViewMensajeAlias);
        textViewMensajeUsuario=findViewById(R.id.textViewMensajeUsuario);
        textViewMensajePassword=findViewById(R.id.textViewMensajePassword);
        textViewMensajeHost=findViewById(R.id.textViewMensajeHost);
        textViewMensajeMac=findViewById(R.id.textViewMensajeMac);
        textViewMensajePuerto=findViewById(R.id.textViewMensajePuerto);
        textViewEnlaceDescargarClavePublica=findViewById(R.id.texViewEnlaceDescargaClavePublica);

        buttonActualizar=findViewById(R.id.buttonActualizarActualizarConexion);
        buttonActualizar.setOnClickListener(this);
        buttonVolver=findViewById(R.id.buttonVolverActualizarConexion);
        buttonVolver.setOnClickListener(this);
        buttonEliminar=findViewById(R.id.buttonEliminarActualizarConexion);
        buttonEliminar.setOnClickListener(this);
        buttonConectar=findViewById(R.id.buttonConectarActualizarConexion);
        buttonConectar.setOnClickListener(this);
        buttonProbarConexion=findViewById(R.id.buttonProbarConexionActualizarConexion);
        buttonProbarConexion.setOnClickListener(this);
        buttonDescargarClaves=findViewById(R.id.buttonDescargarClavePubicaUpdateConexion);
        buttonDescargarClaves.setOnClickListener(this);
        buttonCrearClave=findViewById(R.id.buttonCrearClavePubicaUpdateConexion);
        buttonCrearClave.setOnClickListener(this);
        buttonDespertar=findViewById(R.id.buttonDespertarConexionActualizarConexion);
        buttonDespertar.setOnClickListener(this);


        editTexts=new EditText[4];
        editTexts[0]=editTextAlias;
        editTexts[1]=editTextUsuario;
        //El password noserá obligatorio y se podrá conectar por clave publica
        //editTexts[2]=editTextPassword;
        editTexts[2]=editTextHost;
        //El mac no lo metenemos porque no es obligatorio y esto es para validar
        editTexts[3]=editTextPuerto;

        textViews=new TextView[4];
        textViews[0]=textViewMensajeAlias;
        textViews[1]=textViewMensajeUsuario;
        //El password noserá obligatorio y se podrá conectar por clave publica
        //textViews[2]=textViewMensajePassword;
        textViews[2]=textViewMensajeHost;
        //El mac no lo metenemos porque no es obligatorio y esto es para validar
        textViews[3]=textViewMensajePuerto;
    }
    private void rellenarEditText(Conexion conexion){
        editTextAlias.setText(conexion.getAlias());
        editTextUsuario.setText(conexion.getUsuario());
        editTextPassword.setText(conexion.getPassword());
        editTextHost.setText(conexion.getHost());
        editTextMac.setText(conexion.getMac());
        editTextPuerto.setText(String.valueOf(conexion.getPuerto()));
    }


    @Override
    public void onClick(View v) {
        ponerTextViewsEnBlanco();
        switch (v.getId()){
            case R.id.buttonActualizarActualizarConexion:
                boolean hayError=false;
                ponerTextViewsEnBlanco();
                ponerMensajeDeErrorEnTextViews();
                hayError=comprobarAlgunMensajeEnTextView();
                if(!hayError){
                    actualizarConexion(id);
                }
                break;
            case R.id.buttonVolverActualizarConexion:
                if(vengoDeMainActivity){
                    volverALMain();
                }else{
                    volverALasConexiones();
                }

                break;
            case R.id.buttonDespertarConexionActualizarConexion:
                String host=editTextHost.getText().toString().trim();
                String mac=editTextMac.getText().toString().trim();
                if(TextUtils.isEmpty(mac ) || TextUtils.isEmpty(host)){
                    Toast.makeText(this, "La ip y elmac no pueden vacíos", Toast.LENGTH_SHORT).show();
                }else{
                    Log.d("Mensaje","Has presionado el boton de despertar: "+host+", "+mac);
                    MagicPacket magicPacket=new MagicPacket(this, host,mac);
                    magicPacket.enviar();
                }
                break;
            case R.id.buttonEliminarActualizarConexion:
                AlertDialog.Builder builder = new AlertDialog.Builder(UpdateConexionActivity.this);
                builder.setTitle("Mensaje");
                builder.setMessage("¿Está seguro de que desea eliminarlo?");
                builder.setCancelable(true);
                builder.setPositiveButton("Si", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        eliminarConexion(conexion.getId());
                        actulizarVentana();
                        dialog.cancel();
                    }
                });
                builder.setNegativeButton("No", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        dialog.cancel();
                    }
                });
                AlertDialog alertDialog=builder.create();
                alertDialog.show();
                break;
            case R.id.buttonDescargarClavePubicaUpdateConexion:
                crearTextViewEnlaceDescargaClavePublicaYEnviarArchivoConRetrofit();
                break;
            case R.id.buttonCrearClavePubicaUpdateConexion:
                JschClient jschClient=new JschClient(UpdateConexionActivity.this, null, null, null);
                jschClient.generarClaves();
                break;
            case R.id.buttonConectarActualizarConexion:
                Log.d("Mensaje", "Click en ir a ejecutar-->"+estadoConexion);
                boolean hayError2=false;
                ponerTextViewsEnBlanco();
                ponerMensajeDeErrorEnTextViews();
                hayError2=comprobarAlgunMensajeEnTextView();
                if(!hayError2){
                    if(vengoDeMainActivity){
                        int puerto=Integer.parseInt(editTextPuerto.getText().toString());
                        conexion=new Conexion(0,editTextAlias.getText().toString(),editTextUsuario.getText().toString(),editTextPassword.getText().toString(),editTextHost.getText().toString(),editTextMac.getText().toString(),puerto);
                        if(estadoConexion){
                            irAEjecutarSSHActivity();
                        }else{
                        }
                    }else{
                        if(estadoConexion){
                            irAEjecutarSSHActivity();
                        }else{
                        }
                    }
                }
                break;
            case R.id.buttonProbarConexionActualizarConexion:
                Log.d("Mensaje", "Click en probar conexion");
                int puerto=Integer.parseInt(editTextPuerto.getText().toString());
                conexion=new Conexion(0,editTextAlias.getText().toString(),editTextUsuario.getText().toString(),editTextPassword.getText().toString(),editTextHost.getText().toString(),editTextMac.getText().toString(),puerto);
                boolean hayUnError=false;
                ponerTextViewsEnBlanco();
                ponerMensajeDeErrorEnTextViews();
                hayUnError=comprobarAlgunMensajeEnTextView();
                if(!hayUnError){
                    probarEstadoConexion();
                    Log.d("Mensaje", "El estado es "+estadoConexion);
                }
                break;
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           String permissions[], int[] grantResults) {
        switch (requestCode) {
            case MY_PERMISSIONS_REQUEST_EXTERNAL_SD: {
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    Toast.makeText(this, "Permiso aprobado", Toast.LENGTH_SHORT).show();
                } else {
                    Toast.makeText(this, "Permiso denegado", Toast.LENGTH_SHORT).show();
                    Intent intent=new Intent(this,ConexionesActivity.class);
                    startActivity(intent);
                    finish();
                }
                return;
            }
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        Util.crearMenu(this,item.getItemId());
        return true;
    }

    private void crearTextViewEnlaceDescargaClavePublicaYEnviarArchivoConRetrofit(){
        int permissionCheckRead = ContextCompat.checkSelfPermission(UpdateConexionActivity.this,
                Manifest.permission.READ_EXTERNAL_STORAGE);
        if (permissionCheckRead!= PackageManager.PERMISSION_GRANTED ) {
            requestPermissions(new String[]{Manifest.permission.READ_EXTERNAL_STORAGE,Manifest.permission.WRITE_EXTERNAL_STORAGE },MY_PERMISSIONS_REQUEST_EXTERNAL_SD);
        }else {
            File archivoPublicKey = new File(Environment.getExternalStorageDirectory() + "/ssh/id_rsa.pub");
            if(archivoPublicKey==null){
                Toast.makeText(this, "La clave pública no ha sido creada", Toast.LENGTH_SHORT).show();
            }else{
                /**
                 * 2.Transformamos el archivo en un array de bytes y después a un string para poder pasarla por la URL
                 * Para convertir un archivo a un array de bytes, se utiliza la clase ByteArrayOutputStream.
                 * Esta clase implementa un flujo de salida en el que los datos se escriben en un array de bytes.
                 * El búfer crece automáticamente a medida que se escriben los datos en él. Los datos se pueden
                 * recuperar utilizando toByteArray () y toString ().
                 */
                FileInputStream fileInputStream=null;
                try {
                    fileInputStream =new FileInputStream(archivoPublicKey);
                    String resultado="";
                    byte[] arrayDeBytes = new byte[1024];
                    FileReader fileReader=new FileReader((archivoPublicKey));
                    int c=fileReader.read();
                    resultado+=(char)c;
                    int contador=0;
                    while(c!=-1){
                        c=fileReader.read();
                        resultado+=(char)c;
                    }
                    //Le quitamos las letras raras del final
                    resultado=resultado.substring(0,resultado.length()-2);
                    Log.d("Mensaje", resultado);
                    enviarArchivoClaveConretrofit(resultado);
                    fileInputStream.close();
                } catch (FileNotFoundException e) {
                    e.printStackTrace();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        }


    }

    /**
     * Fin de UI
     */











    /**
     * Retrofit2
     */
    private void enviarArchivoClaveConretrofit(String stringArchivoClavePublica){
        Call<String> callSubirArchivoCLavePublica=null;
        if(Util.estaModoCodeigniter(this)){
            callSubirArchivoCLavePublica= RetrofitClient.getServiceISSHCode(UpdateConexionActivity.this).subirArchivoConLaClavePublica(stringArchivoClavePublica);
        }else{
            callSubirArchivoCLavePublica= RetrofitClient.getServiceISSH(UpdateConexionActivity.this).subirArchivoConLaClavePublica(stringArchivoClavePublica);
        }
        callSubirArchivoCLavePublica.enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                if(response.body()==null){
                    Util.crearToast(UpdateConexionActivity.this, "Hubo un problema de conexión con el servidor.");
                }else{
                    if(response.body().equalsIgnoreCase("Faltan")){
                        textViewEnlaceDescargarClavePublica.setVisibility(View.INVISIBLE);
                        AlertDialog.Builder builder = new AlertDialog.Builder(UpdateConexionActivity.this);
                        builder.setTitle("No se pudo crear el archivo");
                        if(Util.estaModoCodeigniter(getApplicationContext())){
                            builder.setMessage("Faltan los permisos de lectura y escritura, por favor, escriba sudo chmod 666 /var/www/html/ssh/files/authorized_keys");
                        }else{
                            builder.setMessage("Faltan los permisos de lectura y escritura, por favor, escriba sudo chmod 666 /var/www/html/sshcode/public/files/authorized_keys");
                        }

                        builder.setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                dialog.cancel();
                            }
                        });
                        builder.create().show();
                    }else{
                        String enlace="";
                        SharedPreferences prefs =getSharedPreferences("MisPreferencias", Context.MODE_PRIVATE);
                        String direccionServidor=prefs.getString("servidor", "");
                        if(Util.estaModoCodeigniter(getApplicationContext())){
                            enlace="http://"+direccionServidor+"/sshcode/claves/mostrarClave";
                            textViewEnlaceDescargarClavePublica.setText(enlace);
                        }else{
                            enlace="http://"+direccionServidor+"/ssh/views/claves/mostrarClave.php";
                            textViewEnlaceDescargarClavePublica.setText(enlace);
                        }
                        final Uri uri = Uri.parse(enlace);
                        textViewEnlaceDescargarClavePublica.setVisibility(View.VISIBLE);
                        textViewEnlaceDescargarClavePublica.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                Intent intent = new Intent(Intent.ACTION_VIEW, uri);
                                startActivity(intent);
                                textViewEnlaceDescargarClavePublica.setVisibility(View.GONE);
                            }
                        });
                        Log.d("Mensaje", "ha salido bien: "+response.body());
                        AlertDialog.Builder builder = new AlertDialog.Builder(UpdateConexionActivity.this);
                        builder.setTitle("Información");
                        builder.setMessage("Archivo creado en el servidor, pinche en la dirección que se muestra debajo de los botones para ir a la web.");
                        builder.setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                dialog.cancel();
                            }
                        });
                        builder.create().show();
                    }
                }

            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {
                Log.d("Mensaje", "ha salido mal");
            }
        });
    }
    /**
     * Fin de retrofit 2
     */





























    /**
     * Inicio Jsch
     */
    public void probarEstadoConexion(){
        new Thread(new Runnable() {
            @Override
            public void run() {
                try{
                    final JSch jSch=new JSch();
                    int permissionCheckRead = ContextCompat.checkSelfPermission(UpdateConexionActivity.this,
                            Manifest.permission.READ_EXTERNAL_STORAGE);
                    if (permissionCheckRead!= PackageManager.PERMISSION_GRANTED ) {
                        requestPermissions(new String[]{Manifest.permission.READ_EXTERNAL_STORAGE,Manifest.permission.WRITE_EXTERNAL_STORAGE },MY_PERMISSIONS_REQUEST_EXTERNAL_SD);
                    }else{
                        File archivoPrivateKey = new File(Environment.getExternalStorageDirectory() + "/ssh/id_rsa");
                        if(archivoPrivateKey.exists()){
                            jSch.addIdentity(archivoPrivateKey.getAbsolutePath(),"frasePrivada");
                            Log.d("Mensaje","Clave privada encontrada, añadida a las identidades del jsch: "+archivoPrivateKey.getAbsolutePath());
                        }else{
                            Log.d("Mensaje","Clave publica no encontrada");
                        }
                    }
                    final Session session=jSch.getSession(conexion.getUsuario(),conexion.getHost(),conexion.getPuerto());
                    File archivoKnowHost = new File(Environment.getExternalStorageDirectory() + "/ssh/known_hosts");
                    if(archivoKnowHost.exists()) {
                        jSch.setKnownHosts(archivoKnowHost.getAbsolutePath());
                        Log.d("Mensaje", "Los host conocidos fueron añadidos al jsch");
                    }else{
                        Log.d("Mensaje", "Hubo un problema al añadir los host");
                    }
                    MyUserInfo myUserInfo = new MyUserInfo() {
                        @Override
                        public boolean promptPassword(final String message) {
                            return false;
                        }

                        public boolean promptYesNo(final String str) {
                            final Boolean[] siONO = {false, false};
                            runOnUiThread(
                                    new Runnable() {
                                        @Override
                                        public void run() {
                                            AlertDialog.Builder builder = new AlertDialog.Builder(UpdateConexionActivity.this);
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
                    session.connect(4000);

                    Util.crearToast(UpdateConexionActivity.this, "Conexión exitosa");
                    session.disconnect();
                    textViewResultado.setText("Conexión exitosa.");
                    estadoConexion=true;
                }catch(Exception e){
                    Util.crearToast(UpdateConexionActivity.this, "Error: "+ e.getMessage());
                    Log.d("Mensaje","error: "+e.getMessage());
                    estadoConexion=false;
                    textViewResultado.setText("Fracaso al conectar.");
                }
            }
        }).start();
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
    /**
     * Fin de Jsch
     */






















    /**
     * Validaciones
     */
    private void ponerTextViewsEnBlanco() {
        for(TextView textView:textViews){
            textView.setText("");
        }
    }

    private boolean comprobarAlgunMensajeEnTextView(){
        boolean hayError=false;
        for(TextView textView:textViews){
            if(!TextUtils.isEmpty(textView.getText().toString())){
                hayError= true;
                Log.d("Mensaje", "hay un error");
                break;
            }
        }
        return hayError;
    }

    private void ponerMensajeDeErrorEnTextViews() {
        String campoValor;
        //Recorremos el array en busca de campos vacíos
        for (int i=0; i<editTexts.length;i++){
            campoValor=editTexts[i].getText().toString();
            if(TextUtils.isEmpty(campoValor)){
                textViews[i].setText("El campo no puede estar vacío");
            }
        }
    }

    /**
     * Final de validaciones
     */













    /**
     * Navegación entre acitividades
     */
    private void irAEjecutarSSHActivity() {
            Intent intent=new Intent(this, EjecutarSSHActivity.class);
            intent.putExtra("id", conexion.getId());
            startActivity(intent);
            finish();
    }

    private void volverALasConexiones() {
        Intent intent=new Intent(this, ConexionesActivity.class);
        //intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
        finish();
    }

    private void volverALMain() {
        Intent intent=new Intent(this, ConexionesActivity.class);
        //intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
        finish();
    }
    private void irAConexiones(){
        Intent intent=new Intent(this, ConexionesActivity.class);
        //intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
        finish();
    }
    private void actulizarVentana(){
        Intent intent=new Intent(this, ConexionesActivity.class);
        //intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
        finish();
    }


    /**
     * Final de navecación entre actividades
     *
     */








    /**
     *
     * Modelo
     */
    private void actualizarConexion(int id){
        Sqlite sqlite=new Sqlite(this);
        String alias, usuario, password, host,mac;
        int puerto;
        alias=editTextAlias.getText().toString().trim();
        usuario=editTextUsuario.getText().toString().trim();
        password=editTextPassword.getText().toString().trim();
        host=editTextHost.getText().toString().trim();
        mac=editTextMac.getText().toString().trim();
        puerto=Integer.parseInt(editTextPuerto.getText().toString().trim());
        sqlite.updateConexion(id, alias,usuario,password,host,mac,puerto);
        sqlite.close();
        probarEstadoConexion();
        //irAConexiones();
    }
    private void eliminarConexion(int id){
        Log.d("Mensaje","Mensaje dentro de update "+id);
        Sqlite sqlite=new Sqlite(this);
        sqlite.deleteConexion(id);
        sqlite.close();
        Toast.makeText(this, "Conexión borrada", Toast.LENGTH_LONG).show();
        irAConexiones();
    }
    /**
     * Final del modelo
     */









}



