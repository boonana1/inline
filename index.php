<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск по комментариям</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="container">
        <header>
            <h3>Поиск по комментариям:</h3>
            <form>
                <input type="text" name="search" placeholder="Введите текст для поиска">
                <span class="hint-error">Для поиска нужно ввести минимум 3 символа</span>
                <button type="submit">Найти</button>
            </form>
        </header>
        <main>
            <div class="posts">

            </div>
        </main>
    </div>
    <script src="./form.js" type="text/javascript"></script>
</body>

</html>