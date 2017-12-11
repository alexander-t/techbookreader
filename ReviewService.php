<?php

namespace TechbookReader\Service;

class ReviewService {
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getReviewById($id) {
        $stmt = $this->pdo->prepare('SELECT id, title, author, publication_year, summary, reviewed, opinion, is_classic FROM reviews WHERE id = :id');
        $stmt->execute(['id' => $id]);

        try {
            if ($row = $stmt->fetch()) {
                $row['is_classic'] = ($row['is_classic'] == 1) ? true : false;
                return $row;
            }

            throw new \Exception("No review with id $id");
        } finally {
            $stmt->closeCursor();
        }
    }
}