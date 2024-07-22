<?php

namespace Modules\JobCardManagement\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\JobCardManagement\Database\factories\JobCardFactory;
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

}
