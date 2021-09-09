<?php

namespace App\Service;

use Abraham\TwitterOAuth\TwitterOAuth;

class LastTweets
{
    public function tweets()
    {
        $oauth = new TwitterOAuth($_ENV['TWITTER_KEY'], $_ENV['TWITTER_SECRET']);
        $accessToken = $oauth->oauth2('oauth2/token', ['grant_type' => 'client_credentials']);

        $twitter = new TwitterOAuth($_ENV['TWITTER_KEY'], $_ENV['TWITTER_SECRET'], null, $accessToken->access_token);
        $tweets = $twitter->get('statuses/user_timeline', [
            'screen_name' => 'Kuliissu',
            'exclude_replies' => true,
            'count' => 50,
            'tweet_mode' => 'extended'
        ]);

        return $tweets;
    }

    public function link()
    {
        $autoLink = \Twitter\Text\Autolink::create();

        return $autoLink;
    }
}
