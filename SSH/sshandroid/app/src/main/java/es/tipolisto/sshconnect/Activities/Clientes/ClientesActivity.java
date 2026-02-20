package es.tipolisto.sshconnect.Activities.Clientes;

import android.Manifest;
import android.app.ProgressDialog;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.List;

import es.tipolisto.sshconnect.Activities.Conexiones.ConexionesActivity;
import es.tipolisto.sshconnect.Adapters.ClientesAdapter;
import es.tipolisto.sshconnect.Models.Cliente;
import es.tipolisto.sshconnect.Models.Comando;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.RetrofitClient;
import es.tipolisto.sshconnect.Utils.Util;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ClientesActivity extends AppCompatActivity implements AdapterView.OnItemClickListener, View.OnLongClickListener {
    private List<Cliente> clientes;
    private List<Comando> comandos;
    private ListView listView;
    private TextView textViewTitulo;

    private Button buttonInsertarCliente;
    private final int MY_PERMISSIONS_REQUEST_RED=104;
    private final int MY_PERMISSIONS_REQUEST_WIFI_STATUS=100;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_clientes);
        Util.crearToolbar(this);

        comprobarPermisos();

        listView=findViewById(R.id.listViewClientes);
        textViewTitulo=findViewById(R.id.textViewClientes);

        buttonInsertarCliente=findViewById(R.id.buttonNuevoClienteClientes);
        buttonInsertarCliente.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(ClientesActivity.this, InsertClienteActivity.class);
                startActivity(intent);
            }
        });
        //prueba();
        escribirClientesEnListView();
        Log.d("Mensaje", "Estas en clientes activity");
        listView.setOnItemClickListener(this);



    }
    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
        Cliente cliente=(Cliente) parent.getItemAtPosition(position);
        Intent intent=new Intent(ClientesActivity.this, UpdateClienteActivity.class);
        intent.putExtra("id", cliente.getId());
        startActivity(intent);

    }
    @Override
    public boolean onLongClick(View v) {
        Intent intent=new Intent(ClientesActivity.this, UpdateClienteActivity.class);
        startActivity(intent);
        return true;
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



    private void escribirClientesEnListView() {
        final ProgressDialog progressDialog=new ProgressDialog(ClientesActivity.this);
        progressDialog.setMessage("Cargando clientes.");
        progressDialog.show();
        //Call<List<Cliente>> callClientes=RetrofitClient.getServiceConCeretificado(ClientesActivity.this).mostrarClientes();
        Call<List<Cliente>> callClientes=null;
        if(Util.estaModoCodeigniter(this)){
            callClientes=RetrofitClient.getServiceISSHCode(ClientesActivity.this).mostrarClientes();
            Log.d("Mensaje", "El modo codeigniter esta activado");
        }else{
            callClientes=RetrofitClient.getServiceISSH(ClientesActivity.this).mostrarClientes();
            Log.d("Mensaje", "codeigniter no activado");
        }


        callClientes.enqueue(new Callback<List<Cliente>>() {
            @Override
            public void onResponse(Call<List<Cliente>> call, Response<List<Cliente>> response) {
                List<Cliente> clientes=response.body();

                ClientesAdapter clientesAdapter=new ClientesAdapter(ClientesActivity.this, clientes);
                if(clientes!=null){
                    listView.setAdapter(clientesAdapter);
                    Log.d("Mensaje", "Todo bien"+clientes.get(0).getNombre());
                }else{
                    textViewTitulo.setText("Sin resultados");
                    Log.d("Mensaje", "Todo bien, pero clientes es null");
                }
                progressDialog.dismiss();
            }

            @Override
            public void onFailure(Call<List<Cliente>> call, Throwable t) {
                //https://ssh.tipolisto.es/api/cliente/mostrarClientes y acepte el certificado.\n"+t.getMessage()
                //"Por favor visite el enlace de arriba y acepta lo del certificado, también puedes ir a https://10.20.90.254/, pinchar en download y bajarte el certificado para android. \n\n"+t.getMessage()
                Log.d("Mensaje", "Todo mal "+t.getMessage());
                //final String enlace="http://ssh.tipolisto.es/views/cliente/mostrarClientes";
                //Toast.makeText(ClientesActivity.this, "Intente acceder a la dirección que se muestra arriba.", Toast.LENGTH_LONG).show();
                Toast.makeText(ClientesActivity.this, "Imposible acceder al servidor.", Toast.LENGTH_LONG).show();
                //final String enlace="https://10.20.90.254/";
                final TextView textViewEnlace=findViewById(R.id.texViewEnlaceClientesActivity);
                textViewEnlace.setVisibility(View.VISIBLE);
                textViewEnlace.setText("imposible acceder al servidor.");
                /*textViewEnlace.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        Uri uri = Uri.parse(enlace);
                        Intent intent = new Intent(Intent.ACTION_VIEW, uri);
                        startActivity(intent);
                        textViewEnlace.setVisibility(View.GONE);
                    }
                });*/
                progressDialog.dismiss();
            }
        });

    }








    private void comprobarPermisos(){
        //Permiso al estado del WIFI
        int permissionCheckAccessWifiSTate = ContextCompat.checkSelfPermission(getApplicationContext(),
                Manifest.permission.ACCESS_WIFI_STATE);
        //permiso al estado de la red 4G
        int permissionCheckAccessNetworkState = ContextCompat.checkSelfPermission(getApplicationContext(),
                Manifest.permission.ACCESS_NETWORK_STATE);
        //Si no ponía este no me dejaba trabajar
        int permissionCheckFineLocation = ContextCompat.checkSelfPermission(getApplicationContext(),
                Manifest.permission.ACCESS_FINE_LOCATION);

        if(permissionCheckAccessWifiSTate!= PackageManager.PERMISSION_GRANTED || permissionCheckFineLocation!=PackageManager.PERMISSION_GRANTED || permissionCheckAccessWifiSTate!= PackageManager.PERMISSION_GRANTED) {
            Log.d("Mensaje", "No tienes los permisos" +permissionCheckAccessWifiSTate+"--"+PackageManager.PERMISSION_GRANTED+", accessfinelocation: "+permissionCheckFineLocation);
            requestPermissions(new String[]{Manifest.permission.ACCESS_WIFI_STATE,Manifest.permission.ACCESS_NETWORK_STATE,Manifest.permission.ACCESS_FINE_LOCATION},MY_PERMISSIONS_REQUEST_RED);
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           String permissions[], int[] grantResults) {
        switch (requestCode) {
            case MY_PERMISSIONS_REQUEST_RED: {
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    Intent intent=new Intent(this,ClientesActivity.class);
                    startActivity(intent);
                    finish();
                    Toast.makeText(this, "Permiso aprobado", Toast.LENGTH_SHORT).show();

                } else if (grantResults[0] == PackageManager.PERMISSION_DENIED){
                    Toast.makeText(this, "Permiso denegado", Toast.LENGTH_SHORT).show();
                    Intent intent=new Intent(this,ConexionesActivity.class);
                    startActivity(intent);
                    finish();
                }
                return;
            }
            case MY_PERMISSIONS_REQUEST_WIFI_STATUS: {
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    Intent intent=new Intent(this,ClientesActivity.class);
                    startActivity(intent);
                    finish();
                    Toast.makeText(this, "Permiso ver estado wifi aprobado", Toast.LENGTH_SHORT).show();

                } else {
                    Toast.makeText(this, "Permiso ver estado wifi  denegado", Toast.LENGTH_SHORT).show();
                    Intent intent=new Intent(this,ConexionesActivity.class);
                    startActivity(intent);
                    finish();
                }
                return;
            }
        }
    }



}
