/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.http;

import userclient.model.Category;

/**
 *
 * @author Stephan de Jongh
 */
public class CategoryClient extends HttpClient<Category> {
    
    public CategoryClient() {
        super(Category.class);
        gson = builder.create();
    }

    @Override
    public String getUpdateClause(Category model) {
        return new StringBuilder("name-eq-").append(model.getName()).toString();
    }
}