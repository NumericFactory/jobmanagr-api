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
        $path = 'jobs/'.$job->id;
        $originalName = self::replaceSpaceWithHyphen($job->title . '-' . $file->getClientOriginalName());
        $extension = $file->getClientOriginalExtension();
        $filePath =  $path .'/'. $originalName;
        Storage::disk('local')->put( $filePath, file_get_contents($file).$extension);
        $document = $job->documents()->create([ 
            'file_name' => $originalName,
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
        $fileName = self::generateTalentDocumentPathAndFilename($talent, TalentTypeFile::Resume, $extension)['file_name'];
        $filePath = self::generateTalentDocumentPathAndFilename($talent, TalentTypeFile::Resume, $extension)['path'];
        Storage::disk('local')->put( $filePath, file_get_contents($file).$extension);
        $resume = $talent->resumes()->create([ 
            'file_name' => $fileName,
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
        $fileName = self::generateTalentDocumentPathAndFilename($talent, TalentTypeFile::Contract, $extension)['file_name'];
        $filePath = self::generateTalentDocumentPathAndFilename($talent, TalentTypeFile::Contract, $extension)['path'];
        Storage::disk('local')->put( $filePath, file_get_contents($file).$extension);
        $contract = $talent->contracts()->create([ 
            'file_name' => $fileName,
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
    private static function generateTalentDocumentPathAndFilename($talent, TalentTypeFile $type, $extension = 'pdf') {
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
        return [
            'path' => $path.'/'.$fileName. '.' .$extension,
            'file_name' => $fileName. '.' .$extension
        ];
    }


    /**
     * replace space char by "-" and return toLowerCase
     * if space char is preceed or followed by "-" or "_", juste delete space char
     * usage replaceSpaceWithHyphen('hello world - this_is a test')
     * output : hello-world-this_is-a-test
     */
    function replaceSpaceWithHyphen($string) {
        // Use regex to match the conditions
        $result = preg_replace('/(?<=[-_])\s+|\s+(?=[-_])/', '', $string);
        
        // Replace remaining spaces with hyphen
        $result = str_replace(' ', '-', $result);
        
        return strtolower($result);
    }


  
}
