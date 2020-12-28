#How to upload Multiple Image in laravel 8

###Step 1: Install Composer in your system

###Step 2: Download laravel using composer package

`composer create-project --prefer-dist laravel/laravel multipleimageupload`

###Step 3: Configure your database in .env file

`DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=multipleImage
DB_USERNAME=root
DB_PASSWORD=`

###Step:4 Now, run command for creating model and migration

`php artisan make:model file -m`

###Update your migration field for inserting image path== database/migrations/2020_12_28_060509_create_files_table.php

`public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('filenames');
            $table->timestamps();
        });
    }`
	
###Now, run migrate command.

`php artisan migrate`

###Step 5: Now, update your file model which is present inside of app/models/file.php

`<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'filenames'
    ];
  
    public function setFilenamesAttribute($value)
    {
        $this->attributes['filenames'] = json_encode($value);
    }
}`

###Step 6: Here, we will upload web.php.

`Route::get('/image', [App\Http\Controllers\FileController::class, 'create']);
Route::post('/image', [App\Http\Controllers\FileController::class, 'store']);`

###Step 7: Now Create controller and update code.

`php artisan make:controller FileController`

###Update method in controller

`<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\File;
  
class FileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('imageUpload');
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'filenames' => 'required',
                'filenames.*' => 'image'
        ]);
  
        $files = [];
        if($request->hasfile('filenames'))
         {
            foreach($request->file('filenames') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('files'), $name);  
                $files[] = $name;  
            }
         }
  
         $file= new File();
         $file->filenames = $files;
         $file->save();
  
        return back()->with('success', 'Your images has been successfully added');
    }
}`

###Step 8: Create imageUpload.blade inside of resources/views/imageUpload.blade.php and put code inside of imageUpload.blade.php

`<html lang="en">
<head>
  <title>Laravel 8 Multiple Image Upload Real Programmer</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
  <div class="jumbotron text-center" style="margin-bottom:0">
  <h2>Laravel 8 Multiple Image Upload Real Programmer</h2>
</div>
<br>
<div class="container">
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Sorry!</strong> Here have some issue please check<br><br>
    <ul>
      @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
      @endforeach
    </ul>
</div>
@endif
  
@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div> 
@endif
  
 
<form method="post" action="{{url('image')}}" enctype="multipart/form-data">
    @csrf
  
    <div class="input-group realprocode control-group lst increment" >
      <input type="file" name="filenames[]" class="myfrm form-control">
      <div class="input-group-btn"> 
        <button class="btn btn-success" type="button"> <i class="fldemo glyphicon glyphicon-plus"></i>Add</button>
      </div>
    </div>
    <div class="clone hide">
      <div class="realprocode control-group lst input-group" style="margin-top:10px">
        <input type="file" name="filenames[]" class="myfrm form-control">
        <div class="input-group-btn"> 
          <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
        </div>
      </div>
    </div>
  
    <button type="submit" class="btn btn-success" style="margin-top:10px">Submit</button>
  
</form>        
</div>
  
<script type="text/javascript">
    $(document).ready(function() {
      $(".btn-success").click(function(){ 
          var lsthmtl = $(".clone").html();
          $(".increment").after(lsthmtl);
      });
      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".realprocode").remove();
      });
    });
</script>
</body>
</html>`

###Step 9: Now run server

`php artisan serve`

`http://127.0.0.1:8000/image`

