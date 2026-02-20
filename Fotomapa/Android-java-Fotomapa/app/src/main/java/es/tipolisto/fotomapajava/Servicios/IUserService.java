package es.tipolisto.fotomapajava.Servicios;

import es.tipolisto.fotomapajava.Entidades.User;
import es.tipolisto.fotomapajava.Entidades.UsuarioRespuesta;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Path;
import retrofit2.http.Query;

public interface IUserService {


    /**
     * Select usuario respuesta
     */
    //Login
    @FormUrlEncoded
    @POST("login")
    Call<UsuarioRespuesta> login(@Field("name") String name, @Field("password") String password);


    /**
     * Select usuarios
     *
     */
    //Forma 1
    @GET("show/15")
    Call<User> getuser();
    //Fomar 2
    @GET("show/{idusuario}")
    Call<User> getUsusuario(@Path("idusuario") int idusuario);



}
