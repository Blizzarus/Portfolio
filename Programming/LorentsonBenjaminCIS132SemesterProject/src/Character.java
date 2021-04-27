
/**
 * Character class for use with Battle game
 * Creates a Character object to set up stats, names and magic types for both
 * the player character and the CPU opponent
 * @author Benjamin Lorentson
 */

/* Req 8 (Class I created) */
public class Character {
    private String name;
    private int hp;
    private int mp;
    private int ptn;
    private int mgc;

    /**
     * Constructor
     */

    public Character (String name, int hp, int mp, int ptn, int mgc) {
        this.name = name;
        this.hp = hp;
        this.mp = mp;
        this.ptn = ptn;
        this.mgc = mgc;
    }

    /**
     * Accessor and mutator methods
     */

    public void setName (String name) {
        this.name = name;
    }

    public void setHp (int hp) {
        this.hp = hp;
    }

    public void setMp(int mp) {
        this.mp = mp;
    }

    public void setPtn(int ptn) {
        this.ptn = ptn;
    }

    public void setMgc(int mgc) {
        this.mgc = mgc;
    }

    public String getName() {
        return name;
    }

    public int getHp() {
        return hp;
    }

    public int getMp() {
        return mp;
    }

    public int getPtn() {
        return ptn;
    }

    public int getMgc() {
        return mgc;
    }

    /**
     * getMgcType method to return the String that corresponds to the int value given for each magic type
     */

    /* Req 7 (Method I created) */
    public String getMgcType() {
        String magicType = "";
        if (mgc == 1)
            magicType = "Fireball";
        else if (mgc == 2)
            magicType = "Frost Storm";
        else if (mgc == 3)
            magicType = "Lightning Bolt";
        else if (mgc == 4)
            magicType = "Earthquake";
        else
            System.out.println("Error: Magic Type not found");

        return magicType;
    }
}
