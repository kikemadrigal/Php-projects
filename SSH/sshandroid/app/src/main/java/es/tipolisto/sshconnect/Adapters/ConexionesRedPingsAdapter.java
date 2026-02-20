package es.tipolisto.sshconnect.Adapters;

import android.app.Activity;
import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.jcraft.jsch.JSch;
import com.jcraft.jsch.JSchException;
import com.jcraft.jsch.Session;

import java.util.ArrayList;
import java.util.Properties;

import es.tipolisto.sshconnect.Models.Conexion;
import es.tipolisto.sshconnect.Models.Pings;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.ShellConnection;

public class ConexionesRedPingsAdapter extends BaseAdapter {
    private ArrayList<Pings> arrayListPings;
    private LayoutInflater layoutInflater;
    private Activity activity;
    public ConexionesRedPingsAdapter(Activity activity, ArrayList<Pings> arrayListPings){
        this.activity=activity;
        layoutInflater=LayoutInflater.from(activity.getApplicationContext());
        this.arrayListPings=arrayListPings;
    }
    @Override
    public int getCount() {
        return arrayListPings.size();
    }
    @Override
    public Object getItem(int position) {
        return arrayListPings.get(position);
    }
    @Override
    public long getItemId(int position) {
        return position;
    }
    @Override
    public View getView(int position, View convertView, final ViewGroup parent) {
        final View itemView=layoutInflater.inflate(R.layout.item_conexiones_red_fragment,null);
        final ImageView imageView=itemView.findViewById(R.id.imageViewConexionesRedFragment);
        final TextView textViewIP=itemView.findViewById(R.id.textViewItemConexionesRedFragment);
        final Pings pings=arrayListPings.get(position);
        final boolean estadoHost=pings.isPingHost();
        textViewIP.setText(pings.getIpHost()+"\n"+pings.getNombreHost());

        activity.runOnUiThread(new Runnable() {
            @Override
            public void run() {
                if(estadoHost){
                    imageView.setImageResource(R.drawable.drawable_host_conectado);
                }
            }
        });
        return itemView;
    }


}
