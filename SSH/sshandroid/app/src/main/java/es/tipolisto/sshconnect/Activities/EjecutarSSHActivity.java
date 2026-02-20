package es.tipolisto.sshconnect.Activities;

import android.Manifest;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.os.Environment;
import android.support.v4.app.NavUtils;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.jcraft.jsch.JSch;
import com.jcraft.jsch.Session;
import com.jcraft.jsch.UIKeyboardInteractive;
import com.jcraft.jsch.UserInfo;

import java.io.File;
import java.util.ArrayList;
import java.util.List;


import es.tipolisto.sshconnect.Activities.Conexiones.ConexionesActivity;
import es.tipolisto.sshconnect.Activities.Conexiones.UpdateConexionActivity;
import es.tipolisto.sshconnect.Models.Cliente;
import es.tipolisto.sshconnect.Models.ClienteComando;
import es.tipolisto.sshconnect.Models.Comando;
import es.tipolisto.sshconnect.Models.Conexion;
import es.tipolisto.sshconnect.Models.Sqlite;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.JschClient;
import es.tipolisto.sshconnect.Utils.RetrofitClient;
import es.tipolisto.sshconnect.Utils.Util;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;


public class EjecutarSSHActivity extends AppCompatActivity implements View.OnClickListener {
    private EditText editTextComand;
    private TextView textViewTitulo, textViewResultados;
    private Button botonEjecutarSSH;
    Spinner spinnerComando,spinnerComandosPorCliente;
    //String valorItemSpinner;
    Conexion conexion;
    Boolean estadoConexion;
    int id;

    private static final int TIEMPO_DE_CONEXION = 2;
    private final int MY_PERMISSIONS_REQUEST_EXTERNAL_SD=103;
    //ProgressBar progressBar;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_ejecutar_ssh);
        Util.crearToolbar(this);

        conexion = null;
        estadoConexion=false;
        editTextComand = findViewById(R.id.editTextCommandEjecutarSSHActivity);
        textViewTitulo=findViewById(R.id.textViewTituloEjecutarSshActivity);
        textViewResultados = findViewById(R.id.textViewResultadoEjecutaSSHActivity);
        spinnerComando=findViewById(R.id.spinnerComandosEjecutarAcitivity);
        spinnerComandosPorCliente=findViewById(R.id.spinnerComandosPorClienteEjecutarAcitivity);
        botonEjecutarSSH = findViewById(R.id.botonEjecutarActivity);
        botonEjecutarSSH.setOnClickListener(this);

        Bundle extras = getIntent().getExtras();
        id = extras.getInt("id", 0);
        if (extras != null && id != 0) {
            Sqlite sqlite = new Sqlite(getApplicationContext());
            conexion = sqlite.selectUnaConexion(id);
            sqlite.close();
            textViewTitulo.setText(conexion.getUsuario()+"@"+conexion.getHost());
            probarEstadoConexion();
            Util.hideKeyboard(EjecutarSSHActivity.this);
            //Probamos la comunicación con el servidor
            final SharedPreferences prefs =getSharedPreferences("MisPreferencias", Context.MODE_PRIVATE);
            String servidor = prefs.getString("servidor", "http://localhost/ssh/api");
            if(Util.executeCommandPing(servidor)){
                spinnerComando.setVisibility(View.VISIBLE);
                spinnerComandosPorCliente.setVisibility(View.VISIBLE);
                rellenarSpinnerComandosPorClienteYEjecutarAlSeleccionar();
                rellenarSpinnerYEjecutarComandoAlSeleccionar();
                //Si no hay comunicación con el servidor ocultamos los spinner
            }else{
                spinnerComando.setVisibility(View.GONE);
                spinnerComandosPorCliente.setVisibility(View.GONE);
            }

        } else {
            textViewResultados.setText("Hubo un error yno sepuede realizarla conexión");
        }
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.botonEjecutarActivity:
                textViewResultados.setText("");
                if(editTextComand.getText().toString().equalsIgnoreCase("")){
                    Toast.makeText(EjecutarSSHActivity.this, "Debes de introducir un comando.", Toast.LENGTH_LONG).show();
                }else{
                    if(estadoConexion){
                        final ProgressDialog progressDialog=new ProgressDialog(EjecutarSSHActivity.this);
                        progressDialog.setMessage("Ejecutando consulta.");
                        progressDialog.setCancelable(false);
                        progressDialog.show();

                        JschClient jschClient=new JschClient(EjecutarSSHActivity.this, conexion, textViewResultados, editTextComand);
                        jschClient.conectarYEjecutarComando(progressDialog);
                        //estadoConexion=jschClient.isEstadoConexion();

                        probarEstadoConexion();
                        Util.hideKeyboard(EjecutarSSHActivity.this);
                    }else{
                        Toast.makeText(EjecutarSSHActivity.this, "Hubo un problema con la coexión.", Toast.LENGTH_SHORT).show();
                    }
                }
                //Log.d("Mensaje", "Click en ejecutar");
                break;
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








    private void rellenarSpinnerYEjecutarComandoAlSeleccionar(){
        //Rellenamos el spinner con los datos obtenidos de retorfit
        final ProgressDialog progressDialog=new ProgressDialog(this);
        progressDialog.setMessage("Ejecutando consulta.");
        progressDialog.show();
        Call<List<Comando>> callComandos=null;
        if(Util.estaModoCodeigniter(this)){
            callComandos= RetrofitClient.getServiceISSHCode(EjecutarSSHActivity.this).mostrarComandos();

        }else{
            callComandos= RetrofitClient.getServiceISSH(EjecutarSSHActivity.this).mostrarComandos();
        }
        callComandos.enqueue(new Callback<List<Comando>>() {
            ArrayList<String> arrayListComandos=new ArrayList<>();

            @Override
            public void onResponse(Call<List<Comando>> call, Response<List<Comando>> response) {
                arrayListComandos.add("Elige un comando");
                for (Comando comando : response.body()){
                    arrayListComandos.add(comando.getNombre());
                }
                ArrayAdapter arrayAdapter=new ArrayAdapter(EjecutarSSHActivity.this, android.R.layout.simple_spinner_item, arrayListComandos);
                spinnerComando.setAdapter(arrayAdapter);
                progressDialog.dismiss();
            }

            @Override
            public void onFailure(Call<List<Comando>> call, Throwable t) {
                progressDialog.dismiss();
            }
        });
        //Le añadimos al spinner un escuchador de eventos, al hacer click ejecutar el ssh
        spinnerComando.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int pos, long id)
            {
                if(pos!=0){
                    //Creamos un progressdialog para que el usuario no se piense que no funciona
                    final ProgressDialog progressDialog=new ProgressDialog(EjecutarSSHActivity.this);
                    progressDialog.setMessage("Ejecutando consulta.");
                    progressDialog.setCancelable(false);
                    progressDialog.show();
                    textViewResultados.setText("");
                    String valorItemSpinner=(String) adapterView.getItemAtPosition(pos);
                    JschClient jschClient=new JschClient(EjecutarSSHActivity.this, conexion, textViewResultados, editTextComand);
                    jschClient.conectarYEjecutarComandoConSpinner(progressDialog,valorItemSpinner);
                    //estadoConexion=jschClient.isEstadoConexion();
                    Util.hideKeyboard(EjecutarSSHActivity.this);
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent)
            {

            }
        });
    }



    private void rellenarSpinnerComandosPorClienteYEjecutarAlSeleccionar(){
        final ProgressDialog progressDialog=new ProgressDialog(this);
        progressDialog.setMessage("Ejecutando consulta.");
        progressDialog.show();
        final ArrayList<Cliente> arrayListClientes=new ArrayList<>();
        arrayListClientes.add(0,new Cliente(0,"", "Elige un Cliente",""));
        final ArrayList<String> arrayListClientesString=new ArrayList<>();
        Call<List<Cliente>> callClientes=null;
        if(Util.estaModoCodeigniter(this)){
            callClientes= RetrofitClient.getServiceISSHCode(EjecutarSSHActivity.this).mostrarClientes();
        }else{
            callClientes= RetrofitClient.getServiceISSH(EjecutarSSHActivity.this).mostrarClientes();
        }
        callClientes.enqueue(new Callback<List<Cliente>>() {
            @Override
            public void onResponse(Call<List<Cliente>> call, Response<List<Cliente>> response) {
                for (Cliente cliente: response.body()){
                    arrayListClientes.add(cliente);
                    //arrayListClientesString.add(cliente.getNombre());
                }
                ArrayAdapter<Cliente> arrayAdapter=new ArrayAdapter<Cliente>(EjecutarSSHActivity.this, android.R.layout.simple_spinner_item, arrayListClientes);
                spinnerComandosPorCliente.setAdapter(arrayAdapter);
                progressDialog.dismiss();
            }

            @Override
            public void onFailure(Call<List<Cliente>> call, Throwable t) {
                progressDialog.dismiss();
            }
        });


        spinnerComandosPorCliente.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int pos, long id)
            {
                //Log.d("Mensaje", "click en espenier");
                if(pos!=0){
                    textViewResultados.setText("");
                    final Cliente cliente=(Cliente) adapterView.getItemAtPosition(pos);
                    //Obtenmos los camndos del cliente
                    Call<List<ClienteComando>> callClienteComando=null;
                    if(Util.estaModoCodeigniter(getApplicationContext())){
                        callClienteComando= RetrofitClient.getServiceISSHCode(EjecutarSSHActivity.this).mostrarComandosDeUnCliente(cliente.getId());
                    }else{
                        callClienteComando= RetrofitClient.getServiceISSH(EjecutarSSHActivity.this).mostrarComandosDeUnCliente(cliente.getId());
                    }
                    callClienteComando.enqueue(new Callback<List<ClienteComando>>() {
                        @Override
                        public void onResponse(Call<List<ClienteComando>> call, Response<List<ClienteComando>> response) {
                            final List<ClienteComando> clienteComandos=response.body();
                            String mensaje="";
                            for(ClienteComando clienteComando: clienteComandos){
                                mensaje+=clienteComando.getNombre()+" && ";
                                Log.d("Mensaje",clienteComando.getNombre());
                            }
                            if(mensaje.length()>0 && mensaje!=null && !mensaje.equalsIgnoreCase("")){
                                mensaje=mensaje.substring(0,mensaje.length()-3);
                                Toast.makeText(EjecutarSSHActivity.this, "Enviado: "+mensaje, Toast.LENGTH_LONG).show();
                                final ProgressDialog progressDialog=new ProgressDialog(EjecutarSSHActivity.this);
                                progressDialog.setMessage("Ejecutando consulta.");
                                progressDialog.setCancelable(false);
                                progressDialog.show();
                                JschClient jschClient=new JschClient(EjecutarSSHActivity.this, conexion, textViewResultados, editTextComand);
                                jschClient.conectarYEjecutarComandoConSpinner(progressDialog,mensaje);
                                //estadoConexion=jschClient.isEstadoConexion();
                            }else{
                                Toast.makeText(EjecutarSSHActivity.this, "Sin comandos", Toast.LENGTH_LONG).show();
                            }
                            Util.hideKeyboard(EjecutarSSHActivity.this);
                            Log.d("Mensaje", "Bien");
                        }

                        @Override
                        public void onFailure(Call<List<ClienteComando>> call, Throwable t) {
                            Log.d("Mensaje", "Mal");
                        }
                    });
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent)
            {

            }
        });
    }




    /**
     * Inicio Jsch
     */
    public void probarEstadoConexion(){
        new Thread(new Runnable() {
            @Override
            public void run() {
                try{
                    final JSch jSch=new JSch();
                    int permissionCheckRead = ContextCompat.checkSelfPermission(EjecutarSSHActivity.this,
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
                    UpdateConexionActivity.MyUserInfo myUserInfo = new UpdateConexionActivity.MyUserInfo() {
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
                                            AlertDialog.Builder builder = new AlertDialog.Builder(EjecutarSSHActivity.this);
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

                    //Util.crearToast(EjecutarSSHActivity.this, "Conexión exitosa");
                    session.disconnect();
                    estadoConexion=true;
                }catch(Exception e){
                    //Util.crearToast(EjecutarSSHActivity.this, "Error: "+ e.getMessage());
                    Log.d("Mensaje","error: "+e.getMessage());
                    estadoConexion=false;
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





}
