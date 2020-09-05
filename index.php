<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="form-group" id="FileDownload">
                <h2><p class="text-primary">Загрузите файлы для получения hash и размера</p></h2>
                <h4><p class="text-warning">Файл должен иметь формат: doc, docx, odt, pdf, xls, xlsx, ods</p></h4>
                <h4><p class="text-warning">Размер файла не должен превышать 80 МБ</p></h4>
                <input type="file" class="form-control-file" id="File" multiple="true">
            </div>
            <div class="form-group" id="LoadBtn">
                <button type="submit" class="btn btn-primary" id="Load" enabled>Загрузить</button>
            </div>
            <div class="form-group" id="LoadDataError" style="display:none;">
                <h3><p class="text-danger">Некоторые файлы не обработанны. Они имеют неверный тип файла или превышают 80 МБ</p></h3>
            </div>
            <div class="form-group" id="LoadData" style="display:none;">
                <h3><p class="text-success">Обработанные файлы</p></h3>
            </div>
        </div>
    </body>
</html>


