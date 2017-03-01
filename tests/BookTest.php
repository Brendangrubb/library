<?php
    /**
    * @backupGlobals disabled
    * #backupStaticAttributes disabled
    */

    require_once 'src/Book.php';

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        function tearDown()
        {
            Book::deleteAll();
        }

        function test_getTitle()
        {
            // Arrange
            $title = "The Giving Tree";
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);

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
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);

            // Act
            $book->setTitle($new_title);
            $result = $book->getTitle();

            // Assert
            $this->assertEquals("The Missing Piece", $result);
        }

        function test_getAuthor()
        {
            // Arrange
            $title = "The Giving Tree";
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);

            // Act
            $result = $book->getAuthor();

            // Assert
            $this->assertEquals("Shel Silverstein", $result);
        }

        function test_setAuthor()
        {
            // Arrange
            $title = "The Giving Tree";
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);

            // Act
            $new_author = 'Shelly Silverstein';
            $book->setAuthor($new_author);
            $result = $book->getAuthor();

            // Assert
            $this->assertEquals($new_author, $result);
        }

        function test_save()
        {
            // Arrange
            $title = "The Giving Tree";
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);
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
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);
            $book->save();

            $title2 = "The Taking Boy";
            $author2 = "Sandy Goldenstein";
            $genre2 = "adult";
            $book2 = new Book($title2, $author2, $genre2);
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
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);
            $book->save();

            $title2 = "The Taking Boy";
            $author2 = "Sandy Goldenstein";
            $genre2 = "adult";
            $book2 = new Book($title2, $author2, $genre2);
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
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);
            $book->save();

            $title2 = "The Taking Boy";
            $author2 = "Sandy Goldenstein";
            $genre2 = "adult";
            $book2 = new Book($title2, $author2, $genre2);
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
            $title = "The Giving Tree";
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);
            $book->save();

            $title2 = "The Taking Boy";
            $author2 = "Sandy Goldenstein";
            $genre2 = "adult";
            $book2 = new Book($title2, $author2, $genre2);
            $book2->save();

            // Act
            $book->delete();
            $result = Book::getAll();

            // Assert
            $this->assertEquals([$book2], $result);
        }

        function test_update_title()
        {
            // Arrange
            $title = "The Giving Tree";
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);
            $book->save();

            // Act
            $new_title = "The Taking Bush";
            $new_author = $author;
            $new_genre = $genre;
            $book->update($new_title, $new_author, $new_genre);
            $result = $book->getTitle();

            // Assert
            $this->assertEquals($new_title, $result);
        }

        function test_update_author()
        {
            // Arrange
            $title = "The Giving Tree";
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);
            $book->save();

            // Act
            $new_title = $title;
            $new_author = "Billy Bush";
            $new_genre = $genre;
            $book->update($new_title, $new_author, $new_genre);
            $result = $book->getAuthor();

            // Assert
            $this->assertEquals($new_author, $result);
        }

        function test_update_genre()
        {
            // Arrange
            $title = "The Giving Tree";
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);
            $book->save();

            // Act
            $new_title = $title;
            $new_author = $author;
            $new_genre = "adult";
            $book->update($new_title, $new_author, $new_genre);
            $result = $book->getGenre();

            // Assert
            $this->assertEquals($new_genre, $result);
        }

        function test_update_all()
        {
            // Arrange
            $title = "The Giving Tree";
            $author = "Shel Silverstein";
            $genre = "childrens";
            $book = new Book($title, $author, $genre);
            $book->save();

            // Act
            $new_title = "Crazy Tree Time";
            $new_author = "Augustus St Claire";
            $new_genre = "adult";
            $book->update($new_title, $new_author, $new_genre);
            $result1 = $book->getTitle();
            $result2 = $book->getAuthor();
            $result3 = $book->getGenre();

            // Assert
            $this->assertEquals($new_title, $result1);
            $this->assertEquals($new_author, $result2);
            $this->assertEquals($new_genre, $result3);
        }
    }
?>
