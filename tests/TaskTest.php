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

      function test_getDescription()
      {
          $description = "Do dishes.";
          $test_task = new Task($description);

          $result = $test_task->getDescription();
          $this->assertEquals($description, $result);
      }

      function test_setDescription()
      {
          $description = "Do dishes.";
          $test_task = new Task($description);

          $test_task->setDescription("Drink coffee.");
          $result = $test_task->getDescription();
          $this->assertEquals("Drink coffee.", $result);
      }

      function test_getId()
      {
          $description = "Wash the dog";
          $test_task = new Task ($description);
          $test_task->save();
          $result = $test_task->getId();
          $this->assertEquals(true, is_numeric($result));
      }

      function test_save()
      {
          $description = "Wash the dog";
          $test_task = new Task($description);

          $executed = $test_task->save();

          $this->assertTrue($executed, "Task not successfully saved to database");
      }

      function test_getAll()
      {
          $description = "Wash the dog";
          $test_task = new Task($description);
          $test_task->save();
          $description2 = "Water the lawn";
          $test_task2 = new Task($description2);
          $test_task2->save();

          $result = Task::getAll();

          $this->assertEquals([$test_task, $test_task2], $result);
      }

      function test_deleteAll()
      {
          $description = "Wash the dog";
          $test_task = new Task($description);
          $test_task->save();
          $description2 = "Water the lawn";
          $test_task2 = new Task($description2);
          $test_task2->save();

          Task::deleteAll();

          $result = Task::getAll();
          $this->assertEquals([], $result);
      }

      function test_find()
      {
          $description = "Wash the dog";
          $test_task = new Task($description);
          $test_task->save();
          $description2 = "Water the lawn";
          $test_task2 = new Task($description2);
          $test_task2->save();

          $id = $test_task->getId();
          $result = Task::find($id);

          $this->assertEquals($test_task, $result);
      }

      function test_update()
      {
          $description = "Wash the dog";
          $test_task = new Task($description);
          $test_task->save();

          $new_description = "Clean the dog";
          $test_task->update($new_description);
          $this->assertEquals("Clean the dog", $test_task->getDescription());
      }

      function test_deleteTask()
      {
          $description = "Wash the dog";
          $test_task = new Task($description);
          $test_task->save();

          $description2 = "Water the lawn";
          $test_task2 = new Task($description2);
          $test_task2->save();

          $test_task->delete();

          $this->assertEquals([$test_task2], Task::getAll());
      }

      function test_addCategory()
      {
          $name = "work stuff";
          $test_category = new Category($name);
          $test_category->save();

          $description = "file reports";
          $test_task = new Task($description);
          $test_task->save();

          $test_task->addCategory($test_category);
          $this->assertEquals($test_task->getCategories(), [$test_category]);
      }

      function test_getCategories()
      {
          $name = "work stuff";
          $test_category = new Category($name);
          $test_category->save();

          $name2 = "volunteer stuff";
          $test_category2 = new Category($name2);
          $test_category2->save();

          $description = "File reports";
          $test_task = new Task($description);
          $test_task->save();

          $test_task->addCategory($test_category);
          $test_task->addCategory($test_category2);

          $this->assertEquals($test_task->getCategories(), [$test_category, $test_category2]);
      }

      function test_delete()
      {
          $name = "Work stuff";
          $test_category = new Category($name);
          $test_category->save();

          $description = "File reports";
          $test_task = new Task($description);
          $test_task->save();

          $test_task->addCategory($test_category);
          $test_task->delete();

          $this->assertEquals([], $test_category->getTasks());
      }
    }

?>
