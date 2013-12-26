<?php
/**
 * This file is part of SlackHelper.
 *
 * @copyright 2013 Léo Lam
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Innovate\SlackHelper\Model;

use Innovate\SlackHelper\Model\Message as SlackMessage;

class Sender {

    /**
     * Token used to post to Slack.
     * You can get it from: https://my.slack.com/services/new/incoming-webhook
     *
     * @var string
     */
    private $token;

    /**
     * Constructor function
     *    
     */
    public function __construct($token) {
        $this->setToken($token);
    }
    
    /**
     * Posts the message
     * Returns true on success, false on error.
     * 
     * @param \Innovate\SlackMessage $message
     * @return bool
     */
    public function send(SlackMessage $message) {
        $url = 'https://innovate.slack.com/services/hooks/incoming-webhook?token='.$this->getToken();
        $data = array(
            'channel' => $message->getChannel(),
            'username' => $message->getUsername(),
            'text' => $message->getMessage(),
            'attachments' => $message->getAttachments(),
            'icon_emoji' => $message->getEmoji(),
        );

        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => json_encode($data),
                'header' =>  "Content-Type: application/json\r\n" . "Accept: application/json\r\n",
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        return ($result) ? true : false;
    }
    
    /* Getters */
    public function getToken() {
        return $this->token;
    }
    
    /* Setters */
    public function setToken($token) {
        if (strlen($token) !== 24) {
            throw new InvalidArgumentException('Token should be 24 characters long.');
        }
        $this->token = $token;
    }

}
