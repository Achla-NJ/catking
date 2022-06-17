<?php

namespace App\Models;

use App\Traits\ExtraFeaturesOfModel;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, ExtraFeaturesOfModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'old_id',
        'name',
        'email',
        'password',
        'mobile_number',
        'whatsapp_number',
        'is_catking_student',
        'dob',
        'address',
        'city',
        'state',
        'avatar',
        'role',
        'msg_title',
        'msg_description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'exams_score',
        'exams_percentile',
    ];

    public const DEFAULT_FILTERS = [
        'dream_college' => 'sp jain',
        'received_call_college' => 'sp jain',
        'converted_call_college' => 'sp jain',
        'sop_college' => 'sp jain',
    ];

    public const STUDY_CLASSES = [
        'matric'=>'10th Standard',
        'secondary'=>'12th Standard',
        'graduation'=>'Graduation',
        'post_graduation'=>'Post Graduation',
        'diploma'=>'Diploma',
        'other'=>'Other Certifications',
    ];

    public const FILES_PATH = "public/uploads/user-files";

    public function get_state(): HasOne
    {
        return $this->hasOne(State::class, 'id', 'state');
    }

    public function education():? HasMany
    {
        return $this->hasMany(StudentEducation::class);
    }

    public function dream_colleges():? HasMany
    {
        return $this->hasMany(StudentDreamCollege::class);
    }

    public function work():? HasMany
    {
        return $this->hasMany(StudentWork::class);
    }

    public function exams():? HasMany
    {
        return $this->hasMany(StudentExam::class);
    }

    public function sop_colleges():? HasMany
    {
        return $this->hasMany(StudentSopColleges::class);
    }

    public function converted_call_colleges():? HasMany
    {
        return $this->hasMany(StudentConvertedCallCollege::class);
    }

    public function received_call_colleges():? HasMany
    {
        return $this->hasMany(StudentReceivedCallCollege::class);
    }

    public function interview_dates():? HasMany
    {
        return $this->hasMany(StudentInterviewDate::class);
    }

    public function review():? HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function meta($key, $group, $relation = null, $value = 'not_set_1015316646')
    {
        $um = UserMeta::query()
            ->where('user_id', $this->id)
            ->orderBy('created_at', 'desc');

        if($key == 'get_all'){
            return $um->get();
        }

        if($value == 'not_set_1015316646'){
            try {
                $q = $um->where('key', $key)
                    ->orderBy('created_at', 'desc');
                if($relation){
                    $q = $q->where('relation', $relation);
                }
                return $q->where('group', $group)
                    ->get()->pluck('value');
            }catch (Exception $e){
                return null;
            }
        }

        $meta = new UserMeta;
        $meta->user_id = $this->id;
        $meta->relation = $relation;
        $meta->group = $group;
        $meta->key = $key;
        $meta->value = $value;
        $meta->save();
        return $value;
    }

/*    public function getDreamCollegesAttribute()
    {
        $colleges = $this->meta('college', 'dream_college')->toArray();
        $colleges = array_map('trim', array_map('strip_tags', $colleges));
        return array_filter($colleges);
    }

    public function getReceivedCallCollegesAttribute()
    {
        $colleges = $this->meta('college', 'received_call')->toArray();
        $colleges = array_map('trim', array_map('strip_tags', $colleges));
        return array_filter($colleges);
    }

    public function getConvertedCallCollegesAttribute()
    {
        $colleges = $this->meta('college', 'converted_call')->toArray();
        $colleges = array_map('trim', array_map('strip_tags', $colleges));
        return array_filter($colleges);
    }*/

    public function getAvatarAttribute($value)
    {
        if(!$value){
            return asset('assets/images/avatars/user.png');
        }
        if(file_exists(storage_path("app".DIRECTORY_SEPARATOR.self::FILES_PATH.DIRECTORY_SEPARATOR.$value))){
            return asset('storage/uploads/user-files/'.$value);
            // return route("user-files", str_replace('files/profile/','',$value));
        }
        return "https://profile.catking.in/lib/$value";
    }

    /*public function getSopCollegesAttribute()
    {
        $colleges = $this->meta('college', 'sop')->toArray();
        $colleges = array_map('trim', array_map('strip_tags', $colleges));
        return array_filter($colleges);
    }*/

    public function getExamsScoreAttribute()
    {
        $exams = $this->exams;
        if(count($exams) > 0){
            $scores = [];
            foreach ($exams as $exam) {
                $scores[$exam->type] = $exam->score;
            }
            return $scores;
        }
        return [];
    }

    public function getExamsPercentileAttribute()
    {
        $exams = $this->exams;
        if(count($exams) > 0){
            $scores = [];
            foreach ($exams as $exam) {
                $scores[$exam->type] = $exam->percentile;
            }
            return $scores;
        }
        return [];
    }
}
