<?php

/**
 *  Message
 *
 */
class Message extends BaseObject
{

    /**
     *  請依照 table 正確填寫該 field 內容
     *  @return array()
     */
    public static function getTableDefinition()
    {
        return [
            'id' => [
                'type'    => 'integer',
                'filters' => ['intval'],
                'storage' => 'getId',
                'field'   => 'id',
            ],
            'messageId' => [
                'type'    => 'integer',
                'filters' => ['intval'],
                'storage' => 'getMessageId',
                'field'   => 'message_id',
            ],
            'updateId' => [
                'type'    => 'integer',
                'filters' => ['intval'],
                'storage' => 'getUpdateId',
                'field'   => 'update_id',
            ],
            'userId' => [
                'type'    => 'integer',
                'filters' => ['intval'],
                'storage' => 'getUserId',
                'field'   => 'user_id',
            ],
            'firstName' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getFirstName',
                'field'   => 'first_name',
            ],
            'lastName' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getLastName',
                'field'   => 'last_name',
            ],
            'chatType' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getChatType',
                'field'   => 'chat_type',
            ],
            'chatId' => [
                'type'    => 'integer',
                'filters' => ['intval'],
                'storage' => 'getChatId',
                'field'   => 'chat_id',
            ],
            'chatTitle' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getChatTitle',
                'field'   => 'chat_title',
            ],
            'content' => [
                'type'    => 'string',
                'filters' => ['strip_tags','trim'],
                'storage' => 'getContent',
                'field'   => 'content',
            ],
            'createMessageTime' => [
                'type'    => 'timestamp',
                'filters' => ['dateval'],
                'storage' => 'getCreateMessageTime',
                'field'   => 'create_message_time',
                'value'   => 0,
            ],
            'isUsed' => [
                'type'    => 'integer',
                'filters' => ['intval'],
                'storage' => 'getIsUsed',
                'field'   => 'is_used',
                'value'   => false,
            ],
            'properties' => [
                'type'    => 'string',
                'filters' => ['arrayval'],
                'storage' => 'getProperties',
                'field'   => 'properties',
            ],
        ];
    }

    /**
     *  validate
     *  @return messages array()
     */
    public function validate()
    {
        return [];
    }

    /* ------------------------------------------------------------------------------------------------------------------------
        basic method rewrite or extends
    ------------------------------------------------------------------------------------------------------------------------ */

    /**
     *  Disabled methods
     *  @return array()
     */
    public static function getDisabledMethods()
    {
        return ['getIsUsed'];
    }

    /* ------------------------------------------------------------------------------------------------------------------------
        extends
    ------------------------------------------------------------------------------------------------------------------------ */

    public function setIsUsed($type)
    {
        if ( true === $type || 1 === $type) {
            $this->store['is_used'] = true;
        }
        $this->store['is_used'] = false;
    }

    /**
     *  是否已執行過
     */
    public function isUsed()
    {
        if (true === $this->store['is_used']) {
            return true;
        }
        return false;
    }

    /* ------------------------------------------------------------------------------------------------------------------------
        lazy loading methods
    ------------------------------------------------------------------------------------------------------------------------ */

}
