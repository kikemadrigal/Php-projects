package es.tipolisto.fotomapajava.Fragments.MenuPrincipal;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.util.List;

import es.tipolisto.fotomapajava.Entidades.Foto;
import es.tipolisto.fotomapajava.R;

public class MenuPrincipalAdapter extends BaseAdapter {
    private List<Foto> fotos;
    private Context context;
    private LayoutInflater layoutInflater;
    public MenuPrincipalAdapter(Context context, List<Foto> fotos){
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
        ViewHolder viewHolder;
        if(convertView==null){
            //Inflamos nuestra vista
            convertView=layoutInflater.inflate(R.layout.item_para_grid_view_menu_principal_adapter, null);
            viewHolder=new ViewHolder();
            viewHolder.imagen=convertView.findViewById(R.id.imageViewItemMenuPrincipalFragment);
            viewHolder.texto=convertView.findViewById(R.id.textView1ItemMenuPrincipalFragment);
            viewHolder.otrosDatos=convertView.findViewById(R.id.textView2ItemMenuPrincipalFragment);
            convertView.setTag(viewHolder);
        }else{
            viewHolder=(ViewHolder)convertView.getTag();
        }

        Foto foto=fotos.get(position);
        String url="https://fotomapa.es/resources/imagesusers/"+foto.getUser()+"/"+foto.getName();

        Picasso.get()
                .load(url)
                .resize(50, 50)
                .centerCrop()
                .into(viewHolder.imagen);

        viewHolder.texto.setText(foto.getName());
        viewHolder.otrosDatos.setText(foto.getText());
        return convertView;
    }
    /**
     * Patrón View Holder Patern -vista poseedora modelo
     */
    static class ViewHolder{
        private ImageView imagen;
        private TextView texto;
        private TextView otrosDatos;
    }
}
