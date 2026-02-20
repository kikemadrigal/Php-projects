package es.tipolisto.sshconnect.Utils;

import android.app.Activity;
import android.util.Log;
import android.widget.Toast;

import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.InetAddress;

public class MagicPacket {
    private String ipStr;
    private String macStr;
    public static final int PORT = 9;

    private Activity activity;
    public MagicPacket(Activity activity, String ip, String mac){
        this.activity=activity;
        ipStr=ip;
        macStr=mac;
    }

    public void enviar(){
        new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    byte[] macBytes = getMacBytes(macStr);
                    byte[] bytes = new byte[6 + 16 * macBytes.length];
                    for (int i = 0; i < 6; i++) {
                        bytes[i] = (byte) 0xff;
                    }
                    for (int i = 6; i < bytes.length; i += macBytes.length) {
                        System.arraycopy(macBytes, 0, bytes, i, macBytes.length);
                    }
                    InetAddress address = InetAddress.getByName(ipStr);
                    DatagramPacket packet = new DatagramPacket(bytes, bytes.length, address, PORT);
                    DatagramSocket socket = new DatagramSocket();
                    socket.send(packet);
                    socket.close();
                    activity.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            Toast.makeText(activity.getApplicationContext(), "WAL enviado", Toast.LENGTH_LONG).show();
                        }
                    });
                    Log.d("Mesnaje", "Magic paquet enviado");
                }
                catch (final Exception e) {
                    activity.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            Toast.makeText(activity.getApplicationContext(), "Fallo al enviar WAL:\n "+e.getMessage(), Toast.LENGTH_LONG).show();
                        }
                    });
                    Log.d("Mesnaje", " ubo un problema al enviar "+e.getMessage());
                    System.exit(1);
                }
            }
        }).start();

    }






    private static byte[] getMacBytes(String macStr) throws IllegalArgumentException {
        byte[] bytes = new byte[6];
        String[] hex = macStr.split("(\\:|\\-)");
        if (hex.length != 6) {
            throw new IllegalArgumentException("Invalid MAC address.");
        }
        try {
            for (int i = 0; i < 6; i++) {
                bytes[i] = (byte) Integer.parseInt(hex[i], 16);
            }
        }
        catch (NumberFormatException e) {
            throw new IllegalArgumentException("Invalid hex digit in MAC address.");
        }
        return bytes;
    }
}
