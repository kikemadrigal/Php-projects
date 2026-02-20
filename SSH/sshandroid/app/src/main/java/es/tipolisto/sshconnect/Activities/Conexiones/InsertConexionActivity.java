package es.tipolisto.sshconnect.Activities.Conexiones;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import es.tipolisto.sshconnect.Models.Conexion;
import es.tipolisto.sshconnect.Models.Sqlite;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.Util;

public class InsertConexionActivity extends AppCompatActivity {
    private Conexion conexion;
    private EditText editTextAlias,editTextUsuario,editTextPassword, editTextHost, editTextMac, editTextPuerto;
    private TextView textViewMensajeAlias, textViewMensajeUsuario, textViewMensajePassword,textViewMensajeHost,textViewMensajeMac,textViewMensajePuerto;

    private EditText[] editTexts;
    private TextView[] textViews;



    Button buttonCrear, buttonVolver;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_insert_conexion);
        Util.crearToolbar(this);

        obtenerEditText();
        buttonCrear=findViewById(R.id.buttonCrearInsertConexion);
        buttonCrear.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                boolean hayError=false;
                ponerTextViewsEnBlanco();
                ponerMensajeDeErrorEnTextViews();
                comprobarAlgunMensajeEnTextView();
                if(!hayError){
                    crearNuevaConexion();
                }
                else {
                    //Util.crearToast(InsertConexionActivity.this, "Hay mensajes de error");
                    Log.d("Mesnaje", "hay un error");
                }
            }
        });
        buttonVolver=findViewById(R.id.buttonVolverInsertConexion);
        buttonVolver.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(getApplicationContext(), ConexionesActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TASK);
                startActivity(intent);
                finish();
            }
        });

        Bundle extras=getIntent().getExtras();


        if(extras!=null){

            String ipHost=extras.getString("iphost","");
            editTextHost.setText(ipHost);
        }

    }

    private void obtenerEditText(){
        editTextAlias=findViewById(R.id.editTextAliasInsertConexion);
        editTextAlias.setOnKeyListener(new View.OnKeyListener() {
            @Override
            public boolean onKey(View v, int keyCode, KeyEvent event) {
                textViewMensajeAlias.setText("");
                return false;
            }
        });
        editTextUsuario=findViewById(R.id.editTextUsuarioInsertConexion);
        editTextUsuario.setOnKeyListener(new View.OnKeyListener() {
            @Override
            public boolean onKey(View v, int keyCode, KeyEvent event) {
                textViewMensajeUsuario.setText("");
                return false;
            }
        });
        editTextPassword=findViewById(R.id.editTextPasswordInsertConexion);
        editTextPassword.setOnKeyListener(new View.OnKeyListener() {
            @Override
            public boolean onKey(View v, int keyCode, KeyEvent event) {
                textViewMensajePassword.setText("");
                return false;
            }
        });
        editTextHost=findViewById(R.id.editTextHostInsertConexion);
        editTextHost.setOnKeyListener(new View.OnKeyListener() {
            @Override
            public boolean onKey(View v, int keyCode, KeyEvent event) {
                textViewMensajeHost.setText("");
                return false;
            }
        });
        editTextMac=findViewById(R.id.editTextMacInsertConexion);
        editTextMac.setOnKeyListener(new View.OnKeyListener() {
            @Override
            public boolean onKey(View v, int keyCode, KeyEvent event) {
                textViewMensajeMac.setText("");
                return false;
            }
        });
        editTextPuerto=findViewById(R.id.editTextPuertoInsertConexion);
        editTextPuerto.setOnKeyListener(new View.OnKeyListener() {
            @Override
            public boolean onKey(View v, int keyCode, KeyEvent event) {
                textViewMensajePuerto.setText("");
                return false;
            }
        });

        textViewMensajeAlias=findViewById(R.id.textViewMensajeAliasInsertActivity);
        textViewMensajeUsuario=findViewById(R.id.textViewMensajeUsuarioInsertActivity);
        textViewMensajePassword=findViewById(R.id.textViewMensajePasswordInsertActivity);
        textViewMensajeHost=findViewById(R.id.textViewMensajeHosttInsertActivity);
        textViewMensajeMac=findViewById(R.id.textViewMensajeMacInsertActivity);
        textViewMensajePuerto=findViewById(R.id.textViewMensajePuertoInsertActivity);

        editTexts=new EditText[4];
        editTexts[0]=editTextAlias;
        editTexts[1]=editTextUsuario;
        //El password se puede dejar vacío
        //editTexts[2]=editTextPassword;
        editTexts[2]=editTextHost;
        //El mac no lo metemos aqui porque esto es para la validacion
        editTexts[3]=editTextPuerto;

        textViews=new TextView[4];
        textViews[0]=textViewMensajeAlias;
        textViews[1]=textViewMensajeUsuario;
        //El password se puede dejar vacío
        //textViews[2]=textViewMensajePassword;
        textViews[2]=textViewMensajeHost;
        //El mac no lo metemos aqui porque esto es para la validacion
        textViews[3]=textViewMensajePuerto;
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

    private void crearNuevaConexion(){

        Sqlite sqlite=new Sqlite(this);
        String alias=editTextAlias.getText().toString().trim();
        String usuario=editTextUsuario.getText().toString().trim();
        String password=editTextPassword.getText().toString().trim();
        String host=editTextHost.getText().toString().trim();
        String mac=editTextMac.getText().toString().trim();
        String puertoTexto=editTextPuerto.getText().toString();
        int puerto=0;
        if(!puertoTexto.equalsIgnoreCase("") && TextUtils.isDigitsOnly(puertoTexto)){
            puerto=22;
            long resultado=sqlite.insertarConewxion(alias,usuario,password,host, mac,puerto);
            if(resultado>0){
                Toast.makeText(this, "Se lrealizó la inserción de la nueva conexión.", Toast.LENGTH_SHORT).show();
                Intent intent=new Intent(getApplicationContext(), ConexionesActivity.class);
                //intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TASK);
                startActivity(intent);
                finish();
            }else{
                Toast.makeText(this, "No se realizó la inserción "+resultado, Toast.LENGTH_LONG).show();

            }
        }else{
            textViewMensajePuerto.setText("No es un número");
            //puerto=Integer.parseInt(puertoTexto);
           // Log.d("Mensaje", "El valor es "+puertoTexto+", entero: "+puerto);
        }


    }




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
                Log.d("Mensaje", "Error rncontrado ");
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
                textViews[i].setText("El campo no puede estar vacío");;
                Log.d("Mensaje", "El campo no puede estar vacio "+i);
            }
        }
    }


}
