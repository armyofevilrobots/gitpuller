<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../lib/gitpuller.inc.php';


class GitPullerPublic extends GitPuller{

    public function branch_verify_auth($u, $p, $bspec){
        return GitPuller::_branch_verify_auth($u, $p, $bspec);
    }
    
    public function branch_user_match($push, $bspec){
        return GitPuller::_branch_user_match($push, $bspec);
    }

}

class StackTest extends PHPUnit_Framework_TestCase
{

    public function setUp(){
        $this->G = new GitPullerPublic(dirname(__FILE__)."/../cfg/config.test");
    }

    public function tearDown(){
    }

    public function test_checkpass_succeeds()
    {
        $this->assertEquals(
            $this->G->branch_verify_auth(
                "foo", "password", 
                array('huser'=>'foo', 'hpass'=>'password')
            ), TRUE);
         
        $this->assertEquals(0, 0);
    }

    public function test_checkpass_fails()
    {
        $this->assertEquals(
            $this->G->branch_verify_auth(
                "foo", "password", 
                array('huser'=>'foo', 'hpass'=>'XpasswordX')
            ), FALSE);
         
        $this->assertEquals(0, 0);
    }

    public function test_branch_matches(){

    }
}
?>
