package es.tipolisto.fotomapajava.Servicios;

import java.util.List;

import es.tipolisto.fotomapajava.Entidades.Foto;
import es.tipolisto.fotomapajava.Entidades.ListaFotos;
import es.tipolisto.fotomapajava.Entidades.User;
import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Part;
import retrofit2.http.Path;

public interface IFotoMapaService {
    /**
     * Foto
     */
    @GET("photo/showall")
    Call<List<Foto>> getFotos();

    @GET("photo/show/{id}")
    Call<Foto> getFoto(@Path("id") int id);

    //int id, String name, String text, String type, String address, String city, float lat, float lng, int user, String timestamp

    @FormUrlEncoded
    @POST("photo/create")
    Call<String> createPhoto(@Field("imagen") String imagen,@Field("name") String name, @Field("text") String text, @Field("type") String type, @Field("address") String address, @Field("city") String city, @Field("lat") String lat, @Field("lng") String lng, @Field("user") String user, @Field("timestamp") String timestamp);


   /**
     * User
     */
    @FormUrlEncoded
    @POST("usuario/login")
    Call<String> login(@Field("email") String email, @Field("password") String password);

    @GET("usuario/showall")
    Call<List<User>> getUsuarios();
    @POST("usuario/create")
    Call<String> createUser(@Part("name") String name, @Part("email") String email, @Part("password") String password);

}
