<?php

namespace App\Traits;

use App\Category;
use App\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileUploadTrait
{
    /**
     * @var string
     */
    protected $uploadPath = 'uploads';

    /**
     * @var
     */
    public $folderName = "media";

    /**
     * @var string
     */
    public $rule = 'image|max:2000';

    /**
     * @return bool
     */
    private function createUploadFolder(): bool
    {
        if (!file_exists(config('filesystems.disks.public.root') . '/' . $this->uploadPath . '/' . $this->folderName)) {
            $attachmentPath = config('filesystems.disks.public.root') . '/' . $this->uploadPath . '/' . $this->folderName;
            mkdir($attachmentPath, 0777);

            Storage::put('public/' . $this->uploadPath . '/' . $this->folderName . '/index.html', 'Silent Is Golden');

            return true;
        }

        return false;
    }

    /**
     * For handle validation file action
     *
     * @param $file
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFileAction($file)
    {

        $rules = array('fileupload' => $this->rule);
        $file  = array('fileupload' => $file);

        $fileValidator = Validator::make($file, $rules);

        if ($fileValidator->fails()) {

            $messages = $fileValidator->messages();

            return redirect()->back()->withInput(request()->all())
                ->withErrors($messages);
        }
    }

    /**
     * For Handle validation file
     *
     * @param $files
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFile($files)
    {

        if (is_array($files)) {
            foreach ($files as $file) {
                return $this->validateFileAction($file);
            }
        }
        return $this->validateFileAction($files);
    }

    /**
     * For Handle Put File
     *
     * @param $file
     * @return bool|string
     */
    private function putFile($file)
    {
        $fileName = preg_replace('/\s+/', '_', time() . ' ' . $file->getClientOriginalName());
        $path     = $this->uploadPath . '/' . $this->folderName . '/';

        if (Storage::putFileAs('public/' . $path, $file, $fileName)) {
            return $path . $fileName;
        }

        return false;
    }

    /**
     * For Handle Save File Process
     *
     * @param $files
     * @return array
     */
    public function saveFiles($files)
    {
        $data = [];

        if ($files != null) {

            $this->validateFile($files);

            $this->createUploadFolder();

            if (is_array($files)) {

                foreach ($files as $file) {
                    $data[] = $this->putFile($file);
                }
            } else {

                $data[] = $this->putFile($files);
            }
        }

        return $data;
    }


    /**
     * Upload the file with slugging to a given path
     *
     * @param UploadedFile $image
     * @param $path
     * @return string
     */
    public function uploadFile(UploadedFile $image, $path)
    {

        $this->validateFile($image);

        $extension = $image->getClientOriginalExtension();
        $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $image_name = Str::slug(date('Y-m-d-h-i-s') . $name . Str::random()) . '.' . $extension;
        $image->move($path, $image_name);

        return $path . "/" . $image_name;
    }

    /**
     * Upload the file with slugging to a given path
     *
     * @param UploadedFile $image
     * @param $path
     * @return string
     */
    public function saveMedia(UploadedFile $image, $path, $thumbnail)
    {

        $this->validateFile($image);

        $extension = $image->getClientOriginalExtension();
        $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $image_name = Str::slug(date('Y-m-d-h-i-s') . $name . Str::random()) . '.' . $extension;
        $image->move($path, $image_name);

        $url = $path . "/" . $image_name;

        // Create media content
        $media = Media::create([
            'id' => uniqid('gb', false),
            'url' => $this->getBaseUrl() . $url,
            'thumbnail' => $thumbnail ? $thumbnail : null
        ]);

        return $media->id;
    }
    /**
     * Upload the file with slugging to a given path
     *
     * @param UploadedFile $image
     * @param $path
     * @return string
     */
    public function saveMediaURL($url, $thumbnail = null)
    {
        if (isset($url)) {
            // Create media content
            $media = Media::create([
                'id' => uniqid('gb', false),
                'url' => $url,
                'thumbnail' => $thumbnail ? $thumbnail : null
            ]);
            return $media->id;
        }
        return;
    }




    /**
     * Suppose, you are browsing in your localhost
     * http://localhost/myproject/index.php?id=8
     */
    public function getBaseUrl()
    {
        // output: /myproject/index.php
        $currentPath = $_SERVER['PHP_SELF'];

        // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
        $pathInfo = pathinfo($currentPath);

        // output: localhost
        $hostName = $_SERVER['HTTP_HOST'];

        // output: http://
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';
        // return: http://localhost/myproject/
        return $protocol . '://' . $hostName . "/";
    }
}
