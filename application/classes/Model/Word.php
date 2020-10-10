<?php


class Model_Word extends Model_Database
{
    public function saveWord(string $word)
    {
        $sql = "INSERT INTO words (word, stat) VALUES (:word, 1) ON DUPLICATE KEY UPDATE stat=stat+1";
        $query = DB::query(Database::INSERT, $sql);
        $query->parameters(
            [
                ':word' => $word,
            ]
        );

        return $query->execute()[1];
    }

    public function countWords()
    {
        $sql = "SELECT COUNT(word) as num FROM words";
        $query = DB::query(Database::SELECT, $sql);
        $res = $query->execute()->as_array();

        return $res ? $res[0]['num'] : 0;
    }

    public function getPageWords(int $page, int $onPage)
    {
        $sql = "SELECT word FROM words ORDER BY word limit :offset, :num";
        $query = DB::query(Database::SELECT, $sql);
        $query->parameters(
            [
                ':offset' => ($page - 1) * $onPage,
                ':num' => $onPage
            ]
        );

        $res = $query->execute()->as_array();
        $words = [];
        foreach ($res as $k => $v) {
            $words[] = $v['word'];
        }

        return $words;
    }

    public function getWordstat()
    {
        $sql = "SELECT word, stat FROM words ORDER BY stat DESC limit 10";
        $query = DB::query(Database::SELECT, $sql);

        return $query->execute()->as_array();
    }
}
