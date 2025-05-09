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
         <div class="card-header" style="background-color: #c4d9db; position: sticky; top: 0; z-index: 10;">
            <h5>
               <b>{{ $employeedetailspms->Fname }} {{ $employeedetailspms->Sname }} {{ $employeedetailspms->Lname }}</b> 
            </h5>
            <h5>
               <b>Emp Code: {{ $employeedetailspms->EmpCode }}</b> &nbsp;&nbsp;&nbsp; <b>Designation:</b>{{ $employeedetailspms->department_name }}
            </h5>
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
            <div class="card-body table-responsive dd-flex align-items-center p-0">
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
                              onClick="showKraDetailsappraisal('{{ $kraforma->KRAId }}', '{{ $kraforma->Period }}', '{{ $kraforma->Target }}', '{{ $kraforma->Weightage }}', '{{ $kraforma->Logic }}', '{{ $year_pms->CurrY }}')">
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
                        $kraAchSum = DB::table('hrm_pms_kra_tgtdefin')
                        ->where('KRAId', $kraforma->KRAId)
                        ->sum('AppAch');
                        $adjustedAch = match ($kraforma->Period) {
                        'Quarter' => $kraAchSum / 4,
                        '1/2 Annual' => $kraAchSum / 2,
                        'Monthly' => $kraAchSum / 12,
                        default => $kraAchSum, // Annual remains unchanged
                        };
                        if ($kraforma->Period === 'Annual') {
                        $adjustedAch = $kraforma->AppraiserRating;
                        }
                        $krascoreSum = DB::table('hrm_employee_pms_kraforma')->where('KRAFormAId', $kraforma->KRAFormAId)->sum('AppraiserScore');                                                                                  
                        $kralogSum = DB::table('hrm_employee_pms_kraforma')->where('KRAFormAId', $kraforma->KRAFormAId)->sum('AppraiserLogic');                                                                                  

                        $krascoreSumreviewer = DB::table('hrm_employee_pms')
                                ->where('EmpPmsId', $kraforma->EmpPmsId)
                                ->select('ReviewerFormAScore')
                                ->first(); // Use first() if you expect a single result

                        $grandTotalScore += $krascoreSum;
                        @endphp
                        <td>
                           <span class="display-value" id="display-value{{ $kraforma->KRAId }}">{{ round($adjustedAch, 2) }}</span>
                         
                        </td>
                        <td>
                           <span>{{ $kraforma->AppraiserRemark }}</span>
                        </td>
                        <td>
                           <span id="krascorespan{{$kraforma->KRAId}}"  class="" >{{$krascoreSum,2}}</span>
                        </td>
                        
                        <td>
                           <span id="logScorekra{{$kraforma->KRAId}}"  class="d-none" >{{$kralogSum,2}}</span>
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
                                 $subKraAchSum = DB::table('hrm_pms_kra_tgtdefin')->where('KRASubId', $subkra->KRASubId)->sum('AppAch');
                                 $adjustedAchsub = match ($subkra->Period) {'Quarter' => $subKraAchSum / 4,
                                 '1/2 Annual' => $subKraAchSum / 2,
                                 'Monthly' => $subKraAchSum / 12,
                                 default => $subKraAchSum, // Annual remains unchanged
                                 };
                                 if ($subkra->Period === 'Annual') {
                                 $adjustedAchsub = $subkra->AppraiserRating;
                                 }    
<<<<<<< HEAD
                                 if ($subkra->Period === 'Annual') {
                                 $subKraAchSum = $subkra->AppraiserScore;
                                 }  
                                 else{
                                 $subKraAchSum = DB::table('hrm_pms_kra_tgtdefin')->where('KRASubId', $subkra->KRASubId)->sum('AppScor');
                                 }
=======
                                 $subKraAchSum = DB::table('hrm_pms_kra_tgtdefin')->where('KRASubId', $subkra->KRASubId)->sum('AppScor');

>>>>>>> 5b0a2123eab6d243003c8f1ba2a16751b432c0e9
                                 $subKralogSum = DB::table('hrm_pms_kra_tgtdefin')->where('KRASubId', $subkra->KRASubId)->sum('AppLogScr');

                                 $grandTotalScore += $subKraAchSum;
                                 @endphp
                                 <tr data-kraid="{{ $kraforma->KRAId }}" data-subkraid="{{ $subkra->KRASubId }}">
                                 <td><b>{{ $subIndex + 1 }}.</b></td>
                                    <td>{{ $subkra->KRA ?? '' }}</td>
                                    <td>{{ $subkra->KRA_Description ?? '' }}</td>
                                    <td>{{ $subkra->Measure ?? '' }}</td>
                                    <td>{{ $subkra->Unit ?? '' }}</td>
                                    <td>{{ $subkra->Weightage ?? '' }}</td>
                                    <td>{{ $subkra->Logic ?? '' }}</td>
                                    <td>{{ $subkra->Period ?? '' }}</td>
                                    <td>
                                       @if ($subkra->Period !== 'Annual')
                                       <button id="Tar_a{{ $subkra->KRASubId }}"
                                          style="padding: 5px 8px;" 
                                          type="button" 
                                          class="btn btn-outline-success custom-toggle" 
                                          data-bs-toggle="modal"
                                          onClick="showKraDetailsappraisal('sub_{{ $subkra->KRASubId }}', '{{ $subkra->Period }}', '{{ $subkra->Target }}', '{{ $subkra->Weightage }}', '{{ $subkra->Logic }}', '{{ $year_pms->CurrY }}')">
                                       <span class="icon-on">{{ $subkra->Target }}</span> 
                                       </button>
                                       @else
                                       <span class="icon-on">{{ $subkra->Target }}</span>
                                       @endif
                                    </td>
                                    <td>
                                       <span>{{ $subkra->SelfRating ?? 0 }}</span>
                                    </td>
                                    <td>
                                       <span id="display-remark-{{ $subkra->KRASubId }}">{{ $subkra->AchivementRemark }}</span>
                                    </td>
                                    <td>
                                       <span id="display-rating-{{ $subkra->KRASubId }}">{{ $adjustedAchsub ?? 0 }}</span>                      
                                      
                                    </td>
                                    <td>
                                       <span>{{ $subkra->AppraiserRemark }}</span>
                                    </td>
                                    <td><span id="subkrascoreforma{{$subkra->KRASubId}}">{{$subKraAchSum,2}}</span>                              
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
                        <td >{{ round($grandTotalScore, 2) }}</td>
                     </tr>
                     <tr style="background-color: #76a0a3;font-weight:600;">
                        <td  class="text-right" colspan="13">Final Reviewer KRA Score Form A :</td>
                        <td>{{ round($krascoreSumreviewer->ReviewerFormAScore ?? 0, 2)}}
                        </td>

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
                        <td>{{ $form->Weightage }}</td>
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
                           <span class="icon-on">{{ $form->Target }}</span> 
                           </button>
                           @else
                           <span class="icon-on">{{ $form->Target }}</span>
                           @endif
                        </td>
                        @php
                        $kraAchSum = DB::table('hrm_pms_formb_tgtdefin')
                        ->where('FormBId', $form->FormBId)
                        ->where('EmployeeID', $employeeid)
                        ->where('YearId', $PmsYId)
                        ->sum('LogScr');
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
                        $krascoreSumreviewerFormB = DB::table('hrm_employee_pms')
                                ->where('EmpPmsId', $kraforma->EmpPmsId)
                                ->select('ReviewerFormBScore')
                                ->first(); // Use first() if you expect a single result

                        @endphp
                        <td>
                           <span>{{ round($kraAchSum, 2) }}</span>
                        </td>
                        <td>
                           <span >{{ $form->Comments_Example }}</span>
                        </td>
                        <td>
                           <span id="display-rating-formb-{{ $form->BehavioralFormBId }}">{{ round($kraAchSumapp, 2) }}</span>
                          
                        </td>
                        <td>
                           <span placeholder="Enter your remarks">{{ $form->AppraiserRemark}}</span>
                        </td>
                        <td>
                           <span id="krascoreformb{{$form->BehavioralFormBId}}" >{{$krascoreSum,2}}</span>
                        </td>
                        <input type="hidden" class="logscore"  value="{{ $kralogscore, 2}}" id="logScorekraformb{{$form->BehavioralFormBId}}">

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
                                    <td>{{ $subForm->Weightage }}</td>
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
                                       <span class="icon-on">{{ $subForm->Target }}</span> 
                                       </button>
                                       @else
                                       <span class="icon-on">{{ $subForm->Target }}</span>
                                       @endif
                                    </td>
                                    <td>
                                       @php
                                       $adjustedAchsub = DB::table('hrm_pms_formb_tgtdefin')
                                       ->where('FormBSubId', $subForm->FormBSubId)
                                       ->where('EmployeeID',$employeeid)
                                       ->where('YearId',$PmsYId)
                                       ->sum('LogScr');
                                       $adjustedAchsubapp = DB::table('hrm_pms_formb_tgtdefin')
                                       ->where('FormBSubId', $subForm->FormBSubId)
                                       ->where('EmployeeID',$employeeid)
                                       ->where('YearId',$PmsYId)
                                       ->sum('AppLogScr');
                                       $subKraAchSum = DB::table('hrm_pms_formb_tgtdefin')
                                       ->where('FormBSubId', $subForm->FormBSubId)
                                       ->where('EmployeeID',$employeeid)
                                       ->where('YearId',$PmsYId)
                                       ->sum('AppScor');

                                       if ($subForm->Period === 'Annual') {
                                                $sublogscore = DB::table('hrm_employee_pms_behavioralformb_sub')
                                                                ->where('FormBSubId', $subForm->FormBSubId)
                                                                ->sum('AppraiserLogic');
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
                                       <span>{{ round($adjustedAchsubapp,2)}}</span>                                      
                                      
                                    </td>
                                    <td>
                                       <span>{{ $subForm->AppraiserRemark}}</span>
                                    </td>
                                    <td>
                                       <span id="subkrascoreformb{{$subForm->FormBSubId}}">{{$subKraAchSum,2}}</span>
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
                        <td>{{ round($grandTotalScore, 2) }}</td>
                     </tr>
                     <tr style="background-color: #76a0a3;font-weight:600;">
                        <td  class="text-right" colspan="11">Final Appraiser KRA Score Form B :</td>
                        <td>{{ round($krascoreSumreviewerFormB->ReviewerFormBScore ?? 0, 2) }}
                        </td>
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
                        <td>{{$employeealldetailsforpms->AppraiserFormAScore}}</td>
                        @else
                        <td></td>
                        @endif
                        <td >{{$employeealldetailsforpms->FormAKraAllow_PerOfWeightage}}</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td>{{ ($employeealldetailsforpms->AppraiserFormAScore * $employeealldetailsforpms->FormAKraAllow_PerOfWeightage) / 100 }}</td>
                        @else
                        <td></td>
                        @endif
                        @if($data['emp']['Appform'] == 'Y')
                        <td>{{$employeealldetailsforpms->AppraiserFormBScore}}</td>
                        @else
                        <td></td>
                        @endif
                        <td>{{$employeealldetailsforpms->FormBBehaviAllow_PerOfWeightage}}</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td>{{$employeealldetailsforpms->Appraiser_TotalFinalScore}}</td>
                        @else
                        <td></td>
                        @endif
                        <td>{{ number_format($employeealldetailsforpms->AppraiserFinallyFormA_Score + $employeealldetailsforpms->AppraiserFinallyFormB_Score, 2) }}</td>

                        
                        @if($data['emp']['Appform'] == 'Y')
                        <td >{{$employeealldetailsforpms->Appraiser_TotalFinalRating}}</td>
                        @else
                        <td></td>
                        @endif
                     </tr>
                     <tr>
                        @php 
                        $formbfinal = ($employeealldetailsforpms->ReviewerFormBScore * $employeealldetailsforpms->FormBBehaviAllow_PerOfWeightage) / 100 ;
                        
                        @endphp
                        <td>Reviewer</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td id="pmsscoreforma">{{$employeealldetailsforpms->ReviewerFormAScore}}</td>
                        @else
                        <td></td>
                        @endif
                        <td id="formawgt">{{$employeealldetailsforpms->FormAKraAllow_PerOfWeightage}}</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td id="formasperwgt">{{ ($employeealldetailsforpms->ReviewerFormAScore * $employeealldetailsforpms->FormAKraAllow_PerOfWeightage) / 100 }}</td>
                        @else
                        <td></td>
                        @endif
                        @if($data['emp']['Appform'] == 'Y')
                        <td id="pmsscoreformb">{{$employeealldetailsforpms->ReviewerFormBScore}}</td>
                        @else
                        <td></td>
                        @endif
                        <td id="formbwgt">{{$employeealldetailsforpms->FormBBehaviAllow_PerOfWeightage}}</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td id="pmsscoreformbasperwgt">{{$employeealldetailsforpms->Reviewer_TotalFinalScore}}</td>
                        @else
                        <td></td>
                        @endif
                        <td id="totaladdb">{{ number_format($employeealldetailsforpms->ReviewerFinallyFormA_Score + $employeealldetailsforpms->ReviewerFinallyFormB_Score, 2) }}</td>
                        @if($data['emp']['Appform'] == 'Y')
                        <td >{{$employeealldetailsforpms->Reviewer_TotalFinalRating}}</td>
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
                        <td><b>{{ $designation }}</b></td>
                        <td><b>-</b></td>
                     </tr>
                     <tr>
                        <td><b>Appraiser</b></td>
                        <td>{{$gradeappraiser}}</td>
                        <td>{{$designationappraiser}}</td>
                        <td>{{$employeealldetailsforpms->Appraiser_Justification}}</td>
                        </td>
                     </tr>
                     <tr>
                        <td><b>Reviewer</b></td>
                        <td>{{$gradereviewer}}</td>

                        <td>{{$designationreviewer}}</td>
                        <td>{{$employeealldetailsforpms->Reviewer_Justification}}</td>
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
                        <th></th>
                        <th>Category</th>
                        <th>Topic</th>
                        <th>Description</th>
                        <th></th>
                     </tr>
                  </thead>
                    <tbody>
<<<<<<< HEAD
                     
                    @php 
                     // Fetch Other Description for the employee (only once before the loop)
                     $employeePmsDataApp= DB::table('hrm_employee_pms')
                           ->where('EmployeeID', $employeeDetails->EmployeeID)
                           ->where('AssessmentYear', $PmsYId)
                           ->select('Appraiser_SoftSkill_Oth_Desc')
                           ->first();  
                     $employeePmsDataRev = DB::table('hrm_employee_pms')
                           ->where('EmployeeID', $employeeDetails->EmployeeID)
                           ->where('AssessmentYear', $PmsYId)
                           ->select('Reviewer_SoftSkill_Oth_Desc')
                           ->first(); 
                  @endphp

=======
>>>>>>> 5b0a2123eab6d243003c8f1ba2a16751b432c0e9
                    <!-- Display Appraisals Row -->
                    @foreach($softSkillsAppraisal as $appraisal)
                        <tr>
                            <td><b>Appraiser</b></td>
                            <td>{{ $appraisal->Category }}</td>
                            <td>{{ $appraisal->Topic }}</td>
<<<<<<< HEAD
                            <td>
                            @if($appraisal->Tid == 69)
                                {{ $employeePmsDataApp->Appraiser_SoftSkill_Oth_Desc ?? '' }}
                            @else
                                {{ $appraisal->Description }}
                            @endif
                        </td>
=======
                            <td>{{ $appraisal->Description }}</td>
>>>>>>> 5b0a2123eab6d243003c8f1ba2a16751b432c0e9
                            <td><input type="hidden" class="hidden-tid" value="{{ $appraisal->Tid }}"></td>
                        </tr>
                    @endforeach
                    @foreach($softSkillsReviewer as $reviewer)
                        <tr>
                            <td><b>Reviewer</b></td>
                            <td>{{ $reviewer->Category }}</td>
                            <td>{{ $reviewer->Topic }}</td>
<<<<<<< HEAD
                            <td>
                            @if($appraisal->Tid == 69)
                                {{ $employeePmsDataRev->Reviewer_SoftSkill_Oth_Desc ?? '' }}
                            @else
                                {{ $reviewer->Description }}
                            @endif
                        </td>
=======
                            <td>{{ $reviewer->Description }}</td>
>>>>>>> 5b0a2123eab6d243003c8f1ba2a16751b432c0e9
                            <td><input type="hidden" class="hidden-tid" value="{{ $reviewer->Tid }}"></td>
                        </tr>
                        @endforeach
                </tbody>

               </table>
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
                        <th>Sn</th>
                        <th>Topic</th>
                        <th>Description</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
<<<<<<< HEAD
                     @php 
                     // Fetch Other Description for the employee (only once before the loop)
                     $employeePmsDataApp= DB::table('hrm_employee_pms')
                           ->where('EmployeeID', $employeeDetails->EmployeeID)
                           ->where('AssessmentYear', $PmsYId)
                           ->select('Appraiser_TechSkill_Oth_Desc')
                           ->first();  
                     $employeePmsDataRev = DB::table('hrm_employee_pms')
                           ->where('EmployeeID', $employeeDetails->EmployeeID)
                           ->where('AssessmentYear', $PmsYId)
                           ->select('Reviewer_TechSkill_Oth_Desc')
                           ->first(); 
                  @endphp
=======
>>>>>>> 5b0a2123eab6d243003c8f1ba2a16751b432c0e9
                        <!-- Display Appraisals Row -->
                        @foreach($functionalSkillsAppraisal as $appraisal)
                            <tr>
                                <td><b>Appraiser</b></td>
                                <td>{{ $appraisal->Topic }}</td>
<<<<<<< HEAD
                                <td>
                            @if($appraisal->Tid == 70)
                                {{ $employeePmsDataApp->Appraiser_TechSkill_Oth_Desc ?? '' }}
                            @else
                                {{ $appraisal->Description }}
                            @endif
                        </td>
                        <td><input type="hidden" class="hidden-tid" value="{{ $appraisal->Tid }}"></td>
=======
                                <td>{{ $appraisal->Description }}</td>
                                <td><input type="hidden" class="hidden-tid" value="{{ $appraisal->Tid }}"></td>
>>>>>>> 5b0a2123eab6d243003c8f1ba2a16751b432c0e9
                            </tr>
                        @endforeach
                        @foreach($functionalSkillsReviewer as $reviewer)
                            <tr>
                                <td><b>Reviewer</b></td>
                                <td>{{ $reviewer->Topic }}</td>
<<<<<<< HEAD
                                <td>
                            @if($reviewer->Tid == 69)
                                {{ $employeePmsDataRev->Reviewer_TechSkill_Oth_Desc ?? '' }}
                            @else
                                {{ $reviewer->Description }}
                            @endif
                        </td>
=======
                                <td>{{ $reviewer->Description }}</td>
>>>>>>> 5b0a2123eab6d243003c8f1ba2a16751b432c0e9
                                <td><input type="hidden" class="hidden-tid" value="{{ $reviewer->Tid }}"></td>
                            </tr>
                        @endforeach

                    </tbody>
               </table>
            </div>
         </div>
         <div class="card">
            <div class="card-header">
               <div style="float:left;width:100%;">
                  <b>Appraisal Remark</b>
               </div>
            </div>
            <div class="card-body table-responsive dd-flex align-items-center">
               <span>{{$employeealldetailsforpms->Appraiser_Remark}}"</span>
            </div>
         </div>
         <div class="card">
            <div class="card-header">
               <div style="float:left;width:100%;">
                  <b>Reviewer REmarks</b>
               </div>
            </div>
            <div class="card-body table-responsive dd-flex align-items-center">
               <span>{{$employeealldetailsforpms->Reviewer_Remark}}</span>
            </div>
         </div>
      </div>
   </div>
   </div>

   <!--KRA View Details-->
   <div class="modal fade show" id="viewdetailskra" tabindex="-1"
      aria-labelledby="exampleModalCenterTitle" style="display: none;" data-bs-backdrop="static" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalCenterTitle3">KRA view details</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
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
                  data-bs-dismiss="modal">Close</button>
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
      function showKraDetailsappraisal(id, period, target, weightage, logic, year_id) {
            let isSubKra = id.startsWith("sub_"); // Check if it's a Sub-KRA
      
            let requestData = {
                kraId: isSubKra ? null : id,  
                subKraId: isSubKra ? id.replace("sub_", "") : null,  // Remove "sub_" to get only the numeric ID
                year_id: year_id
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
                let savestatus =detail.save_status;
                let submitstatus =detail.submit_status;
      
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
                    
      
                    let showEdit = (parseInt(PerM) === 1 && 
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
                                    <td>${detail.AppAch}</td>
                                    <td>${detail.AppCmnt}</td>
      
                                    <td >${detail.AppScor}</td>`;
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
                                        <td>${detail.AppAch}</td>
                                        <td>${detail.AppCmnt}</td>
                                        <td>${detail.AppScor}</td>
                                       
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