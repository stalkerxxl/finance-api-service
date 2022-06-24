<?php

namespace App\Jobs;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CompanyLogoDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $ticker;
    private string $logo_api_url;
    private Company $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->ticker = $company->ticker;
        $this->logo_api_url = $company->logo_api_url;
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        //FIXME добавить try-catch
        $file = pathinfo($this->logo_api_url);
        $image = file_get_contents($this->logo_api_url);
        $name = $this->ticker.'.'.$file['extension'];
        Storage::disk('public')->put('company-logo/'.$name, $image);

        //$company = Company::query()->firstOrFail(['ticker' => $this->ticker]);
        $this->company->logo = $name;
        $this->company->save();


    }
}
