<?php
// +----------------------------------------------------------------------
// | Title   : 系统日志类
// +----------------------------------------------------------------------
// | Created : Henrick (me@hejinmin.cn)
// +----------------------------------------------------------------------
// | From    : Shenzhen wepartner network Ltd
// +----------------------------------------------------------------------
// | Date    : 2017/8/29 17:12
// +----------------------------------------------------------------------
namespace vendor\hlog\hlog;

class Hlog {

    protected $path = 'runtime/hlog/';
    protected $file_path = '';
    protected $max_size  = 5; //文件最大5M
    protected $file_name = '';//自定文件名

    function __construct()
    {

    }

    function writeJPushMsg($title='',$data=''){ //极光消息推送日志
        $content = $title." => ".serialize($data);
        $this->_getFilePath('jpush',$content);
    }

    protected function _getFilePath($type,$content=''){ //获取文件名
        $path = dirname(dirname(__DIR__)).DS;
        $this->file_path = $path.$this->path.$type.'/'.date("Y").'/'.date("m").'/';
        if(!is_dir($this->file_path)){ //创建目录
            mkdir($this->file_path,0777,true);
        }
        $this->file_name = $this->file_name ? $this->file_nam:date("d").'_1.log';
        //判断文件是否超出文件内容最大限制
        if(filesize($this->file_name)/1024>=5){
            //获取当前文件夹个数
            $file_number = glob($this->file_path.'*');
            $this->file_name = date("d").'_'.$file_number.'.log';
        }
        $file_path = $this->file_path.$this->file_name;
        $content = '['.date("Y-m-d H:i:s").'] '.$content."\n";
        file_put_contents($file_path,$content,FILE_APPEND);
        return $file_path;
    }
}