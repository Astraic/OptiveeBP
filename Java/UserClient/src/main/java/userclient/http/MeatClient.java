/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.http;

import userclient.model.Meat;

/**
 *
 * @author Stephan de Jongh
 */
public class MeatClient extends HttpClient<Meat> {
    
    public MeatClient() {
        super(Meat.class);
        gson = builder.create();
    }

    @Override
    public String getUpdateClause(Meat model) {
        return new StringBuilder("name-eq-").append(model.getName()).toString();
    }

    @Override
    protected Meat removeOverhead(Meat model) {
        return model;
    }
}