class Thesaurus {
    private $thesaurus;

    public function __construct($thesaurus) {
        $this->thesaurus = $thesaurus;
    }

    public function getSynonyms($word) {
        $synonyms = $this->thesaurus[$word] ?? [];

        $result = [
            'word' => $word,
            'synonyms' => $synonyms
        ];

        return json_encode($result);
    }
}

$thesaurusData = array(
    "market" => array("trade"),
    "small" => array("little", "compact")
);

$thesaurus = new Thesaurus($thesaurusData);

$synonymsJson = $thesaurus->getSynonyms("small");
echo $synonymsJson; // Output: {"word":"small","synonyms":["little","compact"]}

$noSynonymsJson = $thesaurus->getSynonyms("asleast");
echo $noSynonymsJson; // Output: {"word":"asleast","synonyms":[]}
