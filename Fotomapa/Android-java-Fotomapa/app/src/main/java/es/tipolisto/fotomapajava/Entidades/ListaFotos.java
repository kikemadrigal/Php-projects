package es.tipolisto.fotomapajava.Entidades;

import java.util.List;

import es.tipolisto.fotomapajava.Entidades.Foto;

public class ListaFotos {
    private List<Foto> fotos;


    public ListaFotos(List<Foto> fotos) {
        this.fotos = fotos;
    }

    public List<Foto> getFotos() {
        return fotos;
    }

    public void setFotos(List<Foto> fotos) {
        this.fotos = fotos;
    }
}
