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

public interface ISSHCodeServices {
    @GET("clientes/pruebaConexion")
    Call<String> pruebaConexion();

    /**
     *
     * Clave
     *
     */

    @FormUrlEncoded
    @POST("claves/guardarClave")
    Call<String> subirArchivoConLaClavePublica(@Field("archivo")String archivo);

    /**
     *
     * Clientes
     *
     */

    @GET("clientes/index")
    Call<List<Cliente>> mostrarClientes();

    //http://ssh.tipolisto.es/api/cliente/mostrarUnCliente.php?id=8
    @GET("clientes/find/{id}")
    Call<Cliente> mostrarUnCliente(@Path("id") int id);

    @FormUrlEncoded
    @POST("clientes/insert")
    Call<String> insertarCliente(@Field("cif") String cif, @Field("nombre") String nombre,@Field("datos") String datos);

    @FormUrlEncoded
    @POST("clientes/update")
    Call<String> actualizarCliente(@Field("id") int id,@Field("cif") String cif, @Field("nombre") String nombre,@Field("datos") String datos);

    @GET("clientes/delete/{id}")
    Call<String> eliminarCliente(@Path("id") int id);



    /**
     *
     * Comando
     *
     */
    @GET("comandos/index")
    Call<List<Comando>> mostrarComandos();

    //http://ssh.tipolisto.es/api/cliente/mostrarUnCliente.php?id=8
    @GET("comandos/find/{id}")
    Call<Comando> mostrarUnComando(@Path("id") int id);

    @FormUrlEncoded
    @POST("comandos/insert")
    Call<String> insertarComando(@Field("nombre") String nombre,@Field("datos") String datos);

    @FormUrlEncoded
    @POST("comandos/update")
    Call<String> actualizarComando(@Field("id") int id, @Field("nombre") String nombre,@Field("datos") String datos);

    @GET("comandos/delete/{id}")
    Call<String> eliminarComando(@Path("id") int id);







    /**
     *
     * ClientesComando
     *
     */
    @GET("clientesComandos/findOneClient/{id}")
    Call<List<ClienteComando>> mostrarComandosDeUnCliente(@Path("id") int id);
    //Call<String> mostrarComandosDeUnCliente(@Query("id") int id);
    @FormUrlEncoded
    @POST("clientesComandos/insert")
    Call<String> insertarClienteComando(@Field("idCliente") int idCliente,@Field("idComando") int idComando);

    @GET("clientesComandos/delete/{id}")
    Call<String> eliminarClienteComando(@Path("id") int id);



}
