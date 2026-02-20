package es.tipolisto.sshconnect.Models;

public class Pings {
    private String ipHost;
    private String nombreHost;
    private String macHost;
    private boolean pingHost;

    public Pings(String ipHost, String nombreHost, boolean pingHost) {
        this.ipHost = ipHost;
        this.nombreHost = nombreHost;
        this.pingHost = pingHost;
    }

    public String getIpHost() {
        return ipHost;
    }

    public void setIpHost(String ipHost) {
        this.ipHost = ipHost;
    }

    public String getNombreHost() {
        return nombreHost;
    }

    public void setNombreHost(String nombreHost) {
        this.nombreHost = nombreHost;
    }

    public boolean isPingHost() {
        return pingHost;
    }

    public void setPingHost(boolean pingHost) {
        this.pingHost = pingHost;
    }

    @Override
    public String toString() {
        return "Pings{" +
                "ipHost='" + ipHost + '\'' +
                ", nombreHost='" + nombreHost + '\'' +
                ", pingHost=" + pingHost +
                '}';
    }
}
