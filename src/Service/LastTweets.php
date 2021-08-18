<?php

namespace App\Service;

use Abraham\TwitterOAuth\TwitterOAuth;

class LastTweets
{
    public function tweets()
    {
        $oauth = new TwitterOAuth('6xTWqkCE3uiL7Y1Z1EegmP0fn', 'jS8dA313bqfErhgwQQmHP3nsEz3hSdfOQIEAzHe3txfTNsf8Kf');
        $accessToken = $oauth->oauth2('oauth2/token', ['grant_type' => 'client_credentials']);

        $twitter = new TwitterOAuth('6xTWqkCE3uiL7Y1Z1EegmP0fn', 'jS8dA313bqfErhgwQQmHP3nsEz3hSdfOQIEAzHe3txfTNsf8Kf', null, $accessToken->access_token);
        $tweets = $twitter->get('statuses/user_timeline', [
            'screen_name' => 'Kuliissu',
            'exclude_replies' => true,
            'count' => 50,
            'tweet_mode' => 'extended'
        ]);

        return $tweets;
    }

    public function autolink()
    {
        $autoLink = \Twitter\Text\Autolink::create();

        return $autoLink;
    }
}
