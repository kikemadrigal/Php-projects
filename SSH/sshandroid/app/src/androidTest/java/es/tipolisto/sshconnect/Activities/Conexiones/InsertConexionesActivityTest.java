package es.tipolisto.sshconnect.Activities.Conexiones;


import android.support.test.espresso.action.ViewActions;
import android.support.test.rule.ActivityTestRule;
import android.support.test.runner.AndroidJUnit4;

import org.junit.Rule;
import org.junit.Test;
import org.junit.runner.RunWith;

import es.tipolisto.sshconnect.R;

import static android.support.test.espresso.Espresso.onView;
import static android.support.test.espresso.action.ViewActions.typeText;
import static android.support.test.espresso.assertion.ViewAssertions.matches;
import static android.support.test.espresso.matcher.ViewMatchers.withId;
import static android.support.test.espresso.matcher.ViewMatchers.withText;

//Con esta anotación le decimos que utilizce la librería JUNit4
@RunWith(AndroidJUnit4.class)
public class InsertConexionesActivityTest {
    //Con esto le estamos diciendo que empiece a la leer el test desde el InsertarConexionesActivity
    @Rule
    public ActivityTestRule<InsertConexionActivity> mActivityRule=new ActivityTestRule<>(InsertConexionActivity.class);
    //Los siguientes métodos los ejecutará solos

    //Vamos a comprobar que todos los campos aceptan texto y que cierra el teclado
    @Test
    public void chekearCamposInsertConexionTest(){
        onView(withId(R.id.editTextUsuarioInsertConexion)).perform(typeText("Hola"), ViewActions.closeSoftKeyboard());
    }


    //Vamos a comprobar que aparece en el textViewTitulo "Nueva conexión"
    @Test
    public void chekearTextoEnTextView(){
        onView(withId(R.id.textViewTituloInsertConexion)).check(matches(withText("0Nueva conexión")));
    }
}
