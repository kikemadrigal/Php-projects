package es.tipolisto.fotomapajava;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.text.TextUtils;
import android.util.Log;
import android.util.Patterns;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Switch;
import android.widget.Toast;

import es.tipolisto.fotomapajava.Entidades.ForeCast;
import es.tipolisto.fotomapajava.Entidades.User;
import es.tipolisto.fotomapajava.Entidades.UsuarioRespuesta;
import es.tipolisto.fotomapajava.Fragments.Mapa.MapActivity;
import es.tipolisto.fotomapajava.Servicios.IUserService;
import es.tipolisto.fotomapajava.Servicios.IWeatherService;
import es.tipolisto.fotomapajava.Servicios.RetrofitClient;
import es.tipolisto.fotomapajava.Utilidades.Constantes;
import es.tipolisto.fotomapajava.Utilidades.Funciones;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

import static es.tipolisto.fotomapajava.Utilidades.Funciones.comprobarQueHayPreferenciasGuardadas;
import static es.tipolisto.fotomapajava.Utilidades.Funciones.getPasswordPrefs;
import static es.tipolisto.fotomapajava.Utilidades.Funciones.getuserMailPrefs;
import static es.tipolisto.fotomapajava.Utilidades.Funciones.guardarPreferencias;
import static es.tipolisto.fotomapajava.Utilidades.Funciones.obtenerHash265;

public class LoginActivity extends AppCompatActivity{
    private EditText editTextemail;
    private EditText editTextPassword;
    private Switch switchRemember;

    private SharedPreferences sharedPreferences;
    private Button botonLogin;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        //Toolbar toolbar = findViewById(R.id.toolbar);
       // setSupportActionBar(toolbar);


        bindUI();


        sharedPreferences=getSharedPreferences("preferences",Context.MODE_PRIVATE);
        if(comprobarQueHayPreferenciasGuardadas(sharedPreferences)){
            Log.d("Mensaje", "Si hay preferencias guardadas: "+getuserMailPrefs(sharedPreferences)+", "+getPasswordPrefs(sharedPreferences));

        }else{
            Log.d("Mensaje", "No hay preferencias: "+getuserMailPrefs(sharedPreferences)+", "+getPasswordPrefs(sharedPreferences));
        }
        //setCredencialsIfExists();


        botonLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String email=editTextemail.getText().toString();
                final String password=editTextPassword.getText().toString();
                if(login(email,password)){
                    Call<String> callRespuestausuario=RetrofitClient.getService().login(email,password);
                    callRespuestausuario.enqueue(new Callback<String>() {
                        @Override
                        public void onResponse(Call<String> call, Response<String> response) {
                            Log.d("Mensaje", response.body());
                            String respuesta=response.body();
                            if(respuesta.equalsIgnoreCase("Autorizado")){
                                goToMain();
                                guardarPreferencias(sharedPreferences,email,password);
                            }else{
                                Toast.makeText(LoginActivity.this, response.body(), Toast.LENGTH_SHORT).show();
                            }
                        }

                        @Override
                        public void onFailure(Call<String> call, Throwable t) {
                            Log.d("Mensaje", "Ha salido mal");
                            Toast.makeText(LoginActivity.this, "Ups, algo ha salido mal", Toast.LENGTH_SHORT).show();
                        }
                    });


                }

            }
        });


    }

    private void bindUI(){
        editTextemail=findViewById(R.id.editTextEmailLoginActivity);
        editTextPassword=findViewById(R.id.editTextPasswordLoginActivity);
        switchRemember=findViewById(R.id.switchRemember);
        botonLogin=findViewById(R.id.buttonLoginActivity);
    }





    private boolean isValidEmail(String email){
        boolean isValid=false;
        boolean valoreMail=Patterns.EMAIL_ADDRESS.matcher(email).matches();
        if(TextUtils.isEmpty(email)){
            Toast.makeText(this, "El email está en blanco", Toast.LENGTH_LONG).show();
            isValid=false;
        }else if(!valoreMail){
            Toast.makeText(this, "Tienes que poner un email", Toast.LENGTH_LONG).show();
            isValid=false;
        }
        else{
            isValid=true;
        }
        return isValid;
    }
    private boolean isValidPassword(String password){
        boolean isValid=false;
        if(password.length()<=4){
            Toast.makeText(this, "El password tiene que ser mayor de 4 caracteres", Toast.LENGTH_LONG).show();
        }else{
            isValid=true;
        }
        return isValid;
    }


    private boolean login(String email, String password){
       if(!isValidEmail(email)){
           return false;
       }
       if(!isValidPassword(password)){
           return false;
       }else{
           return true;
       }
    }
    //Es importante quitar esta activity de la pila para que no se pueda volver a esta pantalla
    //Cuando se inicie sesión
    private void goToMain() {
        Intent intent=new Intent(this,MainActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
        finish();
    }



    /*private void crearRetroFit(){

        Retrofit retrofit=new Retrofit.Builder()
                .baseUrl(Constantes.BASE_URL_USER)
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        IUserService iUserService=retrofit.create(IUserService.class);


        Call<UsuarioRespuesta> callUsuarioRespuesta=iUserService.login(editTextNombreUsuario.getText().toString(), editTextPasswordusuario.getText().toString() );
        callUsuarioRespuesta.enqueue(new Callback<UsuarioRespuesta>() {
            @Override
            public void onResponse(Call<UsuarioRespuesta> call, Response<UsuarioRespuesta> response) {
                UsuarioRespuesta usuarioRespuesta=response.body();
                Toast.makeText(LoginActivity.this, "bien", Toast.LENGTH_SHORT).show();
                cambiardeActivity(MainActivity.class);
            }

            @Override
            public void onFailure(Call<UsuarioRespuesta> call, Throwable t) {
                Toast.makeText(LoginActivity.this, "Mal", Toast.LENGTH_SHORT).show();
            }
        });
    }*/




    private void cambiardeActivity(Class clase){
        Intent intent=new Intent(LoginActivity.this, clase);
        startActivity(intent);
        finish();
    }


}
