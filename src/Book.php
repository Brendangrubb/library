<?php
    class Book
    {
        private $title;
        private $genre;
        private $id;

        function __construct($title, $genre, $id = null)
        {
            $this->title = $title;
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

        function getGenre()
        {
            return $this->genre;
        }

        function setGenre($new_genre)
        {
            $this->genre = $new_genre;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO books (title, genre) VALUES ('{$this->getTitle()}', '{$this->getGenre()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books");
            $books = array();

            foreach ($returned_books as $book) {
                $title = $book['title'];
                $genre = $book['genre'];
                $id = $book['id'];
                $new_book = new Book($title, $genre, $id);
                array_push($books, $new_book);
            }

            return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
        }

        static function find($search_id)
        {
            $found_book = null;
            $books = Book::getAll();

            foreach($books as $book)
            {
                $book_id = $book->getId();
                if ($book_id == $search_id)
                {
                    $found_book = $book;
                }
            }
            return $found_book;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        }

        function update($new_title, $new_genre)
        {
            if ($new_title) {
                $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
                $this->title = $new_title;
            }

            if ($new_genre) {
                $GLOBALS['DB']->exec("UPDATE books SET genre = '{$new_genre}' WHERE id = {$this->getId()};");
                $this->genre = $new_genre;
            }
        }
    }
?>
