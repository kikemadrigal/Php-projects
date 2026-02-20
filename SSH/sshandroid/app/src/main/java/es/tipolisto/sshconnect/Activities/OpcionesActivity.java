package es.tipolisto.sshconnect.Activities;

import android.content.Context;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.preference.PreferenceActivity;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Switch;
import android.widget.TextView;
import android.widget.Toast;

import es.tipolisto.sshconnect.Activities.Conexiones.ConexionesActivity;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.Util;

public class OpcionesActivity extends AppCompatActivity {
    private String servidor;
    private boolean modoCodeigniter;
    private TextView textViewServidor,textViewModoCodeigniter;
    private Switch switchModoCodeigniter;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_opciones);
        Util.crearToolbar(OpcionesActivity.this);
        //addPreferencesFromResource(R.xml.opciones);
        final SharedPreferences prefs =getSharedPreferences("MisPreferencias",Context.MODE_PRIVATE);
        servidor = prefs.getString("servidor", "http://localhost/ssh/api");
        modoCodeigniter=prefs.getBoolean("modoCodeigniter", false);

        textViewServidor=findViewById(R.id.textViewOpcionesActivity);
        textViewModoCodeigniter=findViewById(R.id.textViewModoCodeigniterOpcionesActivity);
        switchModoCodeigniter=findViewById(R.id.switchOpcionesActivity);
        switchModoCodeigniter.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SharedPreferences.Editor editor = prefs.edit();
                if(switchModoCodeigniter.isChecked()){
                    editor.putBoolean("modoCodeigniter", true);
                    textViewModoCodeigniter.setText("Modo codeignitr activado");
                }else{
                    editor.putBoolean("modoCodeigniter", false);
                    textViewModoCodeigniter.setText("Modo codeignitr desactivado");
                }
                editor.commit();
            }
        });
        if(modoCodeigniter){
            textViewModoCodeigniter.setText("Modo codeigniter activado");
            switchModoCodeigniter.setChecked(true);
        }else{
            textViewModoCodeigniter.setText("Modo codeignitr desactivado");
            switchModoCodeigniter.setChecked(false);
        }
        Button buttonServidor=findViewById(R.id.buttonOpcionesActivity);
        buttonServidor.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                abrirDialogoPreguntandoPorServidor();
            }
        });
        Button probarComunicacion=findViewById(R.id.buttonProbarComunicacionOpcionesActivity);
        probarComunicacion.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                boolean resultadoPing=Util.executeCommandPing(textViewServidor.getText().toString());
                if(resultadoPing){
                    Util.crearToast(OpcionesActivity.this, "Se obtuvo respuesta del servidor");
                }else{
                    Util.crearToast(OpcionesActivity.this, "No hubo respuesta del servidor");
                }
            }
        });




        textViewServidor.setText(servidor);
    }

    /**
     *
     * Ejemplo añadir preferencias
     *
     */
    /*
    public void comprobarPreferencias(){
        SharedPreferences prefs = getSharedPreferences("MisPreferencias", Context.MODE_PRIVATE);
            String direccionServidor=prefs.getString("servidor", "");
            if(TextUtils.isEmpty(direccionServidor)){
                SharedPreferences prefs =
                        getSharedPreferences("MisPreferencias",Context.MODE_PRIVATE);

                SharedPreferences.Editor editor = prefs.edit();
                editor.putBoolean("modoCodeigniter", false);
                editor.commit();
        }
    }*/



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


    private void abrirDialogoPreguntandoPorServidor(){
        LayoutInflater inflater = LayoutInflater.from(OpcionesActivity.this);
        View subView = inflater.inflate(R.layout.dialog_server, null);

        final EditText editTextServidor = (EditText)subView.findViewById(R.id.editTextDialogServer);
        editTextServidor.setText(textViewServidor.getText().toString());

        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("Servidor");
        builder.setMessage("Cambia la dirección del servidor");
        builder.setView(subView);
        AlertDialog alertDialog = builder.create();

        builder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                SharedPreferences prefs =
                        getSharedPreferences("MisPreferencias", Context.MODE_PRIVATE);

                SharedPreferences.Editor editor = prefs.edit();
                editor.putString("servidor", editTextServidor.getText().toString());
                editor.commit();

                textViewServidor.setText(editTextServidor.getText().toString());

            }
        });

        builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                Toast.makeText(OpcionesActivity.this, "Cancelado", Toast.LENGTH_LONG).show();
            }
        });

        builder.show();
    }
}
