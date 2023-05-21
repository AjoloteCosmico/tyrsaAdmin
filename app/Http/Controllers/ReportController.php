<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalOrder;

use App\Models\Equipo;
use App\Models\payments;
use App\Models\Customer;
use App\Models\CompanyProfile;
use App\Http\Requests\StorepaymentsRequest;
use App\Http\Requests\UpdatepaymentsRequest;

use SplFileInfo;
use Illuminate\Support\Facades\Storage;
use DB;
use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 
use Illuminate\Support\Facades\Auth;
class ReportController extends Controller
{
    public function contraportada_pdf($id){

    }

}
