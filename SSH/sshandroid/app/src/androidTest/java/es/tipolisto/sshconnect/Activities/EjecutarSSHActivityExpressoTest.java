package es.tipolisto.sshconnect.Activities;

import android.support.test.rule.ActivityTestRule;
import android.support.test.runner.AndroidJUnit4;
import android.support.v7.app.AppCompatActivity;

import org.junit.Rule;
import org.junit.Test;
import org.junit.runner.RunWith;

import es.tipolisto.sshconnect.Activities.Conexiones.InsertConexionActivity;

@RunWith(AndroidJUnit4.class)
public class EjecutarSSHActivityExpressoTest {
    //Con esto le estamos diciendo que empiece a la leer el test desde el EjecutarSSHActivutity
    @Rule
    public ActivityTestRule<EjecutarSSHActivity> mActivityRule=new ActivityTestRule<>(EjecutarSSHActivity.class);


    //Test comprobar la conexión ssh
    @Test
    public void emailValidator_CorrectEmailSimple_ReturnsTrue() {
       EjecutarSSHActivity ejecutarSSHActivity=mActivityRule.getActivity();



    }
}
