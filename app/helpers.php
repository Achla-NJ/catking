<?php 

function getStudentResult($url) {
    $data = fetchMarks($url);
    $sections_marks = [];
    $obtain_marks = 0;
    $total_marks = 0;
    foreach (@$data['sections'] as $section) {
        $attempt_questions = 0;
        $correct_answers = 0;
        $wrong_answers = 0;
        $_total_marks = 0;
        $_obtain_marks = 0;
        foreach ($section['questions'] as $question) {
            $_total_marks += 3;
            if(@$question['attempted']){
                $attempt_questions++;
                if(@$question['answered_correctly']){
                    $correct_answers++;
                    $_obtain_marks += 3;
                }else{
                    $wrong_answers++;
                    if(@$question['type'] == 'mcq'){
                        $_obtain_marks -= 1;
                    }
                }
            }
        }
        //$_obtain_marks = $_obtain_marks > 0 ? $_obtain_marks: 0;
        $sections_marks[] = [
            'name' => @$section['name'],
            'total_questions' => count(@$section['questions']),
            'attempt_questions' => $attempt_questions,
            'correct_answers' => $correct_answers,
            'wrong_answers' => $wrong_answers,
            'obtain_marks' => $_obtain_marks,
            'total_marks' => $_total_marks,
        ];
        $obtain_marks += $_obtain_marks;
        $total_marks += $_total_marks;
    }
    $percentile = @getScorePercentile($obtain_marks, @$data['details']['Shift']);

    return [
        //'data' => $data,
        'percentile' => $percentile,
        'details' => @$data['details'],
        'sections_marks' => $sections_marks,
        'obtain_marks' => $obtain_marks,
        'total_marks' => $total_marks,
    ];
}

function fetchMarks($url) {
    include_once('simple_html_dom.php');
    //$url = "http://catking.local/data.html"; // TODO: remove this line
    $html = file_get_html($url);

    // Get student info (START)
    $student_info = [];
    foreach ($html->find('div.main-info-pnl table tr') as $tr) {
        $tds = $tr->find('td');
        $student_info[_t($tds[0]->plaintext, ':')] = _t($tds[1]->plaintext);
    }
    // Get student info (END)

    $sections_result = [];
    $sections = $html->find('div.grp-cntnr div.section-cntnr');

    foreach ($sections as $section){
        $questions_result = [];
        foreach ($section->find('div.question-pnl') as $question){
            $questions_result[] = parseQuestion($question);
        }
        $section_result = [
            'name' => _t(str_replace('Section : ', '', _t($section->find('div.section-lbl', 0)->plaintext))),
            'questions' => $questions_result,
        ];
        $sections_result[] = $section_result;
    }

    return ['details' => $student_info, 'sections' => $sections_result];
}

function parseQuestion($question) {
    $texts = [];
    foreach ($question->find('td') as $tk => $td){
        $texts[$tk] =_t($td->plaintext);
    }
    $rtexts = array_reverse($texts);
    if(in_array('mcq', [strtolower(@$texts[13]), strtolower(@$texts[21]), strtolower(@$rtexts[6])])){
        return parseMCQ_Question($question);
    }elseif(in_array('sa', [strtolower(@$rtexts[4])])){
        return parseSA_Question($question);
    }else{
        // return $texts;
    }
}

function parseMCQ_Question($question) {
    $texts = [];
    $correct_option = 0;
    $correct_option_index = 0;
    foreach ($question->find('td') as $tk => $td){
        $texts[$tk] = _t($td->plaintext);
        if($td->hasClass('rightAns')){
            $correct_option_index = $tk;
        }
    }
    $rev_correct_option_index = (count($texts) - $correct_option_index) - 1;
    /**
     * Check MSQ question sub type is 'Comprehension passage'
     */
    if(strpos(strtolower(@$texts[2]), 'comprehension') !== false){
        switch ($rev_correct_option_index){
            case 14: $correct_option = 1; break;
            case 12: $correct_option = 2; break;
            case 10: $correct_option = 3; break;
            case 8: $correct_option = 4; break;
        }
        $rtexts = array_reverse($texts);
        return [
            'passage_title' => @$texts[2],
            'passage' => @$texts[4],
            'parse_as' => 'mcq',
            'sub_type' => 'comprehension',
            'type' => strtolower(@$rtexts[6]), // MCQ
            'id' => @$rtexts[4],
            'number' => @$rtexts[18],
            'name' => @$rtexts[17],
            'options' => [
                1 => @$rtexts[14],
                2 => @$rtexts[12],
                3 => @$rtexts[10],
                4 => @$rtexts[8],
            ],
            'attempted' => isQuestionAttempted(@$rtexts[2]),
            'correct_option' => $correct_option,
            'selected_option' => @$rtexts[0],
            'answered_correctly' => $correct_option == @$rtexts[0],
        ];
    }
    else{
        switch ($correct_option_index){
            case 13: case 5: $correct_option = 1; break;
            case 15: case 7: $correct_option = 2; break;
            case 17: case 9: $correct_option = 3; break;
            case 19: case 11: $correct_option = 4; break;
        }
        return [
            'parse_as' => 'mcq',
            'sub_type' => 'alternate',
            'type' => strtolower(@$texts[13]), // MCQ
            'id' => @$texts[15],
            'number' => @$texts[1],
            'name' => @$texts[2],
            'options' => [
                1 => @$texts[5],
                2 => @$texts[7],
                3 => @$texts[9],
                4 => @$texts[11],
            ],
            'attempted' => isQuestionAttempted(@$texts[17]),
            'correct_option' => $correct_option,
            'selected_option' => @$texts[19],
            'answered_correctly' => $correct_option == @$texts[19],
        ];
    }
}

function parseSA_Question($question) {
    $texts = [];
    foreach ($question->find('td') as $tk => $td){
        $texts[$tk] = _t($td->plaintext);
    }
    /**
     * Check SA question sub type is 'Comprehension passage'
     */
    if(strpos(strtolower(@$texts[2]), 'comprehension') !== false) {
        $rtexts = array_reverse($texts);
        $correct_answer = _t(str_replace('possible answer:', '', strtolower(@$rtexts[8])));
        return [
            'passage_title' => @$texts[2],
            'passage' => @$texts[4],
            'parse_as' => 'sa',
            'sub_type' => 'comprehension',
            'type' => strtolower(@$rtexts[4]), // SA
            'cs' => _t(str_replace('case sensitivity:', '', strtolower(@$rtexts[12]))),
            'id' => @$rtexts[2],
            'number' => @$rtexts[16],
            'name' => @$rtexts[15],
            'attempted' => isQuestionAttempted(@$rtexts[0]),
            'correct_answer' => $correct_answer,
            'given_answer' => @$rtexts[6],
            'answered_correctly' => $correct_answer == @$rtexts[6],
        ];
    }
    else {
        $correct_answer = _t(str_replace('possible answer:', '', strtolower(@$texts[9])));
        return [
            'parse_as' => 'sa',
            'sub_type' => 'jumbled',
            'type' => strtolower(@$texts[13]), // SA
            'cs' => _t(str_replace('case sensitivity:', '', strtolower(@$texts[5]))),
            'id' => @$texts[15],
            'number' => @$texts[1],
            'name' => @$texts[2],
            'attempted' => isQuestionAttempted(@$texts[17]),
            'correct_answer' => $correct_answer,
            'given_answer' => @$texts[11],
            'answered_correctly' => $correct_answer == @$texts[11],
        ];
    }
}
function isQuestionAttempted($status){
    $status = _t(strtolower($status));
    return in_array($status,["answered", "marked for review"]);
}
function getScorePercentile($score, $shift){
    $pp = "0%tile - 10%tile";
    if ($shift == 1 || $shift == 2) {
        if (/*$score <= 198 && */ $score>= 120) {
            $pp = "99.8%tile - 100%tile";
        } else if ($score <= 119 && $score>= 116) {
            $pp = "99.6%tile - 99.8%tile";
        } else if ($score <= 115 && $score>= 110) {
            $pp = "99.4%tile - 99.6%tile";
        } else if ($score <= 109 && $score>= 105) {
            $pp = "99.2%tile - 99.4%tile";
        } else if ($score <= 104 && $score>= 100) {
            $pp = "99%tile - 99.2%tile";
        } else if ($score <= 99 && $score>= 95) {
            $pp = "98.5%tile - 99%tile";
        } else if ($score <= 94 && $score>= 90) {
            $pp = "98%tile - 98.5%tile";
        } else if ($score <= 89 && $score>= 85) {
            $pp = "97%tile - 98%tile";
        } else if ($score <= 84 && $score>= 80) {
            $pp = "96%tile - 97%tile";
        } else if ($score <= 79 && $score>= 73) {
            $pp = "95%tile - 96%tile";
        } else if ($score <= 72 && $score>= 65) {
            $pp = "92%tile - 95%tile";
        } else if ($score <= 65 && $score>= 60) {
            $pp = "89%tile - 92%tile";
        } else if ($score <= 60 && $score>= 55) {
            $pp = "85%tile - 89%tile";
        } else if ($score <= 54 && $score>= 50) {
            $pp = "80%tile - 85%tile";
        } else if ($score <= 49 && $score>= 44) {
            $pp = "76%tile - 80%tile";
        } else if ($score <= 43 && $score>= 40) {
            $pp = "70%tile - 76%tile";
        } else if ($score <= 39 && $score>= 35) {
            $pp = "65%tile - 70%tile";
        } else if ($score <= 34 && $score>= 30) {
            $pp = "60%tile - 65%tile";
        } else if ($score <= 29 && $score>= 25) {
            $pp = "55%tile - 60%tile";
        } else if ($score <= 24 && $score>= 20) {
            $pp = "50%tile - 55%tile";
        } else if ($score <= 19 && $score>= 15) {
            $pp = "45%tile - 50%tile";
        } else if ($score <= 14 && $score>= 10) {
            $pp = "35%tile - 45%tile";
        } else if ($score <= 9 && $score>= 5) {
            $pp = "25%tile - 35%tile";
        } else if ($score <= 4 && $score>= 2) {
            $pp = "15%tile - 25%tile";
        } else if ($score <= 2 && $score>= 0) {
            $pp = "10%tile - 15%tile";
        } else if ($score < 0) {
            $pp = "0%tile - 10%tile";
        }
    }
    else if ($shift == 3) {
        if (/*$score <= 198 && */ $score>= 118) {
            $pp = "99.8%tile - 100%tile";
        } else if ($score <= 117 && $score>= 114) {
            $pp = "99.6%tile - 99.8%tile";
        } else if ($score <= 113 && $score>= 108) {
            $pp = "99.4%tile - 99.6%tile";
        } else if ($score <= 107 && $score>= 103) {
            $pp = "99.2%tile - 99.4%tile";
        } else if ($score <= 102 && $score>= 98) {
            $pp = "99%tile - 99.2%tile";
        } else if ($score <= 97 && $score>= 93) {
            $pp = "98.5%tile - 99%tile";
        } else if ($score <= 92 && $score>= 88) {
            $pp = "98%tile - 98.5%tile";
        } else if ($score <= 87 && $score>= 83) {
            $pp = "97%tile - 98%tile";
        } else if ($score <= 82 && $score>= 78) {
            $pp = "96%tile - 97%tile";
        } else if ($score <= 77 && $score>= 72) {
            $pp = "95%tile - 96%tile";
        } else if ($score <= 71 && $score>= 64) {
            $pp = "92%tile - 95%tile";
        } else if ($score <= 64 && $score>= 59) {
            $pp = "89%tile - 92%tile";
        } else if ($score <= 59 && $score>= 54) {
            $pp = "85%tile - 89%tile";
        } else if ($score <= 53 && $score>= 49) {
            $pp = "80%tile - 85%tile";
        } else if ($score <= 48 && $score>= 43) {
            $pp = "76%tile - 80%tile";
        } else if ($score <= 42 && $score>= 39) {
            $pp = "70%tile - 76%tile";
        } else if ($score <= 38 && $score>= 34) {
            $pp = "65%tile - 70%tile";
        } else if ($score <= 33 && $score>= 29) {
            $pp = "60%tile - 65%tile";
        } else if ($score <= 28 && $score>= 25) {
            $pp = "55%tile - 60%tile";
        } else if ($score <= 24 && $score>= 20) {
            $pp = "50%tile - 55%tile";
        } else if ($score <= 19 && $score>= 15) {
            $pp = "45%tile - 50%tile";
        } else if ($score <= 14 && $score>= 10) {
            $pp = "35%tile - 45%tile";
        } else if ($score <= 9 && $score>= 5) {
            $pp = "25%tile - 35%tile";
        } else if ($score <= 4 && $score>= 2) {
            $pp = "15%tile - 25%tile";
        } else if ($score <= 2 && $score>= 0) {
            $pp = "10%tile - 15%tile";
        } else if ($score < 0) {
            $pp = "0%tile - 10%tile";
        }
    }
    return $pp;
}

function sendJson($data, $http_code = 200) {
    header('Content-type: application/json');
    http_response_code($http_code);
    echo json_encode($data);
    die;
}

function _t($str, $remove_extra = '', $remove_extra_by = '') {
    $str = str_replace('&nbsp;', ' ', $str);
    $str = str_replace($remove_extra, $remove_extra_by, $str);
    $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
    $str = html_entity_decode($str);
    $str = htmlspecialchars_decode($str);
    $str = strip_tags($str);
    return trim($str);
}


 function  xlirfetchMarks($url){
    
    include_once('simple_html_dom.php');
    //$url = "http://catking.local/data.html"; // TODO: remove this line
    $html = file_get_html($url);

    // Get student info (START)
    $student_info = [];
    foreach ($html->find('div.main-info-pnl table tr') as $tr) {
        $tds = $tr->find('td');
        $student_info[_t($tds[0]->plaintext, ':')] = _t($tds[1]->plaintext);
    }
    // Get student info (END)

    $sections_result = [];
    $sections = $html->find('div.grp-cntnr div.section-cntnr');

    foreach ($sections as $section){
        $name = _t(str_replace('Section : ', '', _t($section->find('div.section-lbl', 0)->plaintext)));
        if(strpos(strtolower($name), 'essay') === false) {
            $questions_result = [];
            foreach ($section->find('div.question-pnl') as $question) {
                $questions_result[] = parseQuestion($question);
            }
            $section_result = [
                'name' => $name,
                'questions' => $questions_result,
            ];
            $sections_result[] = $section_result;
        }
    }

    return ['details' => $student_info, 'sections' => $sections_result];

}

//xirl===============================//

function getDomainFromUrl($url){
    // regex can be replaced with parse_url
    preg_match("/^(https|http|ftp):\/\/(.*?)\//", "$url/" , $matches);
    $parts = explode(".", $matches[2]);
    $tld = array_pop($parts);
    $host = array_pop($parts);
    if ( strlen($tld) == 2 && strlen($host) <= 3 ) {
        $tld = "$host.$tld";
        $host = array_pop($parts);
    }
    return "$host.$tld";
    /*return array(
        'protocol' => $matches[1],
        'subdomain' => implode(".", $parts),
        'domain' => "$host.$tld",
        'host'=>$host,'tld'=>$tld
    );*/
}
function xatgetStudentResult($url) {
    $data = xatfetchMarks($url);
    //return $data;
    $sections_marks = [];
    $obtain_marks = 0;
    $total_marks = 0;
    $unattempted_questions = 0;
    $unattempted_negative_marks = 0;
    $gk_section_marks = 0;
    foreach (@$data['sections'] as $section) {
        $is_gk_section = strtoupper($section['name']) == 'GENERAL KNOWLEDGE';
        $attempt_questions = 0;
        $correct_answers = 0;
        $wrong_answers = 0;
        $_total_marks = 0;
        $_obtain_marks = 0;
        foreach ($section['questions'] as $question) {
            $_total_marks += 1;
            if(@$question['attempted']){
                $attempt_questions++;
                if(@$question['answered_correctly']){
                    $correct_answers++;
                    $_obtain_marks += 1;
                }else{
                    $wrong_answers++;
                    if(!$is_gk_section){
                        $_obtain_marks -= 0.25;
                    }
                }
            }else{
                if(!$is_gk_section){
                    $unattempted_questions++;
                    if($unattempted_questions > 8) {
                        $unattempted_negative_marks += 0.1;
                    }
                }
            }
        }
        $sections_marks[] = [
            'name' => @$section['name'],
            'total_questions' => count(@$section['questions']),
            'attempt_questions' => $attempt_questions,
            'correct_answers' => $correct_answers,
            'wrong_answers' => $wrong_answers,
            'obtain_marks' => $_obtain_marks,
            'total_marks' => $_total_marks,
        ];
        $obtain_marks += $_obtain_marks;
        $total_marks += $_total_marks;
        if($is_gk_section) {
            $gk_section_marks = $_obtain_marks;
        }
    }

    $percentile = xatgetScorePercentile($obtain_marks - $gk_section_marks);

    return [
        //  'data' => $data,
        'percentile' => $percentile,
        'details' => @$data['details'],
        'sections_marks' => $sections_marks,
        'obtain_marks' => round($obtain_marks - $unattempted_negative_marks, 2),
        'total_marks' => $total_marks,
        'unattempted_questions' => $unattempted_questions,
        'unattempted_negative_marks' => $unattempted_negative_marks,
    ];
}

function xatfetchMarks($url) {
    include_once('simple_html_dom.php');
    //$url = "http://catking.local/data.html"; // TODO: remove this line
    $html = file_get_html($url);

    // Get student info (START)
    $student_info = [];
    foreach ($html->find('div.main-info-pnl table tr') as $tr) {
        $tds = $tr->find('td');
        $student_info[_t($tds[0]->plaintext, ':')] = _t($tds[1]->plaintext);
    }
    // Get student info (END)

    $sections_result = [];
    $sections = $html->find('div.grp-cntnr div.section-cntnr');

    foreach ($sections as $section){
        $name = _t(str_replace('Section : ', '', _t($section->find('div.section-lbl', 0)->plaintext)));
        if(strpos(strtolower($name), 'essay') === false) {
            $questions_result = [];
            foreach ($section->find('div.question-pnl') as $question) {
                $questions_result[] = xatparseQuestion($question);
            }
            $section_result = [
                'name' => $name,
                'questions' => $questions_result,
            ];
            $sections_result[] = $section_result;
        }
    }

    return ['details' => $student_info, 'sections' => $sections_result];
}

/**
 * @param simple_html_dom $question
 * @return array
 */
function xatparseQuestion($question){
    $texts = [];
    $options_as_images = false;
    $correct_option = "";
    $correct_option_index = 0;
    foreach ($question->find('td') as $tk => $td){
        $texts[$tk] = _t($td->plaintext);
        if($td->hasClass('rightAns')){
            $correct_option_index = $tk;
        }
        if($td->has_child()) {
            if(in_array(strtoupper($texts[$tk]), ["A.", "B.", "C.", "D.", "E.", "1.", "2.", "3.", "4.", "5."])){
                $images = $td->find('img');
                if(!empty($images)) {
                    $lastChild = end($images);
                    $texts[$tk] = $lastChild->getAttribute('name');
                    $options_as_images = true;
                }
            }
        }
    }
    $rev_correct_option_index = (count($texts) - $correct_option_index) - 1;

    /**
     * Check MSQ question subtype is 'Comprehension passage'
     */
    if(strpos(strtolower(@$texts[2]), 'comprehension') !== false){
        $rtexts = array_reverse($texts);
        switch ($rev_correct_option_index){
            case 14: $correct_option = "A"; break;
            case 12: $correct_option = "B"; break;
            case 10: $correct_option = "C"; break;
            case 8: $correct_option = "D"; break;
            case 6: $correct_option = "E"; break;
        }

        switch (@$rtexts[0]){
            case "1": $selected_option = "A"; break;
            case "2": $selected_option = "B"; break;
            case "3": $selected_option = "C"; break;
            case "4": $selected_option = "D"; break;
            case "5": $selected_option = "E"; break;
            default: $selected_option = @$rtexts[0]; break;
        }

        $options = [
            "A" => xat_ta("A.", xat_ta("1.", @$rtexts[14])),
            "B" => xat_ta("B.", xat_ta("2.", @$rtexts[12])),
            "C" => xat_ta("C.", xat_ta("3.", @$rtexts[10])),
            "D" => xat_ta("D.", xat_ta("4.", @$rtexts[8])),
            "E" => xat_ta("E.", xat_ta("5.", @$rtexts[6])),
        ];

        return [
            'passage_title' => @$texts[2],
            'passage' => @$texts[4],
            'sub_type' => 'comprehension',
            'type' => 'mcq', // MCQ
            'id' => @$rtexts[4],
            'number' => @$rtexts[18],
            'name' => @$rtexts[17],
            'options' => $options,
            'attempted' => isQuestionAttempted(@$rtexts[2]),
            'selected_option' => $selected_option,
            'selected_option_value' => @$options[@$rtexts[0]],
            'correct_option' => $correct_option,
            'correct_option_value' => $options[$correct_option],
            'options_as_images' => $options_as_images,
            'answered_correctly' => $selected_option == $correct_option,
        ];
    }
    else{
        switch ($correct_option_index){
            case 5: $correct_option = "A"; break;
            case 7: $correct_option = "B"; break;
            case 9: $correct_option = "C"; break;
            case 11: $correct_option = "D"; break;
            case 13: $correct_option = "E"; break;
        }
        switch (@$texts[19]){
            case "1": $selected_option = "A"; break;
            case "2": $selected_option = "B"; break;
            case "3": $selected_option = "C"; break;
            case "4": $selected_option = "D"; break;
            case "5": $selected_option = "E"; break;
            default: $selected_option = @$texts[19]; break;
        }

        $options = [
            "A" => xat_ta("A.", xat_ta("1.", @$texts[5])),
            "B" => xat_ta("B.", xat_ta("2.", @$texts[7])),
            "C" => xat_ta("C.", xat_ta("3.", @$texts[9])),
            "D" => xat_ta("D.", xat_ta("4.", @$texts[11])),
            "E" => xat_ta("E.", xat_ta("5.", @$texts[13])),
        ];

        return [
            'sub_type' => 'alternate',
            'type' => 'mcq', // MCQ
            'id' => @$texts[15],
            'number' => @$texts[1],
            'name' => @$texts[2],
            'options' => $options,
            'attempted' => isQuestionAttempted(@$texts[17]),
            'selected_option' => $selected_option,
            'selected_option_value' => @$options[@$texts[19]],
            'correct_option' => $correct_option,
            'correct_option_value' => $options[$correct_option],
            'options_as_images' => $options_as_images,
            'answered_correctly' => $selected_option == $correct_option,
        ];
    }
}

/**
 * translate answer (remove option like 'A.' from starting of answer)
 * @param $option
 * @param $answer
 * @return null|string
 */
function xat_ta($option, $answer){
    if (substr($answer, 0, strlen($option)) == $option) {
        $answer = substr($answer, strlen($option));
    }
    return xat_t($answer);
}

function xatisQuestionAttempted($status){
    $status = _t(strtolower($status));
    return in_array($status,["answered", "marked for review"]);
}

function xatgetScorePercentile($score){
    if($score >= 35){          return "99%tile - 100%tile";}
    elseif($score >= 33.25){   return "98%tile - 99%tile";}
    elseif($score >= 31.5){    return "97%tile - 98%tile";}
    elseif($score >= 30.25){   return "96%tile - 97%tile";}
    elseif($score >= 29){      return "95%tile - 96%tile";}
    elseif($score >= 27){      return "93%tile - 95%tile";}
    elseif($score >= 25.25){   return "90%tile - 93%tile";}
    elseif($score >= 24){      return "88%tile - 90%tile";}
    elseif($score >= 23){      return "85%tile - 88%tile";}
    elseif($score >= 22){      return "83%tile - 85%tile";}
    elseif($score >= 21.25){   return "80%tile - 83%tile";}
    elseif($score >= 20.75){   return "77%tile - 80%tile";}
    elseif($score >= 20.25){   return "75%tile - 77%tile";}
    elseif($score >= 20){      return "73%tile - 75%tile";}
    elseif($score >= 19.75){   return "70%tile - 73%tile";}
    elseif($score >= 19.25){   return "68%tile - 70%tile";}
    elseif($score >= 18.5){    return "65%tile - 68%tile";}
    elseif($score >= 17){      return "60%tile - 65%tile";}
    elseif($score >= 15.5){    return "55%tile - 60%tile";}
    elseif($score >= 13.75){   return "50%tile - 55%tile";}
    elseif($score >= 12.25){   return "45%tile - 50%tile";}
    elseif($score >= 10.75){   return "40%tile - 45%tile";}
    elseif($score >= 9.25){    return "35%tile - 40%tile";}
    elseif($score >= 7.75){    return "30%tile - 35%tile";}
    elseif($score >= 6.25){    return "25%tile - 30%tile";}
    elseif($score >= 4.75){    return "20%tile - 25%tile";}
    elseif($score >= 3.25){    return "15%tile - 20%tile";}
    elseif($score >= 1.75){    return "10%tile - 15%tile";}
    elseif($score >= 0.25){    return "5%tile - 10%tile";}
    else{return "0%tile - 5%tile";}
}


function xat_t($str, $remove_extra = '', $remove_extra_by = '') {
    $str = str_replace('&nbsp;', ' ', $str);
    $str = str_replace($remove_extra, $remove_extra_by, $str);
    $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
    $str = html_entity_decode($str);
    $str = htmlspecialchars_decode($str);
    $str = strip_tags($str);
    return trim($str);
}


//======================iift================================//


function iiftgetDomainFromUrl($url){
    // regex can be replaced with parse_url
    preg_match("/^(https|http|ftp):\/\/(.*?)\//", "$url/" , $matches);
    $parts = explode(".", $matches[2]);
    $tld = array_pop($parts);
    $host = array_pop($parts);
    if ( strlen($tld) == 2 && strlen($host) <= 3 ) {
        $tld = "$host.$tld";
        $host = array_pop($parts);
    }
    return "$host.$tld";
    /*return array(
        'protocol' => $matches[1],
        'subdomain' => implode(".", $parts),
        'domain' => "$host.$tld",
        'host'=>$host,'tld'=>$tld
    );*/
}


function iiftgetStudentResult($url) {
    $data = iiftfetchMarks($url);
    $sections_marks = [];
    $obtain_marks = 0;
    $total_marks = 0;
    foreach (@$data['sections'] as $section) {
        $is_ga_section = strtoupper($section['name']) == 'GA';
        $attempt_questions = 0;
        $correct_answers = 0;
        $wrong_answers = 0;
        $_total_marks = 0;
        $_obtain_marks = 0;
        foreach ($section['questions'] as $question) {
            if($is_ga_section) {
                $_total_marks += 1.5;
            }else{
                $_total_marks += 3;
            }
            if(@$question['attempted']){
                $attempt_questions++;
                if(@$question['answered_correctly']){
                    $correct_answers++;
                    if($is_ga_section) {
                        $_obtain_marks += 1.5;
                    }else{
                        $_obtain_marks += 3;
                    }
                }else{
                    $wrong_answers++;
                    if($is_ga_section) {
                        $_obtain_marks -= 0.5;
                    }else{
                        $_obtain_marks -= 1;
                    }
                }
            }
        }
        $sections_marks[] = [
            'name' => @$section['name'],
            'total_questions' => count(@$section['questions']),
            'attempt_questions' => $attempt_questions,
            'correct_answers' => $correct_answers,
            'wrong_answers' => $wrong_answers,
            'obtain_marks' => $_obtain_marks,
            'total_marks' => $_total_marks,
        ];
        $obtain_marks += $_obtain_marks;
        $total_marks += $_total_marks;
    }

    return [
        //'data' => $data,
        'details' => @$data['details'],
        'sections_marks' => $sections_marks,
        'obtain_marks' => round($obtain_marks, 2),
        'total_marks' => $total_marks,
    ];
}

function iiftfetchMarks($url) {
    include_once('simple_html_dom.php');
    //$url = "http://catking.local/data.html"; // TODO: remove this line
    $html = file_get_html($url);

    // Get student info (START)
    $student_info = [];
    foreach ($html->find('table tr') as $tr) {
        $tds = $tr->find('td');
        if(count($tds) == 2 && in_array(_t($tds[0]->plaintext), [
            'Roll No',
            'Application No',
            'Name',
            'Paper/Subject',
            'Exam Date',
            'Exam Slot',
        ])){
            $student_info[_t($tds[0]->plaintext)] = _t($tds[1]->plaintext);
        }
    }
    // Get student info (END)
    $answer_sheet_name = @$student_info['Exam Date'];
    $questions = [];
    foreach ($html->find('table tr td table') as $question) {
        $q = iiftparseQuestion($question, $answer_sheet_name);
        if(@$q['selected_option']){
            $questions[] = $q;
        }
    }

    $sections = [];
    foreach ($questions as $question) {
        $sections[$question['section']]['name'] = $question['section'];
        $sections[$question['section']]['questions'][] = $question;
    }

    return [
        'details' => $student_info,
        'sections' => $sections
    ];
}

/**
 * @param simple_html_dom $question
 * @return array
 */
function iiftparseQuestion($question, $answer_sheet_name){
    $data = [];
    $tmp_texts = [];
    foreach ($question->find('td') as $tk => $td){
        $txt = _t($td->plaintext);
        if(!in_array(strtoupper($txt), ["A", "B", "C", "D", ""]) && !in_array($txt, $tmp_texts)) {
            $data[] = $txt;
            $tmp_texts[] = $txt;
        }

        foreach ($td->find('img') as $img){
            if(
                $td->previousSibling() &&
                $td->previousSibling()->nodeName() == 'td' &&
                $td->previousSibling()->hasAttribute('width')
            ){
                $img_path = explode('/', $img->getAttribute('src'));
                $data[] = end($img_path);
            }
        }

        foreach ($td->find('b') as $b){
            if(!$b->has_child()) {
                $data[] = _t($b->plaintext);
            }else{
                foreach ($b->find('font') as $font){
                    $data[] = iift_t($font->plaintext);
                }
            }
        }
    }

    $rdata = array_reverse($data);
    $qid = @$data[1];
    $options = [
        "A" => @$rdata[8],
        "B" => @$rdata[6],
        "C" => @$rdata[4],
        "D" => @$rdata[2],
    ];
    $section = "";
    $answer = "";
    $given_option = @$rdata[0];
    $given_answer = @$options[@$rdata[0]];
    $question_name = _t(@$data[0], 'Question ID:'.$qid);

    global $XLSX;

    $sheet_index = 0;
    foreach ($XLSX->sheetNames() as $index => $name){
        if($name == $answer_sheet_name){
            $sheet_index = $index;
        }
    }
    foreach ($XLSX->rows($sheet_index) as $rk => $row){
        if($rk === 0){
            continue;
        }
        if(@$row[1] == $qid){
            $section = @$row[0];
            $answer = _t(@$row[2], '`');
        }
    }


    return [
        'sub_type' => strtolower(_t(@$data[2], ':')) == 'passage'? 'passage': 'alternate', /* Check MSQ question subtype is 'passage' or 'alternate' */
        'type' => 'mcq',
        'id' => $qid,
        'name' => $question_name,
        'options' => $options,
        'attempted' => iiftisQuestionAttempted($given_option),
        'selected_option' => $given_option,
        'selected_option_value' => $given_answer,
        'correct_option' => iiftgetAnswerOption($options, $answer),
        'correct_option_value' => $answer,
        'answered_correctly' => $answer == $given_answer,
        'section' => $section ?: '-',
    ];

}

/**
 * translate answer (remove option like 'A.' from starting of answer)
 * @param $option
 * @param $answer
 * @return null|string
 */
function iift_ta($option, $answer){
    if (substr($answer, 0, strlen($option)) == $option) {
        $answer = substr($answer, strlen($option));
    }
    return _t($answer);
}

function iiftisQuestionAttempted($status){
    $status = _t(strtolower($status));
    return in_array($status,["a", "b", "c", "d"]);
}

function iiftgetAnswerOption($options, $answer){
    switch($answer){
        case $options["A"]: return "A";
        case $options["B"]: return "B";
        case $options["C"]: return "C";
        case $options["D"]: return "D";
    }
    return null;
}

function iift_t($str, $remove_extra = '', $remove_extra_by = '') {
    $str = str_replace('&nbsp;', ' ', $str);
    $str = str_replace($remove_extra, $remove_extra_by, $str);
    $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
    $str = html_entity_decode($str);
    $str = htmlspecialchars_decode($str);
    $str = strip_tags($str);
    return trim($str);
}

?>