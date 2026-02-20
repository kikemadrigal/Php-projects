package es.tipolisto.fotomapajava.Entidades;

import es.tipolisto.fotomapajava.Entidades.City;

public class ForeCast {
    private String cod;
    private City city;
    public ForeCast(){}

    public ForeCast(String cod, City city) {
        this.cod = cod;
        this.city = city;
    }

    public String getCod() {
        return cod;
    }

    public void setCod(String cod) {
        this.cod = cod;
    }

    public City getCity() {
        return city;
    }

    public void setCity(City city) {
        this.city = city;
    }

}
