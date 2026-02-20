package es.tipolisto.sshconnect.Activities.Comandos;

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

import es.tipolisto.sshconnect.Activities.InstruccionesActivity;
import es.tipolisto.sshconnect.Activities.Conexiones.ConexionesActivity;
import es.tipolisto.sshconnect.Adapters.ComandosAdapter;
import es.tipolisto.sshconnect.Models.Comando;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.RetrofitClient;
import es.tipolisto.sshconnect.Utils.Util;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ComandosActivity extends AppCompatActivity implements AdapterView.OnItemClickListener {
    //private List<Comando> comandos;

    private TextView textViewTituloComandos;
    private ListView listViewComandos;
    private Button buttonNuevoComando;
    private final int MY_PERMISSIONS_REQUEST_RED=104;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_comandos);
        Util.crearToolbar(this);

        textViewTituloComandos=findViewById(R.id.textViewTituloComandos);
        listViewComandos=findViewById(R.id.listViewComandos);
        listViewComandos.setOnItemClickListener(this);
        buttonNuevoComando=findViewById(R.id.buttonNuevoComandoClientes);
        buttonNuevoComando.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(ComandosActivity.this, InsertComandoActivity.class);
                startActivity(intent);
            }
        });

        comprobarPermisos();




        final ProgressDialog progressDialog=new ProgressDialog(ComandosActivity.this);
        progressDialog.setMessage("Cargando Comandos.");
        progressDialog.show();
        Call<List<Comando>> callComandos=null;
        if(Util.estaModoCodeigniter(this)){
            callComandos=RetrofitClient.getServiceISSHCode(ComandosActivity.this).mostrarComandos();
        }else{
            callComandos=RetrofitClient.getServiceISSH(ComandosActivity.this).mostrarComandos();
        }

        callComandos.enqueue(new Callback<List<Comando>>() {
            @Override
            public void onResponse(Call<List<Comando>> call, Response<List<Comando>> response) {
                List<Comando>comandos=response.body();
                ComandosAdapter comandosAdapter=new ComandosAdapter(ComandosActivity.this, comandos);
                listViewComandos.setAdapter(comandosAdapter);
                Log.d("mensaje", "Todo bien");
                progressDialog.dismiss();
            }

            @Override
            public void onFailure(Call<List<Comando>> call, Throwable t) {
                Log.d("mensaje", "Todo mal");
                final String enlace="http://ssh.tipolisto.es/views/cliente/mostrarClientes";
                Toast.makeText(ComandosActivity.this, "Imposible acceder al servidor.", Toast.LENGTH_LONG).show();
                //final String enlace="https://10.20.90.254/";
                final TextView textViewEnlace=findViewById(R.id.texViewEnlaceComandosActivity);
                textViewEnlace.setVisibility(View.VISIBLE);
                textViewEnlace.setText("Imposible acceder al servidor.");
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


    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
        Comando comando=(Comando) parent.getItemAtPosition(position);
        boolean modoDevolverComando=getIntent().getBooleanExtra("modoElegirComando", false);
        if(modoDevolverComando){
            Bundle conData = new Bundle();
            conData.putInt("id", comando.getId());
            Intent intent = new Intent();
            intent.putExtras(conData);
            setResult(RESULT_OK, intent);
            finish();
        }else{
            Intent intent=new Intent(ComandosActivity.this, UpdateComandoActivity.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_CLEAR_TOP);
            intent.putExtra("id", comando.getId());
            startActivity(intent);
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
        if(permissionCheckAccessWifiSTate!= PackageManager.PERMISSION_GRANTED || permissionCheckFineLocation!=PackageManager.PERMISSION_GRANTED){
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
                    Intent intent=new Intent(this, InstruccionesActivity.class);
                    startActivity(intent);
                    finish();
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


}
