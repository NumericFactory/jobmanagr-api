<?php 
namespace App\Services;
use App\Models\Talent;
use App\Models\Job;
use App\Models\Resume;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;


enum TalentTypeFile: string {
    case Resume = 'cv';
    case Contract = 'contrat';
}
// enum JobDocumentTypeFile: string {
//     case Syllabus = 'cv';
//     case Contract = 'contrat';
// }
enum CustomerTypeFile: string {
    case Contract = 'contrat';
}

class UploadFileManagerService {
    

     /**
     * Upload a document file for job
     * @param Job $job
     * @param File $file
     * @return Document
     */
    public function uploadJobDocument(Job $job, $file): Document {
        $extension = $file->getClientOriginalExtension();
        $filePath = self::generateJobDocumentPath($job, $extension);
        Storage::disk('local')->put( $filePath, file_get_contents($file).$extension);
        $document = $job->resumes()->create([ 
            'link'      => '/' . $filePath, 
            'job_id' => $job->id
        ]);
        return $document;  
    }

    /**
     * Upload a resume file for talent
     * @param Talent $talent
     * @param File $file
     * @return Resume
     */
    public function uploadTalentResume(Talent $talent, $file): Resume {
        $extension = $file->getClientOriginalExtension();
        $filePath = self::generateTalentPath($talent, TalentTypeFile::Resume, $extension);
        Storage::disk('local')->put( $filePath, file_get_contents($file).$extension);
        $resume = $talent->resumes()->create([ 
            'link'      => '/' . $filePath, 
            'talent_id' => $talent->id
        ]);
        return $resume;  
    }


    /**
     * Upload a contract file for talent
     * @param Talent $talent
     * @param File $file
     * @return Contract
     */
    public function uploadTalentContract($talent, $file) {
        $extension = $file->getClientOriginalExtension();
        $filePath = self::generateTalentPath($talent, TalentTypeFile::Contract, $extension);
        Storage::disk('local')->put( $filePath, file_get_contents($file).$extension);
        $contract = $talent->contracts()->create([ 
            'link'      => '/' . $filePath, 
            'talent_id' => $talent->id
        ]);
        return $contract;  
    }


    /** UTILITIES */

    /**
     * Generate a path for a talent file
     * /profiles/{talent_id}/{type}-{lastname}-{firstname}-{talent_id}-{timestamp}.{extension}
     * @param Talent $talent
     * @param TalentTypeFile $type
     * @param string $extension
     */
    private static function generateTalentPath($talent, TalentTypeFile $type, $extension = 'pdf') {
        $lastname = strtolower($talent->last);
        $firstname = strtolower($talent->first);
        $path = 'profiles/'.$talent->id;
        switch($type) {
            case TalentTypeFile::Resume :
                $fileName = 'cv-' . $lastname . '-' .  $firstname . '-'. time(); 
            break;
            case TalentTypeFile::Contract :
                $fileName = 'contrat-' . $lastname . '-' . $firstname .'-'. time(); 
            break;
            defaut:
                $fileName = $lastname .  $firstname . '-' . $talent->id .'-'. time(); 
        }
        return $path.'/'.$fileName. '.' .$extension;
    }


    private static function generateJobDocumentPath($job, $extension = 'pdf') {
        $lastname = strtolower($talent->last);
        $firstname = strtolower($talent->first);
        $path = 'jobs/'.$job->id;
        $fileName = $job->title . '-' . time(); 
        return $path.'/'.$fileName. '.' .$extension;
    }
  
}
