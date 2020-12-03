<h3>Запуск dev сервера:</h3>
<ul>
    <li>composer install</li>
    <li>npm install</li>
    <li>php artisan storage:link</li>
    <li>php artisan jwt:secret</li>
    <li>php artisan migrate:refresh --seed</li>
    <li>npm run watch-poll</li>
</ul>
<h3>Демо пользователь (админ):</h3>
<ul>
    <li>Login: admin@demo.ru</li>
    <li>Pass: admin</li>
</ul>
<h3>Если enveroment попал в кэш:</h3>
<ul>
    <li>php artisan config:cache</li>
    <li>php artisan config:clear</li>
</ul>
