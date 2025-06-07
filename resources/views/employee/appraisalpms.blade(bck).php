@include('employee.header')

<body class="mini-sidebar">
   <div id="loader" style="display: none;">
      <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
         <span class="sr-only">Loading...</span>
      </div>
   </div>
   <!-- Main Body -->
   <div class="pmsnewpage" style="padding: 20px;">
      <div class="card mb-4">
      <div class="card-header" style="background-color: #c4d9db; position: sticky; top: 0; z-index: 10; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h5>
                    <b>{{ $employeedetailspms->Fname }} {{ $employeedetailspms->Sname }} {{ $employeedetailspms->Lname }}</b>
                </h5>
                <h5>
                    <b>Emp Code: {{ $employeedetailspms->EmpCode }}</b> &nbsp;&nbsp;&nbsp;
                    <b>Designation:</b> {{ $employeedetailspms->department_name }}
                </h5>
            </div>
            <div style="max-width: 300px; font-size: 16px; color: blue; font-weight: bold;">
                If your rating is 0.0 or 0, please clear it first and re-enter 0.
            </div>
        </div>

         <!-- Achievements Section -->
         <div class="card mb-4">
            <div class="card-header">
               <h5><b>Achievements</b></h5>
            </div>
            <div class="card-body">
               <ol>
                  @foreach($achievement as $ach)
                  <li>{{ $ach->Achivement }}</li>
                  @endforeach
               </ol>
            </div>
         </div>
         <!-- Feedback Section -->
         <div class="card mb-4">
            <div class="card-header">
               <h5><b>Feedback</b></h5>
            </div>
            <div class="card-body">
               <ul>
                  @foreach($feedback as $feed)
                  <li><b>Question:</b> {{ $feed->WorkEnvironment }}</li>
                  <li><b>Answer:</b> {{ $feed->Answer }}</li>
                  <br>
                  @endforeach
               </ul>
            </div>
         </div>
         <div class="card">
            <div class="card-header">
               <h5><b>Form - A (KRA)</b></h5>
            </div>
            <div class="card-body table-responsive dd-flex align-items-center">
               <table class="table table-pad">
                  <thead>
                     <tr>
                        <th>SN.</th>
                        <th style="width:215px;">KRA/Goals</th>
                        <th style="width:300px;">Description</th>
                        <th>Measure</th>
                        <th>Unit</th>
                        <th>Weightage</th>
                        <th>Logic</th>
                        <th>Period</th>
                        <th>Target</th>
                        <th>Emp Rating</th>
                        <th style="width:215px;">Emp Remarks</th>
                        <th>Appraiser Rating</th>
                        <th>Appraiser Remarks</th>
                        <th>Appraiser Score</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     // Initialize grand total
                     $grandTotalScore = 0;
                     @endphp
                     @foreach ($employeePmsKraforma as $index => $kraforma)
                     <tr data-kraid="{{ $kraforma->KRAId }}" data-subkraid="">
                        <td><b>{{ $index + 1 }}.</b></td>
                        <td style="width: 215px;">{{ optional($kraforma->kra->first())->KRA ?? 'N/A' }}</td>
                        <td style="width: 300px;">{{ optional($kraforma->kra->first())->KRA_Description ?? 'N/A' }}</td>
                        <td>{{ optional($kraforma->kra->first())->Measure ?? 'N/A' }}</td>
                        <td>{{ optional($kraforma->kra->first())->Unit ?? 'N/A' }}</td>
                        <td>{{ $kraforma->Weightage ?? 'N/A' }}</td>
                        <td>{{ $kraforma->Logic ?? 'N/A' }}</td>
                        <td>{{ $kraforma->Period ?? 'N/A' }}</td>
                        @if ($kraforma->submr->isEmpty())
                        <td>
                           @if ($kraforma->Period !== 'Annual')
                           <button id="Tar_kra_{{ $kraforma->KRAId }}"
                              style="padding: 5px 8px;" 
                              type="button" 
                              class="btn btn-outline-success custom-toggle" 
                              data-bs-toggle="modal"
                              onClick="showKraDetailsappraisal('{{ $kraforma->KRAId }}', '{{ $kraforma->Period }}', '{{ $kraforma->Target }}', '{{ $kraforma->Weightage }}', '{{ $kraforma->Logic }}', '{{ $year_pms->CurrY }}','empappraisal')">
                           <span class="icon-on">{{ $kraforma->Target }}</span> 
                           </button>
                           @else
                           <span class="icon-on">{{ $kraforma->Target }}</span>
                           @endif
                        </td>
                        <td>
                           <span class="display-value">{{ round($kraforma->SelfRating, 2) }}</span>
                        </td>
                        <td>
                           <span class="display-remark">{{ $kraforma->AchivementRemark }}</span>
                        </td>
                        <!-- Empty cells for Appraiser columns (adjust as needed) -->
                        @php
                       
                        if ($kraforma->Period === 'Annual') {
                        $adjustedAch = $kraforma->AppraiserRating;
                        }
                        else{
                            $adjustedAch = DB::table('hrm_pms_kra_tgtdefin')
                                        ->where('KRAId', $kraforma->KRAId)
                                        ->sum('AppLogScr'); 
                        }
                        if ($kraforma->Period === 'Annual') {

                        $krascoreSum = DB::table('hrm_employee_pms_kraforma')->where('KRAFormAId', $kraforma->KRAFormAId)->sum('AppraiserScore');                                                                                  
                        }
                        else{
                            $krascoreSum = DB::table('hrm_pms_kra_tgtdefin')
                                        ->where('KRAId', $kraforma->KRAId)
                                        ->sum('AppScor'); 
                        }
                        
                        $kralogSum = DB::table('hrm_employee_pms_kraforma')->where('KRAFormAId', $kraforma->KRAFormAId)->sum('AppraiserLogic');                                                                                  

                        $grandTotalScore += $krascoreSum;
                        @endphp
                        <td>
                           @if ($kraforma->Period != 'Annual')
                           <span class="display-value" id="display-value{{ $kraforma->KRAId }}">{{ round($adjustedAch, 2) }}</span>
                           @else
                           <input
                              style="width:62px;" 
                              type="number" 
                              id="input-rating-kra-{{ $kraforma->KRAId }}"
                              class="form-control annual-rating-kra"
                              value="{{ round($adjustedAch, 2) }}" 
                              placeholder="Enter rating"
                              data-target="{{ $kraforma->Target }}" 
                              data-logic="{{ $kraforma->Logic }}" 
                              data-index="{{ $kraforma->KRAId }}"
                              data-weight-logic8="{{ $kraforma->Weightage }}"
                              data-target-logic8="{{ $kraforma->Target }}"
                              data-weight="{{ $kraforma->Weightage }}">
                           @endif
                        </td>
                        <td>
                           <textarea style="min-height:50px; min-width:170px; overflow:hidden; resize:none;"
                              oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"
                              class="form-control" 
                              id="kraremark{{ $kraforma->KRAId }}" 
                              placeholder="Enter your remarks">{{ $kraforma->AppraiserRemark }}</textarea>
                        </td>
                        <td class="text-center">
                           <span id="krascorespan{{$kraforma->KRAId}}"  class="" >{{$krascoreSum,2}}</span>
                        </td>
                        
                        <td class="d-none">
                           <span id="logScorekra{{$kraforma->KRAId}}" >{{$kralogSum,2}}</span>
                        </td>
                        @endif
                     </tr>
                     <!-- If there are sub-KRA records, display them in a nested table -->
                     @if ($kraforma->submr->isNotEmpty())
                     <tr>
                        <td colspan="14">
                           <table class="table" style="background-color:#ECECEC;">
                              <thead>
                                 <tr>
                                    <th>SN.</th>
                                    <th style="width:215px;">Sub KRA/Goals</th>
                                    <th style="width:300px;">Sub KRA Description</th>
                                    <th>Measure</th>
                                    <th>Unit</th>
                                    <th>Weightage</th>
                                    <th>Logic</th>
                                    <th>Period</th>
                                    <th>Target</th>
                                    <th>Emp Rating</th>
                                    <th style="width:215px;">Emp Remarks</th>
                                    <th>Appraiser Rating</th>
                                    <th>Appraiser Remarks</th>
                                    <th>Appraiser Score</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach ($kraforma->submr as $subIndex => $subkra)
                                 @php 
                                 //SUBFORMA
                                
                                 if ($subkra->Period === 'Annual') {
                                 $adjustedAchsub = $subkra->AppraiserRating;
                                 }
                                 else{
                                    $adjustedAchsub = DB::table('hrm_pms_kra_tgtdefin')
                                                    ->where('KRASubId', $subkra->KRASubId)
                                                    ->sum('AppLogScr');
                                 }
                                 if ($subkra->Period != 'Annual') {
                                        $selfratingemployee = DB::table('hrm_pms_kra_tgtdefin')
                                                    ->where('KRASubId', $subkra->KRASubId)
                                                    ->sum('LogScr');
                                 }
                                 else{
                                    $selfratingemployee = $subkra->SelfRating;

                                 }

                                 if ($subkra->Period != 'Annual') {

                                 $subKraAchSum = DB::table('hrm_pms_kra_tgtdefin')->where('KRASubId', $subkra->KRASubId)->sum('AppScor');
                                 }
                                 else{
                                    $subKraAchSum = $subkra->AppraiserScore;
                                 }
                                 if ($subkra->Period === 'Annual') {
                                 $subKralogSum = $subkra->AppraiserLogic;
                                 }
                                 else{
                                    $subKralogSum = DB::table('hrm_pms_kra_tgtdefin')->where('KRASubId', $subkra->KRASubId)->sum('AppLogScr');
                                 }

                                 $grandTotalScore += $subKraAchSum;
                                 @endphp
                                 <tr data-kraid="{{ $kraforma->KRAId }}" data-subkraid="{{ $subkra->KRASubId }}">
                                 <td><b>{{ $subIndex + 1 }}.</b></td>
                                    <td>{{ $subkra->KRA ?? '' }}</td>
                                    <td>{{ $subkra->KRA_Description ?? '' }}</td>
                                    <td>{{ $subkra->Measure ?? '' }}</td>
                                    <td>{{ $subkra->Unit ?? '' }}</td>
                                    <td>{{ fmod($subkra->Weightage, 1) == 0.0 ? number_format($subkra->Weightage, 0) : number_format($subkra->Weightage, 2) }}</td>
                                    <td>{{ $subkra->Logic ?? '' }}</td>
                                    <td>{{ $subkra->Period ?? '' }}</td>
                                    <td>
                                       @if ($subkra->Period !== 'Annual')
                                       <button id="Tar_a{{ $subkra->KRASubId }}"
                                          style="padding: 5px 8px;" 
                                          type="button" 
                                          class="btn btn-outline-success custom-toggle" 
                                          data-bs-toggle="modal"
                                          onClick="showKraDetailsappraisal('sub_{{ $subkra->KRASubId }}', '{{ $subkra->Period }}', '{{ $subkra->Target }}', '{{ $subkra->Weightage }}', '{{ $subkra->Logic }}', '{{ $year_pms->CurrY }}','empappraisal')">
                                       <span class="icon-on">{{ fmod($subkra->Target, 1) == 0.0 ? number_format($subkra->Target, 0) : number_format($subkra->Target, 2) }}</span> 

                                       </button>
                                       @else
                                       <span class="icon-on">{{ fmod($subkra->Target, 1) == 0.0 ? number_format($subkra->Target, 0) : number_format($subkra->Target, 2) }}</span> 
                                       @endif
                                    </td>
                                    <td>
                                       <span>{{ $selfratingemployee ?? '0.00'}}</span>
                                    </td>
                                    <td>
                                       <span id="display-remark-{{ $subkra->KRASubId }}">{{ $subkra->AchivementRemark }}</span>
                                    </td>
                                    <td>
                                       @if ($subkra->Period !== 'Annual')
                                       <span id="display-rating-{{ $subkra->KRASubId }}">{{ $adjustedAchsub ?? 0 }}</span>                      
                                       @else
                                       <input
                                          id="input-rating-{{ $subkra->KRASubId }}"
                                          style="width:62px; " 
                                          type="number" 
                                          value="{{ $adjustedAchsub ?? 0 }}"
                                          class="form-control annual-rating-subkra"
                                          placeholder="Enter rating" 
                                          data-index="{{ $subkra->KRASubId }}"
                                          data-target="{{ $subkra->Target }}" 
                                          data-logic="{{ $subkra->Logic }}" 
                                          data-weight-logic8="{{ $kraforma->Weightage }}"
                                          data-target-logic8="{{ $kraforma->Target }}"
                                          data-weight="{{ $subkra->Weightage }}">
                                       @endif
                                    </td>
                                    <td>
                                       <!-- Textarea, hidden by default -->
                                       <textarea
                                          id="textarea-remark-{{ $subkra->KRASubId }}"
                                          style="min-height:50px; min-width:170px; overflow:hidden; resize:none;"
                                          oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"
                                          class="form-control"
                                          placeholder="Enter your remarks">{{ $subkra->AppraiserRemark }}</textarea>
                                    </td>
                                    <td class="text-center"><span id="subkrascoreforma{{$subkra->KRASubId}}">{{$subKraAchSum,2}}</span>                              
                                    </td>
                                    <td class="d-none">
                                    <span id="logscoresubkra{{$subkra->KRASubId}}" >{{$subKralogSum,2}}</span>
                                    
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </td>
                     </tr>
                     @endif
                     @endforeach
                     <tr style="background-color: #76a0a3;font-weight:600;">
                        <td  class="text-right" colspan="13">Final Appraiser KRA Score Form A :</td>
                        <td name ="grandtotalfinalemp" id="grandtotalfinalemp">{{ round($grandTotalScore, 2) }}</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         <div class="card">
            <div class="card-header" style="background-color:#A8D0D2;">
               <b>Form B (Skills)</b>
              
            </div>
            <div class="card-body table-responsive dd-flex align-items-center ViewAppraisalContent">
               <table class="table table-pad">
                  <thead>
                     <tr>
                        <th>SN.</th>
                        <th style="width:215px;">Behavioral/Skills</th>
                        <th style="width:300px;">Description</th>
                        <th>Weightage</th>
                        <th>Logic</th>
                        <th>Period</th>
                        <th>Target</th>
                        <th>Emp Ass.</th>
                        <th style="width:215px;">Emp. Remarks</th>
                        <th>Appraisar Ass.</th>
                        <th style="width:215px;">App. Remarks</th>
                        <th>Appraiser Score</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     // Initialize grand total
                     $grandTotalScore = 0;
                     @endphp
                     @foreach($behavioralForms as $index => $form)
                     @php 
                     $subForms = $behavioralFormssub->where('FormBId', $form->FormBId);
                     @endphp
                     <tr data-formbkraid="{{ $form->BehavioralFormBId }}" data-formbsubkraid="">
                        <td><b>{{ $index + 1 }}.</b></td>
                        <td style="width:215px;">{{ $form->Skill }}</td>
                        <td style="width:300px;">{{ $form->SkillComment }}</td>
                        @if($subForms->isEmpty())
                        <td>{{ fmod($form->Weightage, 1) == 0.0 ? number_format($form->Weightage, 0) : number_format($form->Weightage, 2) }}</td>

                        <td>{{ $form->Logic }}</td>
                        <td>{{ $form->Period }}</td>
                        <td>
                           @if ($form->Period != 'Annual' && $form->Period != '')
                           <button
                              style="padding: 5px 8px;" 
                              type="button" 
                              class="btn btn-outline-success custom-toggle" 
                              data-bs-toggle="modal"
                              onclick="FunFormBTgt(
                              '{{ $form->FormBId }}',
                              '{{ $form->Period }}',
                              {{ intval($form->Target) }},
                              {{ intval($form->Weightage) }},
                              '{{ $form->Logic }}',
                              {{ $PmsYId }},'{{$form->EmpId}}')">
                            <span class="icon-on">{{ fmod($form->Target, 1) == 0.0 ? number_format($form->Target, 0) : number_format($form->Target, 2) }}</span> 
                            </button>
                           @else
                           <span class="icon-on">{{ fmod($form->Target, 1) == 0.0 ? number_format($form->Target, 0) : number_format($form->Target, 2) }}</span> 
                           @endif
                        </td>
                        @php

                        if ($form->Period != 'Annual') {

                        $kraAchSum = DB::table('hrm_pms_formb_tgtdefin')
                        ->where('FormBId', $form->FormBId)
                        ->where('EmployeeID', $employeeid)
                        ->where('YearId', $PmsYId)
                        ->sum('LogScr');
                        }else{
                            $kraAchSum = $form->SelfFormBLogic;
                        }
                        if ($form->Period != 'Annual') {

                        $kraAchSumapp = DB::table('hrm_pms_formb_tgtdefin')
                        ->where('FormBId', $form->FormBId)
                        ->where('EmployeeID', $employeeid)
                        ->where('YearId', $PmsYId)
                        ->sum('AppLogScr');
                        }
                        else {

                        $kraAchSumapp = $form->AppraiserRating;
                        }
                      
                        if ($form->Period === 'Annual') {
                            $krascoreSum = DB::table('hrm_employee_pms_behavioralformb')
                            ->where('BehavioralFormBId', $form->BehavioralFormBId)
                            ->sum('AppraiserScore');
                        }
                        else{
                            $krascoreSum = DB::table('hrm_pms_formb_tgtdefin')
                                        ->where('FormBId', $form->FormBId)
                                        ->sum('AppScor');
                        }
                        if ($form->Period === 'Annual') {
                            $kralogscore = DB::table('hrm_employee_pms_behavioralformb')
                            ->where('BehavioralFormBId', $form->BehavioralFormBId)
                            ->sum('AppraiserLogic');
                        }
                        else{
                            $kralogscore = DB::table('hrm_pms_formb_tgtdefin')
                                        ->where('FormBId', $form->FormBId)
                                        ->where('EmployeeID',$employeeid)
                                        ->sum('AppLogScr');
                        }
                        // Add to grand total
                        $grandTotalScore += $krascoreSum;
                        @endphp
                        <td>
                           <span>{{ round($kraAchSum, 2) }}</span>
                        </td>
                        <td>
                           <span >{{ $form->Comments_Example }}</span>
                        </td>
                        <td>
                           @if ($form->Period != 'Annual')
                           <span id="display-rating-formb-{{ $form->BehavioralFormBId }}">{{ round($kraAchSumapp, 2) }}</span>
                           @else
                           <input
                              id="input-rating-formb-{{ $form->BehavioralFormBId }}"
                              style="width:70px;" 
                              type="number"
                              maxlength="12"
                              value="{{ round($kraAchSumapp, 2) }}"
                              class="form-control annual-rating-formb"
                              placeholder="Enter rating"
                              data-period="{{ $form->Period }}"
                              data-target="{{ $form->Target }}"
                              data-logic="{{ $form->Logic }}"
                              data-index="{{ $form->BehavioralFormBId }}"
                              data-weight="{{ $form->Weightage }}"
                              >
                           @endif
                        </td>
                        <td>
                           <textarea style="min-height:50px; min-width:170px; overflow:hidden; resize:none;"
                              oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"
                              class="form-control" 
                              id="formbremark{{ $form->BehavioralFormBId }}" 
                              placeholder="Enter your remarks">{{ $form->AppraiserRemark}}</textarea>
                        </td>
                        <td class="text-center">
                           <span id="krascoreformb{{$form->BehavioralFormBId}}" >{{$krascoreSum,2}}</span>
                        </td>
                        <td class="d-none">
                        <span id="logScorekraformb{{$form->BehavioralFormBId}}">{{ $kralogscore, 2}}</span>
                        </td>
                        @endif
                     </tr>
                     @if($subForms->isNotEmpty())
                     <tr>
                        <td colspan="12" class="subform-row">
                           <table class="table" style="background-color:#ECECEC;">
                              <thead>
                                 <tr>
                                    <th>SN.</th>
                                    <th style="width:215px;">Sub Behavioral/Skills</th>
                                    <th style="width:300px;"> Sub Behavioral Description</th>
                                    <th>Weightage</th>
                                    <th>Logic</th>
                                    <th>Period</th>
                                    <th>Target</th>
                                    <th>Emp Ass.</th>
                                    <th style="width:215px;">Emp. Remarks</th>
                                    <th>Appraisar Ass.</th>
                                    <th style="width:215px;">App. Remarks</th>
                                    <th>Appraiser Score</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($subForms as $subIndex => $subForm)
                                 <tr data-formbkraid="{{ $form->BehavioralFormBId }}" data-formbsubkraid="{{ $subForm->FormBSubId }}">
                                    <td><b>{{ $subIndex + 1 }}.</b></td>
                                    <td>{{ $subForm->Skill }}</td>
                                    <td>{{ $subForm->SkillComment }}</td>
                                    <td>{{ fmod($subForm->Weightage, 1) == 0.0 ? number_format($subForm->Weightage, 0) : number_format($subForm->Weightage, 2) }}</td>

                                    <td>{{ $subForm->Logic }}</td>
                                    <td>{{ $subForm->Period }}</td>
                                    <td>
                                       @if ($subForm->Period != 'Annual' && $subForm->Period != '')
                                       <button
                                          style="padding: 5px 8px;" 
                                          type="button" 
                                          class="btn btn-outline-success custom-toggle" 
                                          data-bs-toggle="modal"
                                          onclick="FunFormBTgt(
                                          'sub_{{ $subForm->FormBSubId }}',
                                          '{{ $subForm->Period }}',
                                          {{ intval($subForm->Target) }},
                                          {{ intval($subForm->Weightage) }},
                                          '{{ $subForm->Logic }}',
                                          {{ $PmsYId }},'{{$subForm->EmpId}}')">
                                        <span class="icon-on">{{ fmod($subForm->Target, 1) == 0.0 ? number_format($subForm->Target, 0) : number_format($subForm->Target, 2) }}</span> 
                                        </button>
                                       @else
                                       <span class="icon-on">{{ fmod($subForm->Target, 1) == 0.0 ? number_format($subForm->Target, 0) : number_format($subForm->Target, 2) }}</span> 
                                       @endif
                                    </td>
                                    <td>
                                       @php
                                       $adjustedAchsub = DB::table('hrm_pms_formb_tgtdefin')
                                       ->where('FormBSubId', $subForm->FormBSubId)
                                       ->where('EmployeeID',$employeeid)
                                       ->where('YearId',$PmsYId)
                                       ->sum('LogScr');

                                       if ($subForm->Period != 'Annual') {

                                       $adjustedAchsubapp = DB::table('hrm_pms_formb_tgtdefin')
                                       ->where('FormBSubId', $subForm->FormBSubId)
                                       ->where('EmployeeID',$employeeid)
                                       ->where('YearId',$PmsYId)
                                       ->sum('AppLogScr');
                                       }
                                       else{
                                        $adjustedAchsubapp = $subForm->AppraiserRating;
                                       }

                                       if ($subForm->Period != 'Annual') {

                                       $subKraAchSum = DB::table('hrm_pms_formb_tgtdefin')
                                       ->where('FormBSubId', $subForm->FormBSubId)
                                       ->where('EmployeeID',$employeeid)
                                       ->where('YearId',$PmsYId)
                                       ->sum('AppScor');
                                       }
                                       else{
                                        $subKraAchSum = $subForm->AppraiserLogic;

                                       }

                                       if ($subForm->Period === 'Annual') {
                                                $sublogscore = $subForm->AppraiserLogic;
                                            }
                                            else{
                                                $sublogscore = DB::table('hrm_pms_formb_tgtdefin')
                                                            ->where('FormBSubId', $subForm->FormBSubId)
                                                            ->where('EmployeeID',$employeeid)
                                                            ->sum('AppLogScr');
                                            }
                                       $grandTotalScore += $subKraAchSum;
                                       @endphp
                                       <span>{{ round($adjustedAchsub,2)}}</span>                                      
                                    </td>
                                    <td>
                                       <span>{{ $subForm->AchivementRemark }}</span>
                                    </td>
                                    <td>
                                       @if ($subForm->Period != 'Annual')
                                       <span id="display-rating-subformb-{{ $subForm->FormBSubId }}">{{ round($adjustedAchsubapp,2)}}</span>                                      
                                       @else
                                       <input
                                          id="input-rating-subformb-{{ $subForm->FormBSubId }}"
                                          style="width:70px;" 
                                          type="number"
                                          value="{{ $adjustedAchsubapp ?? 0 }}"
                                          maxlength="12"
                                          class="form-control annual-rating-formb-subkra"
                                          placeholder="Enter rating"
                                          data-period="{{ $subForm->Period }}"
                                          data-index="{{ $subForm->FormBSubId }}"
                                          data-target="{{ $subForm->Target }}"
                                          data-logic="{{ $subForm->Logic }}"
                                          data-weight="{{ $subForm->Weightage }}"
                                          >
                                       @endif
                                    </td>
                                    <td>
                                       <textarea style="min-height:50px; min-width:170px; overflow:hidden; resize:none;"
                                          oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"
                                          class="form-control" 
                                          id="subformbremark{{ $subForm->FormBSubId }}" 
                                          placeholder="Enter your remarks">{{ $subForm->AppraiserRemark}}</textarea>
                                    </td>
                                    <td>
                                       <span id="subkrascoreformb{{$subForm->FormBSubId}}">{{$subKraAchSum,2}}</span>
                                    </td>
                                    <td>
                                    <span  class="d-none" id="logScoresubkraformb{{$subForm->FormBSubId}}">{{ $sublogscore, 2}}</span>
                                        </td>
                                </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </td>
                     </tr>
                     @endif
                     @endforeach
                     <tr style="background-color: #76a0a3;font-weight:600;">
                        <td  class="text-right" colspan="11">Final Appraiser KRA Score Form B :</td>
                        <td name ="grandtotalfinalempFormb" id="grandtotalfinalempFormb">{{ round($grandTotalScore, 2) }}</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         <div class="card">
            <div class="card-header">
               <div style="float:left;width:100%;">
                  <h5 class="float-start"><b>PMS Score</b></h5>
               </div>
            </div>
            <div class="card-body table-responsive dd-flex align-items-center ">
               <table class="table" style="background-color:#ECECEC;">
                  <thead>
                     <tr>
                        <th>Title</th>
                        <th>KRA form</th>
                        <th>% Weightage</th>
                        <th>(A) KRA Score</th>
                        <th>Behavioral form</th>
                        <th>% Weightage</th>
                        <th>(B) Behavioral score</th>
                        <th>(A + B) PMS Score</th>
                        <th>Rating</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>Employee</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td>{{$employeealldetailsforpms->EmpFormAScore}}</td>
                        @else
                        <td></td>
                        @endif
                        <td>{{$employeealldetailsforpms->FormAKraAllow_PerOfWeightage}}</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td>{{$employeealldetailsforpms->EmpFinallyFormA_Score}}</td>
                        @else
                        <td></td>
                        @endif
                        @if($data['emp']['Appform'] == 'Y')
                        <td>{{$employeealldetailsforpms->EmpFormBScore}}</td>
                        @else
                        <td></td>
                        @endif
                        <td>{{$employeealldetailsforpms->FormBBehaviAllow_PerOfWeightage}}</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td>{{$employeealldetailsforpms->EmpFinallyFormB_Score}}</td>
                        @else
                        <td></td>
                        @endif
                        <td>{{ $employeealldetailsforpms->EmpFinallyFormA_Score + $employeealldetailsforpms->EmpFinallyFormB_Score }}</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td>{{$employeealldetailsforpms->Emp_TotalFinalRating}}</td>
                        @else
                        <td></td>
                        @endif
                     </tr>
                     <tr>
                        @php 
                        $formbfinal = ($employeealldetailsforpms->AppraiserFormBScore * $employeealldetailsforpms->FormBBehaviAllow_PerOfWeightage) / 100 ;
                        
                        @endphp
                        <td>Appraiser</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td id="pmsscoreforma">{{$employeealldetailsforpms->AppraiserFormAScore}}</td>
                        @else
                        <td></td>
                        @endif
                        <td id="formawgt">{{$employeealldetailsforpms->FormAKraAllow_PerOfWeightage}}</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td id="formasperwgt">{{ ($employeealldetailsforpms->AppraiserFormAScore * $employeealldetailsforpms->FormAKraAllow_PerOfWeightage) / 100 }}</td>
                        @else
                        <td></td>
                        @endif
                        @if($data['emp']['Appform'] == 'Y')
                        <td id="pmsscoreformb">{{$employeealldetailsforpms->AppraiserFormBScore}}</td>
                        @else
                        <td></td>
                        @endif
                        <td id="formbwgt">{{$employeealldetailsforpms->FormBBehaviAllow_PerOfWeightage}}</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td id="pmsscoreformbasperwgt">{{$employeealldetailsforpms->Appraiser_TotalFinalScore}}</td>
                        @else
                        <td></td>
                        @endif
                        <td id="totaladdb">{{ number_format($employeealldetailsforpms->AppraiserFinallyFormA_Score + $employeealldetailsforpms->AppraiserFinallyFormB_Score, 2) }}</td>

                        
                        @if($data['emp']['Appform'] == 'Y')
                        <td id="rating-input">{{$employeealldetailsforpms->Appraiser_TotalFinalRating}}</td>
                        @else
                        <td></td>
                        @endif
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         @if($data['emp']['Appform'] == 'Y')
         <div class="card">
            <div class="card-header">
               <div style="float:left;width:100%;">
                  <h5 class="float-start"><b>Promotion Recommendation</b></h5>
               </div>
            </div>
            <div class="card-body table-responsive dd-flex align-items-center">
               <table class="table">
                  <thead>
                     <tr>
                        <th></th>
                        <th>Grade</th>
                        <th>Designation</th>
                        <th>Description</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td><b>Current</b></td>
                        <td><b>{{ $gradeValue->grade_name }}.</b></td>
                        <td><b>{{ $designation->designation_name }}</b></td>
                        <td><b>-</b></td>
                     </tr>
                     <tr>
                        <td><b>Appraiser</b></td>
                        <td>
                                <select style="width: 100%; background-color:#c4d9db;" id="gradeSelect">
                                    {{-- Current Grade First --}}
                                    <option value="{{ $gradeValue->id }}" 
                                        @if($employeealldetailsforpms->Appraiser_EmpGrade == $gradeValue->id) 
                                            selected 
                                        @endif>
                                        {{ $gradeValue->grade_name }}
                                    </option>

                                    {{-- Next Grade (only if it's different from current) --}}
                                    @if($nextGrade->id != $gradeValue->id)
                                        <option value="{{ $nextGrade->id }}" 
                                            @if($employeealldetailsforpms->Appraiser_EmpGrade == $nextGrade->id) 
                                                selected 
                                            @endif>
                                            {{ $nextGrade->grade_name }}
                                        </option>
                                    @endif
                                </select>
                        </td>
                            <td>
                                <select style="width: 100%; background-color:#c4d9db;" id="designationSelect">
                                    @php
                                        $designationExists = false;
                                    @endphp

                                    @foreach($availableDesignations as $designationOption)
                                        @php
                                            $allGradeIds = collect([
                                                $designationOption->GradeId, 
                                                $designationOption->GradeId_2, 
                                                $designationOption->GradeId_3, 
                                                $designationOption->GradeId_4, 
                                                $designationOption->GradeId_5
                                            ])->filter(fn($id) => $id != 0)->unique()->values();

                                            $matchesGrade = $allGradeIds->contains($gradeValue->id) || $allGradeIds->contains($nextGrade->id);
                                            $isSelected = $designationOption->DesigId == $employeealldetailsforpms->Appraiser_EmpDesignation;
                                            if ($isSelected) {
                                                $designationExists = true;
                                            }
                                        @endphp

                                        @if($matchesGrade || $isSelected)
                                            <option value="{{ $designationOption->DesigId }}"
                                                    data-grade-ids="{{ $allGradeIds->implode(',') }}"
                                                    style="white-space: nowrap;"
                                                    {{ $isSelected ? 'selected' : '' }}>
                                                {{ $designationOption->designation_name }}
                                            </option>
                                        @endif
                                    @endforeach

                                    {{-- If not in the list, show the current designation as a fallback --}}
                                    @if(!$designationExists)
                                        <option value="{{ $designation->id }}" selected>
                                            {{ $designation->designation_name }}
                                        </option>
                                    @endif
                                </select>
                            </td>

                            <!-- <td>
                            <select style="width: 100%; background-color:#c4d9db;" id="designationSelect">
                                @foreach($availableDesignations as $designationOption)
                                    @php
                                        $allGradeIds = collect([
                                            $designationOption->GradeId, 
                                            $designationOption->GradeId_2, 
                                            $designationOption->GradeId_3, 
                                            $designationOption->GradeId_4, 
                                            $designationOption->GradeId_5
                                        ])->filter(fn($id) => $id != 0)->unique()->values();

                                        $matchesGrade = $allGradeIds->contains($gradeValue->id) || $allGradeIds->contains($nextGrade->id);
                                    @endphp

                                    @if($matchesGrade || $designationOption->DesigId == $employeealldetailsforpms->Appraiser_EmpDesignation)
                                        <option value="{{ $designationOption->DesigId }}"
                                                data-grade-ids="{{ $allGradeIds->implode(',') }}"
                                                style="white-space: nowrap;"
                                                {{ $designationOption->DesigId == $employeealldetailsforpms->Appraiser_EmpDesignation ? 'selected' : '' }}>
                                            {{ $designationOption->designation_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            </td> -->
                       
                        <td>
                           <input style="min-width: 300px;" value="{{$employeealldetailsforpms->Appraiser_Justification}}"id="promdescription" type="text">
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         @endif
         <div class="card">
            <div class="card-header">
               <div style="float:left;width:100%;">
                  <h5 class="float-start"><b>Training Requirements <i>[Mention training requirement during the next appraisal cycle.]</i></b></h5>
                  <br>
                  <b>A) Soft Skills Training [Based on Behavioral parameter]</b>
               </div>
            </div>
            <div class="card-body table-responsive dd-flex align-items-center">
               <table class="table mt-2" id="training-table-a">
                  <thead>
                     <tr>
                        <th style="width:5%;">Sn.</th>
                        <th style="width:20%;">Category</th>
                        <th style="width:20%;">Topic</th>
                        <th style="width:45%;">Description</th>
                        <th style="width:10%;">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                
                  @php 
                    // Fetch Other Description for the employee (only once before the loop)
                    $employeePmsData = DB::table('hrm_employee_pms')
                        ->where('EmployeeID', $employeeDetails->EmployeeID)
                        ->where('AssessmentYear', $PmsYId)
                        ->select('Appraiser_SoftSkill_Oth_Desc')
                        ->first();  
                @endphp

                @if($softSkillsAppraisal->isNotEmpty())
                    @foreach($softSkillsAppraisal as $index => $skill)
                        <tr>
                            <td><b>{{ $index + 1 }}</b></td>

                            <!-- Category Dropdown -->
                            <td>
                                <select style="width:250px;" class="category-select">
                                    <option value="">Select Category</option>
                                    @foreach($softSkills as $category => $topics)
                                        <option value="{{ trim($category) }}" {{ trim($category) === trim($skill->Category) ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <!-- Topic Dropdown -->
                            <td>
                                <select style="width:250px; -moz-appearance:auto;" class="topic-select">
                                    <option value="">Select Topic</option>
                                    @if(isset($softSkills[$skill->Category]))
                                        @foreach($softSkills[$skill->Category] as $topicData)
                                            <option value="{{ trim($topicData->Topic) }}" {{ trim($topicData->Topic) === trim($skill->Topic) ? 'selected' : '' }}>
                                                {{ $topicData->Topic }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>

                            <!-- Description -->
                            <td class="description-cell">
                                @if(trim($skill->Category) === 'Other')
                                    {{ $employeePmsData->Appraiser_SoftSkill_Oth_Desc ?? '' }}
                                @else
                                    {{ trim($skill->Description) }}
                                @endif
                            </td>

                            <td><a href="javascript:void(0);" class="delete-row"><i class="fas fa-trash ml-2 mr-2"></i></a></td>
                            <td class="d-none"><input type="hidden" class="hidden-tid" value="{{ $skill->Tid }}"></td>
                        </tr>
                    @endforeach
                @else
                    <!-- If No Data, Show One Empty Row -->
                    <tr>
                        <td><b>1</b></td>

                        <td>
                            <select style="width:250px;" class="category-select">
                                <option value="">Select Category</option>
                                @foreach($softSkills as $category => $skills)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <select style="width:250px;" class="topic-select">
                                <option value="">Select Topic</option>
                            </select>
                        </td>

                        <td class="description-cell" id="description-cell"></td>

                        <td><a href="javascript:void(0);" class="delete-row"><i class="fas fa-trash ml-2 mr-2"></i></a></td>
                        <td class="d-none"><input type="hidden" class="hidden-tid" value=""></td>
                    </tr>
                @endif

                    </tbody>

               </table>
               <button type="button" id="add-row-a" class="btn btn-primary">Add Row</button>
            </div>
         </div>
         <div class="card">
            <div class="card-header">
               <div style="float:left;width:100%;">
                  <b>B) Functional Skills [Job related]</b>
               </div>
            </div>
            <div class="card-body table-responsive dd-flex align-items-center">
            <table class="table mt-2" id="training-table">
                  <thead>
                     <tr>
                        <th style="width:5%;">Sn.</th>
                        <th style="width:20%;">Topic</th>
                        <th style="width:60%;">Description</th>
                        <th style="width:10%;">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                  @php 
                        // Fetch Appraiser_TechSkill_Oth_Desc once
                        $employeePmsData = DB::table('hrm_employee_pms')
                            ->where('EmployeeID', $employeeDetails->EmployeeID)
                            ->where('AssessmentYear', $PmsYId)
                            ->select('Appraiser_TechSkill_Oth_Desc')
                            ->first();
                    @endphp

                    @if($functionalSkillsAppraisal->isNotEmpty())
                        @foreach($functionalSkillsAppraisal as $index => $skill)
                            <tr>
                                <td><b>{{ $index + 1 }}</b></td>

                                <!-- Topic Dropdown -->
                                <td>
                                    <select style="width:250px;" class="topic-select-selectb">
                                        <option value="">Select Topic</option>
                                        @foreach($trainings as $topic)
                                            <option value="{{ trim($topic->Topic) }}" {{ trim($topic->Topic) === trim($skill->Topic) ? 'selected' : '' }}>
                                                {{ $topic->Topic }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- Description -->
                                <td class="description-cell-selectb">
                                    @if($skill->Tid == 70)
                                        {{ $employeePmsData->Appraiser_TechSkill_Oth_Desc ?? '' }}
                                    @else
                                        {{ trim($skill->Description) }}
                                    @endif
                                </td>

                                <td><a href="javascript:void(0);" class="delete-row-b"><i class="fas fa-trash ml-2 mr-2"></i></a></td>
                                <td class="d-none"><input type="hidden" class="hidden-tid-tech" value="{{ $skill->Tid }}"></td>
                            </tr>
                        @endforeach
                    @else
    <tr>
        <td><b>1</b></td>

        <!-- Topic Dropdown -->
        <td>
            <select style="width:250px;" class="topic-select-selectb">
                <option value="">Select Topic</option>
                @foreach($trainings as $topic)
                    <option value="{{ $topic->Topic }}">{{ $topic->Topic }}</option>
                @endforeach
            </select>
        </td>

        <!-- Description (blank initially) -->
        <td class="description-cell-selectb"></td>

        <td><a href="javascript:void(0);" class="delete-row-b"><i class="fas fa-trash ml-2 mr-2"></i></a></td>
        <td class="d-none"><input type="hidden" class="hidden-tid-tech" value=""></td>
    </tr>
@endif

                    </tbody>

               </table>
               <button type="button" id="add-row" class="btn btn-primary">Add Row</button>
            </div>
         </div>
         <div class="card">
            <div class="card-header">
               <div style="float:left;width:100%;">
                  <b>Remaks</b>
               </div>
            </div>
            <div class="card-body table-responsive dd-flex align-items-center">
               <input id="appreamrks" value="{{$employeealldetailsforpms->Appraiser_Remark}}" class="form-control" Type="text" />
            </div>
         </div>
      </div>
   </div>
   </div>
   <div class="card-footer">
   @if($employeealldetailsforpms->Appraiser_PmsStatus != 2)
  <div class="d-flex align-items-center" style="gap: 15px; margin-top: 10px;">
    <div>
      <button type="button" id="save-button" class="btn btn-primary">Save</button>
      <button type="submit" id="submit-button" class="btn btn-success">Submit</button>
    </div>
    <div style="color: #dc3545; font-weight: 600;">
      <b>Before final submission ,check all the ratings and remarks</b>
    </div>
  </div>
@endif

      <!-- @if($employeealldetailsforpms->Appraiser_PmsStatus != 2)
      <button type="button" id="save-button" class="btn btn-primary">Save</button>
      <button type="submit" id="submit-button" class="btn btn-success">Submit</button>
    @else
    @endif -->
   </div>
   <!--KRA View Details-->
   <div class="modal fade show" id="viewdetailskra" tabindex="-1"
      aria-labelledby="exampleModalCenterTitle" style="display: none;" data-bs-backdrop="static" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalCenterTitle3">KRA view details</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true" onclick="window.location.reload();">×</span>
               </button>
            </div>
            <div class="modal-body">
               <b>Logic: Logic 01</b><br>
               <b>KRA:</b>There are many variations of passages of Lorem Ipsum available, but the majority have
               suffered.<br>
               <b>Description:</b> twst
               <table class="table table-pad" id="mykraeditbox">
               </table>
            </div>
            <div class="modal-footer">
               <button type="button" class="effect-btn btn btn-light squer-btn sm-btn "
                  data-bs-dismiss="modal" onclick="window.location.reload();">Close</button>
            </div>
         </div>
      </div>
   </div>
   <script src="{{asset('../js/jquery.min.js')}}"></script>
   <script src="{{asset('../js/popper.min.js')}}"></script>
   <script src="{{asset('../js/bootstrap.min.js')}}"></script>
   <script src="{{asset('../js/swiper.min.js')}}"></script>
   <!-- Page Specific -->
   <script src="{{asset('../js/nice-select.min.js')}}"></script>
   <!-- Custom Script -->
   <script src="{{asset('../js/calendar.min.js')}}"></script>
   <script src="{{asset('../js/custom.js')}}"></script>
   <!-- Bootstrap JS and dependencies (including Popper.js) -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
   <script src="https://d3js.org/d3.v7.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <!-- Toastr JS -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   <script>
            function showKraDetailsappraisal(id, period, target, weightage, logic, year_id,empappraisal) {
                let isSubKra = id.startsWith("sub_"); // Check if it's a Sub-KRA
      
            let requestData = {
                kraId: isSubKra ? null : id,  
                subKraId: isSubKra ? id.replace("sub_", "") : null,  // Remove "sub_" to get only the numeric ID
                year_id: year_id,
                empappraisal:empappraisal
            };
      
            // Show modal with loader before fetching data
            $("#viewdetailskra .modal-body").html(`
                    <div id="kraLoader" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p>Fetching details, please wait...</p>
                    </div>
                    <div id="kraContent" style="display:none;"></div> <!-- Hidden Content -->
                `);
            $("#viewdetailskra").modal("show"); // Show modal immediately
      
            // Fetch data in the background
            $.ajax({
                url: "{{ route('kra.details') }}",
                type: "GET",
                data: requestData,
                success: function(response) {
                    if (response.success) {
                        let kraData = response.kraData;
                        let subKraData = response.subKraData;
                        let subKraDatamain = response.subKraDatamain;
                        let pmsData = response.pmsData;
      
                        console.log(kraData);
      
                        let contentHtml = ""; // Placeholder for final content
      
                        if (subKraData) {
                            const logic = subKraData.Logic ;
                            console.log(logic);
      
                            contentHtml = `
                    <p><strong>Logic:</strong> ${subKraData.Logic}</p>
                    <p><strong>KRA:</strong> ${subKraData.KRA}</p>
                    <p><strong>KRA Description:</strong> ${subKraData.KRA_Description}</p>
                    <table class="table table-pad" id="mykraeditbox">
                        <thead>
                            <tr style="text-align:center;">
                                                <th></th>
                                                <th>SN.</th>
      					<th>Quarter</th>
      					<th>Weightage</th>
      					<th>Target</th>
      					<th style="width:215px;">Comments</th>
      					<th>Self rating</th>
      					<th style="width:300px;">Rating details</th>
      					<th>Score</th>
      					<th>Reporting rating</th>
      					<th>Reporting remarks</th>
      					<th>Reporting score</th>
      					<th>Action</th>
                                                        <th></th>
      
                            </tr>
                           
                        </thead>
                        <tbody id="kraRows">
                            ${generateKraRowsAppraisal(kraData, subKraData,subKraDatamain,logic,pmsData,period)}
                        </tbody>
                    </table>
                `;
                        } else {
                            const logic = subKraDatamain.Logic ;
                            console.log(logic);
      
                            contentHtml = `
                    <p><strong>Logic:</strong> ${subKraDatamain.Logic}</p>
                    <p><strong>KRA:</strong> ${subKraDatamain.KRA}</p>
                    <p><strong>KRA Description:</strong> ${subKraDatamain.KRA_Description}</p>
                    <table class="table table-pad" id="mykraeditbox">
                        <thead>
                            <tr style="text-align:center;">
                                                    <th></th>
                                                        <th>SN.</th>
      					<th>Quarter</th>
      					<th>Weightage</th>
      					<th>Target</th>
      					<th style="width:215px;">Comments</th>
      					<th>Self rating</th>
      					<th style="width:300px;">Rating details</th>
      					<th>Score</th>
      					<th>Reporting rating</th>
      					<th>Reporting remarks</th>
      					<th>Reporting score</th>
      					<th>Action</th>
                                                        <th></th>
                            </tr>
                            
                        </thead>
                        <tbody id="kraRows">
                            ${generateKraRowsAppraisal(kraData, null, subKraDatamain, logic,pmsData,period)}
                        </tbody>
                    </table>
                `;
                        }
      
                        contentHtml += `
                <div class="float-end">
                    <i class="fas fa-check-circle mr-2 text-success"></i> Final Submit, 
                    <i class="ri-check-double-line mr-1 text-success"></i> Save as Draft
                </div>
                <p><b>Note:</b><br> 
                    1. Please ensure that the achievement is calculated against the "<b>Target Value</b>" only.<br>
                    2. The achievement is required to be entered on the last day or within a few days, beyond which the KRA will be auto-locked.
                </p>
            `;
      
                        // Insert content but keep loader
                        $("#kraContent").html(contentHtml);
      
                        // Wait until generateKraRows is done, then show content & hide loader
                        setTimeout(() => {
                            $("#kraLoader").hide(); // Hide loader
                            $("#kraContent").fadeIn(); // Show content
                        }, 300); // Small delay to ensure rows are ready
                    } else {
                        $("#viewdetailskra .modal-body").html(`<p class="text-center text-danger">No data found!</p>`);
                    }
                },
                error: function() {
                    $("#viewdetailskra .modal-body").html(`<p class="text-center text-danger">An error occurred while fetching KRA details.</p>`);
                }
            });
        }
      
      
        function generateKraRowsAppraisal(kraData, subKraData = null, subKraDatamain = null,logic,pmsData,period) {
            
            let rows = '';
            let totalWeight = 0;
            let totalscremp= 0;
      
            const currentDate = new Date(); // Get the current date
                const currentYear = currentDate.getFullYear();
                const currentMonth = currentDate.getMonth() + 1; // JS months are 0-based, so +1
                let Mnt_cal = 13 - currentMonth; // Equivalent of PHP's `$Mnt_cal`
      
            kraData.forEach((detail, index) => {
            totalWeight += parseFloat(detail.Wgt) || 0; // Use parseFloat to ensure it's a number
            totalscremp += parseFloat(detail.Scor) || 0; // Use parseFloat to ensure it's a number
      
            totalWeight = parseFloat(totalWeight.toFixed(2));
            totalscremp = parseFloat(totalscremp.toFixed(2));
      
      
            let lDate = new Date(detail.Ldate);
      
                // Check if Ldate is within the current date range
                let isWithinDateRange = lDate >= currentDate;
                let next10Day = new Date(lDate);
                    next10Day.setDate(lDate.getDate() + 10); // Add 10 days to Ldate
                    
                    let next14Day = new Date(lDate);
                    next14Day.setDate(lDate.getDate() + 14); // Add 14 days to Ldate
      
                let weight = detail.Wgt; // Get weight from the detail object
                let savestatus =detail.app_savestatus;
                let submitstatus =detail.app_submitstatus;
      
                let lockk = detail.lockk;
      
                    let Applockk  = detail.Applockk;
                    let appRevert = detail.AppRevert;
                    let AppCmnt = detail.AppCmnt;
                    let AppAch = detail.AppAch;
      
                    let tgtDefId = detail.TgtDefId;
      
                        // Calculate PerM value
                    let PerM = 0;
      
                    if (period === 'Monthly') {
                        let lm = index + 1;
                        PerM = Mnt_cal >= (13 - lm) ? 1 : 0;
                    } 
                    else if (period === 'Quarter') {
                        let quarterMappings = [
                            { name: 'Quarter 1', endMonth: 3, startRange: [10, 12] },
                            { name: 'Quarter 2', endMonth: 6, startRange: [7, 12] },
                            { name: 'Quarter 3', endMonth: 9, startRange: [4, 12] },
                            { name: 'Quarter 4', endMonth: 12, startRange: [1, 12] }
                        ];
                        let quarter = quarterMappings.find(q => currentMonth <= q.endMonth);
                        PerM = (quarter && Mnt_cal >= quarter.startRange[0] && Mnt_cal <= quarter.startRange[1]) ? 1 : 0;
                    } 
                    else if (period === '1/2 Annual') {
                        let halfYearMappings = [
                            { name: 'Half Year 1', endMonth: 6, startRange: [7, 12] },
                            { name: 'Half Year 2', endMonth: 12, startRange: [1, 12] }
                        ];
                        let halfYear = halfYearMappings.find(h => currentMonth <= h.endMonth);
                        PerM = (halfYear && Mnt_cal >= halfYear.startRange[0] && Mnt_cal <= halfYear.startRange[1]) ? 1 : 0;
                    }
                    
      
                    let showEdit = (parseInt(PerM) === 1 ||
                                ((parseInt(Applockk) === 0 && currentDate <= next14Day) ||
                                (parseInt(AppAch) === 0 && parseInt(AppAch) === '')|| AppCmnt === ''));
        
                    let allowEdit = showEdit && submitstatus !== 1;
      
      
                    // Define readonly or editable mode based on date range
                    let isReadonly = !isWithinDateRange;
      
                            rows += `
                                <tr>
                                    <td id="applogscore${index}" style="display:none">${detail.AppLogScr}<td>
                                    <input type="hidden" class="tgt-id" value="${detail.TgtDefId }" id="tgt-id-${index}">
      
                                    <td><b>${index + 1}</b></td>
                                    <td>${detail.Tital}</td>
                                    <td style="text-align:center;">${weight}</td>
                                    <td style="text-align:center;">100</td>
                                    <td>${detail.Remark}</td>
                                    <td>${detail.Ach}</td>
                                    <td>${detail.Cmnt}
                                    </td>
                                    <td id="score${index}">${detail.Scor}</td>
                                    <td style="background-color: #e7ebed;">
                                            <input class="form-control self-rating-app" style="width: 60px;" type="number" placeholder="Enter rating"  id="appselfrating${index}"
                                        value="${detail.AppAch}" data-target="${detail.Tgt}" data-index="${index}"data-logic="${logic}" 
                                        data-weight="${detail.Wgt}"
                                            readonly>
                                    </td>
                                    <td style="background-color: #e7ebed;">
                                        <textarea class="form-control self-remark-app" required style="min-width: 200px;min-height:70px;" data-index="${index}"
                                        placeholder="Enter your remark" id="appselfremark${index}"	readonly>${detail.AppCmnt}</textarea>
      
                                    </td>
                                    <td id="appscore${index}" style="background-color: #e7ebed;text-align:center;">${detail.AppScor}</td>
                                        <td>
                                            ${allowEdit ? 
                                            `<a title="Edit" class="fas fa-edit text-info mr-2" onclick="enableEditMode(this, ${index})"></a>` 
                                            : ''
                                            }
                                            
                                        <span class="edit-buttons" style="display: none;">
                                    <a title="Save" href="javascript:void(0);" onclick="saveRowData(${index}, '${tgtDefId}','save')">
                                        <i style="font-size:14px;" class="ri-save-3-line text-success mr-2"></i>
                                    </a>
                                    <a href="javascript:void(0);" style="padding: 2px 7px;font-size: 11px;" onclick="saveRowData(${index}, '${tgtDefId}','submit')"
                                        class="btn btn-outline-success waves-effect waves-light material-shadow-none" title="Submit">
                                        <i style="font-size:14px;" class="ri-check-line"></i>
                                    </a>
                                </span>
                        </td>
                            <td>${savestatus === 1 ? 
                                `<a title="save" href=""><i style="font-size:14px;" class="ri-check-double-line mr-2 text-success"></i></a>` 
                                : ''}
      
                            ${submitstatus === 1 ? 
                                `<a title="Submit"><i style="font-size:14px;" class="fas fa-check-circle mr-2 text-success"></i></a>` 
                                : ''}
                            </td>
                            `;
                        });
                        // Add row for Sub-KRA (Total) if available
                        if (subKraData && !kraData) {
                            rows += `
                                <tr>
                                    <td></td>
                                    <td colspan="2"><b>Total</b></td>
                                    <td style="text-align:center;">${totalWeight}</td>
                                    <td colspan="4"></td>
                                    <td style="text-align:center;">${totalscremp}</td>
                                    <td colspan="7"></td>
                                </tr>
                            `;
                        }
                        if (kraData && !subKraData) {
      
                            rows += `
                                <tr>
                                    <td></td>
                                    <td colspan="2"><b>Total</b></td>
                                    <td style="text-align:center;">${totalWeight}</td>
                                    <td colspan="4"></td>
                                    <td style="text-align:center;">${totalscremp}</td>
                                    <td colspan="7"></td>
                                </tr>
                            `;
                        }
                        if (subKraDatamain && !kraData) {
      
                            rows += `
                                <tr>
                                    <td></td>
                                    <td colspan="2"><b>Total</b></td>
                                    <td style="text-align:center;">${totalWeight}</td>
                                    <td colspan="4"></td>
                                    <td style="text-align:center;">${totalscremp}</td>
                                    <td colspan="7"></td>
                                </tr>
                            `;
                        }
                        if (!subKraDatamain && kraData) {
      
                        rows += `
                            <tr>
                                    <td></td>
                                <td colspan="2"><b>Total</b></td>
                                <td style="text-align:center;">${totalWeight}</td>
                                    <td colspan="4"></td>
                                    <td style="text-align:center;">${totalscremp}</td>
                                <td colspan="7"></td>
                            </tr>
                        `;
                        }
                        return rows;
        }
        function enableEditMode(editLink, index) {
                // Get the row of the clicked edit link
                const row = editLink.closest('tr');
      
                // Find the input and textarea elements in the row
                const inputField = row.querySelector('input[type="number"]');
                const textareaField = row.querySelector('textarea');
                const editButtons = row.querySelector('.edit-buttons');
      
                // Toggle the readonly attribute
                if (inputField && textareaField) {
                const isReadonly = inputField.hasAttribute('readonly');
                if (isReadonly) {
                    inputField.removeAttribute('readonly');
                    textareaField.removeAttribute('readonly');
                    editButtons.style.display = 'inline'; // Show Save and Submit buttons
                    editLink.style.display = 'none'; // Hide Edit button
                } else {
                    inputField.setAttribute('readonly', true);
                    textareaField.setAttribute('readonly', true);
                    editButtons.style.display = 'none'; // Hide Save and Submit buttons
                    editLink.style.display = 'inline'; // Show Edit button
                }
                }
            }
            $(document).on('input', '.self-remark-app', function() {
                let selfremark =$(this).val()|| ''; // Get the self-rating value, default to 0 if empty
                console.log(selfremark);
                let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
      
                $('#appselfremark' + index).text(selfremark); // Update only the respective row's score cell
            });
            // Real-time calculation function for score
            $(document).on('input', '.self-rating-app', function() {
                let selfRating = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
                var ach=Math.round(((target*selfRating)/100)*100)/100; //var ach=parseFloat(v);  
                $('#appselfrating' + index).text(selfRating); // Update only the respective row's score cell
      
                if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#applogscore' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#applogscore' + index).text(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell


                    } 
                    else if (logic === 'Logic2') {
                        let EScore;
                        if (ach <= target) {
                            EScore = ach;
                            $('#applogscore' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            EScore = target;
                            $('#applogscore' + index).text(target); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell



                    }
                    else if (logic === 'Logic2a') {
                        let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        let Per110 = Math.round((target + Per10) * 100) / 100;
                        let EScore;
                        if (ach >= Per110) {
                            EScore = Per110;
                            $('#applogscore' + index).text(Per110); // Update only the respective row's score cell

                        } else {
                            EScore = ach;
                            $('#applogscore' + index).text(ach); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell


                    }
                    else if (logic === 'Logic3') {
                        let EScore;
                            if (ach === target) {
                                EScore = ach;
                                $('#applogscore' + index).text(ach); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#applogscore' + index).text('0'); // Update only the respective row's score cell

                            }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }
                
                    if (logic === 'Logic4') {
                        // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                        let EScore;
                        if (ach >= target) {
                            EScore = target;
                            $('#applogscore' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#applogscore' + index).text('0'); // Update only the respective row's score cell

                        }

                        MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell\


                    }
                    else if (logic === 'Logic5') {
                        let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        let Per70 = Math.round((target - Per30) * 100) / 100;
                        let EScore = 0;
                        if (ach >= Per70 && ach < target) {
                            EScore = ach;
                            $('#applogscore' + index).text(ach); // Update only the respective row's score cell

                        } else if (ach >= target) {
                            EScore = target;
                            $('#applogscore' + index).text(target); // Update only the respective row's score cell

                        }
                        else{
                            EScore = 0;
                            $('#applogscore' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }
                    if (logic === 'Logic6a') {
                        // Logic6a Logic
                            if (target == 8.33) {
                                ach = ach * 12;
                            } else if (target == 25) {
                                ach = ach * 4;
                            } else if (target == 50) {
                                ach = ach * 2;
                            }
                            else{
                                ach=ach;
                            }
                            
                            let Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                            let Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                            if (ach <= 15) {
                                EScore = target;
                                $('#applogscore' + index).text(target); // Update only the respective row's score cell

                            } else if (ach > 15 && ach <= 20) {
                                EScore = Per80;
                                $('#applogscore' + index).text(Per80); // Update only the respective row's score cell

                            } else if (ach > 20 && ach <= 25) {
                                EScore = Per50;
                                $('#applogscore' + index).text(Per50); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#applogscore' + index).text('0'); // Update only the respective row's score cell
                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                            $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                            

                    }
                    else if (logic === 'Logic6b') {
                        // Logic6B Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }
                        else{
                            ach=ach;
                        }

                        if (ach < 5) {
                            EScore = target;
                            $('#applogscore' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#applogscore' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }
                    else if (logic === 'Logic6') {
                        // Logic6 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }
                        else{
                            ach=ach;
                        }

                        let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                        let Per125 = Math.round(((target * 125) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per85 = Math.round(((target * 85) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        let PerAct = Math.round(((target * ach) / 100) * 100) / 100;
                        let ScoAct = Math.round((target - PerAct) * 100) / 100;

                        if (ach <= 10) {
                            EScore = Per150;
                            $('#applogscore' + index).text(Per150);

                        } else if (ach > 10 && ach <= 15) {
                            EScore = Per125;
                            $('#applogscore' + index).text(Per125);

                        } else if (ach > 15 && ach <= 20) {
                            EScore = Per100;
                            $('#applogscore' + index).text(Per100);

                        } else if (ach > 20 && ach <= 25) {
                            EScore = Per85;
                            $('#applogscore' + index).text(Per85);

                        } else if (ach > 25 && ach <= 30) {
                            EScore = Per75;
                            $('#applogscore' + index).text(Per75);

                        } 
                        else {
                            EScore = 0;
                            $('#applogscore' + index).text('0');
                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }
                    else if (logic === 'Logic7') {
                        // Logic7 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }

                        let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per90 = Math.round(((target * 90) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;

                        if (ach == 0) {
                            EScore = Per150;
                            $('#applogscore' + index).text(Per150);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#applogscore' + index).text(Per100);

                        } else if (ach > 2 && ach <= 5) {
                            EScore = Per90;
                            $('#applogscore' + index).text(Per90);

                        } else if (ach > 5 && ach <= 10) {
                            EScore = Per75;
                            $('#applogscore' + index).text(Per75);

                        } else {
                            EScore = 0;
                            $('#applogscore' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }
                    else if (logic === 'Logic7a') {
                        // Logic7 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }

                        let Per120 = Math.round(((target * 120) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        let Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach == 0) {
                            EScore = Per120;
                            $('#applogscore' + index).text(Per120);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#applogscore' + index).text(Per100);

                        } else if (ach > 2 && ach <= 3) {
                            EScore = Per75;
                            $('#applogscore' + index).text(Per75);

                        } else if (ach > 3 && ach <= 4) {
                            EScore = Per50;
                            $('#applogscore' + index).text(Per50);

                        } else {
                            EScore = 0;
                            $('#applogscore' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }
                    else if (logic === 'Logic8a' || logic === 'Logic8b' || logic === 'Logic8c' || logic === 'Logic8d' || logic === 'Logic8e') {
                        // Logic8 variations
                        let Percent = 0;
                        if (logic === 'Logic8a') {
                            Percent = ((ach / target) * 115) / 100;
                        } else if (logic === 'Logic8b') {
                            Percent = ((ach / target) * 100) / 100;
                        } else if (logic === 'Logic8c') {
                            Percent = ((ach / target) * 90) / 100;
                        } else if (logic === 'Logic8d') {
                            Percent = ((ach / target) * 65) / 100;
                        } else if (logic === 'Logic8e') {
                            Percent = ((ach / target) * (-100)) / 100;
                        }

                        MScore = Math.round((Percent * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }
                    // Logic9
                    else if (logic === 'Logic9') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        if (ach < Per90) {
                            var EScore = ach;
                            $('#applogscore' + index).text(ach);

                        } else if (ach >= Per90) {
                            var EScore = target;
                            $('#applogscore' + index).text(target);

                        } else {
                            var EScore = applogscore = 0;
                            $('#applogscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }

                    // Logic10
                    else if (logic === 'Logic10') {
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100; 
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100; 
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100; 
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                        var Per6 = Math.round(((target * 6) / 100) * 100) / 100; 
                        var Per7 = Math.round(((target * 7) / 100) * 100) / 100; 
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                        var Per90 = Math.round((target - Per10) * 100) / 100; 
                        var Per91 = Math.round((Per90 + Per1) * 100) / 100;
                        var Per93 = Math.round((Per90 + Per3) * 100) / 100; 
                        var Per94 = Math.round((target - Per6) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100; 
                        var Per98 = Math.round((target - Per2) * 100) / 100; 
                        var Per105 = Math.round((target + Per5) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        var Per120 = Math.round((target + Per20) * 100) / 100;

                        if (ach < Per90) {
                            var EScore = 0;
                            $('#applogscore' + index).text('0');

                        } else if (ach == Per90) {
                            var EScore = target;
                            $('#applogscore' + index).text(target);

                        } else if (ach > Per90 && ach <= Per93) {
                            var EScore = Per105;
                            $('#applogscore' + index).text(Per105);

                        } else if (ach > Per93 && ach <= Per97) {
                            var EScore = Per110;
                            $('#applogscore' + index).text(Per110);

                        } else if (ach > Per97) {
                            var EScore = Per120;
                            $('#applogscore' + index).text(Per120);

                        } else {
                            var EScore = 0;
                            $('#applogscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }

                    // Logic11
                    else if (logic === 'Logic11') {
                        var EScore = ach;
                        $('#applogscore' + index).text(ach);

                        var MScore = Math.round(((target / EScore) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }

                    // Logic12
                    else if (logic === 'Logic12') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;

                        if (ach < Per90) {
                            var EScore = 0;
                            $('#applogscore' + index).text('0');

                        }  else if (ach >= Per90 && ach<=Per110) {
                            var EScore = ach;
                            $('#applogscore' + index).text(ach);

                        } else if (ach > Per110) {
                            var EScore = Per110;
                            $('#applogscore' + index).text(Per110);
                        }
                        
                        else {
                            var EScore = 0;
                            $('#applogscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }

                    // Logic13a
                    else if (logic === 'Logic13a') {
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                        var Per130 = Math.round((target + Per30) * 100) / 100;
                        var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                        var Per121 = Math.round((target + Per21) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per120 = Math.round((target + Per20) * 100) / 100;
                        var Per11 = Math.round(((target * 11) / 100) * 100) / 100; 
                        var Per111 = Math.round((target + Per11) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        var Per9 = Math.round(((target * 9) / 100) * 100) / 100;   
                        var Per91 = Math.round((target - Per9) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per80 = Math.round((target - Per20) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per70 = Math.round((target - Per30) * 100) / 100;  

                        if (ach <= Per80) {
                            var EScore = Per80;
                            $('#applogscore' + index).text(Per80);

                        } else if (ach >= Per80 && ach <= Per90) {
                            var EScore = Per90;
                            $('#applogscore' + index).text(Per90);

                        } else if (ach >= Per90 && ach <= Per110) {
                            var EScore = target;
                            $('#applogscore' + index).text(target);

                        } else if (ach >= Per110 && ach <= Per120) {
                            var EScore = Per80;
                            $('#applogscore' + index).text(Per80);

                        } else if (ach >= Per120) {
                            var EScore = Per70;
                            $('#applogscore' + index).text(Per70);

                        } else {
                            var EScore = applogscore = 0;
                            $('#applogscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;  
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }

                    // Logic13b
                    else if (logic === 'Logic13b') {
                        var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                        var Per140 = Math.round((target + Per40) * 100) / 100;
                        var Per31 = Math.round(((target * 31) / 100) * 100) / 100; 
                        var Per131 = Math.round((target + Per31) * 100) / 100;
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                        var Per130 = Math.round((target + Per30) * 100) / 100;
                        var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                        var Per121 = Math.round((target + Per21) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per120 = Math.round((target + Per20) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per70 = Math.round((target - Per30) * 100) / 100; 
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per29 = Math.round(((target * 29) / 100) * 100) / 100; 
                        var Per71 = Math.round((target - Per29) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;  

                        if (ach <= Per70) {
                            var EScore = Per70;
                            $('#applogscore' + index).text(Per70);

                        } else if (ach >= Per70 && ach <= Per80) {
                            var EScore = Per90;
                            $('#applogscore' + index).text(Per90);

                        } else if (ach >= Per80 && ach <= Per120) {
                            var EScore = target;
                            $('#applogscore' + index).text(target);

                        } else if (ach >= Per120 && ach <= Per130) {
                            var EScore = Per80;
                            $('#applogscore' + index).text(Per80);

                        } else if (ach >= Per130) {
                            var EScore = Per70;
                            $('#applogscore' + index).text(Per70);

                        } else {
                            var EScore = 0;
                            $('#applogscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }

                    // Logic14a
                    else if (logic === 'Logic14a') {
                        var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                        var Per91 = Math.round((target - Per9) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                        var Per86 = Math.round((target - Per14) * 100) / 100;
                        var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                        var Per85 = Math.round((target - Per15) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per24 = Math.round(((target * 24) / 100) * 100) / 100; 
                        var Per76 = Math.round((target - Per24) * 100) / 100;
                        var Per25 = Math.round(((target * 25) / 100) * 100) / 100; 
                        var Per75 = Math.round((target - Per25) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;

                        if (ach <= Per75) {
                            var EScore = 0;
                            $('#applogscore' + index).text('0');
                        } else if (ach >= Per75 && ach <= Per80) {
                            var EScore = Per80;
                            $('#applogscore' + index).text(Per80);

                        } else if (ach >= Per80 && ach <= Per85) {
                            var EScore = Per90;
                            $('#applogscore' + index).text(Per90);

                        } else if (ach >= Per85 && ach <= Per90) {
                            var EScore = target;
                            $('#applogscore' + index).text(target);

                        } else if (ach >= Per90) {
                            var EScore = Per110;
                            $('#applogscore' + index).text(Per110);

                        } else {
                            var EScore = applogscore = 0;
                            $('#applogscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }

                    else if (logic === 'Logic14b') {
                        var Per4 = Math.round(((target * 4) / 100) * 100) / 100; 
                        var Per96 = Math.round((target - Per4) * 100) / 100;
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                        var Per95 = Math.round((target - Per5) * 100) / 100;
                        var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                        var Per91 = Math.round((target - Per9) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                        var Per86 = Math.round((target - Per14) * 100) / 100;
                        var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                        var Per85 = Math.round((target - Per15) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                        var Per60 = Math.round((target - Per40) * 100) / 100;

                        if (ach <= Per80) {
                            var EScore = 0;
                            $('#applogscore' + index).text('0');

                        } else if (ach > Per80 && ach <= Per85) {
                            var EScore = Per60;
                            $('#applogscore' + index).text(Per60);

                        } else if (ach > Per85 && ach <= Per90) {
                            var EScore = Per90;
                            $('#applogscore' + index).text(Per90);

                        } else if (ach > Per90 && ach <= Per95) {
                            var EScore = target;
                            $('#applogscore' + index).text(target);

                        } else if (ach >= Per96) {
                            var EScore = Per110;
                            $('#applogscore' + index).text(Per110);

                        } else {
                            var EScore = 0;
                            $('#applogscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }
                    else if (logic === 'Logic15a') {
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                        var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                        var Per98 = Math.round((target - Per2) * 100) / 100;
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100;
                        var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                        var Per96 = Math.round((target - Per4) * 100) / 100;
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100;
                        var Per95 = Math.round((target - Per5) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                        var Per40=Math.round(((target*40)/100)*100)/100; 
                        var Per60 = Math.round((target - Per40) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        
                        var EScore = 0;
                        if (ach < Per96) {
                            EScore = 0;
                            $('#applogscore' + index).text('0');

                        } else if (ach >= Per96 && ach < Per97) {
                            EScore = Per50;
                            $('#applogscore' + index).text(Per50);

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per60;
                            $('#applogscore' + index).text(Per60);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = Per90;
                            $('#applogscore' + index).text(Per90);

                        } else if (ach >= Per99) {
                            EScore = target;
                            $('#applogscore' + index).text(target);

                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2));

                    } 
                    else if (logic === 'Logic15b') {
                        var Per05 = Math.round(((target * 0.5) / 100) * 100) / 100;
                        var Per995 = Math.round((target - Per05) * 100) / 100;
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                        var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                        var Per98 = Math.round((target - Per2) * 100) / 100;
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100;
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        var Per70 = Math.round((target - Per30) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        
                        var EScore = 0;
                        if (ach < Per97) {
                            EScore = 0;
                            $('#applogscore' + index).text('0');

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per70;
                            $('#applogscore' + index).text(Per70);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = Per90;
                            $('#applogscore' + index).text(Per90);

                        } else if (ach >= Per99 && ach < Per995) {
                            EScore = target;
                            $('#applogscore' + index).text(target);

                        } else if (ach >= Per995) {
                            EScore = Per110;
                            $('#applogscore' + index).text(Per110);

                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2));

                    }    
                    else if (logic === 'Logic15c') {
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                        var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                        var Per98 = Math.round((target - Per2) * 100) / 100;
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100;
                        var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                        var Per96 = Math.round((target - Per4) * 100) / 100;
                        var Per40 = Math.round(((target * 40) / 100) * 100) / 100;
                        var Per60 = Math.round((target - Per40) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        
                        var EScore = 0;
                        if (ach < Per96) {
                            EScore = 0;
                            $('#applogscore' + index).text('0');

                        } else if (ach >= Per96 && ach < Per97) {
                            EScore = Per60;
                            $('#applogscore' + index).text(Per60);

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per80;
                            $('#applogscore' + index).text(Per80);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = target;
                            $('#applogscore' + index).text(target);

                        } else if (ach >= Per99) {
                            EScore = Per110;
                            $('#applogscore' + index).text(Per110);
                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2));
                    }
                    else if (logic === 'Logic16') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per6 = Math.round(((target * 6) / 100) * 100) / 100; var Per94 = Math.round((target - Per6) * 100) / 100;
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100; var Per95 = Math.round((target - Per5) * 100) / 100;
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100; var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per105 = Math.round((target + Per5) * 100) / 100; var Per106 = Math.round((target + Per6) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100; var Per111 = Math.round((target + Per10 + Per1) * 100) / 100;
                        var Per115 = Math.round((target + Per10 + Per5) * 100) / 100;

                        if (ach >= Per90 && ach <= Per94) { 
                            var EScore = Per110; 
                            $('#applogscore' + index).text(Per110);

                        }
                        else if (ach >= Per95 && ach <= Per99) { 
                            var EScore = Per105; 
                            $('#applogscore' + index).text(Per105);

                        }
                        else if (ach >= target && ach <= Per105) { 
                            var EScore = target; 
                            $('#applogscore' + index).text(target);

                        }
                        else if (ach >= Per105 && ach <= Per110) {
                            var EScore = Per95; 
                            $('#applogscore' + index).text(Per95);

                        }
                        else if (ach >= Per110) { 
                            var EScore = Per90; 
                            $('#applogscore' + index).text(Per90);

                        }
                        else {
                             var EScore = 0; 
                             $('#applogscore' + index).text('0');

                            }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                    else if (logic === 'Logic17') {
                        var Per15 = Math.round(((target * 15) / 100) * 100) / 100;
                        var Per16 = Math.round(((target * 16) / 100) * 100) / 100;
                        var Per22 = Math.round(((target * 22) / 100) * 100) / 100;
                        var Per23 = Math.round(((target * 23) / 100) * 100) / 100;
                        var Per29 = Math.round(((target * 29) / 100) * 100) / 100;
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        var Per36 = Math.round(((target * 36) / 100) * 100) / 100;
                        var Per37 = Math.round(((target * 37) / 100) * 100) / 100;
                        var Per42 = Math.round(((target * 42) / 100) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                        var Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per90 = Math.round(((target * 90) / 100) * 100) / 100;

                        if (ach <= Per15) { 
                            var EScore = target; 
                            $('#applogscore' + index).text(target);

                        }
                        else if (ach > Per15 && ach <= Per22) {
                             var EScore = Per90;
                            $('#applogscore' + index).text(Per90);

                             }
                        else if (ach > Per22 && ach <= Per29) { 
                            var EScore = Per80; 
                            $('#applogscore' + index).text(Per80);

                        }
                        else if (ach > Per29 && ach <= Per36) {
                             var EScore = Per75; 
                             $('#applogscore' + index).text(Per75);

                            }
                        else if (ach > Per36 && ach <= Per42) { 
                            var EScore = Per50; 
                            $('#applogscore' + index).text(Per50);


                        }
                        else if (ach > Per42) { 
                            var EScore = 0; 
                            $('#applogscore' + index).text('0');

                        }
                        else { var EScore = 0; 
                            $('#applogscore' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                    else if (logic === 'Logic18') {
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                        var Per60 = Math.round(((target * 60) / 100) * 100) / 100;
                        var Per69 = Math.round(((target * 69) / 100) * 100) / 100;
                        var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                        var Per79 = Math.round(((target * 79) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                        var Per120 = Math.round((target + Per20) * 100) / 100;
                        var Per25 = Math.round(((target * 25) / 100) * 100) / 100;
                        var Per75 = Math.round(((target * 75) / 100) * 100) / 100;

                        if (ach < Per60) { 
                            var EScore = 0;
                            $('#applogscore' + index).text('0');

                         }
                        else if (ach >= Per60 && ach <= Per69) { 
                            var EScore = Per25; 
                            $('#applogscore' + index).text(Per25);

                        }
                        else if (ach > Per69 && ach <= Per79) { 
                            var EScore = Per50;
                            $('#applogscore' + index).text(Per50);

                         }
                        else if (ach > Per79 && ach <= Per120) { 
                            var EScore = target;
                            $('#applogscore' + index).text(target);

                         }
                        else { 
                            var EScore = 0; 
                            $('#applogscore' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                    else if (logic === 'Logic19') {
                        var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach < Per70) { 
                            var EScore = 0;
                            $('#applogscore' + index).text('0');

                         }
                        else if (ach >= Per70 && ach <= Per80) { 
                            var EScore = Per50; 
                            $('#applogscore' + index).text(Per50);

                        }
                        else if (ach > Per80 && ach <= target) { 
                            var EScore = target; 
                            $('#applogscore' + index).text(target);

                        }
                        else { 
                            var EScore = 0;
                            $('#applogscore' + index).text('0');

                         }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#appscore' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
            
            });
            function saveRowData(index, tgtId, saveType) {
                    $('#loader').show(); // Show loader while saving
                    let selfRemark = $('#appselfremark' + index).val();
                    
                    // Check if selfRemark is empty
                    if (!selfRemark) {
                        // Add red border to indicate it's mandatory
                        $('#appselfremark' + index).css('border', '2px solid red');
                                                    
                        // Hide the loader and return early
                        $('#loader').hide();
                        return;
                    } else {
                        // Remove red border if it was previously added
                        $('#appselfremark' + index).css('border', '');
                    }
      
                    // Collect data from the row
                    let requestData = {
                        logscore: $('#applogscore' + index).text(),
                        tgtDefId: $('#tgt-id-' + index).val(),
                        selfRating: $('#appselfrating' + index).val(),
                        selfRemark: $('#appselfremark' + index).val(),
                        score: $('#appscore' + index).text(),
                        saveType: saveType,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                    };
      
                    console.log("Saving data:", requestData); // Debugging
      
                    $.ajax({
                        url: '/save-pms-row-app', // Laravel route
                        type: 'POST',
                        data: requestData,
                        dataType: 'json', // Ensure response is parsed as JSON
                        success: function(response) {
                            $('#loader').hide(); // Hide loader on success
                            if (response.success) {
                                if (saveType === 'save') {
                                    toastr.success(response.message, 'Success', {
                                        positionClass: "toast-top-right",
                                        timeOut: 3000
                                    });
                                } else if (saveType === 'submit') {
                                    toastr.success(response.message, 'Success', {
                                        positionClass: "toast-top-right",
                                        timeOut: 3000
                                    });
      
                                    setTimeout(function () {
                                        location.reload();
                                    }, 3000); // Reload after 3 seconds to allow the user to see the message
                                }
      
                            } else {
                                toastr.error(response.message, 'Error', {
                                    positionClass: "toast-top-right",
                                    timeOut: 3000
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#loader').hide(); // Hide loader on error
                            console.error("Save failed:", xhr.responseText);
      
                            // Display error toast
                            toastr.error('Failed to save data. Please try again.', 'Error', {
                                positionClass: "toast-top-right",
                                timeOut: 3000
                            });
                        }
                    });
            }
            //annual rating appraisal
            $(document).on('input', '.annual-rating-kra', function() {
                let annualratingkra = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                var ach=annualratingkra; 
                let weightlogic8 = parseFloat($(this).data('weight-logic8')) || 0; // Get the target value from data attribute
                let targetlogic8 = parseFloat($(this).data('target-logic8')) || 0; // Get the target value from data attribute

                let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
                    if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#logScorekra' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#logScorekra' + index).text(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updategrandscore();


                    } 
                    else if (logic === 'Logic2') {
                        let EScore;
                        if (ach <= target) {
                            EScore = ach;
                            $('#logScorekra' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            EScore = target;
                            $('#logScorekra' + index).text(target); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updategrandscore();



                    }
                    else if (logic === 'Logic2a') {
                        let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        let Per110 = Math.round((target + Per10) * 100) / 100;
                        let EScore;
                        if (ach >= Per110) {
                            EScore = Per110;
                            $('#logScorekra' + index).text(Per110); // Update only the respective row's score cell

                        } else {
                            EScore = ach;
                            $('#logScorekra' + index).text(ach); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updategrandscore();


                    }
                    else if (logic === 'Logic3') {
                        let EScore;
                            if (ach === target) {
                                EScore = ach;
                                $('#logScorekra' + index).text(ach); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logScorekra' + index).text('0'); // Update only the respective row's score cell

                            }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updategrandscore();
                        

                    }
                
                    if (logic === 'Logic4') {
                        // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                        let EScore;
                        if (ach >= target) {
                            EScore = target;
                            $('#logScorekra' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logScorekra' + index).text('0'); // Update only the respective row's score cell

                        }

                        MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell\
                        updategrandscore();


                    }
                    else if (logic === 'Logic5') {
                        let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        let Per70 = Math.round((target - Per30) * 100) / 100;
                        let EScore = 0;
                        if (ach >= Per70 && ach < target) {
                            EScore = ach;
                            $('#logScorekra' + index).text(ach); // Update only the respective row's score cell

                        } else if (ach >= target) {
                            EScore = target;
                            $('#logScorekra' + index).text(target); // Update only the respective row's score cell

                        }
                        else{
                            EScore = 0;
                            $('#logScorekra' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    if (logic === 'Logic6a') {
                        // Logic6a Logic
                            if (target == 8.33) {
                                ach = ach * 12;
                            } else if (target == 25) {
                                ach = ach * 4;
                            } else if (target == 50) {
                                ach = ach * 2;
                            }
                            else{
                                ach=ach;
                            }
                            
                            let Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                            let Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                            if (ach <= 15) {
                                EScore = target;
                                $('#logScorekra' + index).text(target); // Update only the respective row's score cell

                            } else if (ach > 15 && ach <= 20) {
                                EScore = Per80;
                                $('#logScorekra' + index).text(Per80); // Update only the respective row's score cell

                            } else if (ach > 20 && ach <= 25) {
                                EScore = Per50;
                                $('#logScorekra' + index).text(Per50); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logScorekra' + index).text('0'); // Update only the respective row's score cell
                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                            $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                    updategrandscore();


                    }
                    else if (logic === 'Logic6b') {
                        // Logic6B Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }
                        else{
                            ach=ach;
                        }

                        if (ach < 5) {
                            EScore = target;
                            $('#logScorekra' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logScorekra' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    else if (logic === 'Logic6') {
                        // Logic6 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }
                        else{
                            ach=ach;
                        }

                        let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                        let Per125 = Math.round(((target * 125) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per85 = Math.round(((target * 85) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        let PerAct = Math.round(((target * ach) / 100) * 100) / 100;
                        let ScoAct = Math.round((target - PerAct) * 100) / 100;

                        if (ach <= 10) {
                            EScore = Per150;
                            $('#logScorekra' + index).text(Per150);

                        } else if (ach > 10 && ach <= 15) {
                            EScore = Per125;
                            $('#logScorekra' + index).text(Per125);

                        } else if (ach > 15 && ach <= 20) {
                            EScore = Per100;
                            $('#logScorekra' + index).text(Per100);

                        } else if (ach > 20 && ach <= 25) {
                            EScore = Per85;
                            $('#logScorekra' + index).text(Per85);

                        } else if (ach > 25 && ach <= 30) {
                            EScore = Per75;
                            $('#logScorekra' + index).text(Per75);

                        } 
                        else {
                            EScore = 0;
                            $('#logScorekra' + index).text('0');
                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    else if (logic === 'Logic7') {
                        // Logic7 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }

                        let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per90 = Math.round(((target * 90) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;

                        if (ach == 0) {
                            EScore = Per150;
                            $('#logScorekra' + index).text(Per150);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#logScorekra' + index).text(Per100);

                        } else if (ach > 2 && ach <= 5) {
                            EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach > 5 && ach <= 10) {
                            EScore = Per75;
                            $('#logScorekra' + index).text(Per75);

                        } else {
                            EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    else if (logic === 'Logic7a') {
                        // Logic7 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }

                        let Per120 = Math.round(((target * 120) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        let Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach == 0) {
                            EScore = Per120;
                            $('#logScorekra' + index).text(Per120);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#logScorekra' + index).text(Per100);

                        } else if (ach > 2 && ach <= 3) {
                            EScore = Per75;
                            $('#logScorekra' + index).text(Per75);

                        } else if (ach > 3 && ach <= 4) {
                            EScore = Per50;
                            $('#logScorekra' + index).text(Per50);

                        } else {
                            EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    else if (logic === 'Logic8a' || logic === 'Logic8b' || logic === 'Logic8c' || logic === 'Logic8d' || logic === 'Logic8e') {
                        // Logic8 variations
                        let Percent = 0;
                        if (logic === 'Logic8a') {
                            Percent = ((ach / targetlogic8) * 115) / 100;
                        } else if (logic === 'Logic8b') {
                            Percent = ((ach / targetlogic8) * 100) / 100;
                        } else if (logic === 'Logic8c') {
                            Percent = ((ach / targetlogic8) * 70) / 100;
                        } else if (logic === 'Logic8d') {
                            Percent = ((ach / targetlogic8) * (-100)) / 100;
                        } else if (logic === 'Logic8e') {
                            Percent = ((ach / targetlogic8) * (-200)) / 100;
                        }

                        MScore = Math.round((Percent * weightlogic8) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    // Logic9
                    else if (logic === 'Logic9') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        if (ach < Per90) {
                            var EScore = ach;
                            $('#logScorekra' + index).text(ach);

                        } else if (ach >= Per90) {
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else {
                            var EScore = applogscore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic10
                    else if (logic === 'Logic10') {
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100; 
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100; 
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100; 
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                        var Per6 = Math.round(((target * 6) / 100) * 100) / 100; 
                        var Per7 = Math.round(((target * 7) / 100) * 100) / 100; 
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                        var Per90 = Math.round((target - Per10) * 100) / 100; 
                        var Per91 = Math.round((Per90 + Per1) * 100) / 100;
                        var Per93 = Math.round((Per90 + Per3) * 100) / 100; 
                        var Per94 = Math.round((target - Per6) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100; 
                        var Per98 = Math.round((target - Per2) * 100) / 100; 
                        var Per105 = Math.round((target + Per5) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        var Per120 = Math.round((target + Per20) * 100) / 100;

                        if (ach < Per90) {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                        } else if (ach == Per90) {
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else if (ach > Per90 && ach <= Per93) {
                            var EScore = Per105;
                            $('#logScorekra' + index).text(Per105);

                        } else if (ach > Per93 && ach <= Per97) {
                            var EScore = Per110;
                            $('#logScorekra' + index).text(Per110);

                        } else if (ach > Per97) {
                            var EScore = Per120;
                            $('#logScorekra' + index).text(Per120);

                        } else {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic11
                    else if (logic === 'Logic11') {
                        var EScore = ach;
                        $('#logScorekra' + index).text(ach);

                        var MScore = Math.round(((target / EScore) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic12
                    else if (logic === 'Logic12') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;

                        if (ach < Per90) {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }  else if (ach >= Per90 && ach<=Per110) {
                            var EScore = ach;
                            $('#logScorekra' + index).text(ach);

                        } else if (ach > Per110) {
                            var EScore = Per110;
                            $('#logScorekra' + index).text(Per110);
                        }
                         else {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic13a
                    else if (logic === 'Logic13a') {
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                        var Per130 = Math.round((target + Per30) * 100) / 100;
                        var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                        var Per121 = Math.round((target + Per21) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per120 = Math.round((target + Per20) * 100) / 100;
                        var Per11 = Math.round(((target * 11) / 100) * 100) / 100; 
                        var Per111 = Math.round((target + Per11) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        var Per9 = Math.round(((target * 9) / 100) * 100) / 100;   
                        var Per91 = Math.round((target - Per9) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per80 = Math.round((target - Per20) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per70 = Math.round((target - Per30) * 100) / 100;  

                        if (ach <= Per80) {
                            var EScore = Per80;
                            $('#logScorekra' + index).text(Per80);

                        } else if (ach >= Per81 && ach <= Per90) {
                            var EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach >= Per90 && ach <= Per110) {
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else if (ach >= Per110 && ach <= Per120) {
                            var EScore = Per80;
                            $('#logScorekra' + index).text(Per80);

                        } else if (ach >= Per120) {
                            var EScore = Per70;
                            $('#logScorekra' + index).text(Per70);

                        } else {
                            var EScore = applogscore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;  
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic13b
                    else if (logic === 'Logic13b') {
                        var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                        var Per140 = Math.round((target + Per40) * 100) / 100;
                        var Per31 = Math.round(((target * 31) / 100) * 100) / 100; 
                        var Per131 = Math.round((target + Per31) * 100) / 100;
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                        var Per130 = Math.round((target + Per30) * 100) / 100;
                        var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                        var Per121 = Math.round((target + Per21) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per120 = Math.round((target + Per20) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per70 = Math.round((target - Per30) * 100) / 100; 
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per29 = Math.round(((target * 29) / 100) * 100) / 100; 
                        var Per71 = Math.round((target - Per29) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;  

                        if (ach <= Per70) {
                            var EScore = Per70;
                            $('#logScorekra' + index).text(Per70);

                        } else if (ach >= Per70 && ach <= Per80) {
                            var EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach >= Per80 && ach <= Per120) {
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else if (ach >= Per120 && ach <= Per130) {
                            var EScore = Per80;
                            $('#logScorekra' + index).text(Per80);

                        } else if (ach >= Per130) {
                            var EScore = Per70;
                            $('#logScorekra' + index).text(Per70);

                        } else {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic14a
                    else if (logic === 'Logic14a') {
                        var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                        var Per91 = Math.round((target - Per9) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                        var Per86 = Math.round((target - Per14) * 100) / 100;
                        var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                        var Per85 = Math.round((target - Per15) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per24 = Math.round(((target * 24) / 100) * 100) / 100; 
                        var Per76 = Math.round((target - Per24) * 100) / 100;
                        var Per25 = Math.round(((target * 25) / 100) * 100) / 100; 
                        var Per75 = Math.round((target - Per25) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;

                        if (ach <= Per75) {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');
                        } else if (ach >= Per75 && ach <= Per80) {
                            var EScore = Per80;
                            $('#logScorekra' + index).text(Per80);

                        } else if (ach >= Per80 && ach <= Per85) {
                            var EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach >= Per85 && ach <= Per90) {
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else if (ach >= Per90) {
                            var EScore = Per110;
                            $('#logScorekra' + index).text(Per110);

                        } else {
                            var EScore = applogscore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    else if (logic === 'Logic14b') {
                        var Per4 = Math.round(((target * 4) / 100) * 100) / 100; 
                        var Per96 = Math.round((target - Per4) * 100) / 100;
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                        var Per95 = Math.round((target - Per5) * 100) / 100;
                        var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                        var Per91 = Math.round((target - Per9) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                        var Per86 = Math.round((target - Per14) * 100) / 100;
                        var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                        var Per85 = Math.round((target - Per15) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                        var Per60 = Math.round((target - Per40) * 100) / 100;

                        if (ach <= Per80) {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                        } else if (ach > Per80 && ach <= Per85) {
                            var EScore = Per60;
                            $('#logScorekra' + index).text(Per60);

                        } else if (ach > Per85 && ach <= Per90) {
                            var EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach > Per90 && ach <= Per95) {
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else if (ach >= Per96) {
                            var EScore = Per110;
                            $('#logScorekra' + index).text(Per110);

                        } else {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    else if (logic === 'Logic15a') {
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                        var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                        var Per98 = Math.round((target - Per2) * 100) / 100;
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100;
                        var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                        var Per96 = Math.round((target - Per4) * 100) / 100;
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100;
                        var Per95 = Math.round((target - Per5) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                        var Per40=Math.round(((target*40)/100)*100)/100; 
                        var Per60 = Math.round((target - Per40) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        
                        var EScore = 0;
                        if (ach < Per96) {
                            EScore = 0;
                            $('#logScorekra' + index).text('0');

                        } else if (ach >= Per96 && ach < Per97) {
                            EScore = Per50;
                            $('#logScorekra' + index).text(Per50);

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per60;
                            $('#logScorekra' + index).text(Per60);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach >= Per99) {
                            EScore = target;
                            $('#logScorekra' + index).text(target);

                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2));

                    } 
                    else if (logic === 'Logic15b') {
                        var Per05 = Math.round(((target * 0.5) / 100) * 100) / 100;
                        var Per995 = Math.round((target - Per05) * 100) / 100;
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                        var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                        var Per98 = Math.round((target - Per2) * 100) / 100;
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100;
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        var Per70 = Math.round((target - Per30) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        
                        var EScore = 0;
                        if (ach < Per97) {
                            EScore = 0;
                            $('#logScorekra' + index).text('0');

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per70;
                            $('#logScorekra' + index).text(Per70);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach >= Per99 && ach < Per995) {
                            EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else if (ach >= Per995) {
                            EScore = Per110;
                            $('#logScorekra' + index).text(Per110);

                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2));

                    }    
                    else if (logic === 'Logic15c') {
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                        var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                        var Per98 = Math.round((target - Per2) * 100) / 100;
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100;
                        var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                        var Per96 = Math.round((target - Per4) * 100) / 100;
                        var Per40 = Math.round(((target * 40) / 100) * 100) / 100;
                        var Per60 = Math.round((target - Per40) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        
                        var EScore = 0;
                        if (ach < Per96) {
                            EScore = 0;
                            $('#logScorekra' + index).text('0');

                        } else if (ach >= Per96 && ach < Per97) {
                            EScore = Per60;
                            $('#logScorekra' + index).text(Per60);

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per80;
                            $('#logScorekra' + index).text(Per80);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else if (ach >= Per99) {
                            EScore = Per110;
                            $('#logScorekra' + index).text(Per110);
                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2));
                    }
                    else if (logic === 'Logic16') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per6 = Math.round(((target * 6) / 100) * 100) / 100; var Per94 = Math.round((target - Per6) * 100) / 100;
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100; var Per95 = Math.round((target - Per5) * 100) / 100;
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100; var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per105 = Math.round((target + Per5) * 100) / 100; var Per106 = Math.round((target + Per6) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100; var Per111 = Math.round((target + Per10 + Per1) * 100) / 100;
                        var Per115 = Math.round((target + Per10 + Per5) * 100) / 100;

                        if (ach >= Per90 && ach <= Per94) { 
                            var EScore = Per110; 
                            $('#logScorekra' + index).text(Per110);

                        }
                        else if (ach >= Per95 && ach <= Per99) { 
                            var EScore = Per105; 
                            $('#logScorekra' + index).text(Per105);

                        }
                        else if (ach >= target && ach <= Per105) { 
                            var EScore = target; 
                            $('#logScorekra' + index).text(target);

                        }
                        else if (ach >= Per105 && ach <= Per110) {
                            var EScore = Per95; 
                            $('#logScorekra' + index).text(Per95);

                        }
                        else if (ach >= Per110) { 
                            var EScore = Per90; 
                            $('#logScorekra' + index).text(Per90);

                        }
                        else {
                             var EScore = 0; 
                             $('#logScorekra' + index).text('0');

                            }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                    else if (logic === 'Logic17') {
                        var Per15 = Math.round(((target * 15) / 100) * 100) / 100;
                        var Per16 = Math.round(((target * 16) / 100) * 100) / 100;
                        var Per22 = Math.round(((target * 22) / 100) * 100) / 100;
                        var Per23 = Math.round(((target * 23) / 100) * 100) / 100;
                        var Per29 = Math.round(((target * 29) / 100) * 100) / 100;
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        var Per36 = Math.round(((target * 36) / 100) * 100) / 100;
                        var Per37 = Math.round(((target * 37) / 100) * 100) / 100;
                        var Per42 = Math.round(((target * 42) / 100) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                        var Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per90 = Math.round(((target * 90) / 100) * 100) / 100;

                        if (ach <= Per15) { 
                            var EScore = target; 
                            $('#logScorekra' + index).text(target);

                        }
                        else if (ach > Per15 && ach <= Per22) {
                             var EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                             }
                        else if (ach > Per22 && ach <= Per29) { 
                            var EScore = Per80; 
                            $('#logScorekra' + index).text(Per80);

                        }
                        else if (ach > Per29 && ach <= Per36) {
                             var EScore = Per75; 
                             $('#logScorekra' + index).text(Per75);

                            }
                        else if (ach > Per36 && ach <= Per42) { 
                            var EScore = Per50; 
                            $('#logScorekra' + index).text(Per50);


                        }
                        else if (ach > Per42) { 
                            var EScore = 0; 
                            $('#logScorekra' + index).text('0');

                        }
                        else { var EScore = 0; 
                            $('#logScorekra' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                    else if (logic === 'Logic18') {
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                        var Per60 = Math.round(((target * 60) / 100) * 100) / 100;
                        var Per69 = Math.round(((target * 69) / 100) * 100) / 100;
                        var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                        var Per79 = Math.round(((target * 79) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                        var Per120 = Math.round((target + Per20) * 100) / 100;
                        var Per25 = Math.round(((target * 25) / 100) * 100) / 100;
                        var Per75 = Math.round(((target * 75) / 100) * 100) / 100;

                        if (ach < Per60) { 
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                         }
                        else if (ach >= Per60 && ach <= Per69) { 
                            var EScore = Per25; 
                            $('#logScorekra' + index).text(Per25);

                        }
                        else if (ach > Per69 && ach <= Per79) { 
                            var EScore = Per50;
                            $('#logScorekra' + index).text(Per50);

                         }
                        else if (ach > Per79 && ach <= Per120) { 
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                         }
                        else { 
                            var EScore = 0; 
                            $('#logScorekra' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                    else if (logic === 'Logic19') {
                        var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach < Per70) { 
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                         }
                        else if (ach >= Per70 && ach <= Per80) { 
                            var EScore = Per50; 
                            $('#logScorekra' + index).text(Per50);

                        }
                        else if (ach > Per80 && ach <= target) { 
                            var EScore = target; 
                            $('#logScorekra' + index).text(target);

                        }
                        else { 
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                         }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascorespan' + index).text(MScore.toFixed(2)); // Update the score for this row
                        updategrandscore();
                    }
            
            });
            //subkraannual appraisal
            $(document).on('input', '.annual-rating-subkra', function() {
                let annualratingsubkra = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                var ach=annualratingsubkra;
                let weightlogic8 = parseFloat($(this).data('weight-logic8')) || 0; // Get the target value from data attribute
                let targetlogic8 = parseFloat($(this).data('target-logic8')) || 0; // Get the target value from data attribute

                let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
                    if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#logscoresubkra' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#logscoresubkra' + index).text(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updategrandscore();


                    } 
                    else if (logic === 'Logic2') {
                        let EScore;
                        if (ach <= target) {
                            EScore = ach;
                            $('#logscoresubkra' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            EScore = target;
                            $('#logscoresubkra' + index).text(target); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updategrandscore();



                    }
                    else if (logic === 'Logic2a') {
                        let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        let Per110 = Math.round((target + Per10) * 100) / 100;
                        let EScore;
                        if (ach >= Per110) {
                            EScore = Per110;
                            $('#logscoresubkra' + index).text(Per110); // Update only the respective row's score cell

                        } else {
                            EScore = ach;
                            $('#logscoresubkra' + index).text(ach); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updategrandscore();


                    }
                    else if (logic === 'Logic3') {
                        let EScore;
                            if (ach === target) {
                                EScore = ach;
                                $('#logscoresubkra' + index).text(ach); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logscoresubkra' + index).text('0'); // Update only the respective row's score cell

                            }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updategrandscore();
                        

                    }
                
                    if (logic === 'Logic4') {
                        // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                        let EScore;
                        if (ach >= target) {
                            EScore = target;
                            $('#logscoresubkra' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logscoresubkra' + index).text('0'); // Update only the respective row's score cell

                        }

                        MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell\
                        updategrandscore();


                    }
                    else if (logic === 'Logic5') {
                        let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        let Per70 = Math.round((target - Per30) * 100) / 100;
                        let EScore = 0;
                        if (ach >= Per70 && ach < target) {
                            EScore = ach;
                            $('#logscoresubkra' + index).text(ach); // Update only the respective row's score cell

                        } else if (ach >= target) {
                            EScore = target;
                            $('#logscoresubkra' + index).text(target); // Update only the respective row's score cell

                        }
                        else{
                            EScore = 0;
                            $('#logscoresubkra' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    if (logic === 'Logic6a') {
                        // Logic6a Logic
                            if (target == 8.33) {
                                ach = ach * 12;
                            } else if (target == 25) {
                                ach = ach * 4;
                            } else if (target == 50) {
                                ach = ach * 2;
                            }
                            else{
                                ach=ach;
                            }
                            
                            let Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                            let Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                            if (ach <= 15) {
                                EScore = target;
                                $('#logscoresubkra' + index).text(target); // Update only the respective row's score cell

                            } else if (ach > 15 && ach <= 20) {
                                EScore = Per80;
                                $('#logscoresubkra' + index).text(Per80); // Update only the respective row's score cell

                            } else if (ach > 20 && ach <= 25) {
                                EScore = Per50;
                                $('#logscoresubkra' + index).text(Per50); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logscoresubkra' + index).text('0'); // Update only the respective row's score cell
                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                            $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                    updategrandscore();


                    }
                    else if (logic === 'Logic6b') {
                        // Logic6B Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }
                        else{
                            ach=ach;
                        }

                        if (ach < 5) {
                            EScore = target;
                            $('#logscoresubkra' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logscoresubkra' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    else if (logic === 'Logic6') {
                        // Logic6 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }
                        else{
                            ach=ach;
                        }

                        let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                        let Per125 = Math.round(((target * 125) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per85 = Math.round(((target * 85) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        let PerAct = Math.round(((target * ach) / 100) * 100) / 100;
                        let ScoAct = Math.round((target - PerAct) * 100) / 100;

                        if (ach <= 10) {
                            EScore = Per150;
                            $('#logscoresubkra' + index).text(Per150);

                        } else if (ach > 10 && ach <= 15) {
                            EScore = Per125;
                            $('#logscoresubkra' + index).text(Per125);

                        } else if (ach > 15 && ach <= 20) {
                            EScore = Per100;
                            $('#logscoresubkra' + index).text(Per100);

                        } else if (ach > 20 && ach <= 25) {
                            EScore = Per85;
                            $('#logscoresubkra' + index).text(Per85);

                        } else if (ach > 25 && ach <= 30) {
                            EScore = Per75;
                            $('#logscoresubkra' + index).text(Per75);

                        } 
                        else {
                            EScore = 0;
                            $('#logscoresubkra' + index).text('0');
                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    else if (logic === 'Logic7') {
                        // Logic7 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }

                        let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per90 = Math.round(((target * 90) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;

                        if (ach == 0) {
                            EScore = Per150;
                            $('#logscoresubkra' + index).text(Per150);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#logscoresubkra' + index).text(Per100);

                        } else if (ach > 2 && ach <= 5) {
                            EScore = Per90;
                            $('#logscoresubkra' + index).text(Per90);

                        } else if (ach > 5 && ach <= 10) {
                            EScore = Per75;
                            $('#logscoresubkra' + index).text(Per75);

                        } else {
                            EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    else if (logic === 'Logic7a') {
                        // Logic7 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }

                        let Per120 = Math.round(((target * 120) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        let Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach == 0) {
                            EScore = Per120;
                            $('#logscoresubkra' + index).text(Per150);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#logscoresubkra' + index).text(Per100);

                        } else if (ach > 2 && ach <= 3) {
                            EScore = Per75;
                            $('#logscoresubkra' + index).text(Per75);

                        } else if (ach > 3 && ach <= 4) {
                            EScore = Per50;
                            $('#logscoresubkra' + index).text(Per50);

                        } else {
                            EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    else if (logic === 'Logic8a' || logic === 'Logic8b' || logic === 'Logic8c' || logic === 'Logic8d' || logic === 'Logic8e') {
                        // Logic8 variations
                        let Percent = 0;
                        if (logic === 'Logic8a') {
                            Percent = ((ach / targetlogic8) * 115) / 100;
                        } else if (logic === 'Logic8b') {
                            Percent = ((ach / targetlogic8) * 100) / 100;
                        } else if (logic === 'Logic8c') {
                            Percent = ((ach / targetlogic8) * 70) / 100;
                        } else if (logic === 'Logic8d') {
                            Percent = ((ach / targetlogic8) * (-100)) / 100;
                        } else if (logic === 'Logic8e') {
                            Percent = ((ach / targetlogic8) * (-200)) / 100;
                        }

                        MScore = Math.round((Percent * weightlogic8) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    // Logic9
                    else if (logic === 'Logic9') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        if (ach < Per90) {
                            var EScore = ach;
                            $('#logscoresubkra' + index).text(ach);

                        } else if (ach >= Per90) {
                            var EScore = target;
                            $('#logscoresubkra' + index).text(target);

                        } else {
                            var EScore = logscoresubkra = 0;
                            $('#logscoresubkra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic10
                    else if (logic === 'Logic10') {
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100; 
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100; 
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100; 
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                        var Per6 = Math.round(((target * 6) / 100) * 100) / 100; 
                        var Per7 = Math.round(((target * 7) / 100) * 100) / 100; 
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                        var Per90 = Math.round((target - Per10) * 100) / 100; 
                        var Per91 = Math.round((Per90 + Per1) * 100) / 100;
                        var Per93 = Math.round((Per90 + Per3) * 100) / 100; 
                        var Per94 = Math.round((target - Per6) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100; 
                        var Per98 = Math.round((target - Per2) * 100) / 100; 
                        var Per105 = Math.round((target + Per5) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        var Per120 = Math.round((target + Per20) * 100) / 100;

                        if (ach < Per90) {
                            var EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        } else if (ach == Per90) {
                            var EScore = target;
                            $('#logscoresubkra' + index).text(target);

                        } else if (ach > Per90 && ach <= Per93) {
                            var EScore = Per105;
                            $('#logscoresubkra' + index).text(Per105);

                        } else if (ach > Per93 && ach <= Per97) {
                            var EScore = Per110;
                            $('#logscoresubkra' + index).text(Per110);

                        } else if (ach > Per97) {
                            var EScore = Per120;
                            $('#logscoresubkra' + index).text(Per120);

                        } else {
                            var EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic11
                    else if (logic === 'Logic11') {
                        var EScore = ach;
                        $('#logscoresubkra' + index).text(ach);

                        var MScore = Math.round(((target / EScore) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic12
                    else if (logic === 'Logic12') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;

                        if (ach < Per90) {
                            var EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        }  else if (ach >= Per90 && ach<=Per110) {
                            var EScore = ach;
                            $('#logscoresubkra' + index).text(ach);

                        } else if (ach > Per110) {
                            var EScore = Per110;
                            $('#logscoresubkra' + index).text(Per110);
                        }
                         else {
                            var EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic13a
                    else if (logic === 'Logic13a') {
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                        var Per130 = Math.round((target + Per30) * 100) / 100;
                        var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                        var Per121 = Math.round((target + Per21) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per120 = Math.round((target + Per20) * 100) / 100;
                        var Per11 = Math.round(((target * 11) / 100) * 100) / 100; 
                        var Per111 = Math.round((target + Per11) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        var Per9 = Math.round(((target * 9) / 100) * 100) / 100;   
                        var Per91 = Math.round((target - Per9) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per80 = Math.round((target - Per20) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per70 = Math.round((target - Per30) * 100) / 100;  

                        if (ach <= Per80) {
                            var EScore = Per80;
                            $('#logscoresubkra' + index).text(Per80);

                        } else if (ach >= Per80 && ach <= Per90) {
                            var EScore = Per90;
                            $('#logscoresubkra' + index).text(Per90);

                        } else if (ach >= Per90 && ach <= Per110) {
                            var EScore = target;
                            $('#logscoresubkra' + index).text(target);

                        } else if (ach >= Per110 && ach <= Per120) {
                            var EScore = Per80;
                            $('#logscoresubkra' + index).text(Per80);

                        } else if (ach >= Per120) {
                            var EScore = Per70;
                            $('#logscoresubkra' + index).text(Per70);

                        } else {
                            var EScore = logscoresubkra = 0;
                            $('#logscoresubkra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;  
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic13b
                    else if (logic === 'Logic13b') {
                        var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                        var Per140 = Math.round((target + Per40) * 100) / 100;
                        var Per31 = Math.round(((target * 31) / 100) * 100) / 100; 
                        var Per131 = Math.round((target + Per31) * 100) / 100;
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                        var Per130 = Math.round((target + Per30) * 100) / 100;
                        var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                        var Per121 = Math.round((target + Per21) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per120 = Math.round((target + Per20) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per70 = Math.round((target - Per30) * 100) / 100; 
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per29 = Math.round(((target * 29) / 100) * 100) / 100; 
                        var Per71 = Math.round((target - Per29) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;  

                        if (ach <= Per70) {
                            var EScore = Per70;
                            $('#logscoresubkra' + index).text(Per70);

                        } else if (ach >= Per70 && ach <= Per80) {
                            var EScore = Per90;
                            $('#logscoresubkra' + index).text(Per90);

                        } else if (ach >= Per80 && ach <= Per120) {
                            var EScore = target;
                            $('#logscoresubkra' + index).text(target);

                        } else if (ach >= Per120 && ach <= Per130) {
                            var EScore = Per80;
                            $('#logscoresubkra' + index).text(Per80);

                        } else if (ach >= Per130) {
                            var EScore = Per70;
                            $('#logscoresubkra' + index).text(Per70);

                        } else {
                            var EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    // Logic14a
                    else if (logic === 'Logic14a') {
                        var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                        var Per91 = Math.round((target - Per9) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                        var Per86 = Math.round((target - Per14) * 100) / 100;
                        var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                        var Per85 = Math.round((target - Per15) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per24 = Math.round(((target * 24) / 100) * 100) / 100; 
                        var Per76 = Math.round((target - Per24) * 100) / 100;
                        var Per25 = Math.round(((target * 25) / 100) * 100) / 100; 
                        var Per75 = Math.round((target - Per25) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;

                        if (ach <= Per75) {
                            var EScore = 0;
                            $('#logscoresubkra' + index).text('0');
                        } else if (ach >= Per75 && ach <= Per80) {
                            var EScore = Per80;
                            $('#logscoresubkra' + index).text(Per80);

                        } else if (ach >= Per80 && ach <= Per85) {
                            var EScore = Per90;
                            $('#logscoresubkra' + index).text(Per90);

                        } else if (ach >= Per85 && ach <= Per90) {
                            var EScore = target;
                            $('#logscoresubkra' + index).text(target);

                        } else if (ach >= Per90) {
                            var EScore = Per110;
                            $('#logscoresubkra' + index).text(Per110);

                        } else {
                            var EScore = logscoresubkra = 0;
                            $('#logscoresubkra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }

                    else if (logic === 'Logic14b') {
                        var Per4 = Math.round(((target * 4) / 100) * 100) / 100; 
                        var Per96 = Math.round((target - Per4) * 100) / 100;
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                        var Per95 = Math.round((target - Per5) * 100) / 100;
                        var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                        var Per91 = Math.round((target - Per9) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                        var Per86 = Math.round((target - Per14) * 100) / 100;
                        var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                        var Per85 = Math.round((target - Per15) * 100) / 100;
                        var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                        var Per81 = Math.round((target - Per19) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                        var Per60 = Math.round((target - Per40) * 100) / 100;

                        if (ach <= Per80) {
                            var EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        } else if (ach > Per80 && ach <= Per85) {
                            var EScore = Per60;
                            $('#logscoresubkra' + index).text(Per60);

                        } else if (ach > Per85 && ach <= Per90) {
                            var EScore = Per90;
                            $('#logscoresubkra' + index).text(Per90);

                        } else if (ach > Per90 && ach <= Per95) {
                            var EScore = target;
                            $('#logscoresubkra' + index).text(target);

                        } else if (ach >= Per96) {
                            var EScore = Per110;
                            $('#logscoresubkra' + index).text(Per110);

                        } else {
                            var EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updategrandscore();


                    }
                    else if (logic === 'Logic15a') {
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                        var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                        var Per98 = Math.round((target - Per2) * 100) / 100;
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100;
                        var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                        var Per96 = Math.round((target - Per4) * 100) / 100;
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100;
                        var Per95 = Math.round((target - Per5) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                        var Per40=Math.round(((target*40)/100)*100)/100; 
                        var Per60 = Math.round((target - Per40) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        
                        var EScore = 0;
                        if (ach < Per96) {
                            EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        } else if (ach >= Per96 && ach < Per97) {
                            EScore = Per50;
                            $('#logscoresubkra' + index).text(Per50);

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per60;
                            $('#logscoresubkra' + index).text(Per60);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = Per90;
                            $('#logscoresubkra' + index).text(Per90);

                        } else if (ach >= Per99) {
                            EScore = target;
                            $('#logscoresubkra' + index).text(target);

                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2));

                    } 
                    else if (logic === 'Logic15b') {
                        var Per05 = Math.round(((target * 0.5) / 100) * 100) / 100;
                        var Per995 = Math.round((target - Per05) * 100) / 100;
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                        var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                        var Per98 = Math.round((target - Per2) * 100) / 100;
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100;
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        var Per70 = Math.round((target - Per30) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        
                        var EScore = 0;
                        if (ach < Per97) {
                            EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per70;
                            $('#logscoresubkra' + index).text(Per70);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = Per90;
                            $('#logscoresubkra' + index).text(Per90);

                        } else if (ach >= Per99 && ach < Per995) {
                            EScore = target;
                            $('#logscoresubkra' + index).text(target);

                        } else if (ach >= Per995) {
                            EScore = Per110;
                            $('#logscoresubkra' + index).text(Per110);

                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2));

                    }    
                    else if (logic === 'Logic15c') {
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                        var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                        var Per98 = Math.round((target - Per2) * 100) / 100;
                        var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                        var Per97 = Math.round((target - Per3) * 100) / 100;
                        var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                        var Per96 = Math.round((target - Per4) * 100) / 100;
                        var Per40 = Math.round(((target * 40) / 100) * 100) / 100;
                        var Per60 = Math.round((target - Per40) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                        var Per80 = Math.round((target - Per20) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;
                        
                        var EScore = 0;
                        if (ach < Per96) {
                            EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                        } else if (ach >= Per96 && ach < Per97) {
                            EScore = Per60;
                            $('#logscoresubkra' + index).text(Per60);

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per80;
                            $('#logscoresubkra' + index).text(Per80);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = target;
                            $('#logscoresubkra' + index).text(target);

                        } else if (ach >= Per99) {
                            EScore = Per110;
                            $('#logscoresubkra' + index).text(Per110);
                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2));
                    }
                    else if (logic === 'Logic16') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per6 = Math.round(((target * 6) / 100) * 100) / 100; var Per94 = Math.round((target - Per6) * 100) / 100;
                        var Per5 = Math.round(((target * 5) / 100) * 100) / 100; var Per95 = Math.round((target - Per5) * 100) / 100;
                        var Per1 = Math.round(((target * 1) / 100) * 100) / 100; var Per99 = Math.round((target - Per1) * 100) / 100;
                        var Per105 = Math.round((target + Per5) * 100) / 100; var Per106 = Math.round((target + Per6) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100; var Per111 = Math.round((target + Per10 + Per1) * 100) / 100;
                        var Per115 = Math.round((target + Per10 + Per5) * 100) / 100;

                        if (ach >= Per90 && ach <= Per94) { 
                            var EScore = Per110; 
                            $('#logscoresubkra' + index).text(Per110);

                        }
                        else if (ach >= Per95 && ach <= Per99) { 
                            var EScore = Per105; 
                            $('#logscoresubkra' + index).text(Per105);

                        }
                        else if (ach >= target && ach <= Per105) { 
                            var EScore = target; 
                            $('#logscoresubkra' + index).text(target);

                        }
                        else if (ach >= Per105 && ach <= Per110) {
                            var EScore = Per95; 
                            $('#logscoresubkra' + index).text(Per95);

                        }
                        else if (ach >= Per110) { 
                            var EScore = Per90; 
                            $('#logscoresubkra' + index).text(Per90);

                        }
                        else {
                             var EScore = 0; 
                             $('#logscoresubkra' + index).text('0');

                            }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                    else if (logic === 'Logic17') {
                        var Per15 = Math.round(((target * 15) / 100) * 100) / 100;
                        var Per16 = Math.round(((target * 16) / 100) * 100) / 100;
                        var Per22 = Math.round(((target * 22) / 100) * 100) / 100;
                        var Per23 = Math.round(((target * 23) / 100) * 100) / 100;
                        var Per29 = Math.round(((target * 29) / 100) * 100) / 100;
                        var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        var Per36 = Math.round(((target * 36) / 100) * 100) / 100;
                        var Per37 = Math.round(((target * 37) / 100) * 100) / 100;
                        var Per42 = Math.round(((target * 42) / 100) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                        var Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per90 = Math.round(((target * 90) / 100) * 100) / 100;

                        if (ach <= Per15) { 
                            var EScore = target; 
                            $('#logscoresubkra' + index).text(target);

                        }
                        else if (ach > Per15 && ach <= Per22) {
                             var EScore = Per90;
                            $('#logscoresubkra' + index).text(Per90);

                             }
                        else if (ach > Per22 && ach <= Per29) { 
                            var EScore = Per80; 
                            $('#logscoresubkra' + index).text(Per80);

                        }
                        else if (ach > Per29 && ach <= Per36) {
                             var EScore = Per75; 
                             $('#logscoresubkra' + index).text(Per75);

                            }
                        else if (ach > Per36 && ach <= Per42) { 
                            var EScore = Per50; 
                            $('#logscoresubkra' + index).text(Per50);


                        }
                        else if (ach > Per42) { 
                            var EScore = 0; 
                            $('#logscoresubkra' + index).text('0');

                        }
                        else { var EScore = 0; 
                            $('#logscoresubkra' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                    else if (logic === 'Logic18') {
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                        var Per60 = Math.round(((target * 60) / 100) * 100) / 100;
                        var Per69 = Math.round(((target * 69) / 100) * 100) / 100;
                        var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                        var Per79 = Math.round(((target * 79) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                        var Per120 = Math.round((target + Per20) * 100) / 100;
                        var Per25 = Math.round(((target * 25) / 100) * 100) / 100;
                        var Per75 = Math.round(((target * 75) / 100) * 100) / 100;

                        if (ach < Per60) { 
                            var EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                         }
                        else if (ach >= Per60 && ach <= Per69) { 
                            var EScore = Per25; 
                            $('#logscoresubkra' + index).text(Per25);

                        }
                        else if (ach > Per69 && ach <= Per79) { 
                            var EScore = Per50;
                            $('#logscoresubkra' + index).text(Per50);

                         }
                        else if (ach > Per79 && ach <= Per120) { 
                            var EScore = target;
                            $('#logscoresubkra' + index).text(target);

                         }
                        else { 
                            var EScore = 0; 
                            $('#logscoresubkra' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                    else if (logic === 'Logic19') {
                        var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach < Per70) { 
                            var EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                         }
                        else if (ach >= Per70 && ach <= Per80) { 
                            var EScore = Per50; 
                            $('#logscoresubkra' + index).text(Per50);

                        }
                        else if (ach > Per80 && ach <= target) { 
                            var EScore = target; 
                            $('#logscoresubkra' + index).text(target);

                        }
                        else { 
                            var EScore = 0;
                            $('#logscoresubkra' + index).text('0');

                         }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
                        updategrandscore();
                    }
      
            });
      
            function updategrandscore() {
            let total = 0;
            let lastTotal = parseFloat($("#grandtotalfinalemp").text()) || 0;
      
            console.log("updategrandscore() called");
      
            $('[id^="krascorespan"], [id^="subkrascoreforma"]').each(function () {
                let elementId = $(this).attr('id'); // Get full element ID
      
                let value = $(this).is("span") ? $(this).text().trim() : $(this).text().trim();
                let numericValue = parseFloat(value);
      
                // ✅ If value is 0, check text content
                if (numericValue === 0) {
                    let textValue = $(this).text().trim();
                    let textNumeric = parseFloat(textValue);
                    if (!isNaN(textNumeric)) {
                        numericValue = textNumeric; // Use text if valid
                    }
                }
      
                numericValue = isNaN(numericValue) ? 0 : numericValue; // Ensure valid number
      
                console.log(`Processing ID: ${elementId}, Used Value: ${numericValue}`);
      
                total += numericValue; // ✅ SUM all valid values
            });
      
            // ✅ Only update UI if total changed
            if (lastTotal !== total.toFixed(2)) {
                console.log("Final Grand Total:", total);
                $("#grandtotalfinalemp").text(total.toFixed(2));
                $("#pmsscoreforma").text(total.toFixed(2)); 
      
                var pmsscoreforma = parseFloat($("#pmsscoreforma").text()) || 0; 
                var formawgt = parseFloat($("#formawgt").text()) || 0; 
      
                var formaperwgt = (pmsscoreforma * formawgt) / 100;
      
                $("#formasperwgt").text(formaperwgt.toFixed(2));
      
                // $("#totaladdb").text(
                //     (parseFloat($("#formasperwgt").text()) || 0) + (parseFloat($("#pmsscoreformbasperwgt").text()) || 0)
                // ).toFixed(2); 

                $("#totaladdb").text(((parseFloat($("#formasperwgt").text()) || 0) + (parseFloat($("#pmsscoreformbasperwgt").text()) || 0)).toFixed(2)
                    ); // Set the grand total value with 2 decimal points

                    let totalScore = (parseFloat($("#formasperwgt").text()) || 0) + (parseFloat($("#pmsscoreformbasperwgt").text()) || 0);

                    const ratings = @json($ratings);  // The rating data from controller

                    let rating = getRatingForScore(totalScore, ratings);
                    $('#rating-input').text(rating);

                    console.log('1', rating); // Fixed the console log syntax

                    // Function to get the appropriate rating based on score
                    function getRatingForScore(score, ratings) {
                        for (let i = 0; i < ratings.length; i++) {
                            if (score >= ratings[i].ScoreFrom && score <= ratings[i].ScoreTo) {
                                return ratings[i].Rating;
                            }
                        }
                        return 'N/A';  // Default if no rating found
                    }
      
            } else {
                console.log("No change in total, skipping UI update.");
            }
        }
        function FunFormBTgt(id, period, target, weightage, logic, year_id,Empid) {
                            let isSubKra = id.startsWith("sub_"); // Check if it's a Sub-KRA
      
                            let requestData = {
                                kraId: isSubKra ? null : id,  
                                subKraId: isSubKra ? id.replace("sub_", "") : null,  // Remove "sub_" to get only the numeric ID
                                year_id: year_id,
                                Empid:Empid
                            };
      
                            // Show modal with loader before fetching data
                            $("#viewdetailskra .modal-body").html(`
                                    <div id="kraLoader" class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <p>Fetching details, please wait...</p>
                                    </div>
                                    <div id="kraContent" style="display:none;"></div> <!-- Hidden Content -->
                                `);
                            $("#viewdetailskra").modal("show"); // Show modal immediately
      
                            // Fetch data in the background
                            $.ajax({
                                url: "{{ route('kra.details.formb') }}",
                                type: "GET",
                                data: requestData,
                                success: function(response) {
                                    if (response.success) {
                                        let kraData = response.kraData;
                                        let subKraData = response.subKraData;
                                        let subKraDatamain = response.subKraDatamain;
                                        let pmsData = response.pmsData;
      
                                        console.log(kraData);
      
                                        let contentHtml = ""; // Placeholder for final content
      
                                        if (subKraData) {
                                            const logic = subKraData.Logic ;
                                                        contentHtml = `
                                                <p><strong>Logic:</strong> ${subKraData.Logic}</p>
                                                <p><strong>Skill:</strong> ${subKraData.Skill}</p>
                                                <p><strong>Description:</strong> ${subKraData.SkillComment}</p>
                                                <table class="table table-pad" id="mykraeditbox">
                                                    <thead>
                                                        <tr style="text-align:center;">
                                                                                <th></th>
                                                                                    <th>SN.</th>
                                                                                    <th>Quarter</th>
                                                                                    <th>Weightage</th>
                                                                                    <th>Target</th>
                                                                                    <th style="width:215px;">Comments</th>
                                                                                    <th>Self rating</th>
                                                                                    <th style="width:300px;">Rating details</th>
                                                                                    <th>Score</th>
                                                                                    <th>Reporting rating</th>
                                                                                    <th>Reporting remarks</th>
                                                                                    <th>Reporting score</th>
                                                                                    <th>Action</th>
                                                                                    <th></th>
                                                        </tr>
                                                       
                                                    </thead>
                                                    <tbody id="kraRows">
                                                        ${generateKraRowsAppraisalfromb(kraData, subKraData,subKraDatamain,logic,pmsData,period)}
                                                    </tbody>
                                                </table>
                                            `;
                                        } else {
                                            const logic = subKraDatamain.Logic ;
                                            console.log(logic);
      
                                            contentHtml = `
                                    <p><strong>Logic:</strong> ${subKraDatamain.Logic}</p>
                                    <p><strong>Skill:</strong> ${subKraDatamain.Skill}</p>
                                    <p><strong>Description:</strong> ${subKraDatamain.SkillComment}</p>
                                    <table class="table table-pad" id="mykraeditbox">
                                        <thead>
                                                                          <tr style="text-align:center;">
                                                    <th></th>
                                                        <th>SN.</th>
      					<th>Quarter</th>
      					<th>Weightage</th>
      					<th>Target</th>
      					<th style="width:215px;">Comments</th>
      					<th>Self rating</th>
      					<th style="width:300px;">Rating details</th>
      					<th>Score</th>
      					<th>Reporting rating</th>
      					<th>Reporting remarks</th>
      					<th>Reporting score</th>
      					<th>Action</th>
                                                        <th></th>
                            </tr>
                                          
                                        </thead>
                                        <tbody id="kraRows">
                                            ${generateKraRowsAppraisalfromb(kraData, null, subKraDatamain, logic,pmsData,period)}
                                        </tbody>
                                    </table>
                                `;
                                        }
      
                                        contentHtml += `
                                <div class="float-end">
                                    <i class="fas fa-check-circle mr-2 text-success"></i> Final Submit, 
                                    <i class="ri-check-double-line mr-1 text-success"></i> Save as Draft
                                </div>
                                <p><b>Note:</b><br> 
                                    1. Please ensure that the achievement is calculated against the "<b>Target Value</b>" only.<br>
                                    2. The achievement is required to be entered on the last day or within a few days, beyond which the KRA will be auto-locked.
                                </p>
                            `;
      
                                    // Insert content but keep loader
                                    $("#kraContent").html(contentHtml);
      
                                    // Wait until generateKraRows is done, then show content & hide loader
                                    setTimeout(() => {
                                        $("#kraLoader").hide(); // Hide loader
                                        $("#kraContent").fadeIn(); // Show content
                                    }, 300); // Small delay to ensure rows are ready
                                } else {
                                    $("#viewdetailskra .modal-body").html(`<p class="text-center text-danger">No data found!</p>`);
                                }
                            },
                            error: function() {
                                $("#viewdetailskra .modal-body").html(`<p class="text-center text-danger">An error occurred while fetching KRA details.</p>`);
                            }
                        });
            }
      
      
            function generateKraRowsAppraisalfromb(kraData, subKraData = null, subKraDatamain = null,logic) {
                              
                            let rows = '';
                            let totalWeight = 0;
                            const currentDate = new Date(); // Get the current date
      
                            kraData.forEach((detail, index) => {
                            console.log(detail);
                            totalWeight += parseFloat(detail.Wgt) || 0; // Use parseFloat to ensure it's a number
                            totalWeight = parseFloat(totalWeight.toFixed(2));
      
                            let lDate = new Date(detail.Ldate);
      
                        // Check if Ldate is within the current date range
                        let isWithinDateRange = lDate >= currentDate;
                        let weight = detail.Wgt; // Get weight from the detail object
                        let savestatus =detail.appsave_status;
                        let submitstatus =detail.appsubmit_status;
      
                        // Check if the weight is a whole number or a decimal
      
                        // Define readonly or editable mode based on date range
                        let isReadonly = !isWithinDateRange;
                        rows += `
                                    <tr>
                                        <td id="logscoreformb${index}" style="display:none">${detail.LogScr}<td>
                                        <input type="hidden" class="tgt-id-formb" value="${detail.TgtFbDefId }" id="tgt-id-formb-${index}">
      
                                        <td><b>${index + 1}</b></td>
                                        <td>${detail.Tital}</td>
                                        <td style="text-align:center;">${weight}</td>
                                        <td style="text-align:center;">100</td>
                                        <td>${detail.Remark}</td>
                                        <td>${detail.Ach}</td>
                                        <td>${detail.Cmnt}</td>
                                        <td>${detail.Scor}</td>
                                        
                                        <td style="background-color: #e7ebed;">
                                            <input class="form-control self-rating-formb" style="width: 60px;" type="number" placeholder="Enter rating"  id="self-rating-formb${index}"
                                            value="${detail.AppAch}" data-target="${detail.Tgt}" data-index="${index}"data-logic="${logic}" 
                                            data-weight="${detail.Wgt}"
                                            readonly>
                                        </td>
                                        <td style="background-color: #e7ebed;">
                                            <textarea class="form-control self-remark-formb" required style="min-width: 200px;min-height:70px;" data-index="${index}"
                                            placeholder="Enter your remark" id="selfremarkformb${index}" readonly>${detail.AppCmnt}</textarea>
      
                                        </td>
                                        <td id="score-formb${index}" style="background-color: #e7ebed;text-align:center;">${detail.AppScor}</td>
                                        <td>
                                            ${isWithinDateRange && submitstatus === 0? 
                                                `<a title="Edit" class="fas fa-edit text-info mr-2" onclick="enableEditMode(this, ${index})"></a>`
                                                : ''
                                            }
                                            ${isWithinDateRange && submitstatus === 1? 
                                            ''
                                                : ''
                                            }
                                            ${lDate < currentDate ? 
                                                `<a title="Lock"><i style="font-size:14px;" class="ri-lock-2-line text-danger mr-2"></i></a>`
                                                : ''
                                                }
      
                                            <span class="edit-buttons" style="display: none;">
                                            <a title="Save" href="javascript:void(0);" onclick="saveRowDataFormb(${index}, '${detail.TgtFbDefId}','save')">
                                                <i style="font-size:14px;" class="ri-save-3-line text-success mr-2"></i>
                                            </a>
                                            <a href="javascript:void(0);" style="padding: 2px 7px;font-size: 11px;" onclick="saveRowDataFormb(${index}, '${detail.TgtFbDefId}','submit')"
                                            class="btn btn-outline-success waves-effect waves-light material-shadow-none" 
                                            title="Submit"><i style="font-size:14px;" class="ri-check-line"></i></a>
                                            </span>
                            </td>    
                            <td>${savestatus === 1 ? 
                                    `<a title="Lock" href=""><i style="font-size:14px;" class="ri-check-double-line mr-2 text-success"></i></a>` 
                                    : ''}
      
                                ${submitstatus === 1 ? 
                                    `<a title="Lock" href=""><i style="font-size:14px;" class="fas fa-check-circle mr-2 text-success"></i></a>` 
                                    : ''}
                                </td>
                                `;
                            });
                            // Add row for Sub-KRA (Total) if available
                            if (subKraData && !kraData) {
                                rows += `
                                    <tr>
                                        <td></td>
                                        <td colspan="2"><b>Total</b></td>
                                        <td style="text-align:center;">${totalWeight}</td>
                                        <td colspan="7"></td>
                                    </tr>
                                `;
                            }
                            if (kraData && !subKraData) {
      
                                rows += `
                                    <tr>
                                        <td></td>
                                        <td colspan="2"><b>Total</b></td>
                                        <td style="text-align:center;">${totalWeight}</td>
                                        <td colspan="7"></td>
                                    </tr>
                                `;
                            }
                            if (subKraDatamain && !kraData) {
      
                                rows += `
                                    <tr>
                                        <td></td>
                                        <td colspan="2"><b>Total</b></td>
                                        <td style="text-align:center;">${totalWeight}</td>
                                        <td colspan="7"></td>
                                    </tr>
                                `;
                            }
                            if (!subKraDatamain && kraData) {
      
                            rows += `
                                <tr>
                                    <td></td>
                                    <td colspan="2"><b>Total</b></td>
                                    <td style="text-align:center;">${totalWeight}</td>
                                    <td colspan="7"></td>
                                </tr>
                            `;
                            }
                            return rows;
            }
            $(document).on('input', '.self-remark-formb', function() {
                let selfremark =$(this).val()|| ''; // Get the self-rating value, default to 0 if empty
                console.log(selfremark);
                let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
      
                $('#self-remark-formb' + index).text(selfremark); // Update only the respective row's score cell
            });
            $(document).on('input', '.self-rating-formb', function() {
                let selfRating = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
                var ach=Math.round(((target*selfRating)/100)*100)/100; //var ach=parseFloat(v);  
                $('#self-rating-formb' + index).text(selfRating); // Update only the respective row's score cell
      
                if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#logscoreformb' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#logscoreformb' + index).text(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    } 
                    else if (logic === 'Logic2') {
                        let EScore;
                        if (ach <= target) {
                            EScore = ach;
                            $('#logscoreformb' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            EScore = target;
                            $('#logscoreformb' + index).text(target); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();



                    }
                    else if (logic === 'Logic2a') {
                        let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        let Per110 = Math.round((target + Per10) * 100) / 100;
                        let EScore;
                        if (ach >= Per110) {
                            EScore = Per110;
                            $('#logscoreformb' + index).text(Per110); // Update only the respective row's score cell

                        } else {
                            EScore = ach;
                            $('#logscoreformb' + index).text(ach); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    }
                    else if (logic === 'Logic3') {
                        let EScore;
                            if (ach === target) {
                                EScore = ach;
                                $('#logscoreformb' + index).text(ach); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logscoreformb' + index).text('0'); // Update only the respective row's score cell

                            }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();
                        

                    }
                
                    if (logic === 'Logic4') {
                        // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                        let EScore;
                        if (ach >= target) {
                            EScore = target;
                            $('#logscoreformb' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logscoreformb' + index).text('0'); // Update only the respective row's score cell

                        }

                        MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell\
                        updateGrandTotal();


                    }
                    else if (logic === 'Logic5') {
                        let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        let Per70 = Math.round((target - Per30) * 100) / 100;
                        let EScore = 0;
                        if (ach >= Per70 && ach < target) {
                            EScore = ach;
                            $('#logscoreformb' + index).text(ach); // Update only the respective row's score cell

                        } else if (ach >= target) {
                            EScore = target;
                            $('#logscoreformb' + index).text(target); // Update only the respective row's score cell

                        }
                        else{
                            EScore = 0;
                            $('#logscoreformb' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                updateGrandTotal();


                    }

           
            });
            function saveRowDataFormb(index, tgtId, saveType) {
                    $('#loader').show(); // Show loader while saving
                    let selfRemark = $('#selfremarkformb' + index).val();
      
                    // Check if selfRemark is empty
                    if (!selfRemark) {
                        // Add red border to indicate it's mandatory
                        $('#selfremarkformb' + index).css('border', '2px solid red');
                                                    
                        // Hide the loader and return early
                        $('#loader').hide();
                        return;
                    } else {
                        // Remove red border if it was previously added
                        $('#selfremarkformb' + index).css('border', '');
                    }
      
                    // Collect data from the row
                    let requestData = {
                        logscore: $('#logscoreformb' + index).text(),
                        tgtDefId: $('#tgt-id-formb-' + index).val(),
                        selfRating: $('#self-rating-formb' + index).val(),
                        selfRemark: $('#selfremarkformb' + index).val(),
                        score: $('#score-formb' + index).text(),
                        saveType: saveType,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                    };
      
                    console.log("Saving data:", requestData); // Debugging
      
                    $.ajax({
                        url: '/save-kra-row-formb-app', // Laravel route
                        type: 'POST',
                        data: requestData,
                        dataType: 'json', // Ensure response is parsed as JSON
                        success: function(response) {
                            $('#loader').hide(); // Hide loader on success
                            if (response.success) {
                                if (saveType === 'save') {
                                    toastr.success(response.message, 'Success', {
                                        positionClass: "toast-top-right",
                                        timeOut: 3000
                                    });
                                } else if (saveType === 'submit') {
                                    toastr.success(response.message, 'Success', {
                                        positionClass: "toast-top-right",
                                        timeOut: 3000
                                    });
      
                                    setTimeout(function () {
                                        location.reload();
                                    }, 3000); // Reload after 3 seconds to allow the user to see the message
                                }
      
                            } else {
                                toastr.error(response.message, 'Error', {
                                    positionClass: "toast-top-right",
                                    timeOut: 3000
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#loader').hide(); // Hide loader on error
                            console.error("Save failed:", xhr.responseText);
      
                            // Display error toast
                            toastr.error('Failed to save data. Please try again.', 'Error', {
                                positionClass: "toast-top-right",
                                timeOut: 3000
                            });
                        }
                    });
            }
            function updateGrandTotal() {
                let total = 0;
      
                // Iterate over all input fields with IDs starting with "krascoreformb"
                        // Iterate over all input fields with IDs starting with "krascoreformb"
                $('[id^="krascoreformb"]').each(function() {
                        // Get the value of the current input field
                        let value = $(this).text();
      
                        // Ensure the value is a valid number
                        if (!isNaN(value) && value.trim() !== "") {
                            total += parseFloat(value); // Add the value to the total
                        }
                    });
      
                    // Iterate over all input fields with IDs starting with "subkrascoreformb"
                    $('[id^="subkrascoreformb"]').each(function() {
                        // Get the value of the current input field
                        let value = $(this).text();
      
                        // Ensure the value is a valid number
                        if (!isNaN(value) && value.trim() !== "") {
                            total += parseFloat(value); // Add the value to the total
                        }
                    });
                    $("#grandtotalfinalempFormb").text(total.toFixed(2)); // Set the grand total value with 2 decimal points
      
                    $("#pmsscoreformb").text(total.toFixed(2)); // Set the grand total value with 2 decimal points
      
                    var pmsscoreformb= parseFloat($("#pmsscoreformb").text()) || 0; 
                    var formbwgt = parseFloat($("#formbwgt").text()) || 0; 
      
                    var pmsscoreformbasperwgt = (pmsscoreformb * formbwgt) / 100;
      
                    console.log($("#pmsscoreformbasperwgt").text()); // This will log the text content of the element
      
                    // // Update the value in the table
                    // $("#pmsscoreformbasperwgt").text(formbscoreasperwgt.toFixed(2));
                    // $("#formasperwgt").text(formaperwgt.toFixed(2));
      
                    
                    $("#pmsscoreformbasperwgt").text(pmsscoreformbasperwgt.toFixed(2));
                    // $("#totaladdb").text(
                    //     (parseFloat($("#formasperwgt").text()) || 0) + (parseFloat($("#pmsscoreformbasperwgt").text()) || 0)
                    // ).toFixed(2); // Set the grand total value with 2 decimal points
                
                    $("#totaladdb").text(((parseFloat($("#formasperwgt").text()) || 0) + (parseFloat($("#pmsscoreformbasperwgt").text()) || 0)).toFixed(2)
                    ); // Set the grand total value with 2 decimal points

                    let totalScore = (parseFloat($("#formasperwgt").text()) || 0) + (parseFloat($("#pmsscoreformbasperwgt").text()) || 0);

                    const ratings = @json($ratings);  // The rating data from controller

                    let rating = getRatingForScore(totalScore, ratings);
                    $('#rating-input').text(rating);

                    console.log('1', rating); // Fixed the console log syntax

                    // Function to get the appropriate rating based on score
                    function getRatingForScore(score, ratings) {
                        for (let i = 0; i < ratings.length; i++) {
                            if (score >= ratings[i].ScoreFrom && score <= ratings[i].ScoreTo) {
                                return ratings[i].Rating;
                            }
                        }
                        return 'N/A';  // Default if no rating found
                    }
      
      
            }
            //annual rating appraisal form b
            $(document).on('input', '.annual-rating-formb', function() {
                let annualratingkra = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                var ach=annualratingkra;
                let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
    
                if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#logScorekraformb' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#logScorekraformb' + index).text(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#krascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    } 
                    else if (logic === 'Logic2') {
                        let EScore;
                        if (ach <= target) {
                            EScore = ach;
                            $('#logScorekraformb' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            EScore = target;
                            $('#logScorekraformb' + index).text(target); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();



                    }
                    else if (logic === 'Logic2a') {
                        let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        let Per110 = Math.round((target + Per10) * 100) / 100;
                        let EScore;
                        if (ach >= Per110) {
                            EScore = Per110;
                            $('#logScorekraformb' + index).text(Per110); // Update only the respective row's score cell

                        } else {
                            EScore = ach;
                            $('#logScorekraformb' + index).text(ach); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    }
                    else if (logic === 'Logic3') {
                        let EScore;
                            if (ach === target) {
                                EScore = ach;
                                $('#logScorekraformb' + index).text(ach); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logScorekraformb' + index).text('0'); // Update only the respective row's score cell

                            }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();
                        

                    }
                
                    if (logic === 'Logic4') {
                        // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                        let EScore;
                        if (ach >= target) {
                            EScore = target;
                            $('#logScorekraformb' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logScorekraformb' + index).text('0'); // Update only the respective row's score cell

                        }

                        MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                        $('#krascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    }
                    else if (logic === 'Logic5') {
                        let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        let Per70 = Math.round((target - Per30) * 100) / 100;
                        let EScore = 0;
                        if (ach >= Per70 && ach < target) {
                            EScore = ach;
                            $('#logScorekraformb' + index).text(ach); // Update only the respective row's score cell

                        } else if (ach >= target) {
                            EScore = target;
                            $('#logScorekraformb' + index).text(target); // Update only the respective row's score cell

                        }
                        else{
                            EScore = 0;
                            $('#logScorekraformb' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                         updateGrandTotal();


                    }

            });
            $(document).on('input', '.annual-rating-formb-subkra', function() {
                let annualratingkra = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                var ach=annualratingkra;
                let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute

                if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#logScoresubkraformb' + index).val(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#logScoresubkraformb' + index).val(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#subkrascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    } 
                    else if (logic === 'Logic2') {
                        let EScore;
                        if (ach <= target) {
                            EScore = ach;
                            $('#logScoresubkraformb' + index).val(ach); // Update only the respective row's score cell

                        } else {
                            EScore = target;
                            $('#logScoresubkraformb' + index).val(target); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();



                    }
                    else if (logic === 'Logic2a') {
                        let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        let Per110 = Math.round((target + Per10) * 100) / 100;
                        let EScore;
                        if (ach >= Per110) {
                            EScore = Per110;
                            $('#logScoresubkraformb' + index).val(Per110); // Update only the respective row's score cell

                        } else {
                            EScore = ach;
                            $('#logScoresubkraformb' + index).val(ach); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    }
                    else if (logic === 'Logic3') {
                        let EScore;
                            if (ach === target) {
                                EScore = ach;
                                $('#logScoresubkraformb' + index).val(ach); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logScoresubkraformb' + index).val('0'); // Update only the respective row's score cell

                            }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();
                        

                    }
                
                    if (logic === 'Logic4') {
                        // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                        let EScore;
                        if (ach >= target) {
                            EScore = target;
                            $('#logScoresubkraformb' + index).val(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logScoresubkraformb' + index).val('0'); // Update only the respective row's score cell

                        }

                        MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                        $('#subkrascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    }
                    else if (logic === 'Logic5') {
                        let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        let Per70 = Math.round((target - Per30) * 100) / 100;
                        let EScore = 0;
                        if (ach >= Per70 && ach < target) {
                            EScore = ach;
                            $('#logScoresubkraformb' + index).val(ach); // Update only the respective row's score cell

                        } else if (ach >= target) {
                            EScore = target;
                            $('#logScoresubkraformb' + index).val(target); // Update only the respective row's score cell

                        }
                        else{
                            EScore = 0;
                            $('#logScoresubkraformb' + index).val('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreformb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    }

            });
      
            $(document).ready(function() {
            // Fetch the current value present in #grandtotalfinalempFormb
            var grandTotalValue = parseFloat($("#grandtotalfinalempFormb").text()) || 0; // Fallback to 0 if the value is not a valid number
            var grandTotalValueforma = parseFloat($("#grandtotalfinalemp").text()) || 0; // Fallback to 0 if the value is not a valid number
      
            $("#pmsscoreformb").text(grandTotalValue.toFixed(2)); 
            $("#pmsscoreforma").text(grandTotalValueforma.toFixed(2)); 
      
            
           
            var formbwgt = parseFloat($("#formbwgt").text()) || 0; 
            var formawgt = parseFloat($("#formawgt").text()) || 0; 
      
            var pmsscoreformb = parseFloat($("#pmsscoreformb").text()) || 0; 
            var pmsscoreforma = parseFloat($("#pmsscoreforma").text()) || 0; 
      
            // Calculate formbscoreasperwgt
            var formbscoreasperwgt = (pmsscoreformb * formbwgt) / 100;
            var formaperwgt = (pmsscoreforma * formawgt) / 100;
      
            // Update the value in the table
            $("#pmsscoreformbasperwgt").text(formbscoreasperwgt.toFixed(2));
            $("#formasperwgt").text(formaperwgt.toFixed(2));
            // $("#totaladdb").text(
            //     ( (parseFloat($("#formasperwgt").text()) || 0) + (parseFloat($("#pmsscoreformbasperwgt").text()) || 0) )
            //     .toFixed(2) // Round the result to 2 decimal places
            //     );
            $("#totaladdb").text(((parseFloat($("#formasperwgt").text()) || 0) + (parseFloat($("#pmsscoreformbasperwgt").text()) || 0)).toFixed(2)
                    ); // Set the grand total value with 2 decimal points

                    let totalScore = (parseFloat($("#formasperwgt").text()) || 0) + (parseFloat($("#pmsscoreformbasperwgt").text()) || 0);

                    const ratings = @json($ratings);  // The rating data from controller

                    let rating = getRatingForScore(totalScore, ratings);
                    $('#rating-input').text(rating);

                    console.log('1', rating); // Fixed the console log syntax

                    // Function to get the appropriate rating based on score
                    function getRatingForScore(score, ratings) {
                        for (let i = 0; i < ratings.length; i++) {
                            if (score >= ratings[i].ScoreFrom && score <= ratings[i].ScoreTo) {
                                return ratings[i].Rating;
                            }
                        }
                        return 'N/A';  // Default if no rating found
                    }
      

        });




      
        document.addEventListener('DOMContentLoaded', function() {
            
            // Function to handle category change
            function handleCategoryChange(event) {
                const categorySelect = event.target;
                const category = categorySelect.value;
                const row = categorySelect.closest('tr'); // Get the closest row
        
                // Hide the description initially
                row.querySelector('.description-cell').textContent = 'Select a topic to view description';
                
                // Reset the hidden input for Tid
                row.querySelector('.hidden-tid').value = '';
        
                if (category) {
                    // Show the topics based on the selected category
                    const topics = @json($softSkills); // Convert the PHP data to JavaScript
        
                    // Find topics for the selected category
                    const categorySkills = topics[category];
        
                    // Populate the topic dropdown based on the selected category
                    const topicSelect = row.querySelector('.topic-select');
                    topicSelect.innerHTML = '<option value="">Select Topic</option>'; // Reset topic options
        
                    categorySkills.forEach(skill => {
                        const option = document.createElement('option');
                        option.value = skill.Tid; // Set Tid as the value
                        option.textContent = skill.Topic; // Display topic name
                        topicSelect.appendChild(option);
                    });
                } else {
                    // If no category is selected, clear topic and description
                    const topicSelect = row.querySelector('.topic-select');
                    topicSelect.innerHTML = '<option value="">Select Topic</option>';
                    row.querySelector('.description-cell').textContent = 'Select a topic to view description';
                }
            }
        
            // Function to handle topic change
            function handleTopicChange(event) {
                const topicSelect = event.target;
                const topicId = topicSelect.value; // Get the selected topic Tid
                const row = topicSelect.closest('tr'); // Get the closest row
        
                // Hide the description initially
                row.querySelector('.description-cell').textContent = 'Select a topic to view description';
        
                // Reset the hidden input for Tid
                const hiddenTid = row.querySelector('.hidden-tid');
                if (topicId) {
                    const topics = @json($softSkills); // Get the softSkills data
                    let description = '';
                    let selectedTopic = null; // ✅ Define outside the loop

                    // Find description for the selected topic by Tid
                    for (const category in topics) {
                        const categorySkills = topics[category];
                        const foundTopic = categorySkills.find(skill => skill.Tid == topicId);
                        if (foundTopic) {
                            selectedTopic = foundTopic; // ✅ Assign to outer-scoped variable
                            description = selectedTopic.Description;
                            hiddenTid.value = selectedTopic.Tid;
                            break;
                        }
                    }

                    const descriptionCell = row.querySelector('.description-cell');

                    if (selectedTopic) {
                        if (selectedTopic.Tid == 69) {
                            // ✅ Show input for Tid 69
                            descriptionCell.innerHTML = `<input type="text" class="description-cell" placeholder="Enter Description" />`;
                        } else {
                            // ✅ Show plain description
                            descriptionCell.textContent = description;
                        }
                    }
                }

                else {
                    // Reset the hidden input when no topic is selected
                    hiddenTid.value = '';
                }
            }
        
            // Event delegation: Add event listener to the table for category and topic selects
            const table = document.getElementById('training-table-a');
            const tableBody = table.querySelector('tbody'); // Get the table body for adding rows
        
            // Listen for category and topic changes
            table.addEventListener('change', function(event) {
                if (event.target.classList.contains('category-select')) {
                    handleCategoryChange(event);
                } else if (event.target.classList.contains('topic-select')) {
                    handleTopicChange(event);
                }
            });
  
            // Event to add a new row
            document.getElementById('add-row-a').addEventListener('click', function() {
                const rowCount = tableBody.rows.length + 1; // Get current row count
                if (rowCount <= 5) { // Limit to a maximum of 5 rows
                    const newRow = document.createElement('tr');
        
                    // Create columns for the new row
                    newRow.innerHTML = `
                        <td><b>${rowCount}</b></td>
                        <td>
                            <!-- Category Dropdown -->
                            <select style="width:250px;" class="category-select">
                                <option value="">Select Category</option>
                                @foreach($softSkills as $category => $skills)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <!-- Topic Dropdown (will be populated based on category) -->
                            <select style="width:250px;" class="topic-select">
                                <option value="">Select Topic</option>
                            </select>
                        </td>
                        <td class="description-cell">Select a topic to view description</td>
                        <!-- Hidden Tid Input -->
                        <td class="d-none"><input type="hidden" class="hidden-tid" value=""></td>
                        <td><a href="javascript:void(0);" class="delete-row"><i class="fas fa-trash ml-2 mr-2"></i></a></td>
                    `;
        
                    // Append the new row to the table body
                    tableBody.appendChild(newRow);
                } else {
                    alert('Maximum number of rows reached');
                }
        });
  
      // Event delegation to delete a row
      table.addEventListener('click', function(event) {
          // Check if the clicked target is the delete button
          if (event.target.classList.contains('delete-row') || event.target.closest('.delete-row')) {
              const row = event.target.closest('tr'); // Find the closest tr element
              row.remove(); // Remove the row from the table
  
              // After row removal, check if it's the first row and hide delete button for it
              const remainingRows = tableBody.rows;
              if (remainingRows.length === 0) {
                  return; // No rows left, so no need to hide anything
              }
              const firstRow = remainingRows[0];
              firstRow.querySelector('.delete-row').style.display = 'none'; // Hide delete button for first row
          }
      });
  
  });
  
  document.addEventListener('DOMContentLoaded', function () {
    let rowCount = 1; // Keeps track of the number of rows
    const maxRows = 5; // Maximum number of rows
    const tableBody = document.querySelector('#training-table tbody');
    const addRowButton = document.getElementById('add-row');
    
    // Event to add a new row
    addRowButton.addEventListener('click', function () {
        if (rowCount < maxRows) {
            rowCount++;
            const newRow = document.createElement('tr');
    
            // Create columns for the new row
            newRow.innerHTML = `
                <td><b>${rowCount}</b></td>
                <td>
                    <!-- Topic Dropdown -->
                    <select style="width:250px;" class="topic-select-selectb">
                        <option value="">Select Topic</option>
                        @foreach($trainings as $topic)
                            @if(strtolower($topic->Category) === strtolower($topic->Category))
                                <option value="{{ $topic->Topic }}" data-tid="{{ $topic->Tid }}">{{ $topic->Topic }}</option>
                            @endif
                        @endforeach
                    </select>
                </td>
                <td class="description-cell-selectb">Select a topic to view description</td>
                <td><a href="javascript:void(0);" class="delete-row-b"><i class="fas fa-trash ml-2 mr-2"></i></a></td>
                <td class="d-none"><input type="hidden" class="hidden-tid-tech" value=""></td> <!-- Hidden Tid field -->
            `;
    
            // Append the new row to the table
            tableBody.appendChild(newRow);
    
            // Hide delete button for the first row
            if (tableBody.rows.length === 1) {
                newRow.querySelector('.delete-row-b').style.display = 'none';
            }
    
            // Recheck delete buttons visibility for each row after adding
            updateDeleteButtonVisibility();
            
            // Add the event listener for the new select dropdown to handle topic change
            newRow.querySelector('.topic-select-selectb').addEventListener('change', handleTopicChange);
        } else {
            alert("You cannot add more than 5 rows.");
        }
    });
    
    // Event listener for change in topic dropdown (for existing and new rows)
    tableBody.addEventListener('change', function (e) {
        if (e.target && e.target.matches('.topic-select-selectb')) {
            handleTopicChange(e);
        }
    });
    
    function handleTopicChange(event) {
        let selectedTopic = event.target.value;
        let descriptionCell = event.target.closest('tr').querySelector('.description-cell-selectb');
        let hiddenTidInput = event.target.closest('tr').querySelector('.hidden-tid-tech'); // Access hidden Tid field
    
        // Find the matching topic's description
        let topicData = @json($trainings); // Pass the data from Laravel to JS
        let topicDescription = topicData.find(item => item.Topic === selectedTopic);
    
        if (topicDescription && topicDescription.Description) {
            descriptionCell.innerText = topicDescription.Description;  // Display the description
        } else {
            // If no description is found, show an input field to add a description
            descriptionCell.innerHTML = `
                <input type="text" class="form-control custom-description-input" placeholder="Enter description" />
            `;
        }
    
        // Set the Tid value to the hidden input in the same row
        if (topicDescription) {
            hiddenTidInput.value = topicDescription.Tid;
        }
    }
    
    // Function to update the delete button visibility (hide for the first row)
    function updateDeleteButtonVisibility() {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            if (index === 0) {
                row.querySelector('.delete-row-b').style.display = 'none'; // Hide delete button on the first row
            } else {
                row.querySelector('.delete-row-b').style.display = 'inline'; // Show delete button on other rows
            }
        });
    }
    tableBody.addEventListener('click', function (e) {
    const deleteBtn = e.target.closest('.delete-row-b');
    if (deleteBtn) {
        const row = deleteBtn.closest('tr');
        row.remove();
        rowCount--; // Decrease the row count when a row is removed

        // Update the row numbering and delete button visibility after deletion
        updateRowNumbers();
        updateDeleteButtonVisibility();
    }
});

    
    // Function to update row numbers after a row is deleted
    function updateRowNumbers() {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            row.querySelector('td:first-child').innerHTML = `<b>${index + 1}</b>`;
        });
    }
});

       $(document).ready(function() {
      // Handle Save Button Click
      $('#save-button').on('click', function() {
        $('#loader').show(); // Show loader while saving

        var year_id  = "{{$PmsYId}}";
        let CompanyId = "{{ Auth::user()->CompanyId }}";
        let pms_id = "{{ $pms_id->EmpPmsId }}";
        let employeeid = "{{$employeeid }}";

         let kraData = gatherKraData(false); // No validation

         var kraDataformb = gatherKraDataFormb(false); // Gather all the data
         var appraiserpmsdata = gatherAppraiserData();
         var trainingData = gatherTrainingData();
         var gatherpromotiondata =gatherPromotionRecommendationData();

         let grandtotalka = parseFloat($("#grandtotalfinalemp").text()) || 0;
         let grandtotalkaformb = parseFloat($("#grandtotalfinalempFormb").text()) || 0;

         var appreamrk = document.getElementById('appreamrks').value;


         $.ajax({
            url: '/saveKraData',  // Your route for saving data
            method: 'POST',
            data: {
               _token: '{{ csrf_token() }}',
               kraData: kraData,
               kraDataformb:kraDataformb,
               action: 'save',
               grandtotalka: grandtotalka,
               grandtotalkaformb:grandtotalkaformb,
               appraiserpmsdata:appraiserpmsdata,
               trainingData:trainingData,
               gatherpromotiondata:gatherpromotiondata,
               appreamrk:appreamrk,
               year_id:year_id,
               CompanyId:CompanyId,
               employeeid:employeeid,
               pms_id:pms_id

            },
            success: function(response) {
                            $('#loader').hide(); // Hide loader on success
                            if (response.success) {
                                
                                    toastr.success(response.message, 'Success', {
                                        positionClass: "toast-top-right",
                                        timeOut: 3000
                                    });
                                    setTimeout(function () {
                                        window.location.href = window.location.href;
                                    }, 3000); // Reload after 3 seconds to allow the user to see the message
                                
      
                            } else {
                            $('#loader').hide(); // Hide loader on error

                                toastr.error(response.message, 'Error', {
                                    positionClass: "toast-top-right",
                                    timeOut: 3000
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#loader').hide(); // Hide loader on error
                            console.error("Save failed:", xhr.responseText);
      
                            // Display error toast
                            toastr.error('Failed to save data. Please try again.', 'Error', {
                                positionClass: "toast-top-right",
                                timeOut: 3000
                            });
                        }
         });
      });

      // Handle Submit Button Click
      $('#submit-button').on('click', function() {
        $('#loader').show(); // Show loader while saving

        var year_id  = "{{$PmsYId}}";
        let CompanyId = "{{ Auth::user()->CompanyId }}";
        let pms_id = "{{ $pms_id->EmpPmsId }}";
        let employeeid = "{{$employeeid }}";

         var kraData = gatherKraData(false);

         var kraDataformb = gatherKraDataFormb(false); // Gather all the data
         var appraiserpmsdata = gatherAppraiserData();
         var trainingData = gatherTrainingData();
         var gatherpromotiondata =gatherPromotionRecommendationData();

         let grandtotalka = parseFloat($("#grandtotalfinalemp").text()) || 0;
         let grandtotalkaformb = parseFloat($("#grandtotalfinalempFormb").text()) || 0;

         var appreamrk = document.getElementById('appreamrks').value;


         $.ajax({
            url: '/saveKraData',  // Your route for saving data
            method: 'POST',
            data: {
               _token: '{{ csrf_token() }}',
               kraData: kraData,
               kraDataformb:kraDataformb,
               action: 'submit',
               grandtotalka: grandtotalka,
               grandtotalkaformb:grandtotalkaformb,
               appraiserpmsdata:appraiserpmsdata,
               trainingData:trainingData,
               gatherpromotiondata:gatherpromotiondata,
               appreamrk:appreamrk,
               year_id:year_id,
               CompanyId:CompanyId,
               employeeid:employeeid,
               pms_id:pms_id

            },
            success: function(response) {
                            $('#loader').hide(); // Hide loader on success
                            if (response.success) {
                                
                                    toastr.success(response.message, 'Success', {
                                        positionClass: "toast-top-right",
                                        timeOut: 3000
                                    });
                                    setTimeout(function () {
                                        window.location.href = window.location.href;
                                    }, 3000); // Reload after 3 seconds to allow the user to see the message
                                
      
                            } else {
                            $('#loader').hide(); // Hide loader on error

                                toastr.error(response.message, 'Error', {
                                    positionClass: "toast-top-right",
                                    timeOut: 3000
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#loader').hide(); // Hide loader on error
                            console.error("Save failed:", xhr.responseText);
      
                            // Display error toast
                            toastr.error('Failed to save data. Please try again.', 'Error', {
                                positionClass: "toast-top-right",
                                timeOut: 3000
                            });
                        }
         });
      });

      // Function to gather the KRA data from the table
    //   function gatherKraData(validate) {
    //     var valid = true;   


    //      var kraData = [];
    //      $('tr').each(function() {
    //         var kraId = $(this).data('kraid');
    //         var subKraId = $(this).data('subkraid');
            
    //         // Check if the element has id starting with 'input-rating-'
    //         if ($(this).find('#input-rating-' + subKraId).length) {
    //             // Retrieve the value of the input field (not text())
    //             var rating = $(this).find('#input-rating-' + subKraId).val();
    //         }
    //         // Check if the element has id starting with 'display-rating-'
    //         if ($(this).find('#display-rating-' + subKraId).length) {
    //             // Retrieve the text inside the span
    //             var rating = $(this).find('#display-rating-' + subKraId).text();
    //         }

    //         if ($(this).find('#input-rating-kra-' + kraId).length) {
    //             // Retrieve the value of the input field (not text())
    //             var krarating = $(this).find('#input-rating-kra-' + kraId).val();
    //         }

    //         // Check if the element has id starting with 'display-rating-'
    //         if ($(this).find('#display-value' + kraId).length) {
    //             // Retrieve the text inside the span
    //             var krarating = $(this).find('#display-value' + kraId).text();
    //         }

    //         var remarks = $(this).find('#textarea-remark-' + subKraId).val();
    //         var kraremarks = $(this).find('#kraremark' + kraId).val();
          
    //         if (validate) {
    //             let hasError = false;

    //             // Check Sub-KRA Remarks
    //             if ((!remarks || remarks.trim() === "") && subKraId) {
    //                 $('#textarea-remark-' + subKraId).css('border', '2px solid red');

    //                 if (!hasError) {
    //                     let subKraElement = $('#textarea-remark-' + subKraId);
    //                     if (subKraElement.length) {
    //                         $('html, body').animate({
    //                             scrollTop: subKraElement.offset().top - 100
    //                         }, 500);
    //                         hasError = true;
    //                     }
    //                 }

    //                 valid = false;
    //             } else {
    //                 $('#textarea-remark-' + subKraId).css('border', '');
    //             }

    //             // Check KRA Remarks
    //             if ((!kraremarks || kraremarks.trim() === "") && kraId) {
    //                 $('#kraremark' + kraId).css('border', '2px solid red');

    //                 if (!hasError) {
    //                     let kraElement = $('#kraremark' + kraId);
    //                     if (kraElement.length) {
    //                         $('html, body').animate({
    //                             scrollTop: kraElement.offset().top - 100
    //                         }, 500);
    //                         hasError = true;
    //                     }
    //                 }

    //                 valid = false;
    //             } else {
    //                 $('#kraremark' + kraId).css('border', '');
    //             }
    //         }

    //         var subKraScore = $(this).find('#subkrascoreforma' + subKraId).text();
    //         var KraScore = $(this).find('#krascorespan' + kraId).text();

    //         var subKralogScore = $(this).find('#logscoresubkra' + subKraId).val();
    //         var KralogScore = $(this).find('#logScorekra' + kraId).val();
        
    //         // Check if logScore or subLogScore is empty, '0.0', or '0.00', and fallback to text if necessary
    //         if (!KralogScore || KralogScore === "0.0" || KralogScore === "0.00") {
    //              KralogScore = $(this).find('#logScorekra' + kraId).text();  // Fallback to text
    //         }
    //         if (!subKralogScore || subKralogScore === "0.0" || subKralogScore === "0.00") {
    //              subKralogScore = $(this).find('#logscoresubkra' + subKraId).text();  // Fallback to text
    //         }

    //         if (kraId || subKraId) {
    //            kraData.push({
    //               kraId: kraId,
    //               subKraId: subKraId,
    //               rating: rating,
    //               krarating: krarating,
    //               KralogScore: KralogScore,
    //               subKralogScore: subKralogScore,
    //               subKraScore: subKraScore,
    //               KraScore: KraScore,
    //               kraremarks: kraremarks,
    //               remarks: remarks,
    //            });
    //         }
    //      });
    //      return kraData;
    //   }
    function gatherKraData(validate) {
    var valid = true;
    var kraData = [];

    $('tr').each(function () {
        var kraId = $(this).data('kraid');
        var subKraId = $(this).data('subkraid');

        let rating = '';
        let krarating = '';

        // Sub-KRA Rating (Input or Display)
        if ($(this).find('#input-rating-' + subKraId).length) {
            rating = $(this).find('#input-rating-' + subKraId).val();
        } else if ($(this).find('#display-rating-' + subKraId).length) {
            rating = $(this).find('#display-rating-' + subKraId).text();
        }

        // KRA Rating (Input or Display)
        if ($(this).find('#input-rating-kra-' + kraId).length) {
            krarating = $(this).find('#input-rating-kra-' + kraId).val();
        } else if ($(this).find('#display-value' + kraId).length) {
            krarating = $(this).find('#display-value' + kraId).text();
        }

        // Remarks
        var remarks = $('#textarea-remark-' + subKraId).val();
        var kraremarks = $('#kraremark' + kraId).val();

        var hasError = false;

        if (validate) {
            // Sub-KRA Remark Validation
            if ((!remarks || remarks.trim() === "") && subKraId) {
                var $remarkField = $('#textarea-remark-' + subKraId);
                $remarkField.css('border', '2px solid red');
                valid = false;
                if (!hasError && $remarkField.length) {
                    $('html, body').animate({
                        scrollTop: $remarkField.offset().top - 100
                    }, 500);
                    hasError = true;
                }
            } else {
                $('#textarea-remark-' + subKraId).css('border', '');
            }

            // KRA Remark Validation
            if ((!kraremarks || kraremarks.trim() === "") && kraId) {
                var $kraRemarkField = $('#kraremark' + kraId);
                $kraRemarkField.css('border', '2px solid red');
                valid = false;
                if (!hasError && $kraRemarkField.length) {
                    $('html, body').animate({
                        scrollTop: $kraRemarkField.offset().top - 100
                    }, 500);
                    hasError = true;
                }
            } else {
                $('#kraremark' + kraId).css('border', '');
            }

            // Sub-KRA Rating Validation
            if ((!rating || rating.trim() === "") && subKraId) {
                var $subRatingField = $('#input-rating-' + subKraId);
                $subRatingField.css('border', '2px solid red');
                valid = false;
                if (!hasError && $subRatingField.length) {
                    $('html, body').animate({
                        scrollTop: $subRatingField.offset().top - 100
                    }, 500);
                    hasError = true;
                }
            } else {
                $('#input-rating-' + subKraId).css('border', '');
            }

            // KRA Rating Validation
            if ((!krarating || krarating.trim() === "") && kraId) {
                var $kraRatingField = $('#input-rating-kra-' + kraId);
                $kraRatingField.css('border', '2px solid red');
                valid = false;
                if (!hasError && $kraRatingField.length) {
                    $('html, body').animate({
                        scrollTop: $kraRatingField.offset().top - 100
                    }, 500);
                    hasError = true;
                }
            } else {
                $('#input-rating-kra-' + kraId).css('border', '');
            }

            // Skip row if any validation failed for this row
            if (!remarks || !kraremarks || !rating || !krarating) {
                return;
            }
        }

        var subKraScore = $(this).find('#subkrascoreforma' + subKraId).text();
        var KraScore = $(this).find('#krascorespan' + kraId).text();

        var subKralogScore = $(this).find('#logscoresubkra' + subKraId).val();
        var KralogScore = $(this).find('#logScorekra' + kraId).val();

        if (!KralogScore || KralogScore === "0.0" || KralogScore === "0.00") {
            KralogScore = $(this).find('#logScorekra' + kraId).text();
        }
        if (!subKralogScore || subKralogScore === "0.0" || subKralogScore === "0.00") {
            subKralogScore = $(this).find('#logscoresubkra' + subKraId).text();
        }

        if (kraId || subKraId) {
            kraData.push({
                kraId: kraId,
                subKraId: subKraId,
                rating: rating,
                krarating: krarating,
                KralogScore: KralogScore,
                subKralogScore: subKralogScore,
                subKraScore: subKraScore,
                KraScore: KraScore,
                kraremarks: kraremarks,
                remarks: remarks,
            });
        }
    });

    if (validate && !valid) {
        return false;
    }

    return kraData;
}




        function gatherKraDataFormb(validate) {
            var valid = true;
            var kraDataformb = [];

            $('tr[data-formbkraid]').each(function () {
                var formKraId = $(this).data('formbkraid');
                var subFormKraId = $(this).data('formbsubkraid');

                var rating = '';
                var krarating = '';

                if (formKraId) {
                    if ($(this).find('#input-rating-formb-' + formKraId).length) {
                        krarating = $(this).find('#input-rating-formb-' + formKraId).val();
                    }
                    if ($(this).find('#display-rating-formb-' + formKraId).length) {
                        krarating = $(this).find('#display-rating-formb-' + formKraId).text();
                    }
                }

                if (subFormKraId) {
                    if ($(this).find('#input-rating-subformb-' + subFormKraId).length) {
                        rating = $(this).find('#input-rating-subformb-' + subFormKraId).val();
                    }
                    if ($(this).find('#display-rating-subformb-' + subFormKraId).length) {
                        rating = $(this).find('#display-rating-subformb-' + subFormKraId).text();
                    }
                }

                var remarks = $(this).find('#formbremark' + formKraId).val();
                var subFormRemarks = $(this).find('#subformbremark' + subFormKraId).val();
                var hasError = false;

                if (validate) {
                    // Validate formKra remarks
                    if ((!remarks || remarks.trim() === "") && formKraId) {
                        $('#formbremark' + formKraId).css('border', '2px solid red');
                        if (!hasError) {
                            $('html, body').animate({
                                scrollTop: $('#formbremark' + formKraId).offset().top - 100
                            }, 500);
                            hasError = true;
                        }
                        valid = false;
                    } else {
                        $('#formbremark' + formKraId).css('border', '');
                    }

                    // Validate subFormKra remarks
                    if ((!subFormRemarks || subFormRemarks.trim() === "") && subFormKraId) {
                        $('#subformbremark' + subFormKraId).css('border', '2px solid red');
                        if (!hasError) {
                            $('html, body').animate({
                                scrollTop: $('#subformbremark' + subFormKraId).offset().top - 100
                            }, 500);
                            hasError = true;
                        }
                        valid = false;
                    } else {
                        $('#subformbremark' + subFormKraId).css('border', '');
                    }

                    // Validate KRA rating
                    if ((!krarating || krarating.trim() === "") && formKraId) {
                        $('#input-rating-formb-' + formKraId).css('border', '2px solid red');
                        if (!hasError) {
                            $('html, body').animate({
                                scrollTop: $('#input-rating-formb-' + formKraId).offset().top - 100
                            }, 500);
                            hasError = true;
                        }
                        valid = false;
                    } else {
                        $('#input-rating-formb-' + formKraId).css('border', '');
                    }

                    // Validate Sub-KRA rating
                    if ((!rating || rating.trim() === "") && subFormKraId) {
                        $('#input-rating-subformb-' + subFormKraId).css('border', '2px solid red');
                        if (!hasError) {
                            $('html, body').animate({
                                scrollTop: $('#input-rating-subformb-' + subFormKraId).offset().top - 100
                            }, 500);
                            hasError = true;
                        }
                        valid = false;
                    } else {
                        $('#input-rating-subformb-' + subFormKraId).css('border', '');
                    }
                }

                // Only push valid rows
                if (!validate || (remarks && subFormRemarks && rating && krarating)) {
                    var kraScore = $(this).find('#krascoreformb' + formKraId).text();
                    var subKraScore = $(this).find('#subkrascoreformb' + subFormKraId).text();

                    var subKralogScore = $(this).find('#logScoresubkraformb' + subFormKraId).val();
                    var logScore = $(this).find('#logScorekraformb' + formKraId).val();

                    if (!logScore || logScore === "0.0" || logScore === "0.00") {
                        logScore = $(this).find('#logScorekraformb' + formKraId).text();
                    }
                    if (!subKralogScore || subKralogScore === "0.0" || subKralogScore === "0.00") {
                        subKralogScore = $(this).find('#logScoresubkraformb' + subFormKraId).text();
                    }

                    if (formKraId || subFormKraId) {
                        kraDataformb.push({
                            formKraId,
                            subFormKraId,
                            rating,
                            krarating,
                            logScore,
                            subLogScore: subKralogScore,
                            subKraScore,
                            kraScore,
                            remarks,
                            subFormRemarks,
                        });
                    }
                }
            });

            if (validate && !valid) {
                return false;
            }

            return kraDataformb;
        }

        // function gatherKraDataFormb(validate) {
        //     var valid = true; // Flag to track validity
        //     var kraDataformb = []; // Array to hold the data

        //     // Loop through each row (this includes both the main form and subforms)
        //     $('tr[data-formbkraid]').each(function() {
        //         var formKraId = $(this).data('formbkraid'); // Main form KRA ID
        //         var subFormKraId = $(this).data('formbsubkraid'); // Subform KRA ID

        //         // For the main form: Retrieve the rating and score (if available)
        //         var rating = '';
        //         var krarating = '';
                
        //         // Main KRA Rating (from input or display)
        //         if (formKraId) {
        //             if ($(this).find('#input-rating-formb-' + formKraId).length) {
        //                 krarating = $(this).find('#input-rating-formb-' + formKraId).val();
        //             }
        //             if ($(this).find('#display-rating-formb-' + formKraId).length) {
        //                 krarating = $(this).find('#display-rating-formb-' + formKraId).text();
        //             }
        //         }

        //         // Subform KRA Rating (from input or display)
        //         if (subFormKraId) {
        //             if ($(this).find('#input-rating-subformb-' + subFormKraId).length) {
        //                 rating = $(this).find('#input-rating-subformb-' + subFormKraId).val();
        //             }
        //             if ($(this).find('#display-rating-subformb-' + subFormKraId).length) {
        //                 rating = $(this).find('#display-rating-subformb-' + subFormKraId).text();
        //             }
        //         }

        //         // Remarks for both main form and subform
        //         var remarks = $(this).find('#formbremark' + formKraId).val();
        //         var subFormRemarks = $(this).find('#subformbremark' + subFormKraId).val();
        //         let valid = true; // Declare before the validation starts
        //         let hasError = false;

        //         if (validate) {

        //             // Check Sub-KRA Remarks
        //             if ((!remarks || remarks.trim() === "") && formKraId) {
        //                 $('#formbremark' + formKraId).css('border', '2px solid red');

        //                 if (!hasError) {
        //                     let subKraElement = $('#formbremark' + formKraId);
        //                     if (subKraElement.length) {
        //                         $('html, body').animate({
        //                             scrollTop: subKraElement.offset().top - 100
        //                         }, 500);
        //                         hasError = true;
        //                     }
        //                 }

        //                 valid = false;
        //             } else {
        //                 $('#formbremark' + formKraId).css('border', '');
        //             }

        //             // Check KRA Remarks
        //             if ((!subFormRemarks || subFormRemarks.trim() === "") && subFormKraId) {
        //                 $('#subformbremark' + subFormKraId).css('border', '2px solid red');

        //                 if (!hasError) {
        //                     let kraElement = $('#subformbremark' + subFormKraId);
        //                     if (kraElement.length) {
        //                         $('html, body').animate({
        //                             scrollTop: kraElement.offset().top - 100
        //                         }, 500);
        //                         hasError = true;
        //                     }
        //                 }

        //                 valid = false;
        //             } else {
        //                 $('#subformbremark' + subFormKraId).css('border', '');
        //             }
        //         }
        //         alert(hasError);
        //         if (!valid) {
        //             return;
        //         }

        //         // Getting other required data such as scores and logic
        //         var kraScore = $(this).find('#krascoreformb' + formKraId).text();
        //         var subKraScore = $(this).find('#subkrascoreformb' + subFormKraId).text();


        //         var subKralogScore = $(this).find('#logScoresubkraformb' + subFormKraId).val();
        //         var logScore = $(this).find('#logScorekraformb' + formKraId).val();
            
        //         // Check if logScore or subLogScore is empty, '0.0', or '0.00', and fallback to text if necessary
        //         if (!logScore || logScore === "0.0" || logScore === "0.00") {
        //             logScore = $(this).find('#logScorekraformb' + formKraId).text();  // Fallback to text
        //         }
        //         if (!subKralogScore || subKralogScore === "0.0" || subKralogScore === "0.00") {
        //             subKralogScore = $(this).find('#logScoresubkraformb' + subFormKraId).text();  // Fallback to text
        //         }

        //         // Push the data to kraDataformb array for both the main and subforms
        //         if (formKraId || subFormKraId) {
        //             kraDataformb.push({
        //                 formKraId: formKraId,
        //                 subFormKraId: subFormKraId,
        //                 rating: rating,
        //                 krarating: krarating,
        //                 logScore: logScore,
        //                 subLogScore: subKralogScore,
        //                 subKraScore: subKraScore,
        //                 kraScore: kraScore,
        //                 remarks: remarks,
        //                 subFormRemarks: subFormRemarks,
        //             });
        //         }
        //     });

        //     return kraDataformb; // Return the gathered data
        // }
        function gatherAppraiserData() {
            var appraiserData = {};

            // Loop through the rows in the tbody
            $('tbody tr').each(function(index) {
                // Handle Appraiser Row (2nd row)
                if (index === 1) {
                    appraiserData['Appraiser'] = {};
                    appraiserData['Appraiser']['AppraiserFormAScore'] = $('#pmsscoreforma').text() || '';  // Appraiser Form A Score
                    appraiserData['Appraiser']['FormAKraAllow_PerOfWeightage'] = $('#formawgt').text() || '';  // Form A Kra Weightage
                    appraiserData['Appraiser']['FormAScorePerWeightage'] = $('#formasperwgt').text() || '';  // Form A Score Per Weightage
                    appraiserData['Appraiser']['AppraiserFormBScore'] = $('#pmsscoreformb').text() || '';  // Appraiser Form B Score
                    appraiserData['Appraiser']['FormBBehaviAllow_PerOfWeightage'] = $('#formbwgt').text() || '';  // Form B Weightage
                    appraiserData['Appraiser']['AppraiserFinalScore'] = $('#pmsscoreformbasperwgt').text() || '';  // Final Score for Form B
                    appraiserData['Appraiser']['TotalFinalScore'] = $('#totaladdb').text() || '';  // Total Final Score
                    appraiserData['Appraiser']['AppraiserTotalFinalRating'] = '';  // Total Rating for Appraiser (next element if needed)

                }
            });

            console.log(appraiserData);
            return appraiserData;
        }
        function gatherTrainingData() {
            var trainingData = {
                "SoftSkillsTraining": [],
                "FunctionalSkillsTraining": []
            };

            // Gather data from the Soft Skills Training Table
            $('#training-table-a tbody tr').each(function() {
                var softSkill = {};

                // Get the category, topic, and description from the row
                softSkill['category'] = $(this).find('.category-select').val();
                softSkill['Tid'] = $(this).find('.hidden-tid').val();

                softSkill['topic'] = $(this).find('.topic-select').val();
                softSkill['description'] = $(this).find('.description-cell').text();
                if (!softSkill['description']) {
                    softSkill['description'] = $(this).find('.description-cell input').val();
                }
                // Push the data for each row into the array
                if (softSkill['category'] && softSkill['topic']) {
                    trainingData['SoftSkillsTraining'].push(softSkill);
                }
            });

            // Gather data from the Functional Skills Training Table
            $('#training-table tbody tr').each(function() {
                var functionalSkill = {};

                // Get the topic and description from the row
                functionalSkill['topic'] = $(this).find('.topic-select-selectb').val();
                functionalSkill['Tid'] = $(this).find('.hidden-tid-tech').val();
               
                if ($(this).find('.custom-description-input').length) {
                functionalSkill['description'] = $(this).find('.custom-description-input').val();
                } else if ($(this).find('.description-cell-selectb').length) {
                    functionalSkill['description'] = $(this).find('.description-cell-selectb').text();
                }
                // Push the data for each row into the array
                if (functionalSkill['topic']) {
                    trainingData['FunctionalSkillsTraining'].push(functionalSkill);
                }
            });
            return trainingData;
        }
        function gatherPromotionRecommendationData() {
                // Fetch the selected grade
                var selectedGrade = document.getElementById('gradeSelect').value;

                // Fetch the selected designation
                var selectedDesignation = document.getElementById('designationSelect').value;
                var promotionDescription = document.getElementById('promdescription').value;

                // Create an object to store the gathered data
                var promotionData = {
                    grade: selectedGrade,
                    designation: selectedDesignation,
                    promotionDescription:promotionDescription
                };

                // Return the promotionData object
                return promotionData;
            }



    });
    document.addEventListener('DOMContentLoaded', function() {
    const gradeSelect = document.getElementById('gradeSelect');
    const designationSelect = document.getElementById('designationSelect');

    gradeSelect.addEventListener('change', function () {
        const selectedGradeId = this.value;
        let firstMatch = null;
        let matchedSelected = false;

        Array.from(designationSelect.options).forEach(option => {
            const gradeIds = (option.dataset.gradeIds || '').split(',');
            const matches = gradeIds.includes(selectedGradeId);

            if (matches) {
                option.style.display = '';
                if (!firstMatch) firstMatch = option;

                // Check if this option is already selected
                if (option.selected) matchedSelected = true;
            } else {
                option.style.display = 'none';
                option.removeAttribute('selected');
            }
        });

        // ✅ If current selection is invalid, fallback to first match
        if (!matchedSelected && firstMatch) {
            designationSelect.value = firstMatch.value;
            firstMatch.setAttribute('selected', 'selected');
        }
    });

    designationSelect.addEventListener('change', function () {
        Array.from(this.options).forEach(option => option.removeAttribute('selected'));
        this.options[this.selectedIndex].setAttribute('selected', 'selected');
    });

    // ✅ Trigger on load
    gradeSelect.dispatchEvent(new Event('change'));
});


      
   </script>
   <style>
      #loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.7);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      }
      .spinner-border {
      width: 3rem;
      height: 3rem;
      }
   </style>