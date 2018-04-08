<?php

namespace TechbookReader\Service;

class CMSService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveReview($review)
    {
        $this->pdo->prepare('UPDATE reviews SET title=:title,author=:author,publication_year=:publication_year,reviewed=:reviewed,is_classic=:is_classic,opinion=:opinion,summary=:summary,canonical_title=:canonical_title WHERE id=:id')
            ->execute(
                ['id' => $review['id'],
                    'title' => $review['title'],
                    'author' => $review['author'],
                    'publication_year' => $review['publication_year'],
                    'reviewed' => $review['reviewed'],
                    'is_classic' => $review['is_classic'] == true ? 1 : 0,
                    'opinion' => $review['opinion'],
                    'summary' => $review['summary'],
                    'canonical_title' => $this->canonicalize($review['title'])
                ]);
    }

    private function canonicalize($s)
    {
        $r = trim(strtolower($s));
        $r = preg_replace("/\s+/", "_", $r);
        return preg_replace("/[^a-z0-9_]/", "", $r);
    }
}