<?php
namespace Edgewizz\Gridtnf\Models;

use Illuminate\Database\Eloquent\Model;

class GridtnfQues extends Model{
    public function answers(){
        return $this->hasMany('Edgewizz\Gridtnf\Models\GridtnfAns', 'question_id');
    }
    protected $table = 'fmt_gridtnf_ques';
}