# Macro
PHP Macro - Dynamically extend PHP objects

## Installation & loading

- Code -> Download ZIP Macro-master.zip
- Extract the file Macro.php to a new Folder 

```php
require '/path/Macro.php';
```

## Usage

```php
use Macro;
```

### Simple example

```php
require '/path/Macro.php';

class myClass{
  use Macro;
  private $number;
  public function setNumber($number){
    $this->number = $number;
    return $this;
  }

  public function getNumber(){
    return $this->number;
  }
}

//add macro
myClass::macro('mul',function($fac){$this->number *= $fac; return $this;});

$t = new myClass;
$result = $t->setNumber(3)
  ->mul(3)
  ->getNumber()
;
var_dump($result); //int(9)
```


