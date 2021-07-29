<div>
    <style>
        .fmt_box{
            margin: 10px 20px;
            padding: 10px 20px;
            border: 4px solid #eeeeee;
            background: #fff;
            box-shadow: 2px 4px 8px #b1b1b1;
        }
        .fmt_headline{
            font-size: 20px;
            margin:10px 0;
        }
        .fmt_label{
            font-size: 14px;
        }
        .fmt_input{
            padding:4px 10px;
            margin: 0 20px 0 0;
            border:1px solid #707070;
            border-radius: 4px;
            display: block;
            font-size: 16px;
        }
        .fmt_sub_btn{
            padding:6px 20px;
            margin:10px 0;
            border-radius: 8px;
            background:#0047d4;
            color:#fff;
            border:none;
            letter-spacing: 1px;
            cursor: pointer;
        }
        .fmt_checkbox{
            /* margin-left: 10px; */
            width: 34px;
            height: 34px;
            display: block;
        }
        .fmt_flex{
            display: flex;
            margin: 10px 0;
        }
        #addOption{
            padding: 6px 20px;
            background: #049e04;
            color: #fff;
            cursor: pointer;
        }
    </style>
    <form action="{{route('fmt.gridtnf.store')}}" method="post" class="fmt_box" enctype="multipart/form-data">
        <input type="integer" name="problem_set_id" value="{{$pbs72 ?? ''}}" hidden style="border:1px solid #000000;">
        <input type="integer" name="format_type_id" value="{{$fmt72 ?? ''}}" hidden style="border:1px solid #000000;">
        <div class="fmt_headline">Add a Grid True & False</div>
        <div>
            <label class="fmt_label" for="">Format Title</label>
            <input class="fmt_input" type="text" name="format_title" placeholder="format_title" style="width: 100%;">
        </div>
        <div>
            <label class="fmt_label" for="">Question</label>
            <input class="fmt_input" type="text" name="question" placeholder="Question" style="width: 100%;">
        </div>
        <div>
            <label class="fmt_label" for="">Comment</label>
            <textarea class="fmt_input" type="text" name="hint" placeholder="comment" style="width: 100%;"></textarea>
        </div>
        <div class="my-2" style="margin: 20px 0;">
            <label class="bloc" for="">Difficulty Level</label>
            @php $d_levels = DB::table('difficulty_levels')->get(); @endphp
            <select name="difficulty_level_id" id="" class="w-full my-2 px-2 py-2 border border-gray-500 rounded-lg">
                @foreach ($d_levels as $level)
                <option value="{{$level->id}}">{{$level->name}}</option>
                @endforeach
            </select>
        </div>
        <hr>
        {{-- answer1-match1 --}}
        <div class="fmt_flex">
            <div>
                <label class="fmt_label" for="">Answer 1</label>
                <input class="fmt_input" type="text" name="answer_1" placeholder="Answer" value="true" readonly>
            </div>
            <div>
                <label class="fmt_label" for="">Correct</label>
                <input class="fmt_checkbox" type="checkbox" name="ans_correct_1" id="">
            </div>
            <div style="margin-left: 10px;">
                <label class="fmt_label" for="">English Word 1</label>
                <input class="fmt_input" type="text" name="eng_word1" placeholder="eng_word1" >
            </div>
        </div>
        {{-- //answer2-match2 --}}
        {{-- answer2-match2 --}}
        <div class="fmt_flex">
            <div>
                <label class="fmt_label" for="">Answer 2</label>
                <input class="fmt_input" type="text" name="answer_2" placeholder="Answer" value="false" readonly>
            </div>
            <div>
                <label class="fmt_label" for="">Correct</label>
                <input class="fmt_checkbox" type="checkbox" name="ans_correct_2" id="">
            </div>
            <div style="margin-left: 10px;">
                <label class="fmt_label" for="">English Word 2</label>
                <input class="fmt_input" type="text" name="eng_word2" placeholder="eng_word2" >
            </div>
        </div>
        {{-- //answer2-match2 --}}
        <div>
            <input type="submit" class="fmt_sub_btn" value="Submit">
        </div>
    </form>
    {{-- <button id="addOption">Add option</button> --}}
    {{--  --}}
    <form action="{{route('fmt.gridtnf.csv')}}" method="POST" enctype='multipart/form-data' style="margin:20px 40px;">
        @csrf
        <input type="integer" name="problem_set_id" value="{{$pbs72 ?? ''}}" hidden style="border:1px solid #000000;">
        <input type="integer" name="format_type_id" value="{{$fmt72 ?? ''}}" hidden style="border:1px solid #000000;">
        <div style="display:block; padding:10px;">
            <label style="font-size:12px;">Format Title</label>
            <input class="fmt_input" type="text" name="format_title" placeholder="format_title">
        </div>
        <div style="display:block; padding:10px;">
            <div style="font-size:12px;">CSV</div>
            <input style="display:block;" type="file" name="file" >
        </div>
        <button type="submit" style="display: inline-block; margin:10px; padding:4px 20px; background:green; color:#fff; text-transform:uppercase; border-radius:4px;">submit</button>
    </form>
    {{--  --}}
</div>
{{-- <script>
    var addOption = document.getElementById('addOption');

</script> --}}
