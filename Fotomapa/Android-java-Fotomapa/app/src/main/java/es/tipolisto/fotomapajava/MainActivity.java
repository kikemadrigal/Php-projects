package es.tipolisto.fotomapajava;

import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.location.Location;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.support.design.widget.NavigationView;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Base64;
import android.util.Log;
import android.view.ContextMenu;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Toast;

import java.io.ByteArrayOutputStream;
import java.util.List;

import es.tipolisto.fotomapajava.Entidades.ForeCast;
import es.tipolisto.fotomapajava.Entidades.Foto;
import es.tipolisto.fotomapajava.Fragments.Fotos.CrearFotoFragment;
import es.tipolisto.fotomapajava.Fragments.Fotos.MenuPrincipalFotosFragment;
import es.tipolisto.fotomapajava.Fragments.Mapa.MapActivity;
import es.tipolisto.fotomapajava.Fragments.Mapa.MenuPrincipalMapaFragment;
import es.tipolisto.fotomapajava.Fragments.MenuPrincipal.MenuPricipalFragment;
import es.tipolisto.fotomapajava.Fragments.Usuarios.MenuPrincipalUsuariosFragment;
import es.tipolisto.fotomapajava.Servicios.IFotoMapaService;
import es.tipolisto.fotomapajava.Servicios.IWeatherService;
import es.tipolisto.fotomapajava.Utilidades.Constantes;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

import static es.tipolisto.fotomapajava.Utilidades.Funciones.removeSharedPreferences;

public class MainActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {
    private static MainActivity mainActivity;
    //Atributo utilizado para ver si la respuesta es de tomar un foto
    private static final int REQUEST_IMAGE_CAPTURE=1;
    private Bitmap bitmapFoto;
    private String stringBitMap;
    private Location location;

    private Menu miMenu;
    public static MainActivity getInstance(){
        if(mainActivity==null){
            mainActivity=new MainActivity();
        }
        return mainActivity;
    }

    public Bitmap getBitmapFoto() {
        return bitmapFoto;
    }

    public void setBitmapFoto(Bitmap bitmapFoto) {
        this.bitmapFoto = bitmapFoto;
    }

    public String getStringBitMap() {
        return stringBitMap;
    }

    public void setStringBitMap(String stringBitMap) {
        this.stringBitMap = stringBitMap;
    }

    public Menu getMiMenu() {
        return miMenu;
    }

    public void setMiMenu(Menu miMenu) {
        this.miMenu = miMenu;
    }

    public Location getLocation() {
        return location;
    }

    public void setLocation(Location location) {
        this.location = location;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        //getSupportActionBar().setIcon(R.mipmap.ic_mapa);
        //getSupportActionBar().setDisplayUseLogoEnabled(true);
        //getSupportActionBar().setDisplayShowHomeEnabled(true);
        //Mostrar icono


        /*FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Replace with your own action", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();
            }
        });*/

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);



        //Esto lo hacemos para detectar que salga elmenu principalcuando sea la primeravez que se carga
        //Sino pusiermos el if al cambiar la rotación de la pantalla cambiaríaal menuprincipal
        if(savedInstanceState==null){
            cambiarDeFragment(new MenuPricipalFragment());
        }



        mainActivity=this;

        //Toast.makeText(mainActivity, "Ha vuelto a MainActivity create", Toast.LENGTH_LONG).show();
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }



    /************Menus*************************/
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        miMenu=menu;
        getMenuInflater().inflate(R.menu.main, menu);

        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();

        if (id == R.id.action_logout) {
            removeSharedPreferences(getApplicationContext());
            return true;
        }else if(id==R.id.anadir_item){
            //Deshabilitamos el boton de añadir foto
            miMenu.findItem(R.id.anadir_item).setVisible(false);
            cambiarDeFragment(new MenuPrincipalMapaFragment());
            return true;
        }else if(id==R.id.ir_a_login){
            Intent intent=new Intent(MainActivity.this, LoginActivity.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK |Intent.FLAG_ACTIVITY_CLEAR_TASK);
            startActivity(intent);
            finish();
        }

        return super.onOptionsItemSelected(item);
    }


    @Override
    public void onCreateContextMenu(ContextMenu menu, View v, ContextMenu.ContextMenuInfo menuInfo) {
        super.onCreateContextMenu(menu, v, menuInfo);
        getMenuInflater().inflate(R.menu.context_menu,menu);

    }

    @Override
    public boolean onContextItemSelected(MenuItem item) {
        AdapterView.AdapterContextMenuInfo adapterContextMenuInfo=(AdapterView.AdapterContextMenuInfo) item.getMenuInfo();
        if(item.getItemId()==R.id.borrar_item){
            getMiMenu().findItem(R.id.anadir_item).setVisible(true);
            Toast.makeText(mainActivity, "Borrado!", Toast.LENGTH_SHORT).show();
            return true;
        }else if(item.getItemId()==R.id.editar_item){
            getMiMenu().findItem(R.id.anadir_item).setVisible(true);
            Toast.makeText(mainActivity, "Editado!", Toast.LENGTH_SHORT).show();
            return true;
        }

        return super.onContextItemSelected(item);
    }

    /**********Fin de menús*********************/


    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        int id = item.getItemId();

        if (id == R.id.nav_menu_principal) {
            getMiMenu().findItem(R.id.anadir_item).setVisible(true);
            cambiarDeFragment(new MenuPricipalFragment());
        } else if (id == R.id.nav_fotos) {
            getMiMenu().findItem(R.id.anadir_item).setVisible(true);
            cambiarDeFragment(new MenuPrincipalFotosFragment());
        } else if (id == R.id.nav_mapa) {
            getMiMenu().findItem(R.id.anadir_item).setVisible(false);
            cambiarDeFragment(new MenuPrincipalMapaFragment());
        } else if (id == R.id.nav_usuarios) {
            getMiMenu().findItem(R.id.anadir_item).setVisible(true);
            cambiarDeFragment(new MenuPrincipalUsuariosFragment());
        } else if (id == R.id.nav_send) {
            Toast.makeText(mainActivity, "Sin acción definida", Toast.LENGTH_LONG).show();
        }else if (id == R.id.nav_share) {
            Toast.makeText(mainActivity, "Sin acción definida", Toast.LENGTH_LONG).show();
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }





    public void cambiarDeFragment(Fragment fragment){
        FragmentManager fragmentManager=getSupportFragmentManager();
        FragmentTransaction fragmentTransaction=fragmentManager.beginTransaction();
        fragmentTransaction.replace(R.id.contentMainAppBarActivityMain,fragment);
        fragmentTransaction.addToBackStack(null);
        //fragmentTransaction.commit();
        fragmentTransaction.commitAllowingStateLoss();
    }




    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        Log.d("Mensaje", "Se han recibido datos en MainActivity");
        if (resultCode ==RESULT_OK) {

            Bundle extras = data.getExtras();
            bitmapFoto = (Bitmap) extras.get("data");
            stringBitMap=bitMapToString(bitmapFoto);
            //Uri uriImagenSeleccionada=data.getData();
            cambiarDeFragment(new CrearFotoFragment());
            Log.d("Mensaje", "Se ha recibido una foto en MainActivity");

        }else{
            Log.d("Mensaje", "Hubo un problema al recibir la foto en MainActivity");
        }
    }

    public String bitMapToString(Bitmap bitmap){
        ByteArrayOutputStream baos=new  ByteArrayOutputStream();
        bitmap.compress(Bitmap.CompressFormat.PNG,100, baos);
        byte [] b=baos.toByteArray();
        String temp= Base64.encodeToString(b, Base64.DEFAULT);
        return temp;
    }



}
