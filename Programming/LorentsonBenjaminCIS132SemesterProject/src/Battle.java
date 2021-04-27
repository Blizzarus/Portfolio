import java.util.Scanner;
import java.io.*;
import java.util.Random;

/**
 * This class contains the main method for the Battle game
 * Players will face an automated CPU opponent and attempt to bring the enemy's hp to 0 before falling themselves
 * @author Benjamin Lorentson
 */

public class Battle {
    public static void main(String[] args) throws FileNotFoundException {
        Scanner kb = new Scanner(System.in); // For Scanner class
        Random chance = new Random(); // For random numbers

        // Use a partially filled array to store scores to write to a file after program is finished running
        final int SCORES_SIZE = 999;
        /* Req 9 (Array) */
        int[] scores = new int[SCORES_SIZE]; // Initialize array with high number of elements for potential games played
        int rounds = 0; // Index that will increment to track number of games played

        // Create loop to surround entire game for replay purpose
        int repeat; // Repeat variable to allow game to replay
        /* Req 6 (Loop statement) */
        do {

            // Variable declarations
            int setup;
            int choice;
            int rating = 0;
            int turn = 0;
            int missfreeze;
            int damage;
            boolean frozen = false;
            boolean CPUfrozen = false;
            boolean guard = false;
            boolean CPUguard = false;
            String name = "Player";
            int hp = 0;
            int mp = 0;
            int ptn = 0;
            int mgc = 0;
            String CPUname = "Enemy";
            int CPUhp = 0;
            int CPUmp = 0;
            int CPUptn = 0;
            int CPUmgc = 0;

            /* Req 1 (name)*/
            System.out.println("Welcome to the Battle for the Ages!");
            System.out.println("Created by: Benjamin Lorentson");

            /* Req 2 (loop for validation)*/
            // Collect user's setup choice with input validation

            do {
                System.out.println("Press 1. Default Mode");
                System.out.println("Press 2. Challenge Mode");
                System.out.println("Press 3. Set up Custom Fighters");
                System.out.println("Press 4. NIGHTMARE MODE!");
                setup = kb.nextInt();
                kb.nextLine();

                /* Req 4 (If statement) */
                if (setup == 1) {
                    // Player setup
                    System.out.println("Please enter your character's name: ");
                    name = kb.nextLine();
                    hp = 100;
                    mp = 15;
                    ptn = 2;
                    mgc = 1;

                    // Enemy setup
                    CPUname = "Soldier of Darkness";
                    CPUhp = 100;
                    CPUmp = 15;
                    CPUptn = 2;
                    CPUmgc = 2;
                } else if (setup == 2) {
                    // Player setup
                    System.out.println("Please enter your character's name: ");
                    name = kb.nextLine();
                    hp = 100;
                    mp = 20;
                    ptn = 2;
                    mgc = 2;

                    // Enemy setup
                    CPUname = "Champion of Darkness";
                    CPUhp = 200;
                    CPUmp = 50;
                    CPUptn = 3;
                    CPUmgc = 3;
                } else if (setup == 3) {
                    // Custom Player setup
                    /* Req 2 (String input) */
                    System.out.println("Please enter your character's name: ");
                    name = kb.nextLine();
                    /* Req 2 (Numeric input) */
                    System.out.println("Enter your HP: ");
                    hp = kb.nextInt();
                    System.out.println("Enter your MP: ");
                    mp = kb.nextInt();
                    System.out.println("Enter your Potion Count: ");
                    ptn = kb.nextByte();
                    System.out.println("Enter your Magic Type: ");
                    System.out.println("1. Fire");
                    System.out.println("2. Frost");
                    System.out.println("3. Lightning");
                    System.out.println("4. Earth");
                    mgc = kb.nextInt();

                    // Custom Enemy setup

                    kb.nextLine();

                    System.out.println("Please enter your opponent's name: ");
                    CPUname = kb.nextLine();
                    System.out.println("Enter opponent's HP: ");
                    CPUhp = kb.nextInt();
                    System.out.println("Enter opponent's MP: ");
                    CPUmp = kb.nextInt();
                    System.out.println("Enter opponent's Potion Count: ");
                    CPUptn = kb.nextByte();
                    System.out.println("Enter opponent's Magic Type: ");
                    System.out.println("1. Fire");
                    System.out.println("2. Frost");
                    System.out.println("3. Lightning");
                    System.out.println("4. Earth");
                    CPUmgc = kb.nextInt();
                } else if (setup == 4) {
                    // Player setup
                    System.out.println("Please enter your character's name: ");
                    name = kb.nextLine();
                    hp = 100;
                    mp = 20;
                    ptn = 1;
                    mgc = 2;

                    // Enemy setup
                    CPUname = "Dreadnought of Horrors";
                    CPUhp = 500;
                    CPUmp = 50;
                    CPUptn = 1;
                    CPUmgc = 3;
                }
                else
                    System.out.println("Error: please enter an option from 1 to 4");
            } while (setup <= 0 || setup > 4); // End of validation loop for setup

            // Begin Battle

            System.out.println("Let the games begin!");
            System.out.println("");
            System.out.println("");
            System.out.println("");

            // Create two instances of the player class for player and CPU characters
            Character player = new Character(name, hp, mp, ptn, mgc);
            Character enemy = new Character(CPUname, CPUhp, CPUmp, CPUptn, CPUmgc);

            // Loop to keep battle going until one character loses all hp
            while (player.getHp() > 0 && enemy.getHp() > 0) {
                // Display stats at start of turn

                turn++; // Turn accumulator
                System.out.println("Turn #" + turn);
                System.out.printf("%-15s %20s\n", player.getName(), enemy.getName());
                System.out.printf("HP: %-15d %15d \n", player.getHp(), enemy.getHp());
                System.out.printf("MP: %-15d %15d \n", player.getMp(), enemy.getMp());
                System.out.printf("Potions: %-15d %10d \n", player.getPtn(), enemy.getPtn());
                System.out.println();
                // Display menu to player
                System.out.println("1. Melee Attack");
                System.out.println("2. " + player.getMgcType());
                System.out.println("3. Use Potion");
                System.out.println("4. Guard");
                System.out.println("Select an action (Enter number 1-4): ");
                guard = false;
                if (frozen)
                    choice = 5;
                else
                    choice = kb.nextInt();

                // Switch for user action

                /* Req 5 (Switch statement) */
                switch (choice) {
                    case 1:
                        System.out.println("You used a melee attack...");
                        /* Req 3 (Random class) */
                        missfreeze = chance.nextInt(10) + 1;
                        if (missfreeze < 3) {
                            System.out.println("Your attack missed, 0 damage dealt");
                            player.setMp(player.getMp() + 1);
                        } else if (CPUguard && missfreeze < 5) {
                            System.out.println("Your attack missed, 0 damage dealt");
                            player.setMp(player.getMp() + 1);
                        } else {
                            damage = chance.nextInt(30) + 1;
                            enemy.setHp(enemy.getHp() - damage);
                            System.out.println("Your attack hit, " + damage + " damage dealt.");
                            player.setMp(player.getMp() + 1);
                        }
                        break;
                    case 2:
                        System.out.println("You cast " + player.getMgcType());
                        if (player.getMgc() == 1) { // For if player magic is fire
                            if (player.getMp() < 2) {
                                System.out.println("Oops!  You don't have enough MP to do that...");
                                break;
                            } else {
                                damage = chance.nextInt(20) + 1;
                                enemy.setHp(enemy.getHp() - damage);
                                System.out.println("Your spell singes your enemy for " + damage + " damage.");
                                player.setMp(player.getMp() - 2);
                            }
                        }

                        else if (player.getMgc() == 2) { // for if player magic is frost
                            if (player.getMp() < 5) {
                                System.out.println("You don't have enough MP to do that...");
                                break;
                            } else {
                                damage = chance.nextInt(20) + 1;
                                enemy.setHp(enemy.getHp() - damage);
                                System.out.println("Your spell hit, " + damage + " damage dealt.");
                                player.setMp(player.getMp() - 5);

                                missfreeze = chance.nextInt(10) + 1;
                                if (missfreeze < 3) {
                                    System.out.println("You froze your opponent!");
                                    CPUfrozen = true;
                                }
                            }
                        }

                        else if (player.getMgc() == 3) { // for if player magic is lightning
                            missfreeze = chance.nextInt(10) + 1;
                            if (player.getMp() < 10) {
                                System.out.println("You don't have enough MP to do that...");
                                break;
                            } else if (missfreeze < 3) {
                                System.out.println("Your spell missed, 0 damage dealt.");
                                player.setMp(player.getMp() - 10);
                            } else {
                                damage = chance.nextInt(50) + 1;
                                enemy.setHp(enemy.getHp() - damage);
                                System.out.println("Your spell hit, " + damage + " damage dealt.");
                                player.setMp(player.getMp() - 10);
                            }
                        }

                        else if (player.getMgc() == 4) { // for if player magic is Earth
                            missfreeze = chance.nextInt(10) + 1;
                            if (player.getMp() < 3) {
                                System.out.println("You don't have enough MP to do that...");
                                break;
                            } else if (missfreeze < 3) {
                                damage = chance.nextInt(30) + 1;
                                enemy.setHp(enemy.getHp() - damage);
                                player.setHp(player.getHp() - damage);
                                player.setMp(player.getMp() - 3);
                                System.out.println("Your spell hit both you and your opponent! " + damage + " damage dealt.");
                            } else {
                                damage = chance.nextInt(30) + 1;
                                enemy.setHp(enemy.getHp() - damage);
                                System.out.println("Your spell hit, " + damage + " damage dealt.");
                                player.setMp(player.getMp() - 10);
                            }
                        }
                        break;
                    case 3:
                        if (player.getPtn() < 1) {
                            System.out.println("you don't have any potions left!");
                            player.setMp(player.getMp() + 1);
                            break;
                        } else {
                            System.out.println("You used a healing potion...");
                            System.out.println("30 HP restored!");
                            player.setHp(player.getHp() + 30);
                            player.setPtn(player.getPtn() - 1);
                            player.setMp(player.getMp() + 1);
                        }
                        break;
                    case 4:
                        System.out.println("You take a defensive stance...");
                        guard = true;
                        player.setMp(player.getMp() + 2);
                        break;
                    case 5:
                        System.out.println("You break free of the ice...");
                        frozen = false;
                        player.setMp(player.getMp() + 1);
                        break;
                    default:
                        System.out.println("Um... why are you just standing there?");
                        player.setMp(player.getMp() + 1);
                        break;
                }


                System.out.println();
                // Enemy's decision logic

                CPUguard = false; // Reset guard status at beginning of turn
                if (CPUfrozen) // If frozen, skip turn
                    choice = 5;
                else if (enemy.getHp() < 50 && enemy.getPtn() > 0) // High priority, use potion if below 50 hp and potions are available
                    choice = 3;
                    // Various magic options for different Magic Types; use if player is below 50 hp or plentiful mp is available
                else if (enemy.getMgc() == 1 && enemy.getMp() > 1 && player.getHp() < 50 || enemy.getMgc() == 1 && enemy.getMp() > 6)
                    choice = 2;
                else if (enemy.getMgc() == 2 && enemy.getMp() > 4 && player.getHp() < 50 || enemy.getMgc() == 2 && enemy.getMp() > 15)
                    choice = 2;
                else if (enemy.getMgc() == 3 && enemy.getMp() > 9 && player.getHp() < 50 || enemy.getMgc() == 3 && enemy.getMp() > 30)
                    choice = 2;
                else if (enemy.getMgc() == 4 && enemy.getMp() > 2 && player.getHp() < 50 || enemy.getMgc() == 4 && enemy.getMp() > 9)
                    choice = 2;
                else if (enemy.getHp() < 30) // Low priority, guard if below 30 hp
                    choice = 4;
                else // If no other option is applicable, use melee attack
                    choice = 1;

                // Switch for Enemy's action

                switch (choice) {
                    case 1:
                        System.out.println(CPUname + " attacks you with a melee...");
                        missfreeze = chance.nextInt(10) + 1;
                        if (missfreeze < 3) {
                            System.out.println("Opponent missed, 0 damage dealt");
                            enemy.setMp(enemy.getMp() + 1);
                        } else if (guard && missfreeze < 5) {
                            System.out.println("Your guard blocked the attack, 0 damage dealt");
                            enemy.setMp(enemy.getMp() + 1);
                        } else {
                            damage = chance.nextInt(30) + 1;
                            player.setHp(player.getHp() - damage);
                            System.out.println("The attack hits you for " + damage + " damage.");
                            enemy.setMp(enemy.getMp() + 1);
                        }
                        break;
                    case 2:
                        System.out.println(CPUname + " casts " + enemy.getMgcType());
                        if (enemy.getMgc() == 1) { // If enemy is using fire
                            damage = chance.nextInt(20) + 1;
                            player.setHp(player.getHp() - damage);
                            System.out.println("The spell singes you for " + damage + " damage.");
                            enemy.setMp(enemy.getMp() - 2);
                        } else if (enemy.getMgc() == 2) { // If enemy is using frost
                            damage = chance.nextInt(20) + 1;
                            player.setHp(player.getHp() - damage);
                            System.out.println("The spell chills you for " + damage + " damage.");
                            enemy.setMp(enemy.getMp() - 5);
                            missfreeze = chance.nextInt(10) + 1;
                            if (missfreeze < 3) {
                                System.out.println("The spell froze you!");
                                frozen = true;
                            }
                        } else if (enemy.getMgc() == 3) { // If enemy is using lightning
                            missfreeze = chance.nextInt(10) + 1;
                            if (missfreeze < 3) {
                                System.out.println("Opponent's spell missed, 0 damage dealt.");
                                enemy.setMp(enemy.getMp() - 10);
                            }
                            else {
                                damage = chance.nextInt(50) + 1;
                                player.setHp(player.getHp() - damage);
                                System.out.println("The spell shocks you for " + damage + " damage.");
                                enemy.setMp(enemy.getMp() - 10);
                            }
                        } else if (enemy.getMgc() == 4) { // If enemy is using Earth
                            missfreeze = chance.nextInt(10) + 1;
                            if (missfreeze < 3) {
                                damage = chance.nextInt(30) + 1;
                                player.setHp(player.getHp() - damage);
                                enemy.setHp(enemy.getHp() - damage);
                                enemy.setMp(enemy.getMp() - 3);
                                System.out.println("Opponent's spell hit themselves and you for " + damage + " damage!");
                            }
                            else {
                                damage = chance.nextInt(30) + 1;
                                player.setHp(player.getHp() - damage);
                                System.out.println("The spell shakes you for " + damage + " damage.");
                                enemy.setMp(enemy.getMp() - 3);
                            }
                        }
                        break;
                    case 3:
                        System.out.println(CPUname + " used a healing potion...");
                        System.out.println("They regain 30 HP.");
                        enemy.setHp(enemy.getHp() + 30);
                        enemy.setPtn(enemy.getPtn() - 1);
                        enemy.setMp(enemy.getMp() + 1);
                        break;
                    case 4:
                        System.out.println(CPUname + " takes a defensive stance...");
                        CPUguard = true;
                        enemy.setMp(enemy.getMp() + 2);
                        break;
                    case 5:
                        System.out.println(CPUname + " breaks free of the ice...");
                        CPUfrozen = false; // Reset frozen status for next turn
                        enemy.setMp(enemy.getMp() + 1);
                        break;
                    default:
                        System.out.println("Well that's not right.  I think the CPU broke itself... good for you!");
                        enemy.setMp(enemy.getMp() + 1);
                        break;
                }

                // Finish by checking HP/MP and resetting any values over their maximum
                if (player.getHp() > hp)
                    player.setHp(hp);
                if (player.getMp() > mp)
                    player.setMp(mp);
                if (enemy.getHp() > CPUhp)
                    enemy.setHp(CPUhp);
                if (enemy.getMp() > CPUmp)
                    enemy.setMp(CPUmp);
            }

            System.out.println();
            System.out.println();
            System.out.println("GAME OVER!");
            if (player.getHp() < 1) {
                System.out.println("You lost.  Better luck next time!");
                rating -= enemy.getHp(); // Calculate game rating (negative number equal to enemy's remaining hp
                scores[rounds] = rating; // Write score to array
                rounds++; // Increment index for array placement
            }
            else if (enemy.getHp() < 1) {
                System.out.println("You won!  Victory is yours!");
                rating += player.getHp(); // Calculate game rating (positive number equal to player's remaining hp
                if (setup == 1)
                    rating += 10; // Add small bonus if player chose default mode
                if (setup == 2)
                    rating += 100; // Add big bonus if player chose challenge mode
                if (setup == 4)
                    rating += 10000; // Add huge bonus if player chose Nightmare mode
                scores[rounds] = rating; // Write score to array
                rounds++; // Increment index for array placement
            }

            // Ask user if they would like to repeat the game, close the program or write record data to a txt file
            System.out.println("Press 1 to play again; press 2 to store all your stats in a text file.  Press 0 to close.");
            repeat = kb.nextInt();
        } while (repeat == 1);

        kb.nextLine();

        if (repeat == 0)
            System.exit(0);
        else if (repeat == 2) { // If user selects 2, open an output file and write data from scores array to it, plus total and average
            System.out.print("Please enter the name of a text file to store your battle data:");
            String filename = kb.nextLine(); // Get file name from user

            // Create the file and, if it already exists, ask the user to validate overwrite
            File datafile = new File(filename);
            if (datafile.exists()) {
                // Display message and ask user for overwrite permission
                System.out.println("WARNING: The file " + filename + " already exists.  Are you sure you want to overwrite it?");
                System.out.println("Type 0 to cancel overwrite; press any other key to continue...");
                int cancel = kb.nextInt();
                if (cancel == 0)
                    System.exit(0);
                else
                    System.out.println("Okay, the file " + filename + " will be overwritten.");
            }

            PrintWriter outputFile = new PrintWriter(datafile); // Open output file to write data
            int total = 0;
            System.out.println("Writing the following data to text file...");
            for (int i = 0; i < rounds; i++) { // Loop to display data to user in console
                System.out.printf("Score #" + (i+1) + ": %,d\n", scores[i]);
                total += scores[i];
            }
            int highest = scores[0];
            for (int i = 1; i < rounds; i++) { // Loop to find highest value
                if (scores[i] > highest)
                        highest = scores[i];
            }
            /* Req 3 (Math class) */
            int greatest = Math.abs(highest); // Use Math abs method to convert highest value to a positive int "greatest"
            System.out.printf("The greatest score in your record was: %,d\n", greatest); // Display greatest
            System.out.printf("Your final score is: %,d\n", total); // Display total
            System.out.printf("Your average score was: %,d\n", total / rounds); // Display average

            /* Req 10 (Writing data to a file) */
            outputFile.println("Your saved Battle records are:");
            for (int i = 0; i < rounds; i++) { // Loop to write data to given output txt file
                outputFile.printf("Score #" + (i+1) + ": %,d", scores[i]);
            }
            outputFile.printf("Your final score is: %,d", total); // Write total to output file
            outputFile.printf("Your average score was: %,d", total / rounds); // Write average to output file
            outputFile.printf("The greatest score in your record was: %,d\n", greatest); // Write greatest to output file
        }
    }
}
