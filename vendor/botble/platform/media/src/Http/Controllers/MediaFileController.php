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
            try{
                $file=$request->file('file');
                $file=$file[0];
                $disk = Storage::disk('gcs');

                // Upload the file contents to the specified location in the GCS bucket
                $disk->put('/' . $file->getClientOriginalName(), file_get_contents($file));
        
                // Check if the file exists in the GCS bucket
                $exists = $disk->exists('/' . $file->getClientOriginalName());
        
                // Get the last modified time of the file in the GCS bucket
                $time = $disk->lastModified('/' . $file->getClientOriginalName());
        
                // Get the URL of the file in the GCS bucket
                $url = $disk->url('/' . $file->getClientOriginalName());
        
                // Set the visibility of the file in the GCS bucket to public
                $disk->setVisibility('/' . $file->getClientOriginalName(), 'public');
        
                // Generate a temporary URL for the file in the GCS bucket (valid for 30 minutes)
                $temporaryUrl = $disk->temporaryUrl('/' . $file->getClientOriginalName(), now()->addMinutes(60));
                dd($temporaryUrl);

            }catch(Exception $e){
                dd($e);
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
