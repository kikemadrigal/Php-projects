package es.tipolisto.sshconnect.Adapters;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentStatePagerAdapter;

import es.tipolisto.sshconnect.Fragments.ConexionesDatabaseFragment;
import es.tipolisto.sshconnect.Fragments.ConexionesRedFragment;

public class PagerAdapter extends FragmentStatePagerAdapter {
    private int numeroDeTabs;
    public PagerAdapter(FragmentManager fm, int numeroDeTabs) {
        super(fm);
        this.numeroDeTabs=numeroDeTabs;
    }

    @Override
    public Fragment getItem(int i) {
        switch (i){
            case 0:
                return new ConexionesDatabaseFragment();
            case 1:
                return new ConexionesRedFragment();
            default:
                return null;
        }
    }

    @Override
    public int getCount() {
        return this.numeroDeTabs;
    }
}
