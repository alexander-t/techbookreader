<?php

namespace TechbookReader\Service;
use PDO;

class ReviewService {
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCategories() {
        return $this->pdo->query('SELECT DISTINCT category FROM reviews')->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getReviewById($id) {
        $stmt = $this->pdo->prepare('SELECT ' . $this->allColumns() . ' FROM reviews WHERE id = :id');
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

    public function getReviewsByCategory($category) {
        $reviews = [];
        if (empty($category)) {
            return $reviews;
        }

        $stmt = $this->pdo->prepare('SELECT ' . $this->allColumns() . ' FROM reviews WHERE category = :category');
        $stmt->execute(['category' => $category]);

        try {
            while ($row = $stmt->fetch()) {
                $row['is_classic'] = ($row['is_classic'] == 1) ? true : false;
                $reviews[] = $row;;
            }
        } finally {
            $stmt->closeCursor();
        }
        return $reviews;
    }

    private function allColumns() {
        return "id, title, author, publication_year, summary, reviewed, opinion, is_classic";
    }
}