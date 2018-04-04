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
        $categories = $this->pdo->query('SELECT name FROM categories')->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function($r) {$r['href'] = '/categories?name=' . $r['name']; return $r;}, $categories);
    }

    public function getReviewByTitle($title) {
        $stmt = $this->pdo->prepare('SELECT ' . $this->allColumns() . ' FROM reviews WHERE canonical_title = :title');
        $stmt->execute(['title' => $title]);

        try {
            if ($row = $stmt->fetch()) {
                $row['is_classic'] = ($row['is_classic'] == 1) ? true : false;
                return $row;
            }

            throw new \Exception("No review with title $title");
        } finally {
            $stmt->closeCursor();
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

    public function findReviewsByCategory($category) {
        $reviews = [];
        if (empty($category)) {
            return $reviews;
        }

        $stmt = $this->pdo->prepare('SELECT r.id, r.title, r.reviewed, r.image FROM reviews r JOIN categories c ON c.id=r.category_id WHERE c.name = :category');
        $stmt->execute(['category' => $category]);
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        usort($reviews, function($a, $b) {return strcmp($a['title'], $b['title']);});
        return array_map(function($r) {$r['href'] = '/reviews/' . $r['id']; return $r;}, $reviews);
    }

    private function allColumns() {
        return "id, title, author, image, publication_year, summary, reviewed, opinion, is_classic";
    }
}