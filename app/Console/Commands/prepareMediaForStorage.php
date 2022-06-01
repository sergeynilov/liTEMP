<?php

namespace App\Console\Commands;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class prepareMediaForStorage extends Command
{
    // php artisan  command:prepareMediaForStorage
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:prepareMediaForStorage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fd = fopen('media_git.txt', "a+");


        $currencies = Photo
            ::orderBy('id', 'asc')
            ->get();
        foreach ($currencies as $nextPhoto) {
            foreach ($nextPhoto->getMedia('photo') as $mediaImage) {
                if (File::exists($mediaImage->getPath())) {
                    fwrite($fd,
                        ' git add -f    storage/app/public/Photos/' . $mediaImage->id . '/' . $mediaImage->file_name . chr(13));
                } else {
                    echo 'File ' . $mediaImage->getPath() . " skipped \r\n";
                }
            }
        }


        $users = User
            ::orderBy('id', 'asc')
            ->get();
        foreach ($users as $nextUser) {
            foreach ($nextUser->getMedia('photo') as $mediaImage) {
                if (File::exists($mediaImage->getPath())) {
                    fwrite($fd,
                        ' git add -f    storage/app/public/Photos/' . $mediaImage->id . '/' . $mediaImage->file_name . chr(13));
                } else {
                    echo 'File ' . $mediaImage->getPath() . " skipped \r\n";
                }
            }
        }



        fclose($fd);

        return 0;
    }
}

