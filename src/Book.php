<?php
    class Book
    {
        private $title;
        private $author;
        private $genre;
        private $id;

        function __construct($title, $author, $genre, $id = null)
        {
            $this->title = $title;
            $this->author = $author;
            $this->genre = $genre;
            $this->id = $id;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setTitle($new_title)
        {
            $this->title = $new_title;
        }

        function getAuthor()
        {
            return $this->author;
        }

        function setAuthor($new_author)
        {
            $this->author = $new_author;
        }


    }
?>
