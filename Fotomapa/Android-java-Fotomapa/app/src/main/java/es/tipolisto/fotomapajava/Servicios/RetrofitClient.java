package es.tipolisto.fotomapajava.Servicios;

import es.tipolisto.fotomapajava.Entidades.ForeCast;
import es.tipolisto.fotomapajava.Utilidades.Constantes;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class RetrofitClient {
    public static IFotoMapaService getService(){
        //Preparamos la instancia de retrofit
        Retrofit retrofit=new Retrofit.Builder()
                .baseUrl(Constantes.BASE_URL_FOTMAPA)
                .addConverterFactory(GsonConverterFactory.create())
                .build();
        //Creamos una clase que implemente la instancia del servicio
        IFotoMapaService iFotoMapaService=retrofit.create(IFotoMapaService.class);
        return iFotoMapaService;
    }

    /*private void apiRetrofitOpenWeather(){

        Retrofit retrofit=new Retrofit.Builder()
                .baseUrl(Constantes.BASE_URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        IWeatherService iWeatherService=retrofit.create(IWeatherService.class);


        Call callCity=iWeatherService.getCity(Constantes.COORDENADAS_USA,Constantes.API_KEY);


        callCity.enqueue(new Callback<ForeCast>() {
            @Override
            public void onResponse(Call<ForeCast> call, Response<ForeCast> response) {
                ForeCast foreCast=response.body();

            }

            @Override
            public void onFailure(Call<ForeCast> call, Throwable t) {

            }
        });
    }*/
}
