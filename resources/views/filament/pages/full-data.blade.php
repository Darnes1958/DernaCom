<div class="flex te">
    @if($record->is_father)
     <p style="color: #fbbf24; ">{{$record->FullName}}</p>
    @else
        @if($record->is_mother)
            <p style="color: #00bb00;">{{$record->FullName}}</p>
        @else
            <p  >{{$record->FullName}}</p>
        @endif
    @endif


        @if ($record->otherName) <p style="color: #9f1239;font-weight: bold"> &nbsp; [{{$record->otherName}}]&nbsp; </p> @endif

    @if($record->wife)
      <p style="color: #fbbf24;font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;زوجها :&nbsp;</p>
      <p >{{$record->wife->FullName}}</p>
    @endif
    @if($record->husband)
        <p style="color: #00bb00;font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;زوجته :&nbsp;</p>
        <p >{{$record->husband->FullName}}&nbsp;({{$record->husband->Family->FamName}})</p>
    @endif
    @if($record->sonOfFather)
        @if($record->male=='ذكر')
        <p style="color: dodgerblue;font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;والده :&nbsp;</p>
        @else
        <p style="color: dodgerblue;font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;والدها :&nbsp;</p>
        @endif
        <p >{{$record->sonOfFather->FullName}}</p>
    @endif
    @if($record->sonOfMother)
        @if($record->male=='ذكر')
            <p style="color: #c084fc;font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;والدته :&nbsp;</p>
        @else
            <p style="color: #c084fc;font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;والدتها :&nbsp;</p>
        @endif

        <p >{{$record->sonOfMother->FullName}}</p>
    @endif
    @if($record->father->count()>0)
            <p style="color: aqua;font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;أبناءه :&nbsp;</p>
        @php
            $i=0;
            foreach($record->father as $item){
                 if ($i == 0) echo "<p>{$item->Name1}</p>"; else echo "<p style=\"color: aqua;font-weight: bold\">&nbsp;,&nbsp;</p><p>{$item->Name1}</p>";
                 $i++;}
        @endphp
    @endif
    @if($record->mother->count()>0)
                <p style="color: aqua;font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;أبناءها :&nbsp;</p>
            @php
                if ($record->has_more !=1) {
                    $i=0;
                    foreach($record->mother as $item){
                         if ($i == 0) echo "<p>{$item->Name1}</p>"; else echo "<p style=\"color: aqua;font-weight: bold\">&nbsp;,&nbsp;</p><p>{$item->Name1}</p>";
                         $i++;}
                    if (!$record->wife) echo "<p>&nbsp&nbsp;(من : &nbsp {$item->Name2}&nbsp;{$item->Name3}&nbsp;{$item->Name4})</p>";
                } else {

                    $rec=\App\Models\Victim::where('mother_id',$record->id)->orderby('Name2')->get();
                    $i=0;

                    $name2=$rec[0]->Name2;
                    $name3=$rec[0]->Name3;
                    $name4=$rec[0]->Name4;
                    foreach($rec as $item){
                      if ($name2 != $item->Name2){
                          echo "<p>&nbsp&nbsp;(من :  {$name2}&nbsp;{$name3}&nbsp;{$name4})</p>";
                          $name2=$item->Name2;
                          $name3=$item->Name3;
                          $name4=$item->Name4;
                          $i=0;
                      }

                         if ($i == 0) echo "<p>&nbsp;{$item->Name1}</p>"; else echo "<p style=\"color: aqua;font-weight: bold\">&nbsp;,&nbsp;</p><p>{$item->Name1}</p>";
                         $i++;
                    }
                        echo "<p>&nbsp&nbsp;(من :  {$name2}&nbsp;{$name3}&nbsp;{$name4})</p>";
                }

            @endphp
        @endif
</div>
