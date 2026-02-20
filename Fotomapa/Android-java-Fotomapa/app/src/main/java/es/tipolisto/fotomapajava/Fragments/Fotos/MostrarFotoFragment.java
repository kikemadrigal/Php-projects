package es.tipolisto.fotomapajava.Fragments.Fotos;


import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.io.IOException;
import java.util.List;
import java.util.concurrent.ExecutionException;

import es.tipolisto.fotomapajava.Entidades.Foto;
import es.tipolisto.fotomapajava.R;
import es.tipolisto.fotomapajava.Servicios.RetrofitClient;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * A simple {@link Fragment} subclass.
 */
public class MostrarFotoFragment extends Fragment {
    private TextView textViewotrosDatos;
    private Foto foto;

    public MostrarFotoFragment() {
        // Required empty public constructor
    }

    public Foto getFoto() {
        return foto;
    }

    public void setFoto(Foto foto) {
        this.foto = foto;
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.fragment_mostrar_foto, container, false);
        TextView textViewTexto=view.findViewById(R.id.textViewTextoMostrarFotoFragment);
        textViewotrosDatos=view.findViewById(R.id.textViewOtrosDatosMostrarFotoFragment);
        if(foto!=null){
            textViewTexto.setText(foto.getName());
            textViewotrosDatos.setText(foto.getText());
            String url="https://fotomapa.es/resources/imagesusers/"+foto.getUser()+"/"+foto.getName();
            ImageView imageView=view.findViewById(R.id.imageViewMostrarFotoFragment);
            Log.d("Mensaje", "El ancho es "+view.getWidth());
            Picasso.get()
                    .load(url)
                    .resize(500, 0)
                    .centerCrop()
                    .into(imageView);
        }
        /*Peticion peticion=new Peticion();
        peticion.execute();

        try {
            textViewotrosDatos.setText(peticion.get());
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (InterruptedException e) {
            e.printStackTrace();
        }*/

        /*Call<Foto> callFoto= RetrofitClient.getService().getFoto(8);
        callFoto.enqueue(new Callback<Foto>() {
            @Override
            public void onResponse(Call<Foto> call, Response<Foto> response) {
                textViewotrosDatos.setText(response.body().getName());
                Log.d("Mensaje", "bien");
            }

            @Override
            public void onFailure(Call<Foto> call, Throwable t) {
                Log.d("Mensaje", "fallo");
            }
        });*/



        return view;
    }

    /*public static class Peticion extends AsyncTask<Void, Void, String> {

        @Override
        protected void onPreExecute() {
            super.onPreExecute();

        }

        @Override
        protected void onPostExecute(String s) {
            super.onPostExecute(s);
        }

        @Override
        protected String doInBackground(Void... voids) {
            Call<List<Foto>> callFotos= RetrofitClient.getService().getFotos();

            String datosFoto="";
            try {
                List<Foto> fotos = callFotos.execute().body();
                for(Foto foto: fotos){
                    datosFoto+="\n"+foto.getAddress();
                    datosFoto+="\n"+foto.getCity();
                    datosFoto+="\n"+foto.getTimestamp();
                    datosFoto+="\n"+foto.getType();
                }
            } catch (IOException e) {
                e.printStackTrace();
            }

            Log.d("Mensaje",datosFoto);
            return datosFoto;
        }
    }*/

}
