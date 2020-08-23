# Установка

    composer require php7bundle/crypt

## Yii2

Копируем файл `vendor/php7bundle/crypt/install/files/crypto.php` в `frontend/web/crypto.php`.

В файле `.env` прописываем:

```dotenv
RSA_DIRECTORY='common/runtime/rsa'
RSA_HOST_DIRECTORY='common/runtime/rsa/app'
RSA_CA_DIRECTORY='common/runtime/rsa/root'
```

