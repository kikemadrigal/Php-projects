package es.tipolisto.sshconnect;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import es.tipolisto.sshconnect.Activities.Conexiones.ConexionesActivity;

public class SplashScreenActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash_screen);

        //Animation animation= AnimationUtils.loadAnimation(getApplicationContext(), R.anim.animacion_splash_screen);




        Intent intent=new Intent(this, ConexionesActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
        finish();
    }
}
