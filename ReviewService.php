<?php

namespace TechbookReader\Service;

class ReviewService {
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getReviewById($id) {
        $stmt = $this->pdo->prepare('SELECT id, title, author, publication_year, summary FROM reviews WHERE id = :id');
        $stmt->execute(['id' => $id]);

        try {
            if ($row = $stmt->fetch()) {
                return $row;
            }

            throw new \Exception("No review with id $id");
        } finally {
            $stmt->closeCursor();
        }
    }
}