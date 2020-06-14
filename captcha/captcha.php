<?php

namespace App;

class Captcha {
    private $charsLength = 4;
    private $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $text;
    private $textAngle = 10;
    private $image;
    private $backgroundColor = [ 231, 74, 59 ];
    private $textColor = [ 255, 255, 255 ];
    private $textX = 11;
    private $textY = 51;
    private $font;
    private $fontSize = 28;
    private $width = 120;
    private $height = 60;

    function __construct(){
        $this->text = $this->generateRandomString();

        $this->image = imagecreatetruecolor($this->width, $this->height);
        $this->backgroundColor = imagecolorallocate($this->image, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
        $this->textColor = imagecolorallocate($this->image, $this->textColor[0], $this->textColor[1], $this->textColor[2]);
    }

    public function setOptions($options){
        if(isset($options['width'])) {
            $this->width = $options['width'];
        }

        if(isset($options['height'])) {
            $this->height = $options['height'];
        }

        $this->image = imagecreatetruecolor($this->width, $this->height);

        foreach ($options as $key => $value) {
            switch ($key) {
                case 'backgroundColor':
                    $this->backgroundColor = imagecolorallocate($this->image, $value[0] ?? 255, $value[1] ?? 255, $value[2] ?? 255);
                    break;

                case 'textColor':
                    $this->textColor = imagecolorallocate($this->image, $value[0] ?? 0, $value[1] ?? 0, $value[2] ?? 0);
                    break;

                case 'charsLength':
                    $this->charsLength = $value;
                    $this->text = $this->generateRandomString();
                    break;

                case 'characters':
                    $this->characters = $value;
                    $this->text = $this->generateRandomString();
                    break;

                case 'font':
                case 'textX':
                case 'textY':
                case 'fontSize':
                case 'textAngle':
                    $this->$key = $value;
                    break;

                default:
                    break;
            }
        }

        return $this;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
     }

    private function generateRandomString() {
        $randomString = '';

        for ($i = 0; $i < $this->charsLength; $i++) {
            $randomString .= str_shuffle($this->characters)[0];
        }

        return $randomString;
    }

    public function generate() {
        imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, $this->backgroundColor);
        imagettftext($this->image, $this->fontSize, $this->textAngle, $this->textX, $this->textY, $this->textColor, $this->font ?? null, $this->text);
        imagepng($this->image);
        imagedestroy($this->image);
    }
}
