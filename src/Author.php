<?php
    class Author
    {
        private $first_name;
        private $last_name;
        private $id;

        function __construct($first_name, $last_name, $id = null)
        {
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->id = $id;
        }

        // Getters and setters

        function getFirstName()
        {
            return $this->first_name;
        }

        function setFirstName($new_first_name)
        {
            $this->first_name = $new_first_name;
        }

        function getLastName()
        {
            return $this->last_name;
        }

        function setLastName($new_last_name)
        {
            $this->last_name = $new_last_name;
        }

        function getId()
        {
            return $this->id;
        }

        // Save and update

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors (first_name, last_name) VALUES ('{$this->getFirstName()}', '{$this->getLastName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_first_name, $new_last_name)
        {
            if ($new_first_name) {
                $GLOBALS['DB']->exec("UPDATE authors SET first_name = '{$new_first_name}' WHERE id = {$this->getId()};");
                $this->setFirstName($new_first_name);
            }

            if ($new_last_name) {
                $GLOBALS['DB']->exec("UPDATE authors SET last_name = '{$new_last_name}' WHERE id = {$this->getId()};");
                $this->setLastName($new_last_name);
            }
        }

        // Get and delete

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors");
            $authors = array();

            foreach ($returned_authors as $author) {
                $first_name = $author['first_name'];
                $last_name = $author['last_name'];
                $id = $author['id'];
                $new_author = new Author($first_name, $last_name, $id);
                array_push($authors, $new_author);
            }

            return $authors;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors;");
            // $GLOBALS['DB']->exec("DELETE FROM authors_books");
        }

        static function find($id)
        {
            $returned_authors = Author::getAll();
            $found_author = null;

            foreach ($returned_authors as $author) {
                $author_id = $author->getId();
                if ($author_id == $id) {
                    $found_author = $author;
                }
            }

            return $found_author;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE author_id = {$this->getId()};");
        }

        // Authors<->Books

        function addBook($book)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$this->getId()}, {$book->getId()});");
        }

        function getBooks()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT books.* FROM authors
                JOIN authors_books ON (authors_books.author_id = authors.id)
                JOIN books ON (books.id = authors_books.book_id)
                WHERE authors.id = {$this->getId()};");
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
    }
?>
