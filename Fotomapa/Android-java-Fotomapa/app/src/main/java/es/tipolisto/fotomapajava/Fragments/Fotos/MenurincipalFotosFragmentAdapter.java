package es.tipolisto.fotomapajava.Fragments.Fotos;

import android.content.Context;
import android.content.Intent;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.util.List;

import es.tipolisto.fotomapajava.Entidades.Foto;
import es.tipolisto.fotomapajava.R;


public class MenurincipalFotosFragmentAdapter extends BaseAdapter {
    private List<Foto> fotos;
    private Context context;
    private LayoutInflater layoutInflater;
    public MenurincipalFotosFragmentAdapter(Context context, List<Foto> fotos){
        this.context=context;
        this.fotos=fotos;
        this.layoutInflater=LayoutInflater.from(context);
    }
    @Override
    public int getCount() {
        return fotos.size();
    }

    @Override
    public Object getItem(int position) {
        return fotos.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        Foto foto=fotos.get(position);
        String url="https://fotomapa.es/resources/imagesusers/"+foto.getUser()+"/"+foto.getName();

        convertView=layoutInflater.inflate(R.layout.item_menu_principal_fotos_adapter, null);
        ImageView imageView=convertView.findViewById(R.id.imageViewItemMenuPrincipalFotoFragment);
        Picasso.get()
                .load(url)
                .resize(50, 50)
                .centerCrop()
                .into(imageView);
        TextView textView1=convertView.findViewById(R.id.textView1ItemMenuPrincipalFotoFragment);
        textView1.setText(foto.getName());
        TextView textView2=convertView.findViewById(R.id.textView2ItemMenuPrincipalFotoFragment);
        textView2.setText(foto.getText());
        return convertView;
    }


}
