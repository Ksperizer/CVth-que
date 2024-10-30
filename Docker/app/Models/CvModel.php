<?php
class CvModel {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function uploadCV($userId, $fileName, $filePath, $fileType) {
        $stmt = $this->bdd->prepare("INSERT INTO CV (user_id, fileName, filePath, fileType) VALUES (:user_id, :fileName, :filePath, :fileType)");
        return $stmt->execute([
            'user_id' => $userId,
            'fileName' => $fileName,
            'filePath' => $filePath,
            'fileType' => $fileType
        ]);
    }

    public function getCVByUserId($userId) {
        $stmt = $this->bdd->prepare("SELECT * FROM CV WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
