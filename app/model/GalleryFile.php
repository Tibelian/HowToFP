<?php

namespace App\Model;

/**
 * @author
 * @see www.tibelian.com
 */

class GalleryFile {

    private string $id;
    private ?UploadedFile $file;
    private string $title;
    private string $description;

    function getId(): string {
        return $this->id;
    }
    function setId(string $id): void {
        $this->id = $id;
    }

    function getFile(): ?UploadedFile {
        return $this->file;
    }
    function setFile(?UploadedFile $file): void {
        $this->file = $file;
    }

    function getTitle(): string {
        return $this->title;
    }
    function setTitle(string $title): void {
        $this->title = $title;
    }

    function getDescription(): string {
        return $this->description;
    }
    function setDescription(string $description): void {
        $this->description = $description;
    }

}