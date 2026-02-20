package es.tipolisto.fotomapajava.Fragments.Usuarios;


import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.util.List;

import es.tipolisto.fotomapajava.Entidades.User;
import es.tipolisto.fotomapajava.R;
import es.tipolisto.fotomapajava.Servicios.IFotoMapaService;
import es.tipolisto.fotomapajava.Servicios.IUserService;
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
public class MenuPrincipalUsuariosFragment extends Fragment {
    private TextView textView;

    public MenuPrincipalUsuariosFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        // Inflate the layout for this fragment
        View view=inflater.inflate(R.layout.fragment_menu_principal_usuarios, container, false);
        textView=view.findViewById(R.id.textViewFragmentmenuPrincipalUsuarios);
        Call<List<User>> callUsuarios= RetrofitClient.getService().getUsuarios();
        callUsuarios.enqueue(new Callback<List<User>>() {
            @Override
            public void onResponse(Call<List<User>> call, Response<List<User>> response) {
                List<User> usuarios=response.body();
                String texto="";
                for(User user:usuarios){
                    texto+="\n"+user.getNombre();
                    texto+="\n"+user.getClave();
                    texto+="\n"+user.getTipo();
                    texto+="\n---------------------------\n";
                }
                textView.setText(texto);
            }

            @Override
            public void onFailure(Call<List<User>> call, Throwable t) {

            }
        });
        return view;
    }





}
