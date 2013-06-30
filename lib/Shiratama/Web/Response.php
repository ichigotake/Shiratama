<?php

class Shiratama_Web_Response
{
    
    public function response_as_static_file($file)
    {
        $body = file_get_contents($file);
        
        header('Content-Type: ' . $this->getMimeType($file));
        header('Content-Length', strlen($body));
        echo $body;
    }

    public function getMimeType($file)
    {
        $ext = preg_replace('/.*\.(.*?)$/', '$1', $file);
        switch (strtolower($ext)) {
            case 'css':
                $mimeType = 'text/css';
                break;

            case 'js':
                $mimeType = 'application/javascript';
                break;

            case 'json':
                $mimeType = 'application/json';
                break;

            default:
                $mimeType = mime_content_type($file);
        }

        return $mimeType;
    }
}
