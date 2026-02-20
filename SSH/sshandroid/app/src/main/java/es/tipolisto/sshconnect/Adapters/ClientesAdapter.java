package es.tipolisto.sshconnect.Adapters;

import android.app.Activity;
import android.app.ProgressDialog;
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
import java.util.List;
import java.util.Properties;

import es.tipolisto.sshconnect.Models.Cliente;
import es.tipolisto.sshconnect.Models.Conexion;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.ShellConnection;

public class ClientesAdapter extends BaseAdapter {
    private List<Cliente> clientes;
    private LayoutInflater layoutInflater;


    private Activity activity;
    public ClientesAdapter(Context context, List<Cliente> clientes){
        this.clientes=clientes;
        this.layoutInflater=LayoutInflater.from(context);
    }
    @Override
    public int getCount() {
        return clientes.size();
    }
    @Override
    public Object getItem(int position) {
        return clientes.get(position);
    }
    @Override
    public long getItemId(int position) {
        return position;
    }
    @Override
    public View getView(int position, View convertView, final ViewGroup parent) {
        final View itemView=this.layoutInflater.inflate(R.layout.item_clientes_adapter,null);
        //TextView textViewIdClienteAdapter=itemView.findViewById(R.id.textViewIdClienteAdapter);
        TextView textViewCifClienteAdapter=itemView.findViewById(R.id.textViewCifClienteAdapter);
        TextView textViewNombreClienteAdapter=itemView.findViewById(R.id.textViewNombreClienteAdapter);
        TextView textViewDatosClienteAdapter=itemView.findViewById(R.id.textViewDatosClienteAdapter);
        Cliente cliente=clientes.get(position);
        //textViewIdClienteAdapter.setText(String.valueOf(cliente.getId()));
        textViewCifClienteAdapter.setText(cliente.getCif());
        textViewNombreClienteAdapter.setText(cliente.getNombre());
        textViewDatosClienteAdapter.setText(cliente.getDatos());

        return itemView;
    }




}
