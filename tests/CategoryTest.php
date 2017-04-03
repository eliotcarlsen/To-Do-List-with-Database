<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Category::deleteAll();
            Task::deleteAll();
        }

        function test_getName()
        {
            $name = "Work stuff";
            $test_Category = new Category($name);
            $result = $test_Category->getName();
            $this->assertEquals($name, $result);
        }

        function test_set_name()
        {
            $name = "Kitchen chores";
            $test_category = new Category($name);

            $test_category->setName("Home chores");
            $result = $test_category->getName();

            $this->assertEquals("Home chores", $result);
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

        function test_update()
        {
            $name = "Work stuff";
            $test_category = new Category($name);
            $test_category->save();
            $new_name = "Home stuff";
            $test_category->update($new_name);
            $this->assertEquals("Home stuff", $test_category->getName());
        }

        function testDeleteCategory()
        {
            $test_category = new Category("Home stuff");
            $test_category->save();
            $test_category2 = new Category("Work stuff");
            $test_category2->save();
            $test_category->delete();
            $this->assertEquals([$test_category2], Category::getAll());
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

        function test_addTask()
        {
            $name = "Work stuff";
            $test_category = new Category($name);
            $test_category->save();

            $description = "File reports";
            $test_task = new Task($description);
            $test_task->save();
            $test_category->addTask($test_task);
            $this->assertEquals($test_category->getTasks(), [$test_task]);
        }

        function test_getTasks()
        {
            $name = "home stuff";
            $test_category = new Category($name);
            $test_category->save();

            $description = "wash the dog";
            $test_task = new Task($description);
            $test_task->save();

            $description2 = "take out the trash";
            $test_task2 = new Task($description2);
            $test_task2->save();

            $test_category->addTask($test_task);
            $test_category->addTask($test_task2);

            $this->assertEquals($test_category->getTasks(), [$test_task, $test_task2]);

        }

        function test_delete()
        {
            $name = "Work stuff";
            $test_category = new Category($name);
            $test_category->save();

            $description = "File reports";
            $test_task = new Task($description);
            $test_task->save();

            $test_category->addTask($test_task);
            $test_category->delete();

            $this->assertEquals([], $test_task->getCategories());
        }
    }

?>
