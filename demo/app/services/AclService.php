<?php

namespace services;

use \Phalcon\Acl;
use Phalcon\Mvc\User\Component;
use \Phalcon\Acl\Resource;
use \Phalcon\Acl\Role;
use \Phalcon\Acl\Adapter\Memory as AclList;

/**
 * Phalcon\UserPlugin\Acl\Acl.
 */
class AclService extends Component
{
    private $_acl;
    private $_filePath = '/cache/acl/data.txt';

    private $cacheFilePath;

    private $accessData = [];

    private $lastUpdate;

    public function __construct($allowList,$lastUpdate)
    {


        $this->cacheFilePath = BASE_PATH.$this->_filePath;
        $this->accessData = $allowList;
        $this->lastUpdate = $lastUpdate;
    }


    /**
     * Checks if the current group is allowed to access a resource.
     *
     * @param string $group
     * @param string $controller
     * @param string $action
     *
     * @return bool
     */
    public function isAllowed($group, $controller, $action)
    {
        return $this->getAcl()->isAllowed($group, $controller, $action);
    }

    /**
     * Returns the ACL list.
     *
     * @return \Phalcon\Acl\Adapter\Memory
     */
    public function getAcl()
    {
        //Check if the ACL is already created
        if (is_object($this->_acl)) {
            return $this->_acl;
        }
        //Check if the ACL is already generated
        if (!file_exists($this->cacheFilePath)) {
            $this->_acl = $this->rebuild();
            return $this->_acl;
        }

        if($this->lastUpdate>filemtime($this->cacheFilePath)){
            $this->_acl = $this->rebuild();
            return $this->_acl;
        }

        //Get the ACL from the data file
        $data = file_get_contents($this->cacheFilePath);
        $this->_acl = unserialize($data);
        return $this->_acl;
    }
    /**
     * Rebuils the access list into a file.
     */
    public function rebuild()
    {

        $acl = new AclList();
        $acl->setDefaultAction(Acl::DENY);

        $roles = [];
        foreach ($this->accessData as $key => $value){
            $roles[$key] = new Role($key);
        }

        foreach ($this->accessData as $key => $value){
            $extends = $value['extends']??false;
            if($extends){
                $acl->addRole($roles[$key], $roles[$extends]);
            }else{
                $acl->addRole($roles[$key]);
            }
            foreach ($value['allow'] as $controller => $actions){
                $resource = new Resource($controller);

                $acl->addResource($resource, $actions);
                $acl->allow($key, $resource, $actions);
            }

        }


        $dir = pathinfo($this->cacheFilePath)['dirname'];

        if(!file_exists($dir)){
            if(!mkdir($dir, 0777, true)){
                $this->flash->error('can not make dir. =>'.$this->cacheFilePath);
            }
        }

        if (is_writable($dir)) {
            file_put_contents($this->cacheFilePath, serialize($acl));
        } else {
            $this->flash->error('The user does not have write permissions. =>'.$this->cacheFilePath);
        }
        return $acl;
    }
}