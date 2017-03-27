<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";

    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class TaskTest extends PHPUnit_Framework_TestCase
    {
      protected function tearDown()
      {
          Task::deleteAll();
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
          $description2 = "Water the lawn";
          $test_task = new Task($description);
          $test_task->save();
          $test_task2 = new Task($description2);
          $test_task2->save();

          $result = Task::getAll();

          $this->assertEquals([$test_task, $test_task2], $result);
      }

      function test_deleteAll()
      {
          $description = "Wash the dog";
          $description2 = "Water the lawn";
          $test_task = new Task($description);
          $test_task->save();
          $test_task2 = new Task($description2);
          $test_task2->save();

          Task::deleteAll();

          $result = Task::getAll();
          $this->assertEquals([], $result);
      }

      function test_getId()
      {
          $description = "Wash the dog";
          $test_Task = new Task($description);
          $test_Task->save();

          $result = $test_Task->getId();
          $this->assertTrue(is_numeric($result));
      }

      function test_find()
      {
          $description = "Wash the dog";
          $description2 = "Water the lawn";
          $test_task = new Task($description);
          $test_task->save();
          $test_task2 = new Task($description2);
          $test_task2->save();

          $id = $test_task->getId();
          $result = Task::find($id);

          $this->assertEquals($test_task, $result);
      }
    }

?>
