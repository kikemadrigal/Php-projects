package es.tipolisto.sshconnect.Adapters;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.List;

import es.tipolisto.sshconnect.Models.Cliente;
import es.tipolisto.sshconnect.Models.Wifi;
import es.tipolisto.sshconnect.R;

public class WifiAdapter extends BaseAdapter {
    private List<Wifi> wifis;
    private LayoutInflater layoutInflater;

    public WifiAdapter(Context context, List<Wifi> wifis){
        this.wifis=wifis;
        this.layoutInflater=LayoutInflater.from(context);
    }
    @Override
    public int getCount() {
        return wifis.size();
    }
    @Override
    public Object getItem(int position) {
        return wifis.get(position);
    }
    @Override
    public long getItemId(int position) {
        return position;
    }
    @Override
    public View getView(int position, View convertView, final ViewGroup parent) {
        final View itemView=this.layoutInflater.inflate(R.layout.item_listview_wifi_adapter,null);
        TextView textView=itemView.findViewById(R.id.itemListViewWifiAdapter);
        Wifi wifi=wifis.get(position);
        //textViewIdClienteAdapter.setText(String.valueOf(cliente.getId()));
        textView.setText(wifi.getSSID());
        return itemView;
    }

}
