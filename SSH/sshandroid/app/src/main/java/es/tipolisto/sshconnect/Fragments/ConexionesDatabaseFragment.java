package es.tipolisto.sshconnect.Fragments;


import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.ListView;

import java.util.ArrayList;

import es.tipolisto.sshconnect.Activities.Conexiones.InsertConexionActivity;
import es.tipolisto.sshconnect.Activities.Conexiones.UpdateConexionActivity;
import es.tipolisto.sshconnect.Adapters.ConexionesAdapter;
import es.tipolisto.sshconnect.Models.Conexion;
import es.tipolisto.sshconnect.Models.Sqlite;
import es.tipolisto.sshconnect.R;

/**
 * A simple {@link Fragment} subclass.
 */
public class ConexionesDatabaseFragment extends Fragment  implements AdapterView.OnItemClickListener {
    ArrayList<Conexion> conexiones;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.fragment_conexiones_database, container, false);
        conexiones = new ArrayList<>();
        Button buttonInsertarNuevaConexion=view.findViewById(R.id.insertarConexionConexionesDatabaseFragment);
        buttonInsertarNuevaConexion.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(getActivity().getApplicationContext(), InsertConexionActivity.class);
                startActivity(intent);
            }
        });
        /*Button buttonActualizar=view.findViewById(R.id.actualizarVistaConexionesDatabaseFragment);
        buttonActualizar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(getActivity().getApplicationContext(), ConexionesActivity.class);
                startActivity(intent);
                getActivity().finish();
            }
        });*/
        ListView listView = view.findViewById(R.id.listViewConexionesDatabaseFragment);

        Sqlite sqlite = new Sqlite(getActivity().getApplicationContext());
        conexiones = sqlite.selectTodosLasConexiones();
        if(conexiones.size()==0){
            conexiones.add(new Conexion(0,"","","","No hay conexiones para mostrar", "", 0));
        }
        Log.d("Mensaje", "obtenidas: "+conexiones.size());
        ConexionesAdapter conexionesAdapter = new ConexionesAdapter(getActivity().getApplicationContext(), (AppCompatActivity)getActivity(), conexiones);
        listView.setAdapter(conexionesAdapter);
        listView.setOnItemClickListener(this);

        return view;
    }

    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
        Conexion conexion=(Conexion) parent.getItemAtPosition(position);
        //Toast.makeText(getApplicationContext(), "COnexion "+conexion.getAlias(), Toast.LENGTH_SHORT).show();
        Intent intent=new Intent(getActivity().getApplicationContext(), UpdateConexionActivity.class);
        intent.putExtra("id", conexion.getId());
        startActivity(intent);
    }
    /*
    @Override
    public boolean onItemLongClick(AdapterView<?> parent, View view, int position, long id) {
        final Conexion conexion=(Conexion) parent.getItemAtPosition(position);
        boolean ping= Util.executeCommandPing(conexion.getHost());


        if(ping){
            //Util.crearAlertDialog(( getActivity(),"Ping recibido!!.");
            Util.crearToast((AppCompatActivity) getActivity(),"Ping recibido");
            Log.d("Mensaje", "ping recibido");
        }else{

            //Util.crearAlertDialog((AppCompatActivity) getActivity(), "Ping perdido.");
            Util.crearToast((AppCompatActivity) getActivity(),"Ping perdido");
            Log.d("Mensaje", "ping no recibido");
        }
        return true;
    }
    */

}
