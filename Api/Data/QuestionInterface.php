<?php
namespace Smile\ContactsPro\Api\Data;

interface QuestionInterface
{
    const QUESTION_ID   = 'question_id';
    const NAME          = 'name';
    const EMAIL         = 'email';
    const PHONE         = 'phone';
    const CONTENT       = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const STATUS        = 'status';

    public function getId();

    public function getName();

    public function getEmail();

    public function getPhone();

    public function getContent();

    public function getCreationTime();

    public function getUpdateTime();

    public function getStatus();

    public function setId($id);

    public function setName($name);

    public function setEmail($email);

    public function setPhone($phone);

    public function setContent($content);

    public function setCreationTime($creationTime);

    public function setUpdateTime($updateTime);

    public function setStatus($status);
}
