<?php
    /**
    * @backupGlobals disabled
    * #backupStaticAttributes disabled
    */

    require_once 'src/Book.php';
    require_once 'src/Author.php';

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

        function test_getTitle()
        {
            // Arrange
            $title = "The Giving Tree";
            $genre = "childrens";
            $book = new Book($title, $genre);

            // Act
            $result = $book->getTitle();

            // Assert
            $this->assertEquals($title, $result);
        }

        function test_setTitle()
        {
            // Arrange
            $title = "The Giving Tree";
            $new_title = "The Missing Piece";
            $genre = "childrens";
            $book = new Book($title, $genre);

            // Act
            $book->setTitle($new_title);
            $result = $book->getTitle();

            // Assert
            $this->assertEquals("The Missing Piece", $result);
        }

        function test_save()
        {
            // Arrange
            $title = "The Giving Tree";
            $genre = "childrens";
            $book = new Book($title, $genre);
            $book->save();

            // Act
            $result = Book::getAll();

            // Assert
            $this->assertEquals($book, $result[0]);
        }

        function test_deleteAll()
        {
            // Arrange
            $title = "The Giving Tree";
            $genre = "childrens";
            $book = new Book($title, $genre);
            $book->save();

            $title2 = "The Taking Boy";
            $genre2 = "adult";
            $book2 = new Book($title2, $genre2);
            $book2->save();

            // Act
            Book::deleteAll();
            $result = Book::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function test_getAll()
        {
            // Arrange
            $title = "The Giving Tree";
            $genre = "childrens";
            $book = new Book($title, $genre);
            $book->save();

            $title2 = "The Taking Boy";
            $genre2 = "adult";
            $book2 = new Book($title2, $genre2);
            $book2->save();

            // Act
            $result = Book::getAll();

            // Assert
            $this->assertEquals([$book, $book2], $result);
        }

        function test_find()
        {
            // Arrange
            $title = "The Giving Tree";
            $genre = "childrens";
            $book = new Book($title, $genre);
            $book->save();

            $title2 = "The Taking Boy";
            $genre2 = "adult";
            $book2 = new Book($title2, $genre2);
            $book2->save();

            // Act
            $id = $book->getId();
            $result = Book::find($id);

            // Assert
            $this->assertEquals($book, $result);
        }

        function test_delete()
        {
            // Arrange
            $first_name = "Shel";
            $last_name = "Silverstein";
            $author = new Author($first_name, $last_name);
            $author->save();

            $title = "The Giving Tree";
            $genre = "childrens";
            $book = new Book($title, $genre);
            $book->save();

            $title2 = "The Taking Boy";
            $genre2 = "Tree Horror";
            $book2 = new Book($title2, $genre2);
            $book2->save();

            // Act
            $book->addAuthor($author);
            $book2->addAuthor($author);
            $book->delete();
            $result = $author->getBooks();

            // Assert
            $this->assertEquals([$book2], $result);
        }

        function test_update_title()
        {
            // Arrange
            $title = "The Giving Tree";
            $genre = "childrens";
            $book = new Book($title, $genre);
            $book->save();

            // Act
            $new_title = "The Taking Bush";
            $new_genre = $genre;
            $book->update($new_title, $new_genre);
            $result = $book->getTitle();

            // Assert
            $this->assertEquals($new_title, $result);
        }

        function test_update_genre()
        {
            // Arrange
            $title = "The Giving Tree";
            $genre = "childrens";
            $book = new Book($title, $genre);
            $book->save();

            // Act
            $new_title = $title;
            $new_genre = "adult";
            $book->update($new_title, $new_genre);
            $result = $book->getGenre();

            // Assert
            $this->assertEquals($new_genre, $result);
        }

        function test_update_all()
        {
            // Arrange
            $title = "The Giving Tree";
            $genre = "childrens";
            $book = new Book($title, $genre);
            $book->save();

            // Act
            $new_title = "Crazy Tree Time";
            $new_genre = "adult";
            $book->update($new_title, $new_genre);
            $result1 = $book->getTitle();
            $result2 = $book->getGenre();

            // Assert
            $this->assertEquals($new_title, $result1);
            $this->assertEquals($new_genre, $result2);
        }

        function test_addAuthor()
        {
            // Arrange
            $title = "The Giving Tree";
            $genre = "childrens";
            $book = new Book($title, $genre);
            $book->save();

            $first_name = "Shel";
            $last_name = "Silverstein";
            $author = new Author($first_name, $last_name);
            $author->save();

            // Act
            $book->addAuthor($author);
            $result = $book->getAuthors();

            // Assert
            $this->assertEquals([$author], $result);

        }

        function test_getAuthors()
        {
            // Arrange
            $title = "Crime and Punishment";
            $genre = "russian classics";
            $book = new Book($title, $genre);
            $book->save();

            $first_name = "Fyodor";
            $last_name = "Dostoyefsky";
            $author = new Author($first_name, $last_name);
            $author->save();

            $first_name2 = "Richard";
            $last_name2 = "Pevear";
            $author2 = new Author($first_name2, $last_name2);
            $author2->save();

            $first_name3 = "Larissa";
            $last_name3 = "Volokhonsky";
            $author3 = new Author($first_name3, $last_name3);
            $author3->save();

            // Act
            $book->addAuthor($author);
            $book->addAuthor($author2);
            $book->addAuthor($author3);

            $result = $book->getAuthors();

            // Assert
            $this->assertEquals([$author, $author2, $author3], $result);
        }
    }
?>
