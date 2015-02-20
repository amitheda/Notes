<?php

namespace Notes\Mapper;

use Notes\Database\Database as Database;

class UserTag
{
    public function create($userTagModel)
    {
        $query            = "INSERT INTO UserTags(userId,tag) VALUES (:userId,:tag)";
        $placeholder      = array(
            ':userId' => $userTagModel->getUserId(),
            ':tag' => $userTagModel->getTag()
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $userTagModelbase = new Database();
        $result           = $userTagModelbase->post($params);
        if ($result['rowCount'] == 1) {
            $userTagModel->setId($result['lastInsertId']);
            return $userTagModel;
        } else {
            throw new \Exception("Column 'userId' cannot be null");
        }
    }
    
    public function read($userTagModel)
    {
        $query            = " SELECT id,userId,tag,isDeleted FROM UserTags WHERE id=:id";
        $placeholder      = array(
            ':id' => $userTagModel->getId()
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $userTagModelbase = new Database();
        $resultset        = $userTagModelbase->get($params);
        if (!empty($resultset)) {
            $userTagModel->setId($resultset[0]['id']);
            $userTagModel->setUserId($resultset[0]['userId']);
            $userTagModel->setTag($resultset[0]['tag']);
            $userTagModel->setIsDeleted($resultset[0]['isDeleted']);
            return $userTagModel;
        } else {
            throw new \Exception("UserTagId Does Not Present");
        }
    }
    
    public function update($userTagModel)
    {
        $query            = " UPDATE UserTags SET tag=:tag  WHERE id=:id";
        $placeholder      = array(
            ':id' => $userTagModel->getId(),
            ':tag' => $userTagModel->getTag()
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $userTagModelbase = new Database();
        $result           = $userTagModelbase->post($params);
        if ($result['rowCount'] == 1) {
            return $userTagModel ;
        } else {
            throw new \Exception("Updation Failed");
        }
        
    }
    
    public function delete($userTagModel)
    {
        $query            = " UPDATE UserTags SET isDeleted=1  WHERE id=:id";
        $placeholder      = array(
            ':id' => $userTagModel->getId()
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database = new Database();
        $result           = $database->post($params);
        if ($result['rowCount'] == 1) {
            $userTagModel->setIsDeleted(1);
            return $userTagModel;
        } else {
            throw new \Exception("UserTagId Does Not Present");
        }
        
    }
}
