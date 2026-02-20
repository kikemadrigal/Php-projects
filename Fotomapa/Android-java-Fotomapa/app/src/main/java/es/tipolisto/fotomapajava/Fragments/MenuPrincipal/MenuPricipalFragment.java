package es.tipolisto.fotomapajava.Fragments.MenuPrincipal;


import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.GridView;
import android.widget.ListView;
import android.widget.Toast;

import com.google.gson.JsonIOException;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.List;

import es.tipolisto.fotomapajava.Entidades.City;
import es.tipolisto.fotomapajava.Entidades.Foto;
import es.tipolisto.fotomapajava.Fragments.Fotos.MenurincipalFotosFragmentAdapter;
import es.tipolisto.fotomapajava.Fragments.Fotos.MostrarFotoFragment;
import es.tipolisto.fotomapajava.MainActivity;
import es.tipolisto.fotomapajava.R;
import es.tipolisto.fotomapajava.Servicios.RetrofitClient;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * A simple {@link Fragment} subclass.
 */
public class MenuPricipalFragment extends Fragment implements AdapterView.OnItemClickListener {

    private ListView listView;
    private GridView gridView;
    public MenuPricipalFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view =inflater.inflate(R.layout.fragment_menu_pricipal, container, false);
        //listView=view.findViewById(R.id.listViewMenuPrincipal);
        //listView.setOnItemClickListener(this);
        gridView=view.findViewById(R.id.gridViwew);
        gridView.setOnItemClickListener(this);
        registerForContextMenu(gridView);

        Call<List<Foto>> callFotos= RetrofitClient.getService().getFotos();
        callFotos.enqueue(new Callback<List<Foto>>() {
            @Override
            public void onResponse(Call<List<Foto>> call, Response<List<Foto>> response) {
                MenuPrincipalAdapter menuPrincipalAdapter=new MenuPrincipalAdapter(getContext(), response.body());
                //listView.setAdapter(menuPrincipalAdapter);
                gridView.setAdapter(menuPrincipalAdapter);
            }

            @Override
            public void onFailure(Call<List<Foto>> call, Throwable t) {
                Toast.makeText(getContext(), "Ups, algo ha ido mal", Toast.LENGTH_SHORT).show();
            }
        });

        return view;
    }


    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
        Foto foto=(Foto)parent.getItemAtPosition(position);
        MostrarFotoFragment mostrarFotoFragment=new MostrarFotoFragment();
        mostrarFotoFragment.setFoto(foto);
        MainActivity.getInstance().cambiarDeFragment(mostrarFotoFragment);
       // Toast.makeText(getContext(), "Bien"+foto.getName(), Toast.LENGTH_SHORT).show();
    }


}
