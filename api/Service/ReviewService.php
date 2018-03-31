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
        $categories = [];
        $query = $this->pdo->query('SELECT DISTINCT category FROM reviews');
        try {
            while ($row = $query->fetch()) {
                $categories[] =
                    ['name' => $row['category'],
                    'href' => '/categories?name='. $row['category']];
            }

            return $categories;
        } finally {
            $query->closeCursor();
        }
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

        $stmt = $this->pdo->prepare('SELECT id, title FROM reviews WHERE category = :category');
        $stmt->execute(['category' => $category]);
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function($r) {$r['href'] = '/reviews/' . $r[id]; return $r;}, $reviews);
    }

    private function allColumns() {
        return "id, title, author, publication_year, summary, reviewed, opinion, is_classic";
    }
}