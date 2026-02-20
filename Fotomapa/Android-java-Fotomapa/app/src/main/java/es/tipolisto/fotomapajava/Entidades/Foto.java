package es.tipolisto.fotomapajava.Entidades;

public class Foto {
    private int id;
    private String name;
    private String text;
    private String type;
    private String address;
    private String city;
    private float lat;
    private float lng;
    private int user;
    private String timestamp;

    public Foto(int id, String name, String text, String type, String address, String city, float lat, float lng, int user, String timestamp) {
        this.id = id;
        this.name = name;
        this.text = text;
        this.type = type;
        this.address = address;
        this.city = city;
        this.lat = lat;
        this.lng = lng;
        this.user = user;
        this.timestamp = timestamp;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getText() {
        return text;
    }

    public void setText(String text) {
        this.text = text;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getCity() {
        return city;
    }

    public void setCity(String city) {
        this.city = city;
    }

    public float getLat() {
        return lat;
    }

    public void setLat(float lat) {
        this.lat = lat;
    }

    public float getLng() {
        return lng;
    }

    public void setLng(float lng) {
        this.lng = lng;
    }

    public int getUser() {
        return user;
    }

    public void setUser(int user) {
        this.user = user;
    }

    public String getTimestamp() {
        return timestamp;
    }

    public void setTimestamp(String timestamp) {
        this.timestamp = timestamp;
    }

    @Override
    public String toString() {
        return "Foto{" +
                "id=" + id +
                ", name='" + name + '\'' +
                ", text='" + text + '\'' +
                ", type='" + type + '\'' +
                ", address='" + address + '\'' +
                ", city='" + city + '\'' +
                ", lat=" + lat +
                ", lng=" + lng +
                ", user=" + user +
                ", timestamp='" + timestamp + '\'' +
                '}';
    }
}
