<?php

class UserUnitTest extends PHPUnit_Framework_TestCase {
  public function testDeleteValidUser()
  {
      $this->obj->deleteUser(1, "passport");
      $this->assertNull($this->obj->getUser(1, "passport"));
  }
  
  public function testDeleteInvalidUser()
  {
      $this->expectException(PDOException::class);
      $this->obj->deleteUser("invalid_id", "passport");
  }
  
  public function testDeleteInvalidDocType()
  {
      $this->expectException(PDOException::class);
      $this->obj->deleteUser(1, "invalid_doc_type");
  }
}

?>