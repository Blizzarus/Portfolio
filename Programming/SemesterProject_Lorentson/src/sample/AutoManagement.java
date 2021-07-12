/**
 * @author: Bejmamin C. Lorentson
 *
 * My Semester Project for CIS232
 *
 * This program is an order management system for an Auto Service company.
 * It will take in the services included in a job order with a GUI items/add-ons list;
 * it will then produce an output pane with an order summary,
 * containing a final total price and the estimated time to complete the job
 *
 * The output can also be written to a text report file
 */

package sample;

import javax.swing.*;
import java.awt.event.*;
import java.io.File;
import java.io.IOException;
import java.io.FileWriter;
class Auto extends JFrame implements ActionListener {
    // Initializations
    JLabel label1, label2;
    JCheckBox primary1, primary2, primary3, primary4, additional1, additional2, additional3, additional4, report;
    JButton btn;

    public Auto()
    { //Sets labels, dimensions, and creates buttons/checkboxes
        label1 = new JLabel("---- PRIMARY SERVICES ----", SwingConstants.CENTER);
        label1.setBounds(30, 20, 300, 20);
        primary1 = new JCheckBox("Brake Replacement - $800");
        primary1.setBounds(100, 50, 200, 20);
        primary2 = new JCheckBox("Tire Replacement - $600");
        primary2.setBounds(100, 75, 200, 20);
        primary3 = new JCheckBox("Engine Tune-Up - $250");
        primary3.setBounds(100, 100, 200, 20);
        primary4 = new JCheckBox("Transmission Work - $350");
        primary4.setBounds(100, 125, 200, 20);
        label2 = new JLabel("---- ADDITIONAL SERVICES ----", SwingConstants.CENTER);
        label2.setBounds(30, 155, 300, 20);
        additional1 = new JCheckBox("Oil Change - $25");
        additional1.setBounds(35, 185, 160, 20);
        additional2 = new JCheckBox("New Air Filter - $10");
        additional2.setBounds(200, 185, 160, 20);
        additional3 = new JCheckBox("Tire Rotation - $50");
        additional3.setBounds(35, 205, 160, 20);
        additional4 = new JCheckBox("Fuel CLeaner - $15");
        additional4.setBounds(200, 205, 160, 20);

        report = new JCheckBox("GENERATE REPORT FILE"); //Checkbox to write report to a file
        report.setBounds(100, 245, 300, 20);

        btn = new JButton("Finalize Order"); //Button to complete the order input
        btn.setBounds(100, 300, 160, 30);
        btn.addActionListener(this);

        //Add elements to input pane and configure
        add(primary1);
        add(primary2);
        add(primary3);
        add(primary4);
        add(label1);
        add(btn);
        add(label2);
        add(additional1);
        add(additional2);
        add(additional3);
        add(additional4);
        add(report);
        setSize(400, 400);
        setLayout(null);
        setVisible(true);
        setDefaultCloseOperation(EXIT_ON_CLOSE);
    }

    public void actionPerformed(ActionEvent e) //Run when the order is submitted to display output
    {
        int price = 0;
        float time = 0;
        double tax;
        String msg = "";

        if (primary1.isSelected()) {
            price += 800;
            time += 1.5;
            msg += "Brake Replacement: $800\n";
        }

        if (primary2.isSelected()) {
            price += 600;
            time += 1;
            msg += "Tire Replacement: $600\n";
        }

        if (primary3.isSelected()) {
            price += 250;
            time += 1.25;
            msg += "Engine Tune-Up: $250\n";
        }

        if (primary4.isSelected()) {
            price += 350;
            time += 2;
            msg += "Transmission Maintenance: $350\n";
        }

        if (additional1.isSelected()) {
            price += 25;
            time += 0.5;
            msg += "Oil Change: $25\n";
        }

        if (additional2.isSelected()) {
            price += 50;
            time += 0.25;
            msg += "Tire Rotation: $50\n";
        }

        if (additional3.isSelected()) {
            price += 10;
            time += 0.15;
            msg += "Air Filter Replacement: $10\n";
        }

        if (additional4.isSelected()) {
            price += 15;
            time += 0.1;
            msg += "Fuel Cleaner: $15\n";
        }

        msg += "-----------\n";
        tax = price * 1.06;
        String taxValue = String.format("%.2f", tax);
        msg += "Total: $" + price +"\nPrice w/ Tax: $" + taxValue +"\nEst. Labor: " + time + " hour(s).\n\n";

        if (report.isSelected()) {
            try {
                File outputFile = new File("Order_Report.txt");
                boolean overwrite = outputFile.createNewFile();

                FileWriter output = new FileWriter("Order_Report.txt");
                output.write(msg);
                output.close();

                if (overwrite) {
                    msg += "Report was written to " + outputFile.getName() + "\n";
                }
                else {
                    msg += "Report was written to " + outputFile.getName() + "; previous report was overwritten.\n";
                }
                msg += "File path: " + outputFile.getAbsolutePath() + "\n";

            } catch (IOException err) {
                System.out.println("Error in write to file.");
                err.printStackTrace();
            }

        }

        JOptionPane.showMessageDialog(this, msg);
    }
}

public class AutoManagement extends Auto {
    public static void main(String[] args)
    {
        // Create Auto object or display error message
        try {
            Auto order = new Auto();
        }
        catch (Exception e) {
            System.out.println("Error in recursive call.");
            e.printStackTrace();
        }
    }
}




