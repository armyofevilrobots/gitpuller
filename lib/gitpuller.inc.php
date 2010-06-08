<?php
class GitPuller
{
    // property declaration
    //public $var = 'a default value';
    //
    function __construct($config=FALSE){
        if (!$config){
            $this->config=dirname(__FILE__)."/../cfg/config.ini";
        }else{
            $this->config=$config;
        }
        $this->cfg=parse_ini_file($this->config, TRUE);
    }

    // method declaration
    public function dumpcfg() {
        var_dump($this->cfg);
    }


    private function _branch_user_match($push, $bspec){
        if ($push->repository->owner->name != $bspec['owner'] || 
            $push->repository->name != $bspec['project']){
                //Wrong project or spec. Fail
                //echo "No match on repo/name", $push->repository->owner->name, " ", $push->repository->name."<br/>\n";
                //echo "Expected repo/name", $bspec['owner'], " ", $bspec['project']."<br/>\n";
                return FALSE;
            }
        //Next check branch
        $_head = explode("/", $push->ref);
        $head = $_head[count($_head)-1];
        if($head != $bspec['branch']) return FALSE;//wrong branch
        
        //WIN!
        return TRUE;
    }

    private function _branch_verify_auth($u, $p, $bspec){
        if( ($bspec['huser'] == "" || $u == $bspec['huser']) && 
            ($bspec['hpass'] == "" || $p == $bspec['hpass'])){
                //echo "Auth OK";
                return TRUE;
            }
        return FALSE;
    }

    private function run($bspec){
        ///This actually runs the repo push/pull
        $_h = explode(":", $bspec['target']);
        if(count($_h)!=2){
            throw new Exception("Invalid target for bspec $bspec[project]<br/>\n");
        }

        $host = $_h[0];
        $path = $_h[1];
        $repo=$bspec['repo']?$bspec['repo']:'origin';
        $git=$bspec['git']?$bspec['git']:'/usr/bin/git';
        $cmd = $git." pull ".$repo." ".$bspec['branch'];

        if ($host="@"){
            $result=0;
            //echo "Running locally<br/>\n";
            chdir($path);
            //echo "Running $cmd in $path <br/>\n";
            $out = system($cmd." 2>&1", $result);
            //echo "$result was result.\n";
            if($result!=0){
                error_log("Command failed with:\n$out\n");
                return FALSE;
            }
            return TRUE;
        }else{
            //echo "Remote repos are not yet implemented...";
            throw new Exception("Remote repos are not yet implemented.");
        }
    }//run

    public function process($post, $authname=FALSE, $authpwd=FALSE){
        //This will receive the POST data and then generate
        //the actions required to push upstream.
        $push = json_decode($post);
        $head = explode("/", $push->ref);
        $owner = $push->repository->owner->name;
        foreach($this->cfg as $branch=>$bspec){
            //echo "Testing against $branch<br/>\n";
            if ($this->_branch_user_match($push, $bspec) && 
                $this->_branch_verify_auth($authname, $authpwd, $bspec)){
                    return $this->run($bspec);
            }else{
                return FALSE;
            }
        }//foreach
    }//process

}//class


?>
