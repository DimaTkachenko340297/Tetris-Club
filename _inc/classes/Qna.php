<?php

class Qna
{
    // Natvrdo definované otázky a odpovede
    private $qnaItems = [
        ['question' => 'Otázka 1', 'answer' => 'Odpoveď 1'],
        ['question' => 'Otázka 2', 'answer' => 'Odpoveď 2'],
        ['question' => 'Otázka 3', 'answer' => 'Odpoveď 3']
    ];

    // Metóda na získanie otázok a odpovedí
    public function index()
    {
        return $this->qnaItems;
    }
}
?>
