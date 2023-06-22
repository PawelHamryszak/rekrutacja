class TextInput {
    protected $value = '';

    public function add($text) {
        $this->value .= $text;
    }

    public function getValue() {
        return $this->value;
    }
}

class NumericInput extends TextInput {
    public function add($text) {
        // Sprawdzenie, czy tekst zawiera tylko cyfry
        if (ctype_digit($text)) {
            $this->value .= $text;
        }
    }
}

// Przykład użycia

$textInput = new TextInput();
$textInput->add('Hello');
$textInput->add('123');
$textValue = $textInput->getValue();
echo $textValue;  // Output: Hello123

$numericInput = new NumericInput();
$numericInput->add('Hello');
$numericInput->add('123');
$numericValue = $numericInput->getValue();
echo $numericValue;  // Output: 123
