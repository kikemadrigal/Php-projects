package es.tipolisto.sshconnect.Activities.Clientes;

import android.app.ProgressDialog;
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
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.google.gson.stream.JsonReader;

import java.util.List;

import es.tipolisto.sshconnect.Activities.Comandos.ComandosActivity;
import es.tipolisto.sshconnect.Adapters.ClienteComandosAdapter;
import es.tipolisto.sshconnect.Models.Cliente;
import es.tipolisto.sshconnect.Models.ClienteComando;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.RetrofitClient;
import es.tipolisto.sshconnect.Utils.Util;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class UpdateClienteActivity extends AppCompatActivity implements View.OnClickListener {
    private EditText editTextCif, editTextNombre, editTextDatos;
    private TextView textViewCif, textViewNombre, textViewDatos,textViewResultadoComandos;
    private Button buttonActualizar, buttonVolver, buttonEliminar, buttonVerComandos,buttonInsertarClienteComandos;
    private ListView listViewClienteComandos;
    private EditText[] editTexts;
    private TextView[] textViews;
    private int INTENT_FOR_RESULT_ELEGIR_COMANDO=200;

    private int id;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_cliente);
        Util.crearToolbar(this);

        editTextCif=findViewById(R.id.editTextCifClienteUpdateActivity);
        editTextNombre=findViewById(R.id.editTextNombreClienteUpdateActivity);
        editTextDatos=findViewById(R.id.editTextDatosClienteUpdateActivity);
        textViewCif=findViewById(R.id.textViewMensajeCifClienteUpdateActivity);
        textViewNombre=findViewById(R.id.textViewMensajeNombreClienteUpdateActivity);
        textViewDatos=findViewById(R.id.textViewMensajeDatosClienteUpdateActivity);
        textViewResultadoComandos=findViewById(R.id.textViewResultadoClientesComandosUpdateClienteActivity);

        buttonVerComandos=findViewById(R.id.buttonVerComandosClienteUpdateActivity);
        buttonInsertarClienteComandos=findViewById(R.id.buttonInsertarComandosClienteUpdateActivity);
        buttonActualizar=findViewById(R.id.buttonActualizarClienteUpdateActivity);
        buttonVolver=findViewById(R.id.buttonVolverClienteUpdateActivity);
        buttonEliminar=findViewById(R.id.buttonEliminarClienteUpdateActivity);
        listViewClienteComandos=findViewById(R.id.listViewClientesComandosUpdateClienteActivity);
        listViewClienteComandos.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                final ClienteComando clienteComando=(ClienteComando)parent.getItemAtPosition(position);
                android.support.v7.app.AlertDialog.Builder builder = new AlertDialog.Builder(UpdateClienteActivity.this);
                builder.setTitle("Advertencia");
                builder.setMessage("¿Está seguro de que desea eliminarlo?");
                //builder.setCancelable(true);
                builder.setPositiveButton("Ok", new DialogInterface.OnClickListener() {

                    public void onClick(DialogInterface dialog, int id) {
                        eliminarComandoClienteConRetrofit(clienteComando.getId());
                        //Toast.makeText(UpdateClienteActivity.this, "El id es "+clienteComando.getNombre(), Toast.LENGTH_SHORT).show();
                        //Log.d("Mensaje", "Cliente comando id: "+clienteComando.getId());
                        dialog.cancel();
                    }
                });
                builder.create().show();
            }
        });
        buttonVerComandos.setOnClickListener(this);
        buttonInsertarClienteComandos.setOnClickListener(this);
        buttonActualizar.setOnClickListener(this);
        buttonVolver.setOnClickListener(this);
        buttonEliminar.setOnClickListener(this);
        editTexts=new EditText[3];
        editTexts[0]=editTextCif;
        editTexts[1]=editTextNombre;
        editTexts[2]=editTextDatos;
        textViews=new TextView[3];
        textViews[0]=textViewCif;
        textViews[1]=textViewNombre;
        textViews[2]=textViewDatos;

        Bundle extras = getIntent().getExtras();
        if(extras!=null){
            id = extras.getInt("id",0);
            if(id!=0){
                rellenarEditTextsConRetrofit();
                rellenarListViewClienteComandos();
            }
        }


    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.buttonVerComandosClienteUpdateActivity:
                Log.d("Mensaje", "click en ver comandos: "+id);
                if(getIntent().getExtras()!=null) {
                    rellenarListViewClienteComandos();
                }else{
                    Toast.makeText(UpdateClienteActivity.this, "No se ha recibido el cliente.", Toast.LENGTH_LONG).show();
                }
                break;
            case R.id.buttonInsertarComandosClienteUpdateActivity:
                Toast.makeText(UpdateClienteActivity.this, "Selecciona el comando que quieres añadir.", Toast.LENGTH_LONG).show();
                Intent intent =new Intent(UpdateClienteActivity.this, ComandosActivity.class);
                intent.putExtra("modoElegirComando", true);
                startActivityForResult(intent,INTENT_FOR_RESULT_ELEGIR_COMANDO);
                break;
            case R.id.buttonActualizarClienteUpdateActivity:
                ponerTextViewsEnBlanco();
                ponerMensajeDeErrorEnTextViews();
                boolean hayError=comprobarAlgunMensajeEnTextView();
                if(!hayError){
                    actualizarClienteConRetrofit();
                }
                break;
            case R.id.buttonVolverClienteUpdateActivity:
                Intent intent2=new Intent(UpdateClienteActivity.this, ClientesActivity.class);
                startActivity(intent2);
                finish();
                break;
            case R.id.buttonEliminarClienteUpdateActivity:
                android.support.v7.app.AlertDialog.Builder builder = new AlertDialog.Builder(UpdateClienteActivity.this);
                builder.setTitle("Advertencia");
                builder.setMessage("¿Está seguro de que desea eliminarlo?");
                //builder.setCancelable(true);
                builder.setPositiveButton("Ok", new DialogInterface.OnClickListener() {

                    public void onClick(DialogInterface dialog, int id) {
                        eliminarClienteConRetrofit();
                        dialog.cancel();
                    }
                });
                builder.create().show();
                break;
        }
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if(resultCode==RESULT_OK ) {
            //Si viene de obtenerMatricula
            if (requestCode == INTENT_FOR_RESULT_ELEGIR_COMANDO) {
                final Bundle res = data.getExtras();
                //El id del comando elegido para añadirselo al cliente
                int idComando = res.getInt("id");
                Call<String> callInsertarClienteComando=null;
                if(Util.estaModoCodeigniter(this)){
                    callInsertarClienteComando=RetrofitClient.getServiceISSHCode(UpdateClienteActivity.this).insertarClienteComando(id, idComando);

                }else{
                    callInsertarClienteComando=RetrofitClient.getServiceISSH(UpdateClienteActivity.this).insertarClienteComando(id, idComando);
                }
                callInsertarClienteComando.enqueue(new Callback<String>() {
                    @Override
                    public void onResponse(Call<String> call, Response<String> response) {
                        if(response.body()==null){
                            Toast.makeText(UpdateClienteActivity.this, "No se ha podido reibir el resultado de la inserción", Toast.LENGTH_LONG).show();
                        }else{
                            Toast.makeText(UpdateClienteActivity.this, response.body(), Toast.LENGTH_LONG).show();
                        }
                        rellenarListViewClienteComandos();
                    }

                    @Override
                    public void onFailure(Call<String> call, Throwable t) {
                        Toast.makeText(UpdateClienteActivity.this, "Hubo un fallo: "+t.getMessage(), Toast.LENGTH_LONG).show();
                    }
                });
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
     * Retorfit
     *
     */
    private void rellenarListViewClienteComandos(){

        if(getIntent().getExtras()==null){
            Toast.makeText(UpdateClienteActivity.this, "No hay cliente para mostrar comandos", Toast.LENGTH_LONG).show();
        }else{
            Log.d("Mensaje","Vamos a mostrar los comandos del clinete: "+id);
            final ProgressDialog progressDialog=new ProgressDialog(UpdateClienteActivity.this);
            progressDialog.setMessage("Cargando hosts.");
            progressDialog.show();
            Call<List<ClienteComando>> callClienteComando=null;
            if(Util.estaModoCodeigniter(this)){
                callClienteComando= RetrofitClient.getServiceISSHCode(UpdateClienteActivity.this).mostrarComandosDeUnCliente(id);

            }else{
                callClienteComando= RetrofitClient.getServiceISSH(UpdateClienteActivity.this).mostrarComandosDeUnCliente(id);
            }

            callClienteComando.enqueue(new Callback<List<ClienteComando>>() {
                @Override
                public void onResponse(Call<List<ClienteComando>> call, Response<List<ClienteComando>> response) {
                    final List<ClienteComando> clienteComandos=response.body();

                    if( clienteComandos==null){
                        textViewResultadoComandos.setText("Sin comandos");
                        Log.d("Mensaje", "Se obtuvieron los comandosClientes de un cliente en updateClientesActivity pero fue null");
                    }else{
                        textViewResultadoComandos.setText("");
                        Log.d("Mensaje", "Obtenidos: "+response.body().toString());
                        ClienteComandosAdapter clienteComandosAdapter=new ClienteComandosAdapter(UpdateClienteActivity.this,clienteComandos);
                        listViewClienteComandos.setAdapter(clienteComandosAdapter);
                    }


                    progressDialog.dismiss();
                }

                @Override
                public void onFailure(Call<List<ClienteComando>> call, Throwable t) {
                    Log.d("Mensaje", "Mal---->"+t.getMessage());
                    progressDialog.dismiss();
                }
            });
        }

    }



    private void rellenarEditTextsConRetrofit() {
        if (getIntent().getExtras() == null) {
            Toast.makeText(UpdateClienteActivity.this, "No hay cliente para escribir en editTexts", Toast.LENGTH_LONG).show();
        }else{
            ////http://ssh.tipolisto.es/api/cliente/mostrarUnCliente.php?id=8
            Call<Cliente> callCliente=null;
            if(Util.estaModoCodeigniter(this)){
                callCliente= RetrofitClient.getServiceISSHCode(UpdateClienteActivity.this).mostrarUnCliente(id);
            }else{
                callCliente= RetrofitClient.getServiceISSH(UpdateClienteActivity.this).mostrarUnCliente(id);
            }
            callCliente.enqueue(new Callback<Cliente>() {
                @Override
                public void onResponse(Call<Cliente> call, Response<Cliente> response) {
                    Cliente cliente=response.body();
                    if(cliente==null){
                        Toast.makeText(UpdateClienteActivity.this, "No se ha podido reibir el cliente", Toast.LENGTH_LONG).show();
                    }else{
                        editTextCif.setText(""+cliente.getCif());
                        editTextNombre.setText(""+cliente.getNombre());
                        editTextDatos.setText(""+cliente.getDatos());
                    }
                }

                @Override
                public void onFailure(Call<Cliente> call, Throwable t) {
                    Toast.makeText(UpdateClienteActivity.this, "Hubo un fallo: "+t.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
        }

    }

    private void actualizarClienteConRetrofit(){
        if(getIntent().getExtras()==null) {
            Toast.makeText(UpdateClienteActivity.this, "No hay clinete para actualizar", Toast.LENGTH_SHORT).show();
        }else{
            Call<String> callActualizar=null;
            if(Util.estaModoCodeigniter(this)){
                callActualizar=RetrofitClient.getServiceISSHCode(UpdateClienteActivity.this).actualizarCliente(id, editTextCif.getText().toString(),editTextNombre.getText().toString(), editTextDatos.getText().toString());

            }else{
               callActualizar=RetrofitClient.getServiceISSH(UpdateClienteActivity.this).actualizarCliente(id, editTextCif.getText().toString(),editTextNombre.getText().toString(), editTextDatos.getText().toString());
            }
            callActualizar.enqueue(new Callback<String>() {
                @Override
                public void onResponse(Call<String> call, Response<String> response) {
                    if(response!=null){
                        Toast.makeText(UpdateClienteActivity.this, response.body(), Toast.LENGTH_SHORT).show();
                    }else{
                        Toast.makeText(UpdateClienteActivity.this, "No se obtuvo una respuesta del servidor", Toast.LENGTH_SHORT).show();
                    }

                }

                @Override
                public void onFailure(Call<String> call, Throwable t) {
                    Toast.makeText(UpdateClienteActivity.this, "Hubo un problema al actualizar: "+t.getMessage(), Toast.LENGTH_SHORT).show();
                    Log.d("Mensaje", "Error: "+t.getMessage());
                }
            });
        }
    }


    private void eliminarClienteConRetrofit(){
        if(getIntent().getExtras()==null) {
            Toast.makeText(UpdateClienteActivity.this, "No hay clinete para actualizar", Toast.LENGTH_SHORT).show();
        }else{
            Call<String> callEliminarCliente=null;
            if(Util.estaModoCodeigniter(this)){
                callEliminarCliente=RetrofitClient.getServiceISSHCode(UpdateClienteActivity.this).eliminarCliente(id);

            }else{
                callEliminarCliente=RetrofitClient.getServiceISSH(UpdateClienteActivity.this).eliminarCliente(id);
            }
            callEliminarCliente.enqueue(new Callback<String>() {
                @Override
                public void onResponse(Call<String> call, Response<String> response) {
                    Toast.makeText(UpdateClienteActivity.this, response.body(), Toast.LENGTH_SHORT).show();
                    Intent intent=new Intent(UpdateClienteActivity.this, ClientesActivity.class);
                    startActivity(intent);
                    finish();
                }

                @Override
                public void onFailure(Call<String> call, Throwable t) {
                    Toast.makeText(UpdateClienteActivity.this, "Hubo n problema al eliminar: "+t.getMessage(), Toast.LENGTH_SHORT).show();
                    Log.d("Mensaje", "Error: "+t.getMessage());
                }
            });
        }
    }

    private void eliminarComandoClienteConRetrofit(int idClienteComando){
        Log.d("Mensaje", "el id de dentro de retorofit es "+idClienteComando);
        Call<String> callEliminarClienteComando=null;
        if(Util.estaModoCodeigniter(this)){
            callEliminarClienteComando= RetrofitClient.getServiceISSHCode(UpdateClienteActivity.this).eliminarClienteComando(idClienteComando);

        }else{
            callEliminarClienteComando= RetrofitClient.getServiceISSH(UpdateClienteActivity.this).eliminarClienteComando(idClienteComando);
        }

        callEliminarClienteComando.enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                if(response!=null){
                    Toast.makeText(UpdateClienteActivity.this, response.body(), Toast.LENGTH_SHORT).show();
                }else{
                    Toast.makeText(UpdateClienteActivity.this, "No se obtuvo una respuesta del servidor", Toast.LENGTH_SHORT).show();
                }
                rellenarListViewClienteComandos();
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {
                Toast.makeText(UpdateClienteActivity.this, "Hubo n problema al actualizar: "+t.getMessage(), Toast.LENGTH_SHORT).show();
                Log.d("Mensaje", "Error: "+t.getMessage());
            }
        });

    }

}
