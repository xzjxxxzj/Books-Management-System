<?php

namespace App\Model;

class UpFile
{
    protected $maxSize = '2000000';
    protected $types = [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                            'image/pjpeg',
                            'image/gif',
                            'image/bmp',
                            'image/x-png'
                        ];
    protected $isWater = false;
    protected $water = '';
    protected $waterSpac = '';
    protected $path = '';
    private $files = '';

    /**
     * 上传图片控制器
     * @param array $config['isWater', 'water', 'waterSpac', 'maxSize', 'path']
     * 分别代表：
     * isWater是否开启水印；
     * water水印图片路径；
     * waterSpac 水印距离
     * maxSize 限制文件大小
     * path 文件上传路径
     */

    public function __construct($config)
    {
        $this->fileConfig($config);
    }

    /** 上传文件
     * @param array $uplist POST过来的$_FILE
     */

    public function upFile($uplist)
    {
        if (!$this->path) {
            return false;
        }
        $checkimage = $this->is_image($uplist);
        if (!$checkimage) {
            return false;
        }
        $this->files = $checkimage;
        return $this->uploadImage();
    }

    private function uploadImage()
    {
        $uplist = $this->files;

        foreach($uplist['tmp_name'] as $key=>$val) {
            if(!is_uploaded_file($val)) {
                return false;
            }
        }
        foreach($uplist['type'] as $key=>$val) {
            if(!in_array($val, $this->types)) {
                return false;
            }
        }
        foreach($uplist['size'] as $key=>$val) {
            if($val >$this->maxSize) {
                return false;
            }
        }

        if(!file_exists($this->path))
        {
            mkdir($this->path, '666');
        }
        if(!file_exists($this->path . date("Ymd")))
        {
            mkdir($this->path . date("Ymd"), '666');
        }
        $this->path = $this->path . date("Ymd") . '/';

        for($i=0; $i < count($uplist['tmp_name']); $i++) {
            $pinfo = pathinfo($uplist['name'][$i]);
            $ftype = $pinfo['extension'];
            //保存文件
            $filename = $this->path . time() . mt_rand(1000, 9999) . ($i+1) . '.' . $ftype;
            if (move_uploaded_file ($uplist['tmp_name'][$i], $filename)) {
                $filenew[$i]['path'] = $filename;
                $filenew[$i]['name'] = $pinfo['filename'];
            }
        }

        if($this->isWater) {
            $this->addwater($filenew);
        }
        /*
         * 上传成功返回文件信息
         */
        return $filenew;
    }

    private function is_image($image)
    {
        if (empty($image['tmp_name'])) {
            return false;
        }
        if (!is_array($image['tmp_name'])) {
            $checkimage = @getimagesize($image['tmp_name']);
            if (!$checkimage) {
                return false;
            }
            foreach ($image as $key => $value) {
                unset($image["{$key}"]);
                $image["{$key}"][] = $value;
            }
            return $image;
        } else {
            foreach ($image['tmp_name'] as $key =>$velue) {
                $checkimage = @getimagesize($velue);
                if (!$checkimage) {
                    return false;
                }
            }
            return $image;
        }
    }

    private function fileConfig($config)
    {
        if (!empty($config['path'])) {
            $this->path = rtrim($config['path'], '/') . '/';
        }

        if (!empty($config['isWater']) && !empty($config['water'])) {
            $this->isWater = true;
            $this->water = $config['water'];
        }
        if (!empty($config['isMinThum'])) {
            $this->isMinThum = true;
        }
        if (!empty($config['maxSize'])) {
            $this->maxSize = $config['maxSize'];
        }
    }

    private function addwater($filenew)
    {
        if (!file_exists($this->water)) {
            return false;
        }
        $in = getimagesize($this->water);
        $wdith = $in['0'];
        $height = $in['1'];
        $in = $this->imageType($this->water, $in['2']);
        foreach($filenew as $key=>$val){
            $im = getimagesize($val['path']);//加载原图
            //获取 宽 长
            $wd=$im['0'];
            $he=$im['1'];
            $im = $this->imageType($val['path'],$im['2']);
            //加印
            for ($x = 10; $x < ($wd - 10); $x = ($x + $wdith + $wd / $this->waterSpac)) {
                for ($y = 10; $y < ($he - 10); $y = ($y + $height + $he / $this->waterSpac)) {
                    imagecopy($im, $in, $x, $y,0, 0, $wdith, $height);
                }
            }
            ///保存图像
            imagejpeg($im,$val['path']);
            imagedestroy($im);
        }
    }

    private function imageType($w_dir, $w_img)
    {
        ini_set('memory_limit','512M');
        switch($w_img) {
            case 1;
                $w_img = imagecreatefromgif($w_dir);
                break;
            case 2;
                $w_img = imagecreatefromjpeg($w_dir);
                break;
            case 3;
                $w_img = imagecreatefrompng($w_dir);
                break;
            case 4;
                $w_img = imagecreatefromgif($w_dir);
                break;
        }
        return $w_img;
    }
}
