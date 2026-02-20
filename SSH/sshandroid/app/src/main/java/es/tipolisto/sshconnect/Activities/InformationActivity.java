package es.tipolisto.sshconnect.Activities;

import android.content.Intent;
import android.support.v4.app.NavUtils;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;

import java.io.IOException;
import java.io.InputStream;

import es.tipolisto.sshconnect.Activities.Clientes.ClientesActivity;
import es.tipolisto.sshconnect.Activities.Comandos.ComandosActivity;
import es.tipolisto.sshconnect.Activities.Conexiones.ConexionesActivity;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.Util;

public class InformationActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_information);
        Util.crearToolbar(this);

        TextView textView = findViewById(R.id.textViewInformationActivity);

        try {
            InputStream inputStream = getAssets().open("informacion.txt");
            int tamanyo = inputStream.available();
            byte[] bytes = new byte[tamanyo];
            inputStream.read(bytes);
            inputStream.close();
            String texto = new String(bytes);
            textView.setText(texto);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        Util.crearMenu(this,item.getItemId());
        return true;
    }




}
