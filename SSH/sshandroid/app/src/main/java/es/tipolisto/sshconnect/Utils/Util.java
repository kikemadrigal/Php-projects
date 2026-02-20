package es.tipolisto.sshconnect.Utils;



import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Handler;
import android.os.Message;
import android.support.v4.app.NavUtils;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.text.TextUtils;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.Toast;

import java.io.IOException;
import java.net.InetAddress;
import java.net.NetworkInterface;
import java.net.SocketException;
import java.util.Collections;
import java.util.List;

import es.tipolisto.sshconnect.Activities.Clientes.ClientesActivity;
import es.tipolisto.sshconnect.Activities.Comandos.ComandosActivity;
import es.tipolisto.sshconnect.Activities.InstruccionesActivity;
import es.tipolisto.sshconnect.Activities.Conexiones.ConexionesActivity;
import es.tipolisto.sshconnect.Activities.InformationActivity;
import es.tipolisto.sshconnect.Activities.OpcionesActivity;
import es.tipolisto.sshconnect.Activities.WifiActivity;
import es.tipolisto.sshconnect.R;


public class Util {


    public static Boolean validarCamposVacios(Context context,String s){
        if(TextUtils.isEmpty(s)){
            Toast.makeText(context, "El texto no puede estar vacío", Toast.LENGTH_SHORT).show();
            return false;
        }else{
            return true;
        }
    }

    public static void crearAlertDialog(final AppCompatActivity activity, final String mensaje){
        activity.runOnUiThread(new Runnable() {
            @Override
            public void run() {
                AlertDialog.Builder builder = new AlertDialog.Builder(activity.getApplicationContext());
                builder.setTitle("Mensaje");
                builder.setMessage(mensaje);
                //builder.setCancelable(true);
                int[] resultados={0,-1};
                int resultadoDevuelto;
                builder.setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        dialog.cancel();
                    }
                });
                builder.create().show();
            }
        });
    }
    public static void crearProgressDialog(AppCompatActivity appCompatActivity) {
        final ProgressDialog progressDoalog = new ProgressDialog(appCompatActivity);
        final Handler handle = new Handler() {
            @Override
            public void handleMessage(Message msg) {
                super.handleMessage(msg);
                progressDoalog.incrementProgressBy(1);
            }
        };


        progressDoalog.setMax(4);
        progressDoalog.setMessage("Espere...");
        progressDoalog.setTitle("Leiendo");
        progressDoalog.setProgressStyle(ProgressDialog.STYLE_HORIZONTAL);
        progressDoalog.show();
        new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    while (progressDoalog.getProgress() <= progressDoalog.getMax()) {
                        Thread.sleep(200);
                        handle.sendMessage(handle.obtainMessage());
                        if (progressDoalog.getProgress() == progressDoalog.getMax()) {
                            progressDoalog.dismiss();
                        }
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        }).start();
    }
    public static boolean executeCommandPing(String host){
        Runtime runtime = Runtime.getRuntime();
        try
        {
            Process  mIpAddrProcess = runtime.exec("/system/bin/ping -c 1 "+host);
            int mExitValue = mIpAddrProcess.waitFor();
            if(mExitValue==0){
                return true;
            }else{
                return false;
            }
        }
        catch (InterruptedException ignore)
        {
            ignore.printStackTrace();
           // System.out.println(" Exception:"+ignore);
            Log.d("Mensaje"," executeCommandPing dice: Exception:"+ignore);
        }
        catch (IOException e)
        {
            e.printStackTrace();
            //System.out.println(" Exception:"+e);
            Log.d("Mensaje","executeCommandPing dice:  Exception3:"+e);
        }
        return false;
    }


    public static void crearToast(final AppCompatActivity activity, final String mensaje){
        activity.runOnUiThread(new Runnable() {
            @Override
            public void run() {
                Toast toast= Toast.makeText(activity.getApplicationContext(),
                        mensaje, Toast.LENGTH_LONG);
                toast.setGravity(Gravity.CENTER|Gravity.CENTER_HORIZONTAL, 0, 0);
                toast.show();
            }
        });
    }

    /*view.setClickable(false);
    view.setBackgroundColor(Color.RED);
    view.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            new Handler(Looper.getMainLooper()).post(new Runnable() {
                @Override
                public void run() {
                    Toast.makeText(context, "No se puede conectar", Toast.LENGTH_LONG).show();
                }
            });
        }
    });*/

    public static String obtenerMensaje(String mensaje){
        String texto="Excepción";

        if(mensaje.contains("ECONNREFUSED")){
            texto="Conexión denegada";
        }else if(mensaje.contains("ENETUNREACH")){
            texto="La red es inalcanzable.";
        }else if(mensaje.contains("timeout")){
            texto="No se puede establecer la conexión";
        }else if(mensaje.contains(" java.net.UnknownHostException:")){
            texto="No se puede establecer la conexion.";
        }
        return texto;
    }

    public static boolean executeCommand(String ip){
        System.out.println("executeCommand");
        Runtime runtime = Runtime.getRuntime();
        try
        {
            Process  mIpAddrProcess = runtime.exec("/system/bin/ping -c 1 "+ip);
            int mExitValue = mIpAddrProcess.waitFor();
            System.out.println(" mExitValue "+mExitValue);
            if(mExitValue==0){
                return true;
            }else{
                return false;
            }
        }
        catch (InterruptedException ignore)
        {
            ignore.printStackTrace();
            System.out.println(" Exception:"+ignore);
        }
        catch (IOException e)
        {
            e.printStackTrace();
            System.out.println(" Exception:"+e);
        }
        return false;
    }


    public static String obtenerIP(){
        String ip="";
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

                            ip= sAddr;
                        }
                    }
                }
            }
        } catch (SocketException e) {
            e.printStackTrace();
            ip= "No detectada IP";
        }
        return ip;
    }



    public static boolean estaModoCodeigniter(Context context){
        SharedPreferences prefs =context.getSharedPreferences("MisPreferencias",Context.MODE_PRIVATE);
        boolean modoCodeigniter=prefs.getBoolean("modoCodeigniter", false);
        return modoCodeigniter;
    }


    public static void hideKeyboard(Activity activity) {
        InputMethodManager imm = (InputMethodManager) activity.getSystemService(Activity.INPUT_METHOD_SERVICE);
        //Find the currently focused view, so we can grab the correct window token from it.
        View view = activity.getCurrentFocus();
        //If no view currently has focus, create a new one, just so we can grab a window token from it
        if (view == null) {
            view = new View(activity);
        }
        imm.hideSoftInputFromWindow(view.getWindowToken(), 0);
    }



    public static void crearToolbar(final AppCompatActivity appCompatActivity){
        Toolbar toolbar = (Toolbar) appCompatActivity.findViewById(R.id.toolbar);
        appCompatActivity.setSupportActionBar(toolbar);
        toolbar.setLogo(R.drawable.casa);
        toolbar.setNavigationIcon(R.drawable.flecha);
        toolbar.setTitle("SSH");
        //Si pinchas en la flecha de atrás te llevará a la clase anterior a esta
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(appCompatActivity.getParentActivityIntent()!=null)
                    NavUtils.navigateUpFromSameTask(appCompatActivity);
                else
                    appCompatActivity.finish();
            }
        });
        //Si pinchas en la casa te llevará a ConexionesActivity.class
        toolbar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(appCompatActivity, ConexionesActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_CLEAR_TOP);
                appCompatActivity.startActivity(intent);
                appCompatActivity.finish();
            }
        });
    }

    public static void crearMenu(AppCompatActivity appCompatActivity,int id){
        switch (id) {
            case R.id.clientes:
                Intent intent3=new Intent(appCompatActivity, ClientesActivity.class);
                appCompatActivity.startActivity(intent3);
                break;
            case R.id.comandos:
                Intent intent4=new Intent(appCompatActivity, ComandosActivity.class);
                appCompatActivity.startActivity(intent4);
                break;
            case R.id.network:
                Intent intent=new Intent(appCompatActivity, WifiActivity.class);
                appCompatActivity.finish();
                appCompatActivity.startActivity(intent);
                break;
            case R.id.informacion:
                Intent intent1=new Intent(appCompatActivity, InformationActivity.class);
                appCompatActivity.startActivity(intent1);
                break;
            case R.id.instrucciones:
                Intent intent2=new Intent(appCompatActivity, InstruccionesActivity.class);
                appCompatActivity.startActivity(intent2);
                break;
            case R.id.configuración:
                Intent intent5=new Intent(appCompatActivity, OpcionesActivity.class);
                appCompatActivity.startActivity(intent5);
                break;
        }
    }



}
