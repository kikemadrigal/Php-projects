package es.tipolisto.fotomapajava.Utilidades;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Matrix;
import android.text.TextUtils;
import android.util.Base64;
import android.util.Log;

import java.io.IOException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import es.tipolisto.fotomapajava.LoginActivity;

public class Funciones {
    public static boolean comprobarCamposVacíos(String campo){
        boolean vacio=true;
        if(!campo.equals("")){
            vacio=false;
        }
        return vacio;
    }

    public static String obtenerHash265(String cadena){
        MessageDigest md=null;
        try {
            md = MessageDigest.getInstance("SHA-256");
        } catch (NoSuchAlgorithmException e) {
            e.printStackTrace();
        }
        md.update(cadena.getBytes());
        return bytesToHex(md.digest());
    }
    private static String bytesToHex(byte[] bytes) {
        StringBuffer result = new StringBuffer();
        for (byte byt : bytes) result.append(Integer.toString((byt & 0xff) + 0x100, 16).substring(1));
        return result.toString();
    }










    /***********Preferencias****************/
    /**
     * Por favor, visita https://developer.android.com/guide/topics/data/data-storage?hl=es-419#pref
     * para entender el manejo de las preferencias
     */
    public static boolean comprobarQueHayPreferenciasGuardadas(SharedPreferences sharedPreferences){
        String email= getuserMailPrefs(sharedPreferences);
        String password=getPasswordPrefs(sharedPreferences);
        //False es que no hay preferencias
        if (TextUtils.isEmpty(email) && TextUtils.isEmpty(password)){
            return false;
        }else{
            return true;
        }
    }




    public static String getuserMailPrefs(SharedPreferences sharedPreferences){
        return sharedPreferences.getString("email","");
    }
    public static String getPasswordPrefs(SharedPreferences sharedPreferences){
        return sharedPreferences.getString("password","");
    }

    public static void guardarPreferencias(SharedPreferences sharedPreferences,String email, String password){
        //if(switchRemember.isChecked()){
        SharedPreferences.Editor editor=sharedPreferences.edit();
        editor.putString("email", email);
        //editor.putString("password", obtenerHash265(password));
        editor.putString("password", password);
        editor.commit();
        /**
         * También podemos utilizar el método sincrono para guardar las preferencias,
         * devuelve un booleano si algo sale mal, el aplly es asyncrono y no nos devolverá nada
         *
         */
        //editor.commit();
        Log.d("Mensaje", "Las preferencias han sido guardadas. el hash 265 de pasword es: "+obtenerHash265(password));
        // }
    }



    public static void removeSharedPreferences(Context context){
        SharedPreferences sharedPreferences= context.getSharedPreferences("preferences", context.MODE_PRIVATE);
        SharedPreferences.Editor editor=sharedPreferences.edit();
        editor.clear();
        editor.apply();
        Intent intent=new Intent(context, LoginActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        context.startActivity(intent);
    }
    /**************Final de las preferencias***************************/

    /*****Redimensionar la imagen*******************************/
    public static Bitmap getResizedBitmap(Bitmap bm, int newWidth, int newHeight) {
        int width = bm.getWidth();
        int height = bm.getHeight();
        float scaleWidth = ((float) newWidth) / width;
        float scaleHeight = ((float) newHeight) / height;
        // CREATE A MATRIX FOR THE MANIPULATION
        Matrix matrix = new Matrix();
        // RESIZE THE BIT MAP
        matrix.postScale(scaleWidth, scaleHeight);

        // "RECREATE" THE NEW BITMAP
        Bitmap resizedBitmap = Bitmap.createBitmap(bm, 0, 0, width, height, matrix, false);
        bm.recycle();
        return resizedBitmap;
    }


    public static String getTimeStamp() {

        final long timestamp = new Date().getTime();

        final Calendar cal = Calendar.getInstance();
        cal.setTimeInMillis(timestamp);

        final String timeString = new SimpleDateFormat("HH_mm_ss_SSS").format(cal.getTime());


        return timeString;
    }

}
