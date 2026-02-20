package es.tipolisto.sshconnect.Activities.Conexiones;



import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.os.PowerManager;
import android.preference.PreferenceManager;
import android.support.design.widget.TabLayout;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import es.tipolisto.sshconnect.Activities.WifiActivity;
import es.tipolisto.sshconnect.Fragments.ConexionesDatabaseFragment;
import es.tipolisto.sshconnect.Fragments.ConexionesRedFragment;
import es.tipolisto.sshconnect.R;
import es.tipolisto.sshconnect.Utils.Util;

public class ConexionesActivity extends AppCompatActivity {

    //Esto es para dejar la pantalla siempre activada
    PowerManager.WakeLock mWakeLock;
    //Para comprobar los permisos del acceso al wifi y accesos al 4G
    //Este atibuto será manejado por el fragment conexionesRedWifi y por el método
    //onRequestPermissionsResult de esta actividad
    private final int MY_PERMISSIONS_REQUEST_RED=104;
    //Para manejar los eventos de click del toolbar
    private Toolbar toolbar;
    ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_conexiones);
        Util.crearToolbar(this);

        //Comprobamos si existe la ip del servidor si no existe la pedimos
        //SharedPreferences pref = PreferenceManager.getDefaultSharedPreferences(ConexionesActivity.this);

        SharedPreferences prefs =
                getSharedPreferences("MisPreferencias", Context.MODE_PRIVATE);
        String direccionServidor=prefs.getString("servidor", "");
        if(TextUtils.isEmpty(direccionServidor)){
            abrirDialogoPreguntandoPorServidor();
        }

        dejarSiempreActivadaLaPantalla();
        cambiarFragment(new ConexionesDatabaseFragment());

        TabLayout tabLayout= findViewById(R.id.tabLayoutConexionesActivity);
        tabLayout.addTab(tabLayout.newTab().setText("Database"));
        tabLayout.addTab(tabLayout.newTab().setText("Network"));
        tabLayout.setTabGravity(TabLayout.GRAVITY_FILL);

        /*final ViewPager viewPager=(ViewPager) findViewById(R.id.viewPagerConexionesActivity);
        final PagerAdapter pagerAdapter=new PagerAdapter(getSupportFragmentManager(),tabLayout.getTabCount());
        viewPager.setAdapter(pagerAdapter);
        viewPager.addOnPageChangeListener(new TabLayout.TabLayoutOnPageChangeListener(tabLayout));*/

        tabLayout.addOnTabSelectedListener(new TabLayout.OnTabSelectedListener() {
            @Override
            public void onTabSelected(TabLayout.Tab tab) {

                int position=tab.getPosition();
                if(position==0){
                    cambiarFragment(new ConexionesDatabaseFragment());
                }else if(position==1){
                    cambiarFragment(new ConexionesRedFragment());
                }
            }
            @Override
            public void onTabUnselected(TabLayout.Tab tab) {

            }

            @Override
            public void onTabReselected(TabLayout.Tab tab) {

            }
        });




    }


    private void cambiarFragment(Fragment fragment) {
        FragmentManager fragmentManager = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();
        fragmentTransaction.replace(R.id.frameLayoutParaFragment,fragment);
        fragmentTransaction.addToBackStack(null);
        fragmentTransaction.commit();
    }

    private void dejarSiempreActivadaLaPantalla() {
        PowerManager pm = (PowerManager)getSystemService(Context.POWER_SERVICE);
        mWakeLock = pm.newWakeLock(PowerManager.SCREEN_DIM_WAKE_LOCK | PowerManager.ON_AFTER_RELEASE, "tipolisto:My Tag");
    }



    @Override
    protected void onResume() {
        super.onResume();
        mWakeLock.acquire();

    }

    @Override
    protected void onPause() {
        super.onPause();
        mWakeLock.release();

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



    //Los permisos devueltos por las comprobaciones deben de ser manejados aquí
    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           String permissions[], int[] grantResults) {
        switch (requestCode) {
            case MY_PERMISSIONS_REQUEST_RED: {
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    Intent intent=new Intent(this,WifiActivity.class);
                    startActivity(intent);
                    finish();
                    Toast.makeText(this, "Permiso aprobado", Toast.LENGTH_SHORT).show();

                } else {
                    Toast.makeText(this, "Permiso denegado", Toast.LENGTH_SHORT).show();
                    Intent intent=new Intent(this,ConexionesActivity.class);
                    startActivity(intent);
                    finish();
                }
                return;
            }
        }
    }



    private void abrirDialogoPreguntandoPorServidor(){
        LayoutInflater inflater = LayoutInflater.from(ConexionesActivity.this);
        View subView = inflater.inflate(R.layout.dialog_server, null);
        final EditText editTextServidor = (EditText)subView.findViewById(R.id.editTextDialogServer);


        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("Servidor");
        builder.setMessage("Introduce la dirección del servidor");
        builder.setView(subView);
        builder.setCancelable(false);
        AlertDialog alertDialog = builder.create();

        builder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                SharedPreferences prefs =
                        getSharedPreferences("MisPreferencias",Context.MODE_PRIVATE);

                SharedPreferences.Editor editor = prefs.edit();
                editor.putString("servidor", editTextServidor.getText().toString());
                editor.commit();
            }
        });

        builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                Toast.makeText(ConexionesActivity.this, "Cancelado", Toast.LENGTH_LONG).show();
            }
        });

        builder.show();
    }

}
