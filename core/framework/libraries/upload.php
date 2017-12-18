<?php

/*
 * 在包含此类时请尽量传递 前五个参数 形式如下。
 * $upload=new Upload(array(upload_path=>'public/uploads/',allow_size=>2000000));
 * 其中$formname 为 form 表单中 <input type="file" name="files[]">的name的值 “files[]” 当然也可以在调用 upload 方法时 把参数传递进去。
 */

defined('InCosmos') or exit('Access Invalid!');
class Upload {
    private $default_path = BASE_UPLOAD_PATH;
    private $upload_path = 'indiana/product/';
    private $allow_type = array("image/png","image/jpeg","image/gif","image/x-png","image/pjpeg","txt","application/octet-stream");
    private $allow_size = "1000000";
    private $israndname=true;
    private $formname='files';

    private $PATH;
    private $initialName;
    public  $newFileName;
    private $file_Size;
    private $file_Type;
    private $tmp_Name;
    private $errorNum;
    private $errorMsg;
    public $return_msg;
    /* 构造函数会在对象生成时，自动调用，可以把一些私有方法放在里边，用来做某些参数的初始化也可以，在需要时用其他方法里直接调用。
    *  这里初始化了 定义的上传的路径 $upload_path 类型 $allow_type 大小 $allow_size 是否随机 $israndname 表单里边的文件名 $formname
    *  同时调用了 错误消息提示这个方法 function error_Msg() 为的是定义 $errorMsg这个参数以便以后调用（这个参数是数组）
    */
    function __Construct($arr=array()){
        foreach($arr as $key=>$val){
            $key = strtolower($key);
            if(array_key_exists($key,get_class_vars(get_class($this)))){
                // print_r($key);
                $this->$key=$val;
                //  echo $this->$key;
                //  echo "<br />";
            }
        }
        $this->PATH = $this->default_path.DS.$this->upload_path;
        if(!is_dir($this->PATH)){
            mkdir($this->PATH,'0777','true');
        }
        // echo $this->upload_path;
        $this->error_Msg();
        // print_r($this->errorMsg);
        // print_r(get_class_vars(get_class($this)));
        // print_r($_FILES);

    }
    private function error_Msg(){
        $this->errorMsg=array(1=>'上传文件超过了php.ini 中upload_max_filesize选项的值',
            2=>'上传文件超过了HTML表单中MAX_FILE_SIZE选项指定的值',
            3=>'文件只有部分被上传',
            4=>'没有上传文件',
            -1=>'不允许的类型',
            -2=>"文件过大，上传文件不能超过{$this->allow_size}个字节",
            -3=>'上传失败',
            -4=>'建立存放上传文件目录失败，请重新指定上传目录',
            -5=>'必须指定上传文件的路径');

    }
    /*
     *  此方法通过比较 来进行逻辑判断 同时产生相应的数字 最后返回一组数字。与function error_Msg()方法里的数字相匹配。
     *  同时还要满足最后产生的$arr 是二维数组 能跟 $_FILES['files']['name'] 数组相对应。以便在调用时 可以使用同样的下表。
     */
    private function error_Num(){

        $arr=array();

        foreach($_FILES[$this->formname]['name'] as $key=>$val){
            if(!in_array($_FILES[$this->formname]['type'][$key],$this->allow_type)){
                $i=0;
                $arr[$key][$i]='-1';
                $i++;
            }else{
                $i=0;
                $i++;
            }
            if($_FILES[$this->formname]['size'][$key] > $this->allow_size){

                $arr[$key][$i]='-2';
                $i++;
            }else{
                $i++;
            }

            if(empty($this->upload_path)){

                $arr[$key][$i]='-5';
            }
            if(empty($_FILES[$this->formname]['name'][$key])){
                $arr[$key][$i]='4';
            }

        }
        $this->errorNum=$arr;
        // print_r($arr);
        // echo 'aaa';

    }
    /*
     * 上传类先调用错误数字方法 得到 $errorNum 参数
     * 再遍历文件  在遍历每个文件时都先用if条件 来判断 $error_Num 是否为空.为空才可以 上传。不为空 则 输出 错误消息。
     */
    function upload_File($fileField){
        $this->formname = $fileField;
        $this->error_Num();
        // print_r($this->errorNum);
        // print_r($this->errorMsg);
        if(is_dir($this->PATH)) {
            if (isset($_FILES[$fileField])) {
                //  print_r($_FILES[$fileField]['name']);
                for ($i = 0; $i < count($_FILES[$fileField]['name']); $i++) {
                    if (!empty($this->errorNum[$i])) {
                        //遍历第一个文件 的错误数字。如果文件名为空就不用遍历了
                        if (!empty($_FILES[$fileField]['name'][$i])) {
                            foreach ($this->errorNum[$i] as $num) {
                              //  echo '第' . ($i + 1) . '个文件错误提示:' . $this->errorMsg[$num];
                              //  echo '<br />';
                                $this->return_msg .= $this->errorMsg[$num];
                            }
                        } else {
                           // echo '第' . ($i + 1) . '个文件错误提示:请选择文件';
                          //  echo '<br />';
                        }

                    } else {
                       // print_r($_FILES);
                        $name[$i] = $_FILES[$fileField]['name'][$i];
                        //
                        $extension[$i]=pathinfo($name[$i], PATHINFO_EXTENSION);

                        if ($this->israndname) {
                            $this->newFileName =$this->proRandName($extension[$i]);
                            move_uploaded_file($_FILES[$fileField]['tmp_name'][$i],  $this->PATH . $this->newFileName);
                        } else {
                            move_uploaded_file($_FILES[$fileField]['tmp_name'][$i], $this->PATH . $name[$i]);
                        }
                        // echo $this->upload_path;
                        //P($this->newFileName);
                        $filePathName[$i] =  $this->PATH . $this->newFileName;
                        $fileNewName[$i] = $this->newFileName;
                      //  echo $name[$i] . '这个文件上传成功<br>';

                    }
                }
            }

        }

        $return['filePathName'] = $filePathName;
        $return['fileNewName'] = $fileNewName;
        return $return;
    }
    private function proRandName($fileName) {
        $randleft = date('YmdHis')."_".rand(100,999);   //获取随机文件名
        $this->initialName = $randleft.'.'.$fileName;
        return $this->initialName;    //返回随机后文件名
    }
    /*
    function aa(){
        $this->error_Msg();
        echo "1111";
        echo count($this->errorMsg);
        foreach($this->errorMsg as $num=>$msg){
            echo $num.'=>'.$msg;
        }

    }
    */
}




