/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package userclient.http;

import userclient.model.Feed;

/**
 *
 * @author Stephan de Jongh
 */
public class FeedClient extends HttpClient<Feed> {
    
    public FeedClient() {
        super(Feed.class);
        gson = builder.create();
    }

    @Override
    public String getUpdateClause(Feed model) {
        return new StringBuilder("id-eq-").append(model.getId()).toString();
    }
}