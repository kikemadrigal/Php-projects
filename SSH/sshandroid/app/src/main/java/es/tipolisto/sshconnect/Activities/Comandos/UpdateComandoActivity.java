package es.tipolisto.sshconnect.Activities.Comandos;

import android.content.DialogInterface;
import android.content.Intent;
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
import android.widget.TextView;
import android.widget.Toast;

import es.tipolisto.sshconnect.Models.Comando;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.RetrofitClient;
import es.tipolisto.sshconnect.Utils.Util;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class UpdateComandoActivity extends AppCompatActivity implements View.OnClickListener {
    private EditText editTextNombre, editTextDatos;
    private TextView textViewNombre, textViewDatos, textViewResultadosComandosDeUnCliente;
    private Button buttonActualizar, buttonVolver, buttonEliminar;
    private EditText[] editTexts;
    private TextView[] textViews;
    private int id;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_comando);
        Util.crearToolbar(this);

        editTextNombre=findViewById(R.id.editTextNombreComandoUpdateActivity);
        editTextDatos=findViewById(R.id.editTextDatosComandoUpdateActivity);

        textViewNombre=findViewById(R.id.textViewMensajeNombreComandoUpdateActivity);
        textViewDatos=findViewById(R.id.textViewMensajeDatosComandoUpdateActivity);

        buttonActualizar=findViewById(R.id.buttonActualizarComandoUpdateActivity);
        buttonVolver=findViewById(R.id.buttonVolverComandoUpdateActivity);
        buttonEliminar=findViewById(R.id.buttonEliminarComandoUpdateActivity);

        buttonActualizar.setOnClickListener(this);
        buttonVolver.setOnClickListener(this);
        buttonEliminar.setOnClickListener(this);
        editTexts=new EditText[2];
        editTexts[0]=editTextNombre;
        editTexts[1]=editTextDatos;

        textViews=new TextView[2];
        textViews[0]=textViewNombre;
        textViews[1]=textViewDatos;


        Bundle extras = getIntent().getExtras();
        if(extras!=null){
            id = extras.getInt("id",0);
            if(id!=0)obtenerUnComandoYRellenarEditTextsConRetrofit();
        }


    }

    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.buttonActualizarComandoUpdateActivity:
                Log.d("Mensaje", "click en ver comandos: " + id);
                if (getIntent().getExtras() != null) {
                    ponerTextViewsEnBlanco();
                    ponerMensajeDeErrorEnTextViews();
                    boolean hayError=comprobarAlgunMensajeEnTextView();
                    if(!hayError) {
                        actualizarComandoConRetrofit();
                    }
                } else {
                    Toast.makeText(UpdateComandoActivity.this, "No se ha recibido el cliente.", Toast.LENGTH_LONG).show();
                }
                break;
            case R.id.buttonVolverComandoUpdateActivity:
                Intent intent = new Intent(UpdateComandoActivity.this, ComandosActivity.class);
                startActivity(intent);
                finish();
                break;
            case R.id.buttonEliminarComandoUpdateActivity:
                android.support.v7.app.AlertDialog.Builder builder = new AlertDialog.Builder(UpdateComandoActivity.this);
                builder.setTitle("Advertencia");
                builder.setMessage("¿Está seguro de que desea eliminarlo?");
                //builder.setCancelable(true);
                builder.setPositiveButton("Ok", new DialogInterface.OnClickListener() {

                    public void onClick(DialogInterface dialog, int id) {
                        eliminarComandoConRetrofit();
                        dialog.cancel();
                    }
                });
                builder.create().show();
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
     *
     * Retrofit
     *
     */
    private void obtenerUnComandoYRellenarEditTextsConRetrofit() {
        Log.d("Mensaje", "pasa por rellenar");
        ////http://ssh.tipolisto.es/api/cliente/mostrarUnComando.php?id=8
        if (getIntent().getExtras() == null) {
            Toast.makeText(UpdateComandoActivity.this, "No hay comando para escribir en editTexts", Toast.LENGTH_LONG).show();
        }else{
            Call<Comando> callComando=null;
            if(Util.estaModoCodeigniter(this)){
                callComando= RetrofitClient.getServiceISSHCode(UpdateComandoActivity.this).mostrarUnComando(id);
            }else{
                callComando= RetrofitClient.getServiceISSH(UpdateComandoActivity.this).mostrarUnComando(id);
            }
            callComando.enqueue(new Callback<Comando>() {
                @Override
                public void onResponse(Call<Comando> call, Response<Comando> response) {
                    Comando comando=response.body();
                    Log.d("Mensaje","respuesta al obetener un comando "+response.body());
                    if(comando==null){
                        Toast.makeText(UpdateComandoActivity.this, "No se ha podido reibir el comando", Toast.LENGTH_LONG).show();
                    }else{
                        editTextNombre.setText(""+comando.getNombre());
                        editTextDatos.setText(""+comando.getDatos());
                    }
                }

                @Override
                public void onFailure(Call<Comando> call, Throwable t) {
                    Toast.makeText(UpdateComandoActivity.this, "Hubo un fallo: "+t.getMessage(), Toast.LENGTH_LONG).show();
                    Log.d("Mensaje", "hubo un error al obtener un comando:"+t.getMessage());
                }
            });
        }
    }

    private void actualizarComandoConRetrofit(){
        if(getIntent().getExtras()==null) {
            Toast.makeText(UpdateComandoActivity.this, "No hay comando para actualizar", Toast.LENGTH_SHORT).show();
        }else{
            Call<String> callActualizar=null;
            if(Util.estaModoCodeigniter(this)){
                callActualizar=RetrofitClient.getServiceISSHCode(UpdateComandoActivity.this).actualizarComando(id, editTextNombre.getText().toString(), editTextDatos.getText().toString());
            }else{
                callActualizar=RetrofitClient.getServiceISSH(UpdateComandoActivity.this).actualizarComando(id, editTextNombre.getText().toString(), editTextDatos.getText().toString());
            }
            callActualizar.enqueue(new Callback<String>() {
                @Override
                public void onResponse(Call<String> call, Response<String> response) {
                    Log.d("Mensaje", "Mensjae al actualziar:  "+response.toString());
                    if(response!=null){
                        Toast.makeText(UpdateComandoActivity.this, response.body(), Toast.LENGTH_SHORT).show();
                    }else{
                        Toast.makeText(UpdateComandoActivity.this, "No se obtuvo una respuesta del servidor", Toast.LENGTH_SHORT).show();
                    }

                }

                @Override
                public void onFailure(Call<String> call, Throwable t) {
                    Toast.makeText(UpdateComandoActivity.this, "Hubo un problema al actualizar: "+t.getMessage(), Toast.LENGTH_SHORT).show();
                    Log.d("Mensaje", "Error al actualizar: "+t.getMessage());
                }
            });
        }
    }
    private void eliminarComandoConRetrofit(){
        if(getIntent().getExtras()==null) {
            Toast.makeText(UpdateComandoActivity.this, "No hay clinete para actualizar", Toast.LENGTH_SHORT).show();
        }else{
            Call<String> callEliminarComando=null;
            if(Util.estaModoCodeigniter(this)){
                callEliminarComando=RetrofitClient.getServiceISSHCode(UpdateComandoActivity.this).eliminarComando(id);
            }else{
                callEliminarComando=RetrofitClient.getServiceISSH(UpdateComandoActivity.this).eliminarComando(id);
            }
            callEliminarComando.enqueue(new Callback<String>() {
                @Override
                public void onResponse(Call<String> call, Response<String> response) {
                    Log.d("Mensaje", "Mensjae al eliminar:  "+response.toString());
                    Toast.makeText(UpdateComandoActivity.this, response.body(), Toast.LENGTH_LONG).show();
                    Intent intent=new Intent(UpdateComandoActivity.this, ComandosActivity.class);
                    startActivity(intent);
                    finish();
                }

                @Override
                public void onFailure(Call<String> call, Throwable t) {
                    Toast.makeText(UpdateComandoActivity.this, "Hubo n problema al actualizar: "+t.getMessage(), Toast.LENGTH_LONG).show();
                    Log.d("Mensaje", "Error al eliminar: "+t.getMessage());
                }
            });
        }
    }
}
