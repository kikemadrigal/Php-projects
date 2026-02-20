package es.tipolisto.fotomapajava;

import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;

public class SplashActivity extends AppCompatActivity {
    private SharedPreferences sharedPreferences;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);


        sharedPreferences=getSharedPreferences("preferences", MODE_PRIVATE);

        Intent intentLogin=new Intent(this, LoginActivity.class);
        Intent intentMain=new Intent(this, MainActivity.class);

        boolean estaVacioElEmail=TextUtils.isEmpty(sharedPreferences.getString("email",""));
        boolean estaVacioElPasword=TextUtils.isEmpty(sharedPreferences.getString("password",""));
        if(!estaVacioElEmail && !estaVacioElPasword){
            intentMain.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK |Intent.FLAG_ACTIVITY_CLEAR_TASK);
            startActivity(intentMain);
        }else{
            intentLogin.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK |Intent.FLAG_ACTIVITY_CLEAR_TASK);
            startActivity(intentLogin);
        }



        finish();
    }
}
