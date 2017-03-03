<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Author.php';
    require_once __DIR__.'/../src/Book.php';

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();
    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__.'/../views'));

    $app->get('/', function() use ($app) {
        $books = Book::getAll();
        $authors = Author::getAll();

        return $app['twig']->render('index.html.twig', array('books' => $books, 'authors' => $authors));
    });

    $app->post('/add_book', function() use ($app) {
        $new_book = new Book(filter_var($_POST['title'], FILTER_SANITIZE_MAGIC_QUOTES), filter_var($_POST['genre'], FILTER_SANITIZE_MAGIC_QUOTES));
        $new_book->save();

        return $app->redirect('/');
    });

    $app->post('/add_author', function() use ($app) {
        $new_author = new Author($_POST['first_name'], $_POST['last_name']);
        $new_author->save();

        return $app->redirect('/');
    });

    $app->delete('/', function() use ($app) { // Deletes all information
        Book::deleteAll();
        Author::deleteAll();
        $GLOBALS['DB']->exec("DELETE FROM authors_books;");

        return $app->redirect('/');
    });

    $app->delete('/delete_books', function() use ($app) { // Deletes all books
        Book::deleteAll();

        return $app->redirect('/');
    });

    $app->delete('/delete_authors', function() use ($app) { // Deletes all authors
        Author::deleteAll();

        return $app->redirect('/');
    });

    $app->get('/edit/{id}', function($id) use ($app) {
        $author = Author::find($id);
        $books = Book::getAll();
        $author_books = $author->getBooks();

        return $app['twig']->render('edit_author.html.twig', array('author' => $author, 'books' => $books, 'author_books' => $author_books));
    });

    $app->post("/edit/{id}", function($id) use ($app) {
        $author = Author::find($id);
        $author->addBook($_POST['book_id']);

        return $app->redirect("/edit/" . $id);
    });

    return $app;
?>
