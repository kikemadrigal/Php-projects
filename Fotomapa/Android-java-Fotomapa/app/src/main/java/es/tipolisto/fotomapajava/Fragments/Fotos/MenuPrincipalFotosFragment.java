package es.tipolisto.fotomapajava.Fragments.Fotos;


import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.List;

import es.tipolisto.fotomapajava.Entidades.Foto;
import es.tipolisto.fotomapajava.R;
import es.tipolisto.fotomapajava.Servicios.IFotoMapaService;
import es.tipolisto.fotomapajava.Servicios.RetrofitClient;
import es.tipolisto.fotomapajava.Utilidades.Constantes;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

/**
 * A simple {@link Fragment} subclass.
 */
public class MenuPrincipalFotosFragment extends Fragment {
    private TextView textView;
    private ListView listView;
    public MenuPrincipalFotosFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        Log.d("Mensaje", "Cargado fotos");
        apiRetrofitFotoMapa();
        // Inflate the layout for this fragment
        View view=inflater.inflate(R.layout.fragment_menu_principal_fotos, container, false);
        listView=view.findViewById(R.id.list);
        return view;
    }

    private void apiRetrofitFotoMapa(){


        //Preparamos la petición o la Request pero todavía no lo hemos ejecutado
        Call callGetFotos= RetrofitClient.getService().getFotos();

        //Para ejecutarlo:
        callGetFotos.enqueue(new Callback<List<Foto>>() {
            @Override
            public void onResponse(Call<List<Foto>> call, Response<List<Foto>> response) {
                List<Foto> fotos=response.body();
                MenurincipalFotosFragmentAdapter arrayAdapter=new MenurincipalFotosFragmentAdapter(getContext(), fotos);
                listView.setAdapter(arrayAdapter);
            }

            @Override
            public void onFailure(Call<List<Foto>> call, Throwable t) {
                Toast.makeText(getContext(), "Ups, algo ha salido mal", Toast.LENGTH_SHORT).show();
                Log.d("Mensaje", "Mal");
            }
        });
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        Log.d("Mensaje", "Se han recibido datos en ;emiPrincipalFotosFragment");

    }
}
