<?php

namespace Botble\Media\Http\Controllers;

use Botble\Media\Chunks\Exceptions\UploadMissingFileException;
use Botble\Media\Chunks\Handler\DropZoneUploadHandler;
use Botble\Media\Chunks\Receiver\FileReceiver;
use Botble\Media\Facades\RvMedia;
use Botble\Media\Repositories\Interfaces\MediaFileInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Botble\Media\Models\MediaFile;

/**
 * @since 19/08/2015 07:50 AM
 */
class MediaFileController extends Controller
{
    public function __construct(protected MediaFileInterface $fileRepository)
    {
    }

    public function postUpload(Request $request)
    {
        // if (! RvMedia::isChunkUploadEnabled()) {
            try {
                $file = $request->file('file')[0]; // Assuming you're sure about this structure.
                $disk = Storage::disk('gcs');
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $uniqueNameWoExtension=uniqid() . '_' . time();
                $uniqueName = $uniqueNameWoExtension . '.' . $extension; // Example: 5f586bf65e5bb_1601374123.jpg
            
                // Upload the file to the GCS bucket with the new unique name
                $filePath = $uniqueName;            
                // Upload the file to the GCS bucket
                $disk->put($filePath, file_get_contents($file));
            
                // Immediately check if the file exists to confirm upload success
                if (!$disk->exists($filePath)) {
                    return response()->json(['error' => 'File upload failed or file does not exist in GCS.'], 500);
                }
            
                // If the file exists, proceed with the rest of the operations
                $time = $disk->lastModified($filePath);
                $url = $disk->url($filePath);
                $disk->setVisibility($filePath, 'public');
                if($url){
                    $this->saveFileMetadata($file,$filePath,$url);
                    $croppedUrl = $this->cropUploadAndSave($file,$uniqueNameWoExtension,$extension,150, 150);
                    $croppedUrl2 = $this->cropUploadAndSave($file,$uniqueNameWoExtension,$extension,540, 360);
                }
                // Success response
                return response()->json([
                    'message' => 'File uploaded and processed successfully.',
                    'url' => $url,
                    'lastModified' => $time
                ]);
            
            } catch (\Exception $e) {
                // Return a JSON response with the error
                return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
            }
        
            // $result = RvMedia::handleUpload(Arr::first($request->file('file')), $request->input('folder_id', 0));


            // return $this->handleUploadResponse($result);
        // }

        try {
            // Create the file receiver
            $receiver = new FileReceiver('file', $request, DropZoneUploadHandler::class);
            // Check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }
            // Receive the file
            $save = $receiver->receive();
            // Check if the upload has finished (in chunk mode it will send smaller files)
            if ($save->isFinished()) {
                $result = RvMedia::handleUpload($save->getFile(), $request->input('folder_id', 0));

                return $this->handleUploadResponse($result);
            }
            // We are in chunk mode, lets send the current progress
            $handler = $save->handler();

            return response()->json([
                'done' => $handler->getPercentageDone(),
                'status' => true,
            ]);
        } catch (Exception $exception) {
            return RvMedia::responseError($exception->getMessage());
        }
    }


    protected function saveFileMetadata($file, $uniqueName, $url)
    {
        $mimeType = $file->getClientMimeType();
        $fileSize = $file->getSize();
        // You might get $folderId and $userId from the request, session, or another part of your application
        $altText = ''; // Set this based on your application's logic or user input

        $mediaFile = new MediaFile([
            'name' => $uniqueName,
            'alt' => $uniqueName,
            'mime_type' => $mimeType,
            'size' => $fileSize,
            'url' => $url,
            'options' => json_encode([]), // Assuming you're using this field for additional metadata
            'folder_id' => 0,
            'user_id' => 2,
        ]);

        $mediaFile->save();
    }

    protected function cropUploadAndSave($file,$fileName,$extension, $width, $height, $folderId = 0, $userId = 2)
{
    $disk = Storage::disk('gcs');
    $extension = $file->getClientOriginalExtension();
    $croppedName = $fileName.'-'.$width.'x'.$height. '.' . $extension;

    // Crop the image
    $croppedImage = \Image::make($file)->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });

    // Prepare the cropped image for uploading
    $tempPath = sys_get_temp_dir() . '/' . $croppedName;
    $croppedImage->save($tempPath);

    // Upload the cropped image
    $disk->put($croppedName, fopen($tempPath, 'r+'));

    // After uploading, get the URL of the cropped image
    $url = $disk->url($croppedName);

    // Clean up the local temporary file
    @unlink($tempPath);


    // Return the URL or any other relevant information
    return $url;
}



    protected function handleUploadResponse(array $result): JsonResponse
    {
        if (! $result['error']) {
            return RvMedia::responseSuccess([
                'id' => $result['data']->id,
                'src' => RvMedia::url($result['data']->url),
            ]);
        }

        return RvMedia::responseError($result['message']);
    }

    public function postUploadFromEditor(Request $request)
    {
        return RvMedia::uploadFromEditor($request);
    }

    public function postDownloadUrl(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return RvMedia::responseError($validator->messages()->first());
        }

        $result = RvMedia::uploadFromUrl($request->input('url'), $request->input('folderId'));

        if (! $result['error']) {
            return RvMedia::responseSuccess([
                'id' => $result['data']->id,
                'src' => Storage::url($result['data']->url),
                'url' => $result['data']->url,
                'message' => trans('core/media::media.javascript.message.success_header'),
            ]);
        }

        return RvMedia::responseError($result['message']);
    }
}
