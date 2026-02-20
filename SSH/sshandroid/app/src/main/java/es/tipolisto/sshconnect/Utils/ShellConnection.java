package es.tipolisto.sshconnect.Utils;



import android.content.Context;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Handler;
import android.os.Looper;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.jcraft.jsch.ChannelExec;
import com.jcraft.jsch.JSch;
import com.jcraft.jsch.JSchException;
import com.jcraft.jsch.Session;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.Properties;

import es.tipolisto.sshconnect.Models.Conexion;
import es.tipolisto.sshconnect.Models.Objects;

public class ShellConnection {

	private boolean conexionFunciona;
	private Conexion conexion;


	public ShellConnection(){

	}
	public void connectarSsh(Objects objects) {
		//Log.d("Mensaje","pasa por conectar conexionytextview");
		ShellConnectionAsyntaskRespuesta shellConnectionAsyntaskRespuesta=new ShellConnectionAsyntaskRespuesta();
		shellConnectionAsyntaskRespuesta.execute(objects);
	}


	public void probarConexion(Objects objects){

		//crearAlertDialog(this, "La conexion fue exitosa");
		Boolean exito=false;
		ShellConnectionAsyntaskPruebas shellConnectionAsyntaskPruebas = new ShellConnectionAsyntaskPruebas();
		//Log.d("Mensaje", "dentro de probarconexion "+conexion.getAlias());
		//exito=shellConnectionAsyntaskPruebas.doInBackground(conexion);
		shellConnectionAsyntaskPruebas.execute(objects);

		//shellConnectionAsyntaskPruebas.execute();
		//return exito;

	}
	public void probarConexionYDeshabilitarItem(Objects objects){
		ShellConnectionAsyntaskProbarConexionYdeshabilitarItem shellConnectionAsyntaskProbarConexionYdeshabilitarItem=new ShellConnectionAsyntaskProbarConexionYdeshabilitarItem();
		shellConnectionAsyntaskProbarConexionYdeshabilitarItem.execute(objects);
	}




	//<Entrada de doInbackground,,salida del doinbackgroun >entrada aque le vamos a pasa a la funcion doInbackground

	private class ShellConnectionAsyntaskPruebas extends AsyncTask<Objects, Void, Boolean> {

		@Override
		protected void onPostExecute(Boolean aBoolean) {
			super.onPostExecute(aBoolean);
			Log.d("Mensaje","La respuesta es: "+aBoolean);
		}

		@Override
		protected Boolean doInBackground(Objects... voids) {
			Objects objects=voids[0];
			final Conexion conexion=objects.getConexion();
			final Context context=objects.getContext();
			try {
				JSch jsch = new JSch();
				Session session = jsch.getSession(conexion.getUsuario(),conexion.getHost(), conexion.getPuerto());
				session.setPassword(conexion.getPassword());

				Properties prop = new Properties();
				prop.put("StrictHostKeyChecking", "no");
				session.setConfig(prop);

				session.connect();
				session.disconnect();
				Log.d("Mensaje", "Conexion exitosa");
				new Handler(Looper.getMainLooper()).post(new Runnable() {
					@Override
					public void run() {
						Toast.makeText(context, "Conexion exitosa", Toast.LENGTH_LONG).show();
					}
				});
				return true;

			} catch (Exception e) {
				//Toast.makeText(context, "Conexion fallida", Toast.LENGTH_LONG).show();
				Log.d("Mensaje", "Conexion fallida-->" + e.getMessage());
               // Log.d("Mensaje", "dentro de backgroun "+conexion.getUsuario()+", "+conexion.getPassword()+", "+conexion.getHost()+", "+conexion.getPuerto());
				new Handler(Looper.getMainLooper()).post(new Runnable() {
					@Override
					public void run() {
						Toast.makeText(context, "Conexion fallida", Toast.LENGTH_LONG).show();
					}
				});
				return false;
			}



		}
	}


















	private class ShellConnectionAsyntaskProbarConexionYdeshabilitarItem extends AsyncTask<Objects, Void, Boolean> {

		@Override
		protected void onPostExecute(Boolean aBoolean) {
			super.onPostExecute(aBoolean);
			//Log.d("Mensaje","La respuesta es: "+aBoolean);
		}

		@Override
		protected Boolean doInBackground(Objects... voids) {
			Objects objects =voids[0];
			final Conexion conexion= objects.getConexion();
			final Context context= objects.getContext();
			final View view= objects.getView();
			try {
				JSch jsch = new JSch();
				Session session = jsch.getSession(conexion.getUsuario(),conexion.getHost(), conexion.getPuerto());
				session.setPassword(conexion.getPassword());

				Properties prop = new Properties();
				prop.put("StrictHostKeyChecking", "no");
				session.setConfig(prop);

				session.connect();
				session.disconnect();
				//Log.d("Mensaje", "Conexion exitosa");

				//view.setEnabled(false);
				view.setBackgroundColor(Color.GREEN);

				return true;

			} catch (Exception e) {
				//Toast.makeText(context, "Conexion fallida", Toast.LENGTH_LONG).show();
				//Log.d("Mensaje", "Conexion fallida-->" + e.getMessage());
				// Log.d("Mensaje", "dentro de backgroun "+conexion.getUsuario()+", "+conexion.getPassword()+", "+conexion.getHost()+", "+conexion.getPuerto());
				//view.setEnabled(false);
				//view.setClickable(false);
				//view.setFocusable(false);
				//view.setActivated(false);
				//view.setBackgroundColor(Color.RED);
				/*view.setOnClickListener(new View.OnClickListener() {
					@Override
					public void onClick(View v) {
						new Handler(Looper.getMainLooper()).post(new Runnable() {
							@Override
							public void run() {
								Toast.makeText(context, "No se puede conectar", Toast.LENGTH_LONG).show();
							}
						});
					}
				});*/
				//view.setVisibility(View.INVISIBLE);
				return false;
			}



		}
	}




























	/*private class ShowErrorMessageAlert extends AsyncTask<Void, Void, Void> {
		protected Void doInBackground(Void... param) {
			AlertDialog alertDialog = new AlertDialog.Builder(context).create();
			alertDialog.setTitle("Alert");
			alertDialog.setMessage("Alert message to be shown");
			alertDialog.setButton(AlertDialog.BUTTON_NEUTRAL, "OK",
					new DialogInterface.OnClickListener() {
						public void onClick(DialogInterface dialog, int which) {
							dialog.dismiss();
						}
					});
			alertDialog.show();
			return null;
		}
	}*/








	private class ShellConnectionAsyntaskRespuesta extends AsyncTask<Objects, Void, Boolean> {

		@Override
		protected Boolean doInBackground(Objects... voids) {
			Objects objects = voids[0];

			try {


				executeRemoteCommand(objects);
				//executeRemoteCommand("despacho", "4143", "0.0.0.0",22);
				Log.d("Mensaje", "Conexion exitosa");
				//Toast.makeText(activity, "Conexion exitosa", Toast.LENGTH_LONG).show();
			} catch (Exception e) {
				//Toast.makeText(context, "Conexion fallida", Toast.LENGTH_LONG).show();
				Log.d("Mensaje", "Conexion fallida-->" + e.getMessage());
				//Toast.makeText(activity, "Conexion fallida", Toast.LENGTH_LONG).show();
			}
			return null;
		}

	}

















	//datos: https://www.programcreek.com/java-api-examples/?api=com.jcraft.jsch.Channel
	public void executeRemoteCommand(Objects objects) throws JSchException, IOException {

		Conexion conexion= objects.getConexion();
		String valorEditextComand=objects.getMensaje();
		TextView textView= (TextView) objects.getView();

		textView.setText("");
		String usuario = conexion.getUsuario();
		String password = conexion.getPassword();
		String host = conexion.getHost();
		int puerto = conexion.getPuerto();
		ArrayList<String> strings=new ArrayList<>();
		//ArrayList<String> resultado=new ArrayList<>();
		JSch jsch = new JSch();
		Session session = null;

		session = jsch.getSession(usuario, host, puerto);

		session.setPassword(password);

		// Avoid asking for key confirmation
		Properties prop = new Properties();
		prop.put("StrictHostKeyChecking", "no");
		session.setConfig(prop);

		session.connect();


		// SSH Channel
		ChannelExec channelssh = (ChannelExec) session.openChannel("exec");
		//Abrimos un canal de salida para poder ejecutar un comando
		ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
		channelssh.setOutputStream(byteArrayOutputStream);

		// Execute command
		channelssh.setCommand(valorEditextComand);
		//Abrimos un flujo de entrada para obetenr los datos


		channelssh.connect();

		InputStream in = channelssh.getInputStream();
		byte[] tmp = new byte[1024];
		//Log.d("Mensaje", "available : "+in.available());
		while (true) {
			while (in.available() > 0) {
				int i = in.read(tmp, 0, 1024);
				if (i < 0) {
					break;
				}
				Log.d("Mensaje", new String(tmp, 0, i));
				//resultado.add(new String(tmp, 0, i));
				String palabra =new String(tmp, 0, i);
				textView.setText(textView.getText()+palabra+"\n");
			}
			if (channelssh.isClosed()) {
				if (in.available() > 0) {
					continue;
				}
				System.out
						.println("exit-status: " + channelssh.getExitStatus());
				break;
			}
			try {
				Thread.sleep(1000);
			} catch (Exception ee) {
			}
		}


		channelssh.disconnect();

		session.disconnect();
	}















}
