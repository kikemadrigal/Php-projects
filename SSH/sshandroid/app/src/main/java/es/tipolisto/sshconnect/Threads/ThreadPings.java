package es.tipolisto.sshconnect.Threads;

import android.app.Activity;
import android.util.Log;

import es.tipolisto.sshconnect.Utils.Util;

public class ThreadPings extends Thread {
    private Activity activity;
    private String ip;
    public ThreadPings(Activity activity, String ip){
        this.activity=activity;
        this.ip=ip;
    }

    @Override
    public void run() {
        String mensaje="";
        boolean hizoPingo= Util.executeCommandPing(ip);
        if(hizoPingo){
            mensaje="La ip: "+ip+", hizo ping";
            Log.d("Mensajes", mensaje);
        }else{
            mensaje="La ip: "+ip+", no hizo ping";
            Log.d("Mensajes", mensaje);
        }

    }

}
