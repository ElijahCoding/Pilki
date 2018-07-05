<?php

namespace App\Jobs;

use App\Models\Contracts\IImageable;
use App\Models\Image;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DownloadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
    protected $disk;
    protected $url;

    public $allowed = [
        'image/jpeg' => '.jpg',
        'image/png'  => '.png',
    ];

    /**
     * Create a new job instance.
     */
    public function __construct(IImageable $model, $disk, $url)
    {
        $this->onQueue('download');

        $this->model = $model;
        $this->disk = $disk;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();
        $response = $client->get($this->url);

        $mime = $response->getHeader('Content-Type')[0];

        if (!isset($this->allowed[$mime])) {
            return;
        }

        $filename = md5(uniqid());

        $fullPath = substr($filename, 0, 1) . '/' . substr($filename, 1, 2) . '/' . $filename . $this->allowed[$mime];


        if (\Storage::disk($this->disk)->put($fullPath, $response->getBody()->getContents())) {
            $this->model->images()->save(new Image([
                'disk'     => $this->disk,
                'filename' => $fullPath,
            ]));
        }
    }

}
