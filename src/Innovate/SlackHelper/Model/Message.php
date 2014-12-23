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

use Innovate\SlackHelper\Model\Attachment as SlackAttachment;

class Message implements \JsonSerializable {

    /**
     * Username used to post to Slack.
     * If null, the default username for the integration will be used.
     *
     * @var string
     */
    private $username;
    
    /**
     * Emoji used to post to Slack.
     * It should be a name of an emoji (for a full list, check Slack.)
     * If null, the default icon for the integration will be used.
     *
     * @var string
     */
    private $emoji;

    /**
     * Message to post.
     *
     * @var string
     */
    private $message;

    /**
     * Channel to which the message is posted.
     * If null, the default channel for the integration will be used.
     *
     * @var string
     */
    private $channel;
    
    /**
     * Attachments (optional)
     * 
     * @var array
     */
    private $attachments;
    
    /**
     * Constructor function
     * 
     * @param string $message
     * @param string $channel
     * @param string $username
     * @param string $emoji
     * @param array $attachments
     */
    public function __construct($message, $channel = null,
            $username = null, $emoji = null, $attachments = null) {
        $this->message = html_entity_decode($message);
        $this->channel = $channel;
        $this->username = $username;
        $this->emoji = $emoji;
        $this->attachments = $attachments;
    }
    
    public function jsonSerialize() {
        return get_object_vars($this);
    }
    
    /* Getters */
    public function getUsername() {
        return $this->username;
    }
    
    public function getEmoji() {
        return $this->emoji;
    }
    
    public function getMessage() {
        return $this->message;
    }
    
    public function getChannel() {
        return $this->channel;
    }
    
    public function getAttachments() {
        return $this->attachments;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this->username;
    }
    
    public function setEmoji($emoji) {
        $this->emoji = $emoji;
        return $this->emoji;
    }
    
    public function setMessage($message) {
        $message = preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $message);
        $this->message = $message;
        return $this->message;
    }
    
    public function setChannel($channel) {
        $this->channel = $channel;
        return $this->channel;
    }
    
    public function setAttachments($attachments) {
        $this->attachments = $attachments;
    }
    
    public function addAttachment(SlackAttachment $attachment) {
        $this->attachments[] = $attachment;
    }
    
    public function removeAttachment($index) {
        if (!is_int($index)) {
            throw new \InvalidArgumentException("The index should be an int.");
        }
        
        unset($this->attachments[$index]);
    }

}
