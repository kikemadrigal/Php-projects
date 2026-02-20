package es.tipolisto.sshconnect.Utils;

import java.util.List;

import es.tipolisto.sshconnect.Models.Cliente;
import es.tipolisto.sshconnect.Models.ClienteComando;
import es.tipolisto.sshconnect.Models.Comando;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Path;
import retrofit2.http.Query;


public interface ISSHServices {
    @FormUrlEncoded
    @POST("clave/guardarClave.php")
    Call<String> subirArchivoConLaClavePublica(@Field("archivo")String archivo);

    /**
     *
     * Clientes
     *
     */

    @GET("clientes/show.php")
    Call<List<Cliente>> mostrarClientes();

    //http://ssh.tipolisto.es/api/cliente/mostrarUnCliente.php?id=8
    @GET("clientes/showClient.php")
    Call<Cliente> mostrarUnCliente(@Query("id") int id);

    @FormUrlEncoded
    @POST("clientes/insert.php")
    Call<String> insertarCliente(@Field("cif") String cif, @Field("nombre") String nombre,@Field("datos") String datos);

    @FormUrlEncoded
    @POST("clientes/update.php")
    Call<String> actualizarCliente(@Field("id") int id,@Field("cif") String cif, @Field("nombre") String nombre,@Field("datos") String datos);

    @GET("cliente/eliminarCliente")
    Call<String> eliminarCliente(@Query("id") int id);



    /**
     *
     * Comando
     *
     */
    @GET("comandos/show.php")
    Call<List<Comando>> mostrarComandos();

    //http://ssh.tipolisto.es/api/cliente/mostrarUnCliente.php?id=8
    @GET("comandos/showComand.php")
    Call<Comando> mostrarUnComando(@Query("id") int id);
    //Call<String> mostrarUnComando(@Query("id") int id);

    @FormUrlEncoded
    @POST("comandos/insert.php")
    Call<String> insertarComando(@Field("nombre") String nombre,@Field("datos") String datos);

    @FormUrlEncoded
    @POST("comandos/update.php")
    Call<String> actualizarComando(@Field("id") int id, @Field("nombre") String nombre,@Field("datos") String datos);

    @GET("comandos/delete.php")
    Call<String> eliminarComando(@Query("id") int id);







    /**
     *
     * ClientesComando
     *
     */
    @GET("clientesComandos/mostrarComandosDeUnCliente.php")
    Call<List<ClienteComando>> mostrarComandosDeUnCliente(@Query("id") int id);
    //Call<String> mostrarComandosDeUnCliente(@Query("id") int id);
    @FormUrlEncoded
    @POST("clientesComandos/insert.php")
    Call<String> insertarClienteComando(@Field("idCliente") int idCliente,@Field("idComando") int idComando);

    @FormUrlEncoded
    @POST("clientesComandos/delete.php")
    Call<String> eliminarClienteComando(@Field("id") int id);


}
