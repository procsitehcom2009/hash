<?php
//Класс LoadFile служит для обработки полученных файлов (загрузка на сервер, получение hash, удаление с сервера)
class LoadFile {
    private $path_dir;//Поле имени дирректории, куда будет загружен файл
    private $name;//Имя файла
    private $type;//Тип файла
    private $tmp_name;//Временное имя файла
    private $error;//Ошибки при загрузке
    private $size;//Размер файла
    private $encryption_type;//Тип шифрования
    
    public function __construct(string $path_dir,string $name,string $type,string $tmp_name,string $error,string $size,string $encryption_type) {
        $this->path_dir=$path_dir;
        $this->name=$name;
        $this->type=$type;
        $this->tmp_name=$tmp_name;
        $this->error=$error;
        $this->size=$size;
        $this->encryption_type=$encryption_type;
    }
    
    public function get() {//Метод возвращает данные по файлу
        $this->upload();
        $result = array ($this->get_name(), $this->get_size_file(), $this->get_extensions(), $this->get_encryption());
        $this->delete();
        return $result;
    }

    private function upload(){//Метод загружает файл на сервер
        move_uploaded_file($this->tmp_name, $this->path_dir . $this->name);
    }
    
    private function delete(){//Метод удаляет файл с сервера
        unlink($this->path_dir . $this->name);
    }
    
    private function get_encryption(){//Метод проверяет тип шифрования и шифрует
        if ($this->encryption_type=="crc32"){
            return $this->get_crc32_file();
        }
        if ($this->encryption_type=="md5"){
            return $this->get_md5_file();
        }
    }
    
    private function get_md5_file(){//Метод возвращает hash md5 файла
        return md5_file($this->path_dir . $this->name);
    }
    
    private function get_crc32_file(){//Метод возвращает hash crc32 файла
        return crc32(file_get_contents($this->path_dir . $this->name));
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
