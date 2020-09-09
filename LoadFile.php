<?php
//Класс LoadFile служит для обработки полученных файлов (загрузка на сервер, получение hash, удаление с сервера)
class LoadFile {
    private $path_dir;//Поле имени дирректории, куда будет загружен файл
    private $name;//Имя файла
    private $type;//Тип файла
    private $tmp_name;//Временное имя файла
    private $error;//Ошибки при загрузке
    private $size;//Размер файла
    
    public function __construct(string $path_dir,string $name,string $type,string $tmp_name,string $error,string $size) {
        $this->path_dir=$path_dir;
        $this->name=$name;
        $this->type=$type;
        $this->tmp_name=$tmp_name;
        $this->error=$error;
        $this->siza=$size;
    }
    
    public function get() {//Метод возвращает данные по файлу
        $this->upload();
        $result = array ($this->get_name(), $this->get_size_file(), $this->get_extensions(), $this->get_md5_file());
        $this->delete();
        return $result;
    }

    private function upload(){//Метод загружает файл на сервер
        move_uploaded_file($this->tmp_name, $this->path_dir . $this->name);
    }
    
    private function delete(){//Метод удаляет файл с сервера
        unlink($this->path_dir . $this->name);
    }
    
    private function get_md5_file(){//Метод возвращает hash md5 файла
        return md5_file($this->path_dir . $this->name);
    }
     
    private function get_size_file(){//Метод возвращает размер файла
        return filesize($this->path_dir . $this->name);
    }
    
    private function get_name() {//Метод возвращает название без расширения
        return substr($this->name, 0 ,strrpos($this->name,'.'));
    }
    
    private function get_extensions(){//Метод возвращает расширение файла
        return $this->type= substr(strtolower($this->name),strrpos($this->name,'.')+1);
    }
}
