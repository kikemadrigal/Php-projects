package es.tipolisto.fotomapa.Fragments.MenuPrincipal


import android.content.Intent
import android.os.Bundle
import android.support.v4.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.Toast
import es.tipolisto.fotomapa.Fragments.Fotos.FotosFragment
import es.tipolisto.fotomapa.Fragments.Mapa.MapaFragment
import es.tipolisto.fotomapa.MainActivity

import es.tipolisto.fotomapa.R

// TODO: Rename parameter arguments, choose names that match
// the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
private const val ARG_PARAM1 = "param1"
private const val ARG_PARAM2 = "param2"

/**
 * A simple [Fragment] subclass.
 *
 */
class MenuPrincpalFragment : Fragment(), View.OnClickListener {


    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?,savedInstanceState: Bundle?): View? {
        //Re3cuperamos la vista

        val view:View=inflater.inflate(R.layout.fragment_menu_princpal, container, false)
        val botonVerFotos: Button = view.findViewById(R.id.botonVerFotos)
        val botonVerMapa:Button=view.findViewById(R.id.botonVerMApa)

        botonVerFotos.setOnClickListener(this)
        botonVerMapa.setOnClickListener(this)
        return view
    }



    override fun onClick(v: View?) {
        var fotosFragment:FotosFragment=FotosFragment()
        when(v?.getId()){
            R.id.botonVerFotos->
                //Toast.makeText(context, "has pulsado boton ver fotos", Toast.LENGTH_LONG).show()
                MainActivity::getInstance()
            R.id.botonVerMApa->
               // Toast.makeText(context, "has pulsado boton ver mapa", Toast.LENGTH_LONG).show()
                MainActivity.cambiarFragment(MapaFragment())
            else->{
                Toast.makeText(context, "No has pulsado nada", Toast.LENGTH_LONG).show()
            }
        }
    }


}
