<?php

namespace TicketProPlus\App\Core;

class FileUploader
{
    private string $uploadDir;
    private array $allowedMimeTypes;
    private int $maxFileSize; // en octets
    private string $newFilename;

    /**
     * Constructeur de la classe FileUploader.
     *
     * @param string $uploadDir Le chemin du répertoire de destination pour les uploads.
     * @param array $allowedMimeTypes Un tableau des types MIME autorisés (ex: ['image/jpeg', 'image/png']).
     * @param int $maxFileSize La taille maximale autorisée pour le fichier en octets.
     */
    public function __construct(string $uploadDir, int $maxFileSize = 2097152) // 2MB par défaut
    {
        $this->uploadDir = rtrim($uploadDir, '/'); // Assure l'absence de slash final
        $this->allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $this->maxFileSize = $maxFileSize;
    }

    /**
     * Télécharge un fichier.
     *
     * @param array $fileInfo Le tableau $_FILES correspondant au fichier à télécharger.
     * @param string|null $customFilename Un nom de fichier personnalisé (sans l'extension). Si null, un nom unique sera généré.
     * @return string|false Le chemin complet du fichier téléchargé en cas de succès, false en cas d'échec.
     */
    public function upload(array $fileInfo, ?string $customFilename = null): string|false
    {
        if (!isset($fileInfo['error']) || $fileInfo['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        if ($fileInfo['size'] > $this->maxFileSize) {
            return false;
        }

        $mime = mime_content_type($fileInfo['tmp_name']);
        if (!empty($this->allowedMimeTypes) && !in_array($mime, $this->allowedMimeTypes, true)) {
            return false;
        }

        $extension = $this->getExtensionFromMime($mime);
        if ($extension === false) {
            return false;
        }

        $baseFilename = $customFilename ?? uniqid();
        $this->newFilename = $baseFilename . '.' . $extension;
        $destination = $this->uploadDir . '/' . $this->newFilename;

        if (!is_dir($this->uploadDir) && !mkdir($this->uploadDir, 0755, true)) {
            return false;
        }

        if (!move_uploaded_file($fileInfo['tmp_name'], $destination)) {
            return false;
        }

        return $destination;
    }

    public function deleteFile(string $filePath): void
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    /**
     * Récupère le nom du fichier téléchargé (si le téléchargement a réussi).
     *
     * @return string|null Le nom du fichier.
     */
    public function getFilename(): ?string
    {
        return $this->newFilename ?? null;
    }

    /**
     * Obtient l'extension de fichier à partir du type MIME.
     *
     * @param string $mime Le type MIME du fichier.
     * @return string|false L'extension de fichier en minuscules, ou false si non trouvé.
     */
    private function getExtensionFromMime(string $mime): string|false
    {
        return match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            default => false,
        };
    }
}
