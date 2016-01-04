<?php

/**
 *
 */
class Messages extends ZendModel
{
    const CACHE_MESSAGE             = 'cache_message';
    const CACHE_MESSAGE_MESSAGE_ID  = 'cache_message_message_id';

    /**
     *  table name
     */
    protected $tableName = 'messages';

    /**
     *  get method
     */
    protected $getMethod = 'getMessage';

    /**
     *  get db object by record
     *  @param  row
     *  @return TahScan object
     */
    public function mapRow( $row )
    {
        $object = new Message();
        $object->setId                ( $row['id']                              );
        $object->setMessageId         ( $row['message_id']                      );
        $object->setUpdateId          ( $row['update_id']                       );
        $object->setUserId            ( $row['user_id']                         );
        $object->setFirstName         ( $row['first_name']                      );
        $object->setLastName          ( $row['last_name']                       );
        $object->setChatType          ( $row['chat_type']                       );
        $object->setChatId            ( $row['chat_id']                         );
        $object->setChatTitle         ( $row['chat_title']                      );
        $object->setContent           ( $row['content']                         );
        $object->setCreateMessageTime ( strtotime($row['create_message_time'])  );
        $object->setIsExecute         ( $row['is_execute']                      );
        $object->setProperties        ( unserialize($row['properties'])         );
        return $object;
    }

    /* ================================================================================
        write database
    ================================================================================ */

    /**
     *  add Message
     *  @param Message object
     *  @return insert id or false
     */
    public function addMessage($object)
    {
        $insertId = $this->addObject($object, true);
        if (!$insertId) {
            return false;
        }

        $object = $this->getMessage($insertId);
        if (!$object) {
            return false;
        }

        $this->preChangeHook($object);
        return $insertId;
    }

    /**
     *  update Message
     *  @param Message object
     *  @return int
     */
    public function updateMessage($object)
    {
        $result = $this->updateObject($object);
        if (!$result) {
            return false;
        }

        $this->preChangeHook($object);
        return $result;
    }

    /**
     *  delete Message
     *  @param int id
     *  @return boolean
     */
    public function deleteMessage(int $id)
    {
        $object = $this->getMessage($id);
        if ( !$object || !$this->deleteObject($id) ) {
            return false;
        }

        $this->preChangeHook($object);
        return true;
    }

    /**
     *  pre change hook, first remove cache, second do something more
     *  about add, update, delete
     *  @param object
     */
    public function preChangeHook($object)
    {
        // first, remove cache
        $this->removeCache($object);

        // second do something
        // 因為自身修改的影響, 必須要修改其它資料表記錄的欄位值
        /*
            // 例如 add article comment , 則 article of num_comments field 要做更新
            $article = $object->getArticle();
            $article->setNumComments( $this->getNumArticleComments( $article->getId() ) );
            $articles = new Articles();
            $articles->updateArticle($article);
        */
    }

    /**
     *  remove cache
     *  @param object
     */
    protected function removeCache($object)
    {
        if ( $object->getId() <= 0 ) {
            return;
        }

        $cacheKey = $this->getFullCacheKey( $object->getId(), Messages::CACHE_MESSAGE );
        CacheBrg::remove( $cacheKey );

        $cacheKey = $this->getFullCacheKey( $object->getUserId(), Messages::CACHE_MESSAGE_MESSAGE_ID );
        CacheBrg::remove( $cacheKey );
    }


    /* ================================================================================
        read access database
    ================================================================================ */

    /**
     *  get by id
     *  @param  int id
     *  @return object or false
     */
    public function getMessage( $id )
    {
        $object = $this->getObject( 'id', $id, Messages::CACHE_MESSAGE );
        if ( !$object ) {
            return false;
        }
        return $object;
    }

    /**
     *  get by message id
     *  @param  int id
     *  @return object or false
     */
    public function getMessageByMessageId( $messageId )
    {
        $object = $this->getObject( 'message_id', $messageId, Messages::CACHE_MESSAGE_MESSAGE_ID );
        if ( !$object ) {
            return false;
        }
        return $object;
    }

    /* ================================================================================
        find Messages and get count
        多欄、針對性的搜尋, 主要在後台方便使用, 使用 and 搜尋方式
    ================================================================================ */

    /**
     *  find many Message
     *  @param  option array
     *  @return objects or empty array
     */
    public function findMessages($opt=[])
    {
        $opt += [
            '_order'        => 'id,DESC',
            '_page'         => 1,
            '_itemsPerPage' => Config::get('db.items_per_page')
        ];
        return $this->findMessagesReal( $opt );
    }

    /**
     *  get count by "findMessages" method
     *  @return int
     */
    public function numFindMessages($opt=[])
    {
        // $opt += [];
        return $this->findMessagesReal($opt, true);
    }

    /**
     *  findMessages option
     *  @return objects or record total
     */
    protected function findMessagesReal($opt=[], $isGetCount=false)
    {
        // validate 欄位 白名單
        $list = [
            'fields' => [
                'id'                => 'id',
                'messageId'         => 'message_id',
                'updateId'          => 'update_id',
                'userId'            => 'user_id',
                'firstName'         => 'first_name',
                'lastName'          => 'last_name',
                'chatType'          => 'chat_type',
                'chatId'            => 'chat_id',
                'chatTitle'         => 'chat_title',
                'content'           => 'content',
                'createMessageTime' => 'create_message_time',
                'isExecute'         => 'is_execute',
                'properties'        => 'properties',
            ],
            'option' => [
                '_order',
                '_page',
                '_itemsPerPage',
            ]
        ];

        ZendModelWhiteListHelper::validateFields($opt, $list);
        ZendModelWhiteListHelper::filterOrder($opt, $list);
        ZendModelWhiteListHelper::fieldValueNullToEmpty($opt);

        $select = $this->getDbSelect();
        $field = $list['fields'];

        if ( isset($opt['id']) ) {
            $select->where->and->equalTo( $field['id'], $opt['id'] );
        }
        if ( isset($opt['messageId']) ) {
            $select->where->and->equalTo( $field['messageId'], $opt['messageId'] );
        }
        if ( isset($opt['updateId']) ) {
            $select->where->and->equalTo( $field['updateId'], $opt['updateId'] );
        }
        if ( isset($opt['userId']) ) {
            $select->where->and->equalTo( $field['userId'], $opt['userId'] );
        }
        if ( isset($opt['firstName']) ) {
            $select->where->and->equalTo( $field['firstName'], $opt['firstName'] );
        }
        if ( isset($opt['lastName']) ) {
            $select->where->and->equalTo( $field['lastName'], $opt['lastName'] );
        }

        if ( isset($opt['chatType']) ) {
            $select->where->and->equalTo( $field['chatType'], $opt['chatType'] );
        }
        if ( isset($opt['chatId']) ) {
            $select->where->and->equalTo( $field['chatId'], $opt['chatId'] );
        }
        if ( isset($opt['chatTitle']) ) {
            $select->where->and->equalTo( $field['chatTitle'], $opt['chatTitle'] );
        }
        if ( isset($opt['content']) ) {
            $select->where->and->like( $field['content'], '%'.$opt['content'].'%' );
        }
        if ( isset($opt['isExecute']) ) {
            $select->where->and->equalTo( $field['isExecute'], $opt['isExecute'] );
        }

        if ( !$isGetCount ) {
            return $this->findObjects( $select, $opt );
        }
        return $this->numFindObjects( $select );
    }

    /* ================================================================================
        extends
    ================================================================================ */

}
