SPA Приложение для учета финансов При разработке проекта показать:

1. Умение использовать ajax для обновления данных страницы без перезагрузки.
2. Работа на JS с DOM браузера(создание элементов на js, манипуляции с DOM деревом).
3. Использование jquery(По желанию).

Требования:

1. Неавторизованные пользователи видят форму в которой могут указать логин и пароль для авторизации или перейти на шаг
регистрации.
2. Проект должен содержать docker-compose файл, который запустит сайт локально.
3. Форма регистрации — логин и пароль, после регистрации мы показываем основной экран приложения.
4. Основной экран:

4.1 Форма ввода операции. Состоит из полей: Сумма, Тип(Расход, Приход), Комментарий.
4.2 Таблица, которая показывает 10 последних записей.
4.3 Блок Итого За: Сумма всех расходов, Сумма всех приходов.
4.4 Записи можно добавлять и удалять, редактирование недоступно.

5. Операции добавляются в БД без обновления страницы при помощи аякс, при этом обновляется таблица с 10ю последними
записями и блок ИТОГО.


cd .docker

docker-compose build

docker-compose up

http://localhost:8071