class RankingTable {
    private $players = [];

    public function __construct($playerNames) {
        foreach ($playerNames as $playerName) {
            $this->players[$playerName] = ['score' => 0, 'gamesPlayed' => 0];
        }
    }

    public function recordResult($playerName, $score) {
        if (isset($this->players[$playerName])) {
            $this->players[$playerName]['score'] += $score;
            $this->players[$playerName]['gamesPlayed']++;
        }
    }

    public function playerRank($rank) {
        // Sortowanie graczy według wyników, liczby rozegranych gier i kolejności w oryginalnej tablicy graczy
        uasort($this->players, function ($a, $b) {
            if ($a['score'] != $b['score']) {
                return $b['score'] - $a['score']; // Sortowanie malejąco według wyników
            } elseif ($a['gamesPlayed'] != $b['gamesPlayed']) {
                return $a['gamesPlayed'] - $b['gamesPlayed']; // Sortowanie rosnąco według liczby rozegranych gier
            } else {
                return -1; // Zachowanie oryginalnej kolejności graczy o tych samych wynikach i liczbie rozegranych gier
            }
        });

        $rankedPlayers = array_keys($this->players); // Pobranie posortowanych graczy

        return $rankedPlayers[$rank - 1] ?? null; // Zwracanie gracza o podanym rankingu
    }
}

$table = new RankingTable(array('Jan', 'Maks', 'Monika'));
$table->recordResult('Jan', 2);
$table->recordResult('Maks', 3);
$table->recordResult('Monika', 5);
$rankedPlayer = $table->playerRank(1);
echo $rankedPlayer; // Output: Monika
