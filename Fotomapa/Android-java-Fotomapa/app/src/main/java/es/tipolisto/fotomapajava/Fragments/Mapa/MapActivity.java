package es.tipolisto.fotomapajava.Fragments.Mapa;

import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdate;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;

import es.tipolisto.fotomapajava.R;

public class MapActivity extends AppCompatActivity implements OnMapReadyCallback {
    private GoogleMap mapa;
    Button btnOpciones, btnMover;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_map);
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);


        MapFragment mapFragment = (MapFragment) getFragmentManager()
                .findFragmentById(R.id.map);

        mapFragment.getMapAsync(this);

        btnOpciones = (Button)findViewById(R.id.btnOpciones);
        btnOpciones.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                cambiarOpciones();
            }
        });
        btnMover = (Button)findViewById(R.id.btnMover);
        btnMover.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                moverMadrid();
            }
        });


    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        Log.d("Mensaje", "Mapa leido");
        mapa = googleMap;
        mapa.setMinZoomPreference(10);
        mapa.setMaxZoomPreference(15);
        iniciarMapa();
    }


    private void cambiarOpciones()
    {
        mapa.setMapType(GoogleMap.MAP_TYPE_SATELLITE);
        mapa.getUiSettings().setZoomControlsEnabled(true);
    }

    private void moverMadrid()
    {
        CameraUpdate camUpd1 =
                CameraUpdateFactory
                        .newLatLngZoom(new LatLng(40.41, -3.69), 5);


        mapa.moveCamera(camUpd1);
    }


    private void iniciarMapa(){
        LatLng latLngMurcia=new LatLng(37.9962351773258, -1.1251189440552025);
        //bearing es la horientación de la cámara hacia el este
        //El tild le da un efecto  de 3 dimensiones
        CameraPosition cameraPosition=new CameraPosition.Builder()
                .target(latLngMurcia)
                .zoom(15)
                .bearing(90)
                .tilt(90)
                .build();
        mapa.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));
        mapa.setOnMapClickListener(new GoogleMap.OnMapClickListener() {
            @Override
            public void onMapClick(LatLng latLng) {
                Toast.makeText(MapActivity.this, "Latitud: "+latLng.latitude+", longitud: "+latLng.longitude, Toast.LENGTH_SHORT).show();
            }
        });
        crearMarcador(latLngMurcia, "Murcia");
    }


    private void crearMarcador(LatLng latLng, String lugar){
        MarkerOptions markerOptions=new MarkerOptions();
        markerOptions.position(latLng);
        markerOptions.title(lugar);
        mapa.addMarker(markerOptions);

        /**
         * Creamos su evento
         */

    }
}
