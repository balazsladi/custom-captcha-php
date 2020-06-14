# PHP Custom Captcha

## Basic Usage

```
$captcha = new Captcha();

$captcha->setOptions([
    'font' => 'Arial.ttf'
])->generate();
```

## Configuration

You can alter the Captcha options in your code before generating the image using this command:

```
$captcha->setOptions([
    'font' => 'Arial.ttf',
    'fontSize' => 23,
    'backgroundColor' => [ 255, 231, 179 ]
])->generate();
```

### Available options:

#### Required:

* __font__:  Captcha text font link

#### Optional:

* __width__:  Image width in pixels, default: 120
* __height__:  Image height in pixels, default: 60
* __backgroundColor__: Background color in [ R, G, B ], default: [ 231, 74, 59 ]
* __textColor__: Captcha text color in [ R, G, B ],  default: [ 255, 255, 255 ]
* __textX__: Captcha text x-coordinate,  default: 11
* __textY__: Captcha text y-coordinate,  default: 51
* __charsLength__: Captcha text length,  default: 4
* __characters__: Captcha text character bank, default: '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
* __fontSize__: Captcha text font size,  default: 28
* __fontAngle__: Captcha text font angle,  default: 10


## Example

```
//Endpoint: /captcha
public function captcha(){
    header("Content-type: image/png");

    $captcha = new Captcha();

    $captcha->setOptions([
        'font' => 'Arial.ttf',
        'fontSize' => 22,
        'textAngle' => -3,
        'charsLength' => 6,
        'characters' => 'asdmk012',
        'width' => 200,
        'height' => 60,
        'backgroundColor' => [ 10,88,10 ],
        'textColor' => [ 240,230,220 ]
    ]);

    //Set session variable
    $_SESSION["captcha"] = $captcha->text;

    //Generate captcha image
    $captcha->generate();
}


//HTML
<img src="/captcha">
<input type="text" name="captcha" required>

//Endpoint for Authentication
...

if(isset($_SESSION["captcha"]) && $_POST['captcha'] != $_SESSION["captcha"]) {
    //Captcha error
}
...


```
