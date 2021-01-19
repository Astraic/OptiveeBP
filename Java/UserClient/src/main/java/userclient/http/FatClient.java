/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.http;

import userclient.model.Fat;

/**
 *
 * @author Stephan de Jongh
 */
public class FatClient extends HttpClient<Fat> {
    
    public FatClient() {
        super(Fat.class);
        gson = builder.create();
    }

    @Override
    public String getUpdateClause(Fat model) {
        return new StringBuilder("name-eq-").append(model.getName()).toString();
    }

    @Override
    protected Fat removeOverhead(Fat model) {
        return model;
    }
}