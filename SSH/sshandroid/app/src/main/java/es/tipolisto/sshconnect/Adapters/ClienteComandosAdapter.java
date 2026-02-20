package es.tipolisto.sshconnect.Adapters;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

import es.tipolisto.sshconnect.Models.ClienteComando;
import es.tipolisto.sshconnect.Models.Comando;
import es.tipolisto.sshconnect.R;

public class ClienteComandosAdapter extends BaseAdapter {
    private List<ClienteComando> clienteComandos;
    private LayoutInflater layoutInflater;


    private Activity activity;
    public ClienteComandosAdapter(Context context, List<ClienteComando> clienteComandos){
        this.clienteComandos=clienteComandos;
        this.layoutInflater=LayoutInflater.from(context);
    }
    @Override
    public int getCount() {
        return clienteComandos.size();
    }
    @Override
    public Object getItem(int position) {
        return clienteComandos.get(position);
    }
    @Override
    public long getItemId(int position) {
        return position;
    }
    @Override
    public View getView(int position, View convertView, final ViewGroup parent) {
        final View itemView=this.layoutInflater.inflate(R.layout.item_cliente_comandos_adapter,null);
        //TextView textViewIdClienteComando=itemView.findViewById(R.id.textViewIdClienteComandoAdapter);
        //TextView textViewIdClienteClienteComando=itemView.findViewById(R.id.textViewIdClienteClienteComandoAdapter);
        //TextView textViewIdComandoClienteComando=itemView.findViewById(R.id.textViewIdComandoClienteComandoAdapter);
        TextView textViewNombreComandoClienteComando=itemView.findViewById(R.id.textViewNombreComandoClienteComandoAdapter);
        ClienteComando clienteComando=clienteComandos.get(position);
        //textViewIdClienteComando.setText(String.valueOf(clienteComando.getId()));
        //textViewIdClienteClienteComando.setText(String.valueOf(clienteComando.getIdCliente()));
        //textViewIdComandoClienteComando.setText(String.valueOf(clienteComando.getIdComando()));
        textViewNombreComandoClienteComando.setText(clienteComando.getNombre());

        return itemView;
    }




}
