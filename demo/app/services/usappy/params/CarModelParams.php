<?php
/**
 * Created by IntelliJ IDEA.
 * User: phucanthony
 * Date: 11/14/17
 * Time: 9:24 PM
 */

namespace services\usappy\params;


class CarModelParams implements \JsonSerializable
{
    public function __construct()
    {
        $this->{'model_id'} = '';
        $this->{'model_name'} = '';

    }
    public function setModelId(string $model_id) : CarModelParams
    {
        $this->{'model_id'}  = $model_id;
        return $this;
    }

    public function setModelName(string $model_name) : CarModelParams
    {
        $this->{'model_name'} = $model_name;
        return $this;
    }

    public function getModelId()
    {
        return $this->{'model_id'};
    }


    public function getModelName()
    {
        return $this->{'model_name'};
    }

    public function jsonSerialize()
    {
        return (array)$this;
    }

    public function parseArray($data)
    {
        $keys = array_keys((array)$this);
        $data = (array)$data;
        foreach ($keys as $key){
            $this->$key = $data[$key];
        }
    }
}