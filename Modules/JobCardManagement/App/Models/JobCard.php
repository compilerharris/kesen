<?php

namespace Modules\JobCardManagement\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\JobCardManagement\Database\factories\JobCardFactory;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\WriterManagement\App\Models\Writer;

class JobCard extends Model
{
    use HasFactory,HasUuids;

    protected $guarded = [
        'id'
    ];

    public function estimateDetail()
    {
        return $this->belongsTo(EstimatesDetails::class, 'estimate_detail_id', 'id');
    }

    public function tWriter()
    {
        return $this->belongsTo(Writer::class, 't_writer_code', 'id');
    }

    public function btWriter()
    {
        return $this->belongsTo(Writer::class, 'bt_writer_code', 'id');
    }

    public function jobRegister()
    {
        return $this->belongsTo(JobRegister::class, 'job_no', 'sr_no');
    }

}
