/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.model;

/**
 *
 * @author Stephan de Jongh
 */
public class Category {
    
    private char name;

    public Category() {
    }

    public char getName() {
        return name;
    }

    public void setName(char name) {
        this.name = name;
    }
    
    @Override
    public String toString() {
        return Character.toString(getName());
    }
}