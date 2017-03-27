<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Category::deleteAll();
        }

        function test_getName()
        {
            $name = "Work stuff";
            $test_Category = new Category($name);
            $result = $test_Category->getName();
            $this->assertEquals($name, $result);
        }

        function test_save()
        {
            $name = "Work stuff";
            $test_Category = new Category ($name);
            $executed = $test_Category->save();
            $this->assertTrue($executed, "Category not successfully saved to database");
        }

        function test_getId()
        {
            $name = "Work stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $result = $test_Category->getId();
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getAll()
        {
            $name = "Work stuff";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();
            $result = Category::getAll();
            $this->assertEquals([$test_Category, $test_Category2], $result);
        }

        function test_deleteAll()
        {
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();
            Category::deleteAll();
            $result = Category::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();
            $result = Category::find($test_Category->getId());
            $this->assertEquals($test_Category, $result);
        }
    }

?>
