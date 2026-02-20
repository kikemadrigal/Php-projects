package es.tipolisto.sshconnect.Activities.Comandos;

import android.content.Intent;
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

import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.RetrofitClient;
import es.tipolisto.sshconnect.Utils.Util;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class InsertComandoActivity extends AppCompatActivity implements View.OnClickListener {
    private EditText editTextNombre, editTextDatos;
    private TextView textViewNombre, textViewDatos;
    private Button buttonInsertar, buttonVolver;
    private EditText[] editTexts;
    private TextView[] textViews;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_insert_comando);
        Util.crearToolbar(this);

        editTextNombre=findViewById(R.id.editTextNombreInsertComandoActivity);
        editTextDatos=findViewById(R.id.editTextDatosInsertComandoActivity);

        textViewNombre=findViewById(R.id.textViewMensajeNombreInsertComandoActivity);
        textViewDatos=findViewById(R.id.textViewMensajeDatosInsertComandoActivity);
        buttonInsertar=findViewById(R.id.buttonInsertarInsertComandoActivity);
        buttonVolver=findViewById(R.id.buttonVolverInsertComandoActivity);
        buttonInsertar.setOnClickListener(this);
        buttonVolver.setOnClickListener(this);
        editTexts=new EditText[2];

        editTexts[0]=editTextNombre;
        editTexts[1]=editTextDatos;
        textViews=new TextView[2];

        textViews[0]=textViewNombre;
        textViews[1]=textViewDatos;
    }



    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.buttonInsertarInsertComandoActivity:
                ponerTextViewsEnBlanco();
                ponerMensajeDeErrorEnTextViews();
                boolean hayError=comprobarAlgunMensajeEnTextView();
                if(!hayError){
                    insertarConRetrofit();
                }
                break;
            case R.id.buttonVolverInsertComandoActivity:
                Intent intent=new Intent(InsertComandoActivity.this, ComandosActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                finish();
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
    private void insertarConRetrofit(){
        Call<String> callInsertarComando=null;
        if(Util.estaModoCodeigniter(this)){
            callInsertarComando= RetrofitClient.getServiceISSHCode(InsertComandoActivity.this).insertarComando(editTextNombre.getText().toString(),editTextDatos.getText().toString());
        }else{
            callInsertarComando= RetrofitClient.getServiceISSH(InsertComandoActivity.this).insertarComando(editTextNombre.getText().toString(),editTextDatos.getText().toString());
        }
        callInsertarComando.enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                if(response!=null){
                    Toast.makeText(InsertComandoActivity.this, response.body(), Toast.LENGTH_LONG).show();
                    Intent intent=new Intent(InsertComandoActivity.this, ComandosActivity.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    startActivity(intent);
                }else{
                    Toast.makeText(InsertComandoActivity.this, "No se obtuvo una respuesta del servidor", Toast.LENGTH_LONG).show();
                }
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {
                Toast.makeText(InsertComandoActivity.this, "Hubo un problema al insertar nuevo cliente: "+t.getMessage(), Toast.LENGTH_LONG).show();
                Log.d("Mensaje", "Error: "+t.getMessage());
            }
        });
    }





}
