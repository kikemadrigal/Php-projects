package es.tipolisto.sshconnect.Activities;

import android.Manifest;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.pm.PackageManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.wifi.ScanResult;
import android.net.wifi.WifiManager;
import android.support.v4.app.NavUtils;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.text.format.Formatter;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.net.InetAddress;
import java.net.NetworkInterface;
import java.net.SocketException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

import es.tipolisto.sshconnect.Activities.Clientes.ClientesActivity;
import es.tipolisto.sshconnect.Activities.Comandos.ComandosActivity;
import es.tipolisto.sshconnect.Activities.Conexiones.ConexionesActivity;
import es.tipolisto.sshconnect.Adapters.WifiAdapter;
import es.tipolisto.sshconnect.Models.Wifi;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.Util;

public class WifiActivity extends AppCompatActivity implements AdapterView.OnItemClickListener {
    private WifiManager wifiManager;
    private NetworkInfo networkInfo;
    private ListView listView;
    private TextView textViewEstado, textViewIp, textViewInfo;
    private Button button;
    private int size=0;
    private List<ScanResult> results;
    private ArrayList<Wifi> arrayList=new ArrayList<>();
    private WifiAdapter wifiAdapter;
    private final int MY_PERMISSIONS_REQUEST_WIFI_STATUS=100;

    private String ip;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_wifi);
        Util.crearToolbar(this);

        textViewEstado=findViewById(R.id.estadoWifiActivity);
        textViewIp=findViewById(R.id.ipWifiActivity);
        textViewInfo=findViewById(R.id.infoWifiActivity);
        listView=findViewById(R.id.listViewWifiActivity);

        /**
         *
         * Rollo Wifi
         *
         */
        //Vemos si tiene denegado el permiso del Wifi
        int permissionCheckAccessWifiSTate = ContextCompat.checkSelfPermission(this,
                Manifest.permission.ACCESS_WIFI_STATE);
        int permissionCheckFineLocation = ContextCompat.checkSelfPermission(this,
                Manifest.permission.ACCESS_FINE_LOCATION);
        //Si el permiso es diferente a  permiso concedido
        if(permissionCheckAccessWifiSTate!= PackageManager.PERMISSION_GRANTED || permissionCheckFineLocation!=PackageManager.PERMISSION_GRANTED){
            Log.d("Mensaje", "Oncreate dice: No tienes los permisos" +permissionCheckAccessWifiSTate+"--"+PackageManager.PERMISSION_GRANTED+", accessfinelocation: "+permissionCheckFineLocation);
            requestPermissions(new String[]{Manifest.permission.ACCESS_FINE_LOCATION},MY_PERMISSIONS_REQUEST_WIFI_STATUS);
        }else{
            Log.d("Mensaje", "Oncreate dice: Si tienes los permisos, wifi state" +permissionCheckAccessWifiSTate+"--"+PackageManager.PERMISSION_GRANTED+", accessfinelocation: "+permissionCheckFineLocation);
            wifiManager=(WifiManager) getApplicationContext().getSystemService(Context.WIFI_SERVICE);
            if(!wifiManager.isWifiEnabled()){
                Toast.makeText(this, "Wifi deshabilitado", Toast.LENGTH_LONG).show();
                textViewEstado.setText("desactivado");
                textViewIp.setText("desactivado");
                textViewInfo.setText("desactivado");
            }else{
                wifiManager.setWifiEnabled(true);
                String estadoConexion=wifiManager.isWifiEnabled()? "Wifi activao." : "No conectado.";
                textViewEstado.setText(estadoConexion);
                String ipFormateada=Formatter.formatIpAddress(wifiManager.getConnectionInfo().getIpAddress());
                ip=ipFormateada;
                textViewIp.setText("Ip: "+ipFormateada);
                textViewInfo.setText(wifiManager.getConnectionInfo().toString());
            }
            wifiAdapter =new
                    WifiAdapter(this, arrayList);
            listView.setAdapter(wifiAdapter);
            listView.setOnItemClickListener(this);
        }
        /**
         *
         * Fin de rollo wifi
         *
         */
        obtenerDatosNetwork();
        escanearWifi();
    }


    private void escanearWifi(){
        arrayList.clear();
        registerReceiver(wifiReceiver, new IntentFilter(wifiManager.SCAN_RESULTS_AVAILABLE_ACTION));
        wifiManager.startScan();
        Toast.makeText(this, "Esaneando wifis...", Toast.LENGTH_LONG).show();
    }

    BroadcastReceiver wifiReceiver=new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            results=wifiManager.getScanResults();
            unregisterReceiver(this);
            for(ScanResult scanResult: results){
                Wifi wifi=new Wifi();
                wifi.setSSID(scanResult.SSID);
                wifi.setBSSID(scanResult.BSSID);
                wifi.setCapabilities(scanResult.capabilities);
                wifi.setFrequency(scanResult.frequency);
                arrayList.add(wifi);
               // Log.d("Mensaje",scanResult.toString() );
                wifiAdapter.notifyDataSetChanged();
            }
        }
    };






    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           String permissions[], int[] grantResults) {
        switch (requestCode) {
            case MY_PERMISSIONS_REQUEST_WIFI_STATUS: {
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    Intent intent=new Intent(this,WifiActivity.class);
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




    private void obtenerDatosNetwork(){
        Log.d("Mensaje", "Vamos a hacer ping");
        /**
         *
         * Rollo net
         *
         */

        ConnectivityManager cm =
                (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        int permissionCheckAccessNetworkState = ContextCompat.checkSelfPermission(this,
                Manifest.permission.ACCESS_NETWORK_STATE);
        if(permissionCheckAccessNetworkState!= PackageManager.PERMISSION_GRANTED){
            Log.d("Mensaje", "Oncreate dice: No tienes los permisos, network state" +permissionCheckAccessNetworkState+"--"+PackageManager.PERMISSION_GRANTED);
        }else{
            Log.d("Mensaje", "Oncreate dice: Si tienes los permisos, network state" +permissionCheckAccessNetworkState+"--"+PackageManager.PERMISSION_GRANTED);
            networkInfo = cm.getActiveNetworkInfo();
            TextView textViewNameNetWork=findViewById(R.id.nameNetWorkActivity);
            TextView textViewTypeNetWork=findViewById(R.id.typeNetWorkActivity);
            TextView textViewIpAddresNetWork=findViewById(R.id.ipNetWorkActivity);
            if(!networkInfo.isConnected()){
                Toast.makeText(this, "Network no activa", Toast.LENGTH_SHORT).show();
            }else{
                textViewNameNetWork.setText(networkInfo.toString());
                textViewTypeNetWork.setText(networkInfo.getSubtypeName()+" ("+networkInfo.getSubtype()+")");

                //Obtenemos la IP
                try {
                    List<NetworkInterface> interfaces = Collections.list(NetworkInterface.getNetworkInterfaces());
                    for (NetworkInterface intf : interfaces) {

                        List<InetAddress> addrs = Collections.list(intf.getInetAddresses());
                        for (InetAddress addr : addrs) {
                            if (!addr.isLoopbackAddress()) {
                                String sAddr = addr.getHostAddress();

                                //Nos suele devolver otra direccion ip de otros protocolos,para filtrarla...
                                if(sAddr.indexOf(":")>0){
                                    Log.d("Mensaje","la direccion: "+sAddr+", no es IPv4");
                                }else{
                                    Log.d("Mensaje","la direccion: "+sAddr+", si es IPv4");
                                    textViewIpAddresNetWork.setText(textViewIpAddresNetWork.getText()+sAddr);
                                    ip=sAddr;
                                }
                            }
                        }


                    }
                } catch (SocketException e) {
                    e.printStackTrace();
                }


            }
        }
    }


    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
        Wifi wifi=(Wifi) parent.getItemAtPosition(position);
        AlertDialog.Builder builder=new AlertDialog.Builder(WifiActivity.this);
        builder.setMessage("SSID: "+wifi.getSSID()+
                            "\nBSSID: "+wifi.getBSSID()+
                            "\ncompatibility: "+wifi.getCapabilities()+
                            "\nFrecuency: "+wifi.getFrequency());
        builder.setPositiveButton("Ok", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int id) {
                dialog.cancel();
            }
        });
        builder.create().show();
    }
}

