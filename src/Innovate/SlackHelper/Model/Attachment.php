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

class Attachment implements \JsonSerializable {

    /**
     * Fallback message
     * Required text summary of the attachment that is shown by clients that understand attachments but choose not to show them.
     *
     * @var string
     */
    private $fallback;

    /**
     * Attachment color
     * Can either be one of 'good', 'warning', 'danger', or any hex color code
     * If null, defaults to a light gray (#939393)
     *
     * @var string
     */
    private $color;

    /**
     * Attachment text
     * Optional text that should appear within the attachment
     *
     * @var string
     */
    private $text;
    
    /**
     * Pretext
     * Optional text that should appear above the formatted data
     *
     * @var string
     */
    private $pretext;
    
    /**
     * Attachment fields
     * 
     * @var array
     */
    private $fields;
    
    /**
     * Constructor function
     * 
     * @param string $fallback
     * @param string $color
     * @param array $fields
     * @param string $text
     * @param string $pretext
     */
    public function __construct($fallback, $color = "#939393", $fields = null, $text = null, $pretext = null) {
        $this->fallback = $fallback;
        $this->color = $color;
        $this->fields = $fields;
        $this->text = $text;
        $this->pretext = $pretext;
    }
    
    public function jsonSerialize() {
        return get_object_vars($this);
    }
    
    public function getFallback() {
        return $this->fallback;
    }

    public function getColor() {
        return $this->color;
    }

    public function getText() {
        return $this->text;
    }

    public function getPretext() {
        return $this->pretext;
    }

    public function getFields() {
        return $this->fields;
    }

    public function setFallback($fallback) {
        $this->fallback = $fallback;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setPretext($pretext) {
        $this->pretext = $pretext;
    }

    public function setFields($fields) {
        $this->fields = $fields;
    }
    
    public function addField($title, $value, $isShort = false) {
        $this->fields[] = array(
            'title' => $title,
            'value' => $value,
            'short' => $isShort,
        );
        
        return $this;
    }
    
    public function removeField($index) {
        if (!is_int($index)) {
            throw new \InvalidArgumentException("The index should be an int.");
        }
        
        unset($this->fields[$index]);
    }

}
