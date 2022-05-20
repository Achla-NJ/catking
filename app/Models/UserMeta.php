<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use HasFactory;

    protected $table = 'user_meta';

    protected $fillable = ['user_id','key','value','relation','sort','group'];

    public const EDUCATION_KEYS = [
        'board','school','marks','cgpa','passing_year','board_name','sort','class_type','user_id','class_name'
    ];

    public const EDUCATION_BOARD_TYPES = [
        'matric' => [
            'icse-isc' => 'ICSE/ISC',
            'cbse' => 'CBSE',
            'state-board' => 'State Board',
            'other' => 'Other',
        ],
        'secondary' => [
            'icse-isc' => 'ICSE/ISC',
            'cbse' => 'CBSE',
            'state-board' => 'State Board',
            'other' => 'Other',
        ],
        'graduation' => [
            'bcom' => 'BCOM',
            'bca' => 'BCA',
            'btech' => 'BTECH',
            'bba' => 'BBA',
            'bsc' => 'BSC',
            'other' => 'Other',
        ],
        'post_graduation' => [
            'mcom' => 'MCOM',
            'mca' => 'MCA',
            'ma' => 'MTECH',
            'mba' => 'MBA',
            'mtech' => 'MTECH',
            'other' => 'Other',
        ],
        'diploma' => [
        ],
        'other' => [
            'ca/cs/cfa' => 'CA/CS/CFA',
            'actuaries' => 'Actuaries',
            'engage7x' => 'Engage7x',
            'other' => 'Other certifications',
        ],
    ];

    public static function getEducationStaticFields()
    {
        return json_decode(json_encode([
            // key == relation
            1 => [
                ['key' => 'class_type', 'value' => 'matric'],
                ['key' => 'school', 'value' => ''],
                ['key' => 'marks', 'value' => ''],
                ['key' => 'cgpa', 'value' => ''],
                ['key' => 'passing_year', 'value' => ''],
                ['key' => 'board_name', 'value' => ''],
                ['key' => 'board', 'value' => ''],
                ['key' => 'class_name', 'value' => ''],
                ['key' => 'start_date', 'value' => ''],
            ],
             2 => [
                (['key' => 'class_type', 'value' => 'secondary']),
                (['key' => 'school', 'value' => '']),
                (['key' => 'marks', 'value' => '']),
                (['key' => 'cgpa', 'value' => '']),
                (['key' => 'passing_year', 'value' => '']),
                (['key' => 'board_name', 'value' => '']),
                (['key' => 'board', 'value' => '']),
                (['key' => 'class_name', 'value' => '']),
                (['key' => 'start_date', 'value' => '']),
            ],
            3 => [
                (['key' => 'class_type', 'value' => 'graduation']),
                (['key' => 'school', 'value' => '']),
                (['key' => 'marks', 'value' => '']),
                (['key' => 'cgpa', 'value' => '']),
                (['key' => 'passing_year', 'value' => '']),
                (['key' => 'board_name', 'value' => '']),
                (['key' => 'board', 'value' => '']),
                (['key' => 'class_name', 'value' => '']),
                (['key' => 'start_date', 'value' => '']),
            ]
        ]));
    }

    public static function getWorkStaticFields()
    {
        return json_decode(json_encode([
            // key == relation
            1 => [
                ['key' => 'work_for', 'value' => ''],
                ['key' => 'company_name', 'value' => ''],
                ['key' => 'designation', 'value' => ''],
                ['key' => 'start_date', 'value' => ''],
                ['key' => 'end_date', 'value' => ''],
                ['key' => 'responsibilities', 'value' => ''],
                ['key' => 'working_presently', 'value' => ''],
            ],
        ]));
    }

    public static function getCurricularStaticFields()
    {
        return json_decode(json_encode([
            'co' => [],
            'extra' => [],
            'other' => [],
        ]));
    }

    public const CURRICULAR = [
        'co' => 'Co-Curricular Details',
        'extra' => 'Extra Curricular Details',
        'other' => 'Other relevant detailss',
    ];


    public static function getExamStaticFields()
    {
        return json_decode(json_encode([
            // key == relation
            1 => [
                ['key' => 'exam_type', 'value' => 'CAT'],
                ['key' => 'took_exam', 'value' => ''],
                ['key' => 'score', 'value' => ''],
                ['key' => 'percentile', 'value' => ''],
                ['key' => 'score_card', 'value' => ''],
            ],
        ]));
    }

    public static function getDreamCollegeStaticFields()
    {
        return json_decode(json_encode([
            // key == relation
            1 => [
                ['key' => 'dream_college', 'value' => ''],
            ],
        ]));
    }

    public static function getReceivedCallStaticFields()
    {
        return json_decode(json_encode([
            // key == relation
            1 => [
                ['key' => 'received_call', 'value' => ''],
            ],
        ]));
    }

}
