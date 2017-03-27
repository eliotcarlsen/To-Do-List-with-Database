<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";
    require_once "src/Category.php";

    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class TaskTest extends PHPUnit_Framework_TestCase
    {
      protected function tearDown()
      {
          Task::deleteAll();
          Category::deleteAll();
      }

      function test_getId()
      {
          $name = "Home stuff";
          $test_category = new Category($name);
          $test_category->save();
          $description = "Wash the dog";
          $category_id = $test_category->getId();
          $test_task = new Task ($description, $category_id);
          $test_task->save();
          $result = $test_task->getId();
          $this->assertEquals(true, is_numeric($result));
      }

      function test_getCategoryId()
      {
          $name = "Home stuff";
          $test_category = new Category($name);
          $test_category->save();
          $category_id = $test_category->getId();
          $description = "Wash the dog";
          $test_task = new Task($description, $category_id);
          $test_task->save();
          $result = $test_task->getCategoryId();
          $this->assertEquals($category_id, $result);
      }

      function test_save()
      {
          $name = "Home stuff";
          $test_category = new Category($name);
          $test_category->save();

          $description = "Wash the dog";
          $category_id = $test_category->getId();
          $test_task = new Task($description, $category_id);

          $executed = $test_task->save();

          $this->assertTrue($executed, "Task not successfully saved to database");
      }

      function test_getAll()
      {
          $name = "Home stuff";
          $test_category = new Category($name);
          $test_category->save();
          $category_id = $test_category->getId();

          $description = "Wash the dog";
          $description2 = "Water the lawn";
          $test_task = new Task($description, $category_id);
          $test_task->save();
          $test_task2 = new Task($description2, $category_id);
          $test_task2->save();

          $result = Task::getAll();

          $this->assertEquals([$test_task, $test_task2], $result);
      }

      function test_deleteAll()
      {
          $name = "Home stuff";
          $test_category = new Category($name);
          $test_category->save();
          $category_id = $test_category->getId();

          $description = "Wash the dog";
          $description2 = "Water the lawn";
          $test_task = new Task($description, $category_id);
          $test_task->save();
          $test_task2 = new Task($description2, $category_id);
          $test_task2->save();

          Task::deleteAll();

          $result = Task::getAll();
          $this->assertEquals([], $result);
      }

      function test_find()
      {
          $name = "Home stuff";
          $test_category = new Category($name);
          $test_category->save();
          $category_id = $test_category->getId();

          $description = "Wash the dog";
          $description2 = "Water the lawn";
          $test_task = new Task($description, $category_id);
          $test_task->save();
          $test_task2 = new Task($description2, $category_id);
          $test_task2->save();

          $id = $test_task->getId();
          $result = Task::find($id);

          $this->assertEquals($test_task, $result);
      }
    }

?>
