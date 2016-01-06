<?php
namespace CommandController;
use CommandController;
use BotHelper;

/**
 *
 */
class Enter
{

    /**
     *
     */
    public function home($id)
    {
        $messages = new \Messages();
        $message = $messages->getMessage($id);
        $this->_validateMessage($message);
        $controller = $this->_getController($message);

        $text = $controller->perform($message);
        if (!$text) {
            return;
        }

        // send text
        $chatId = $message->getChatId();
        $messageId = BotHelper::sendMessage($chatId, $text);
        if (!$messageId) {
            di('log')->record("send fail: message id = {$message->getId()}");
        }
    }
 
    // --------------------------------------------------------------------------------
    // private
    // --------------------------------------------------------------------------------

    /**
     *  route controller
     */
    protected function _getController($message)
    {
        list($command, $content) = $message->parseCommand();
        switch ($command) {
            case 'help':
                return new CommandController\ToHelp();
                break;
        }
        return new CommandController\ToDefault();
    }

    /**
     *  validate message
     */
    protected function _validateMessage($message)
    {
        if (!$message) {
            di('log')->record("message not found at " . date('Y-m-d H:i:s'));
            exit;
        }

        // 已處理過的 message 將不再處理
        if ($message->getIsUsed()) {
            di('log')->record("message {$id} is used");
            exit;
        }

        // 回應的 chat_id 必須在白名單之內
        $chatId = $message->getChatId();
        $allowIds = conf('bot.allow_chat_ids');
        if (!in_array($chatId, $allowIds)) {
            di('log')->record("message can not allow send to {$chatId} ({$message->getName()})");

            // debug -> 如果不在予許的名單內, 發送警告訊息
            if (isTraining()) {
                $userId = $message->getUserId();
                $text   = '您不在白名單之內 by BOT';
                BotHelper::sendMessage($userId, $text);
            }
            exit;
        }

    }

}
