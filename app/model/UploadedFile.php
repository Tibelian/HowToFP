<?php

namespace App\Model;

/**
 * @author
 * @see www.tibelian.com
 */

class UploadedFile extends \SplFileInfo {

    private string $id;
    private string $path;
    private string $description;

    function __construct($filename){
        parent::__construct($filename);
    }

    function getId(): string {
        return $this->id;
    }
    function setId(string $id): void {
        $this->id = $id;
    }

    function getPath(): string {
        return $this->path;
    }
    function setPath(string $path): void {
        $this->path = $path;
    }

    function getDescription(): string {
        return $this->description;
    }
    function setDescription(string $description): void {
        $this->description = $description;
    }

}