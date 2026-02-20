package es.tipolisto.fotomapajava.Fragments.Fotos;


import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.location.Location;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Base64;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import java.io.ByteArrayOutputStream;
import java.io.File;

import es.tipolisto.fotomapajava.Fragments.MenuPrincipal.MenuPricipalFragment;
import es.tipolisto.fotomapajava.MainActivity;
import es.tipolisto.fotomapajava.R;
import es.tipolisto.fotomapajava.Servicios.IFotoMapaService;
import es.tipolisto.fotomapajava.Servicios.RetrofitClient;
import okhttp3.MediaType;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;

import static es.tipolisto.fotomapajava.Utilidades.Funciones.getResizedBitmap;
import static es.tipolisto.fotomapajava.Utilidades.Funciones.getTimeStamp;

/**
 * A simple {@link Fragment} subclass.
 */
public class CrearFotoFragment extends Fragment {
    private ImageView imageView;
    private TextView textViewOtrosDatps;
    private EditText editTextTexto;
    private Location currentLocation;

    Bitmap bitmapImagen=null;
    String stringBitmap;

    public CrearFotoFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.fragment_crear_foto, container, false);
        imageView=view.findViewById(R.id.imageViewCrearFotoFragment);


        if(MainActivity.getInstance().getBitmapFoto()==null){
            imageView.setImageResource(R.drawable.sinfoto);
        }else {
            //Obtenenemos la imagen
            bitmapImagen=MainActivity.getInstance().getBitmapFoto();
            stringBitmap=MainActivity.getInstance().getStringBitMap();
            Bitmap bitmapImagenRedimensionada=getResizedBitmap(bitmapImagen,600,400);
            imageView.setImageBitmap(bitmapImagenRedimensionada);



        }


        //RequestBody requestBody=RequestBody.create(MediaType.parse("*/*"));
        textViewOtrosDatps=view.findViewById(R.id.textViewOtrosDatosFotoFragment);
        if(MainActivity.getInstance().getLocation()==null){
            textViewOtrosDatps.setText("Sin localización");
        }else{
            textViewOtrosDatps.setText(MainActivity.getInstance().getLocation().getLatitude()+", "+MainActivity.getInstance().getLocation().getLongitude());
        }
        editTextTexto=view.findViewById(R.id.EditTextTextoCrearFotoFragment);

        Button botonVolver=view.findViewById(R.id.buttonVolverFotoFragment);
        botonVolver.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                MainActivity.getInstance().cambiarDeFragment(new MenuPricipalFragment());
            }
        });
        Button botonCrear=view.findViewById(R.id.buttonCrearFotoFragment);
        botonCrear.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(editTextTexto.getText().equals("")|| editTextTexto.getText().length()==0){
                    editTextTexto.setText("Sin texto "+getTimeStamp());
                }
                //Call<String> createPhoto(@Field("imagen") String imagen,@Field("name") String name, @Field("text") String text, @Field("type") String type, @Field("address") String address, @Field("city") String city, @Field("lat") String lat, @Field("lng") String lng, @Field("user") String user, @Field("timestamp") String timestamp);
                Call<String> callUploadFoto= RetrofitClient.getService().createPhoto(stringBitmap, editTextTexto.getText().toString(), textViewOtrosDatps.getText().toString(),"","sin direccion","","","","","");
                callUploadFoto.enqueue(new Callback<String>() {
                    @Override
                    public void onResponse(Call<String> call, Response<String> response) {
                        Toast.makeText(getContext(), "Ha salido bien--->"+response.body(), Toast.LENGTH_LONG).show();
                    }

                    @Override
                    public void onFailure(Call<String> call, Throwable t) {
                        Toast.makeText(getContext(), "Ha salido aml", Toast.LENGTH_LONG).show();
                    }
                });
            }
        });
        return view;
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        Log.d("Mensaje", "Se han recibido datos en crearFotoFragmet");
    }


    /*private String imagenToString(){
        ByteArrayOutputStream byteArrayOutputStream=new ByteArrayOutputStream();
        //El formato de compresión elegido será un jpg, la callidad 100 y la variable final
        //Bitmap bitmap=bitmapImagen.copy(Bitmap.Config.RGB_565, false);
        String valor="";
        if (!bitmapImagen.isRecycled()) {
            bitmapImagen.compress(Bitmap.CompressFormat.JPEG, 100, byteArrayOutputStream);
            byte[] imageByte=byteArrayOutputStream.toByteArray();
            Log.d("Mensaje","El tamaño es "+imageByte.length);
            valor= Base64.encodeToString(imageByte,Base64.DEFAULT);

        }
        return valor;
    }*/





}
