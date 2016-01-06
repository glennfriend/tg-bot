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
        return [];
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
     *  是否已完成該指令
     *      - true  -> 已完成該指令的動作
     *      - false -> 未執行過的指令
     */
    public function getIsUsed()
    {
        if (true === $this->store['is_used']) {
            return true;
        }
        return false;
    }

    /**
     *  get full name
     */
    public function getName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     *  解析最基本的命令
     *      - 參數1 為 命令名稱
     *      - 參數2 為 命令內容
     *
     *  @return array
     */
    public function parseCommand()
    {
        $tmp = explode(' ', $this->getContent());
        if (!$tmp || !is_array($tmp) ) {
            return [null, null];
        }

        $command = '';
        if ('/'===substr($tmp[0],0,1)) {
            $command = substr($tmp[0],1);
        }

        unset($tmp[0]);
        $body = join(' ',$tmp);
        return [
            strtolower($command),
            $body
        ];
    }

    /* ------------------------------------------------------------------------------------------------------------------------
        lazy loading methods
    ------------------------------------------------------------------------------------------------------------------------ */

}
