$(init);//Инициализируем события компонентов
let oFiles=null;//Переменная для массива файлов
function init(){
    $('#Load').bind( 'click', Load );//Событие на загрузку файлов
    $('#File').bind( 'change', Files );//Событие на выбор файлов
}

function Files(){
    oFiles = this.files;//Переприсваиваем при выборе файлов в глобальный массив
    $('#LoadBtn').css('display', 'block');//Показать кнопку для загрузки файлов
}

function FilesCheked(oFile){//Метод проверяет расширение файла и его размер
    let fileExtension = ['doc', 'docx', 'odt', 'pdf', 'xls', 'xlsx', 'ods'];//Массив разрешенных расширений
    let type=oFile['name'].toLowerCase();//Преобразуем имя файла в нижней регистр
    type = type.substring(type.lastIndexOf('.')+1);//Получаем расширение из имени файла
    let result=0;
    if ($.inArray(type,fileExtension)!=-1){//Сверяем полученное расширение с разрешенными 
        if (oFile['size']>83886080){//Проверяем размер, чтобы был не больше 80 Мб
            result = 1;
        }
    } else {
        result = 1;
    }
    return result;//Возвращаем результат. Если вернулся 0, то проверка успешна, если 1, то нет.
}

function FilesErrorTable(oFilesError){//Метод формирует таблицу с ошибками и выводит пользователю
    let content = '<table class="table table-bordered"><thead><tr><th scope="col">Имя файла</th><th scope="col">Размер файла (байт)</th></tr></thead>';
    content += '<tbody>';
    for (let oFileError of oFilesError.keys()){
        content += '<tr><td>'+oFileError+'</td><td>'+oFilesError.get(oFileError)+'</td></tr>';
    }
    content += '</tbody></table>';
    $('#LoadDataError').append(content);
    $('#LoadDataError').css('display', 'block');
}

function Load(){//Метод срабатывает при нажатии на кнпопку "Загрузить"
    $('#LoadBtn').css('display', 'none');//Спрятат кнопку для загрузки файлов
    $('#LoadProgressBar').css('display', 'block');//Показать процесс загрузки
    let oFormData = new FormData();//Создаем форму для отправки в Ajax режиме
    let oFilesError = new Map();//Создаем коллекцию для файлов, которые не будут обработаны
    if (oFiles.length!=0){//Если выбран для загрузки хотя бы один файл
        for (index=0;index<oFiles.length;++index){//Проходим по выбранному массиву файлов
        if (FilesCheked(oFiles[index])==0){//Проверяем файл на тип и размер
                oFormData.append('file[]',oFiles[index]);//Помещаем файл в форму
            }else {
                oFilesError.set(oFiles[index]['name'],oFiles[index]['size']);//Помещаем файл в коллекцию ошибок
            }
        }
        if (oFilesError.size!=0){//Проверяем на существование файлов с ошибками
            FilesErrorTable(oFilesError);//Формируем таблицу с ошибками
        }
        AjaxGet(oFormData);//Отправляем данные на сервер
    }  
}

function AjaxGet(oFormData){//Метод отправляет данные на сервер в виде Ajax запроса
    $.ajax({
        url: 'application.php',
        type: 'post',
        data: oFormData,
        contentType: false,
        processData: false,
        success:function(data){//В ответе фомируется таблица с результатами
            let result = JSON.parse(data);
            let content = '<table class="table table-bordered"><thead><tr><th scope="col">Имя файла</th><th scope="col">Размер файла (байт)</th><th scope="col">Тип файла</th><th scope="col">Hash файла</th></tr></thead>';
            content += '<tbody>';
            for (let i=0;i<result.length;i++){
                content += '<tr><td>'+result[i][0]+'</td><td>'+result[i][1]+'</td><td>'+result[i][2]+'</td><td>'+result[i][3]+'</td></tr>';
            }
            content += '</tbody></table>';
            $('#LoadData').append(content);
            $('#LoadProgressBar').css('display', 'none');//Спрятать процесс загрузки
            $('#LoadData').css('display', 'block');
        }
    });
}
