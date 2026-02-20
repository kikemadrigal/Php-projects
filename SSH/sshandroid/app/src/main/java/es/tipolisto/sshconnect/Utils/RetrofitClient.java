package es.tipolisto.sshconnect.Utils;

import android.content.Context;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;

import java.io.IOException;
import java.io.InputStream;
import java.security.KeyManagementException;
import java.security.KeyStore;
import java.security.KeyStoreException;
import java.security.NoSuchAlgorithmException;
import java.security.cert.Certificate;
import java.security.cert.CertificateException;
import java.security.cert.CertificateFactory;

import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.SSLContext;
import javax.net.ssl.SSLSession;
import javax.net.ssl.SSLSocketFactory;
import javax.net.ssl.TrustManager;
import javax.net.ssl.TrustManagerFactory;
import javax.net.ssl.X509TrustManager;

import es.tipolisto.sshconnect.R;
import okhttp3.OkHttpClient;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class RetrofitClient {
    public RetrofitClient(){

    }
    /*
    public static ISSHServices getServiceConCeretificado(Context context){
        try {
            //https://stackoverflow.com/questions/2642777/trusting-all-certificates-using-httpclient-over-https/6378872#6378872
            // Load CAs from an InputStream
            CertificateFactory certificateFactory = CertificateFactory.getInstance("X.509");

            //InputStream inputStream = context.getResources().openRawResource(R.raw.ssl_certificate); //(.crt)
            InputStream inputStream =context.getAssets().open("ClientAuth_CA.scc");
            Certificate certificate = certificateFactory.generateCertificate(inputStream);

            inputStream.close();

            // Create a KeyStore containing our trusted CAs
            // Cree un KeyStore que contenga nuestras CA confiables
            String keyStoreType = KeyStore.getDefaultType();
            KeyStore keyStore = KeyStore.getInstance(keyStoreType);
            keyStore.load(null, null);
            keyStore.setCertificateEntry("ca", certificate);

            // Create a TrustManager that trusts the CAs in our KeyStore.
//           // Cree un TrustManager que confíe en las CA en nuestro KeyStore
            String tmfAlgorithm = TrustManagerFactory.getDefaultAlgorithm();
            TrustManagerFactory trustManagerFactory = TrustManagerFactory.getInstance(tmfAlgorithm);
            trustManagerFactory.init(keyStore);

            TrustManager[] trustManagers = trustManagerFactory.getTrustManagers();
            X509TrustManager x509TrustManager = (X509TrustManager) trustManagers[0];


            // Create an SSLSocketFactory that uses our TrustManager
            SSLContext sslContext = SSLContext.getInstance("SSL");
            sslContext.init(null, new TrustManager[]{x509TrustManager}, null);
            SSLSocketFactory sslSocketFactory = sslContext.getSocketFactory();

            //create Okhttp client
            OkHttpClient client = new OkHttpClient.Builder()
                    .sslSocketFactory(sslSocketFactory,x509TrustManager)
                    .build();
            //Preparamos la instancia de retrofit
            Retrofit retrofit=new Retrofit.Builder()
                    .baseUrl("http://ssh.tipolisto.es/api/")
                    .addConverterFactory(GsonConverterFactory.create())
                    .client(client)
                    .build();
            //Creamos una clase que implemente la instancia del servicio
            ISSHServices isshServices=retrofit.create(ISSHServices.class);
            return isshServices;
        } catch (CertificateException e) {
            e.printStackTrace();
            return null;
        } catch (NoSuchAlgorithmException e) {
            e.printStackTrace();
            return null;
        } catch (KeyStoreException e) {
            e.printStackTrace();
            return null;
        } catch (KeyManagementException e) {
            e.printStackTrace();
            return null;
        } catch (IOException e) {
            e.printStackTrace();
            return null;
        }



    }*/

    //.client(getUnsafeOkHttpClient().build())
    public static ISSHServices getServiceISSH(AppCompatActivity context){
        SharedPreferences prefs =context.getSharedPreferences("MisPreferencias", Context.MODE_PRIVATE);
        String direccionServidor=prefs.getString("servidor", "");
        boolean modoCodeigniter=prefs.getBoolean("modoCodeigniter", false);
        //Si hemos guardado en las preferencias el modocodeigniter a activado, le asgnamos la dirección de este modo
        if(modoCodeigniter){
            direccionServidor="http://"+direccionServidor+"/sshcode/api/";
        }else{
            direccionServidor="http://"+direccionServidor+"/ssh/api/";
        }
        Log.d("Mensaje", "La doreccion del servidor es: "+direccionServidor);
        // Log.i("Mensaje", ": " + pref.getString("servidor", "Sin seridor"));
        Retrofit retrofit=new Retrofit.Builder()
                .baseUrl(direccionServidor)
                .addConverterFactory(GsonConverterFactory.create())
                .build();
        //Creamos una clase que implemente la instancia del servicio
        ISSHServices isshServices=retrofit.create(ISSHServices.class);
        return isshServices;
    }
    public static ISSHCodeServices getServiceISSHCode(AppCompatActivity context){
        SharedPreferences prefs =context.getSharedPreferences("MisPreferencias", Context.MODE_PRIVATE);
        String direccionServidor=prefs.getString("servidor", "");
        boolean modoCodeigniter=prefs.getBoolean("modoCodeigniter", false);
        //Si hemos guardado en las preferencias el modocodeigniter a activado, le asgnamos la dirección de este modo
        if(modoCodeigniter){
            direccionServidor="http://"+direccionServidor+"/sshcode/api/";
        }else{
            direccionServidor="http://"+direccionServidor+"/ssh/api/";
        }
        Log.d("Mensaje", "La doreccion del servidor es: "+direccionServidor);
        // Log.i("Mensaje", ": " + pref.getString("servidor", "Sin seridor"));
        Retrofit retrofit=new Retrofit.Builder()
                .baseUrl(direccionServidor)
                .addConverterFactory(GsonConverterFactory.create())
                .build();
        //Creamos una clase que implemente la instancia del servicio
        ISSHCodeServices isshCodeServices=retrofit.create(ISSHCodeServices.class);
        return isshCodeServices;
    }




    /*
    public static OkHttpClient.Builder getUnsafeOkHttpClient() {
        try {
            // Create a trust manager that does not validate certificate chains
            final TrustManager[] trustAllCerts = new TrustManager[]{
                    new X509TrustManager() {
                        @Override
                        public void checkClientTrusted(java.security.cert.X509Certificate[] chain, String authType) throws CertificateException {
                        }

                        @Override
                        public void checkServerTrusted(java.security.cert.X509Certificate[] chain, String authType) throws CertificateException {
                        }

                        @Override
                        public java.security.cert.X509Certificate[] getAcceptedIssuers() {
                            return new java.security.cert.X509Certificate[]{};
                        }
                    }
            };

            // Install the all-trusting trust manager
            final SSLContext sslContext = SSLContext.getInstance("SSL");
            sslContext.init(null, trustAllCerts, new java.security.SecureRandom());

            // Create an ssl socket factory with our all-trusting manager
            final SSLSocketFactory sslSocketFactory = sslContext.getSocketFactory();

            OkHttpClient.Builder builder = new OkHttpClient.Builder();
            builder.sslSocketFactory(sslSocketFactory, (X509TrustManager) trustAllCerts[0]);
            builder.hostnameVerifier(new HostnameVerifier() {
                @Override
                public boolean verify(String hostname, SSLSession session) {
                    return true;
                }
            });
            return builder;
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }*/
}
