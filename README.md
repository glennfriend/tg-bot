BOT
=================

- 使用前環境準備
    - 準備一台有 domain 並且公開的 web server
    - 建立 Telegram bot
    - 產生 SSL key, 不需要經過認證, 但是 "Common Name" 必須同於伺服器名稱

### set web-hook example
```sh
    curl -F url="https://bot.xxx.com/secret/web-hook.php" \
         -F certificate="@/private/ssl-key/telegram/ca.crt" \
         https://api.telegram.org/bot???:??????/setWebhook
```
