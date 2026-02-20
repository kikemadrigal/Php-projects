package es.tipolisto.fotomapajava.Servicios;

import es.tipolisto.fotomapajava.Entidades.ForeCast;
import retrofit2.Call;
import retrofit2.http.GET;
import retrofit2.http.Query;

public interface IWeatherService {
    //forecast?id=524901&appid=7a92dffe3be099c10e08312ccbd38c68
    @GET("forecast")
    Call<ForeCast> getCity(@Query("id") String city, @Query("appid") String key);
}
