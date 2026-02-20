package es.tipolisto.sshconnect.Adapters;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;


import java.util.List;

import es.tipolisto.sshconnect.Models.Comando;
import es.tipolisto.sshconnect.R;

public class ComandosAdapter extends BaseAdapter {
    private List<Comando> comandos;
    private LayoutInflater layoutInflater;


    private Activity activity;
    public ComandosAdapter(Context context, List<Comando> comandos){
        this.comandos=comandos;
        this.layoutInflater=LayoutInflater.from(context);
    }
    @Override
    public int getCount() {
        return comandos.size();
    }
    @Override
    public Object getItem(int position) {
        return comandos.get(position);
    }
    @Override
    public long getItemId(int position) {
        return position;
    }
    @Override
    public View getView(int position, View convertView, final ViewGroup parent) {
        final View itemView=this.layoutInflater.inflate(R.layout.item_comandos_adapter,null);
        //TextView textViewIdComandoAdapter=itemView.findViewById(R.id.textViewIdComandoAdapter);

        TextView textViewNombreComandoAdapter=itemView.findViewById(R.id.textViewNombreComandoAdapter);
        TextView textViewDatosComandoAdapter=itemView.findViewById(R.id.textViewDatosComandoAdapter);
        Comando comando=comandos.get(position);
        //textViewIdComandoAdapter.setText(String.valueOf(comando.getId()));
        textViewNombreComandoAdapter.setText(comando.getNombre());
        textViewDatosComandoAdapter.setText(comando.getDatos());

        return itemView;
    }




}
