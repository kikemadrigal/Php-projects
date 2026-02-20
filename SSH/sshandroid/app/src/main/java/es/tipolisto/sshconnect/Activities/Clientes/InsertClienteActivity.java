package es.tipolisto.sshconnect.Activities.Clientes;

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

import es.tipolisto.sshconnect.Activities.Comandos.ComandosActivity;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.RetrofitClient;
import es.tipolisto.sshconnect.Utils.Util;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class InsertClienteActivity extends AppCompatActivity implements View.OnClickListener {
    private EditText editTextCif, editTextNombre, editTextDatos;
    private TextView textViewCif, textViewNombre, textViewDatos, textViewResultadosComandosDeUnCliente;
    private Button buttonInsertar, buttonVolver;
    private EditText[] editTexts;
    private TextView[] textViews;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_insert_cliente);
        Util.crearToolbar(this);

        editTextCif=findViewById(R.id.editTextCifInsertClienteActivity);
        editTextNombre=findViewById(R.id.editTextNombreInsertClienteActivity);
        editTextDatos=findViewById(R.id.editTextDatosInsertClienteActivity);
        textViewCif=findViewById(R.id.textViewMensajeCifInsertClienteActivity);
        textViewNombre=findViewById(R.id.textViewMensajeNombreInsertClienteActivity);
        textViewDatos=findViewById(R.id.textViewMensajeDatosInsertClienteActivity);
        buttonInsertar=findViewById(R.id.buttonInsertarInsertClienteActivity);
        buttonVolver=findViewById(R.id.buttonVolverInsertClienteActivity);
        buttonInsertar.setOnClickListener(this);
        buttonVolver.setOnClickListener(this);
        editTexts=new EditText[3];
        editTexts[0]=editTextCif;
        editTexts[1]=editTextNombre;
        editTexts[2]=editTextDatos;
        textViews=new TextView[3];
        textViews[0]=textViewCif;
        textViews[1]=textViewNombre;
        textViews[2]=textViewDatos;


    }


    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.buttonInsertarInsertClienteActivity:
                ponerTextViewsEnBlanco();
                ponerMensajeDeErrorEnTextViews();
                boolean hayError=comprobarAlgunMensajeEnTextView();
                if(!hayError){
                    insertarConRetrofit();
                }
                break;
            case R.id.buttonVolverInsertClienteActivity:
                Intent intent=new Intent(InsertClienteActivity.this, ClientesActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
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
        Call<String> callInsertarCliente=null;
        if(Util.estaModoCodeigniter(this)){
            callInsertarCliente= RetrofitClient.getServiceISSHCode(InsertClienteActivity.this).insertarCliente(editTextCif.getText().toString(), editTextNombre.getText().toString(),editTextDatos.getText().toString());

        }else{
            callInsertarCliente= RetrofitClient.getServiceISSH(InsertClienteActivity.this).insertarCliente(editTextCif.getText().toString(), editTextNombre.getText().toString(),editTextDatos.getText().toString());

        }
        callInsertarCliente.enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                if(response!=null){
                    Toast.makeText(InsertClienteActivity.this, response.body(), Toast.LENGTH_LONG).show();
                    Intent intent=new Intent(InsertClienteActivity.this, ClientesActivity.class);
                    startActivity(intent);
                }else{
                    Toast.makeText(InsertClienteActivity.this, "No se obtuvo una respuesta del servidor", Toast.LENGTH_LONG).show();
                }
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {
                Toast.makeText(InsertClienteActivity.this, "Hubo un problema al insertar nuevo cliente: "+t.getMessage(), Toast.LENGTH_LONG).show();
                Log.d("Mensaje", "Error: "+t.getMessage());
            }
        });
    }

}
