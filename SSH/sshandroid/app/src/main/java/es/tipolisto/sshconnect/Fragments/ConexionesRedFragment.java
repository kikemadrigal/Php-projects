package es.tipolisto.sshconnect.Fragments;


import android.Manifest;
import android.app.Activity;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.pm.PackageManager;
import android.net.ConnectivityManager;
import android.net.Network;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.Fragment;
import android.support.v4.content.ContextCompat;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;


import java.net.InetAddress;
import java.net.UnknownHostException;
import java.util.ArrayList;

import es.tipolisto.sshconnect.Activities.Conexiones.InsertConexionActivity;
import es.tipolisto.sshconnect.Adapters.ConexionesRedPingsAdapter;
import es.tipolisto.sshconnect.Models.Pings;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.Util;

//La dopcumentación de lo que aqui paarece está en:
//https://developer.android.com/training/monitoring-device-state/connectivity-monitoring
public class ConexionesRedFragment extends Fragment implements AdapterView.OnItemClickListener , AdapterView.OnItemLongClickListener {
    private final int MY_PERMISSIONS_REQUEST_RED=104;
    private Context context;
    private ConnectivityManager connectivityManager;
    private Network network;
    private NetworkInfo networkInfo;
    private TextView textViewResultados;
    private String nombreConexion;
    private String ip;
    private String tipoConexion;
    private ArrayList<Pings> arrayListPings;
    private ListView listView;
    ConexionesRedPingsAdapter conexionesRedPingsAdapter;
    public ConexionesRedFragment() {
        // Required empty public constructor

    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        this.context= getActivity().getApplicationContext();


        this.arrayListPings=new ArrayList<Pings>(300);
        View view= inflater.inflate(R.layout.fragment_conexiones_red, container, false);
        textViewResultados=view.findViewById(R.id.textViewresultadoConexionesRedFragment);
        listView=view.findViewById(R.id.listViewConexionesRedFragment);

        //Esto comprobarálos permisos y si alguno no lo tiene los solicitará y será manjeado por el onActivityresult de
        comprobarPermisos();
        registrarCambiosEnConnectividad();

        connectivityManager =(ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        networkInfo=connectivityManager.getActiveNetworkInfo();
        tipoConexion=ConnectivityManager.EXTRA_NETWORK_TYPE;


        //Necesitamos coger la ip para poder escaenar la red
        if(networkInfo.getState()== NetworkInfo.State.CONNECTED){
            nombreConexion=networkInfo.getExtraInfo();
            ip=Util.obtenerIP();
            Toast.makeText(getActivity(), "Espera..", Toast.LENGTH_SHORT).show();
            new Handler().postDelayed(new Runnable(){
                public void run(){
                    escanearRed();
                }
            }, 500);


        }else{
            nombreConexion="Sin conexion";
        }
        return view;
    }

    @Override
    public void onPause() {
        super.onPause();

        conexionesRedPingsAdapter=new ConexionesRedPingsAdapter(getActivity(), arrayListPings);
        listView.setAdapter(conexionesRedPingsAdapter);
        listView.setOnItemClickListener(this);
    }

    private void escanearRed()  {
        int ultimpPunto=ip.lastIndexOf(".");
        String ipRed=ip.substring(0,ultimpPunto+1);
        //Log.d("Mensajes", "Resulatdo "+ipRed);
        for(int i=0;i<255;i++){
            //Para que no haga ping en la del dispositivo
            if(!ipRed.equalsIgnoreCase(ip)){
                String ipAEscanear=ipRed+i;
               // Log.d("Mensajes", "Resulatdo "+ipAEscanear);
                ThreadPing threadPing=new ThreadPing(getActivity(), ipAEscanear);
                threadPing.start();
            }
        }
        conexionesRedPingsAdapter=new ConexionesRedPingsAdapter(getActivity(), arrayListPings);
        listView.setAdapter(conexionesRedPingsAdapter);
        listView.setOnItemClickListener(this);
    }




    private void comprobarPermisos(){
        //Permiso al estado del WIFI
        int permissionCheckAccessWifiSTate = ContextCompat.checkSelfPermission(context,
                Manifest.permission.ACCESS_WIFI_STATE);
        //permiso al estado de la red 4G
        int permissionCheckAccessNetworkState = ContextCompat.checkSelfPermission(context,
                Manifest.permission.ACCESS_NETWORK_STATE);
        //Si no ponía este no me dejaba trabajar
        int permissionCheckFineLocation = ContextCompat.checkSelfPermission(context,
                Manifest.permission.ACCESS_FINE_LOCATION);
        if(permissionCheckAccessWifiSTate!= PackageManager.PERMISSION_GRANTED || permissionCheckFineLocation!=PackageManager.PERMISSION_GRANTED){
            Log.d("Mensaje", "No tienes los permisos" +permissionCheckAccessWifiSTate+"--"+PackageManager.PERMISSION_GRANTED+", accessfinelocation: "+permissionCheckFineLocation);
            requestPermissions(new String[]{Manifest.permission.ACCESS_WIFI_STATE,Manifest.permission.ACCESS_NETWORK_STATE,Manifest.permission.ACCESS_FINE_LOCATION},MY_PERMISSIONS_REQUEST_RED);
        }
    }


    private void registrarCambiosEnConnectividad(){
        getActivity().registerReceiver(broadcastReceiverConnectivityManagaer, new IntentFilter(ConnectivityManager.CONNECTIVITY_ACTION));
    }

    private BroadcastReceiver broadcastReceiverConnectivityManagaer = new BroadcastReceiver() {
        @Override
        public void onReceive(final Context context, final Intent intent) {
            android.util.Log.i("Mensaje", "mIRNetwork: Network State Received: " + intent.getAction());
            Bundle extras = intent.getExtras();
            if (extras != null) {
                nombreConexion=extras.getString(ConnectivityManager.EXTRA_EXTRA_INFO);
                if(connectivityManager.getNetworkInfo(ConnectivityManager.TYPE_WIFI).isConnected()) {
                    tipoConexion="Wifi";
                }
                if(connectivityManager.getNetworkInfo(ConnectivityManager.TYPE_MOBILE).isConnected()) {
                    tipoConexion="4G";
                }
                getActivity().runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        textViewResultados.setText("Tipo: "+tipoConexion+", "+nombreConexion+",   IP: "+Util.obtenerIP());
                    }
                });
            }
        }
    };

    @Override
    public boolean onItemLongClick(AdapterView<?> parent, View view, int position, long id) {
        Toast.makeText(context, "Has hecho una pulsacin larga", Toast.LENGTH_SHORT).show();
        return true;
    }


    public class ThreadPing extends Thread {
        private Activity activity;
        private String ip;
        public ThreadPing(Activity activity, String ip){
            this.activity=activity;
            this.ip=ip;
        }

        @Override
        public void run() {
            boolean hizoPingo= Util.executeCommandPing(ip);
            if(hizoPingo){
                InetAddress inetAddress= null;
                try {
                    inetAddress = InetAddress.getByName(ip);
                } catch (UnknownHostException e) {
                    e.printStackTrace();
                }
                String nombreHost=inetAddress.getHostName();
                arrayListPings.add(new Pings(ip,nombreHost,true));
                //Log.d("Mensajes", "bine");
                listView.post(new Runnable() {
                    @Override
                    public void run() {
                        conexionesRedPingsAdapter.notifyDataSetChanged();
                    }
                });
            }
            /*activity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    listView.setAdapter(conexionesRedPingsAdapter);
                }
            });*/

        }
    }





    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
        Pings pings=(Pings)parent.getItemAtPosition(position);
        //Toast.makeText(getActivity(), "la ip es "+pings.getHost(), Toast.LENGTH_LONG).show();
        Intent intent=new Intent(getActivity(), InsertConexionActivity.class);
        intent.putExtra("iphost",pings.getIpHost());
        startActivity(intent);
        getActivity().finish();
    }





}
