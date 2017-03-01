<?php
    /**
    * @backupGlobals disabled
    * #backupStaticAttributes disabled
    */

    require_once 'src/Author.php';

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        function tearDown()
        {
            Author::deleteAll();
        }

        function test_getFirstName()
        {
            // Arrange
            $first_name = 'Jaques';
            $last_name = 'St Pierre';
            $new_author = new Author($first_name, $last_name);

            // Act
            $result = $new_author->getFirstName();

            // Assert
            $this->assertEquals($first_name, $result);

        }

        function test_getLastName()
        {
            // Arrange
            $first_name = 'Jaques';
            $last_name = 'St Pierre';
            $new_author = new Author($first_name, $last_name);

            // Act
            $result = $new_author->getLastName();

            // Assert
            $this->assertEquals($last_name, $result);

        }

        function test_setFirstName()
        {
            // Arrange
            $first_name = 'Jaques';
            $last_name = 'St Pierre';
            $new_author = new Author($first_name, $last_name);

            // Act
            $new_first_name = "Pierre";
            $new_author->setFirstName($new_first_name);
            $result = $new_author->getFirstName();

            // Assert
            $this->assertEquals($new_first_name, $result);
        }

        function test_setLastName()
        {
            // Arrange
            $first_name = 'Jaques';
            $last_name = 'St Pierre';
            $new_author = new Author($first_name, $last_name);

            // Act
            $new_last_name = "Pierre";
            $new_author->setLastName($new_last_name);
            $result = $new_author->getLastName();

            // Assert
            $this->assertEquals($new_last_name, $result);
        }

        function test_save()
        {
            // Arrange
            $first_name = 'Jaques';
            $last_name = 'St Pierre';
            $new_author = new Author($first_name, $last_name);
            $new_author->save();

            // Act
            $result = Author::getAll();

            // Assert
            $this->assertEquals($new_author, $result[0]);
        }

        function test_getAll()
        {
            // Arrange
            $first_name = 'Jaques';
            $last_name = 'St Pierre';
            $new_author = new Author($first_name, $last_name);
            $new_author->save();

            $first_name2 = 'Jaques';
            $last_name2 = 'St Pierre';
            $new_author2 = new Author($first_name, $last_name);
            $new_author2->save();

            // Act
            $result = Author::getAll();

            // Assert
            $this->assertEquals([$new_author, $new_author2], $result);
        }

        function test_deleteAll()
        {
            // Arrange
            $first_name = 'Jaques';
            $last_name = 'St Pierre';
            $new_author = new Author($first_name, $last_name);
            $new_author->save();

            $first_name2 = 'Jaques';
            $last_name2 = 'St Pierre';
            $new_author2 = new Author($first_name, $last_name);
            $new_author2->save();

            // Act
            Author::deleteAll();
            $result = Author::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            // Arrange
            $first_name = 'George';
            $last_name = 'Orwell';
            $new_author = new Author($first_name, $last_name);
            $new_author->save();

            $first_name2 = 'Jaques';
            $last_name2 = 'St Pierre';
            $new_author2 = new Author($first_name, $last_name);
            $new_author2->save();

            // Act
            $id = $new_author2->getId();
            $result = Author::find($id);

            // Assert
            $this->assertEquals($new_author2, $result);
        }

        function test_delete()
        {
            // Arrange
            $first_name = 'George';
            $last_name = 'Orwell';
            $new_author = new Author($first_name, $last_name);
            $new_author->save();

            $first_name2 = 'Jaques';
            $last_name2 = 'St Pierre';
            $new_author2 = new Author($first_name, $last_name);
            $new_author2->save();

            // Act
            $new_author2->delete();
            $result = Author::getAll();

            // Assert
            $this->assertEquals($new_author, $result[0]);
        }

        function test_update()
        {
            // Arrange
            $first_name = 'George';
            $last_name = 'Orwell';
            $new_author = new Author($first_name, $last_name);
            $new_author->save();

            // Act
            $new_first_name = 'Fyodor';
            $new_last_name = 'Dostoyevsky';
            $new_author->update($new_first_name, $new_last_name);
            $result1 = $new_author->getFirstName();
            $result2 = $new_author->getLastName();

            // Assert
            $this->assertEquals($new_first_name, $result1);
            $this->assertEquals($new_last_name, $result2);
        }
    }
?>
