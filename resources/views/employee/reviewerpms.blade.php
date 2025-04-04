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
                                 if ($subkra->Period === 'Annual') {
                                 $adjustedAchsub = $subkra->AppraiserRating;
                                 }
                                 else{
                                    $adjustedAchsub = DB::table('hrm_pms_kra_tgtdefin')
                                                    ->where('KRASubId', $subkra->KRASubId)
                                                    ->sum('AppLogScr');
                                 }

                                 if ($subkra->Period != 'Annual') {

                                 $subKraAchSum = DB::table('hrm_pms_kra_tgtdefin')->where('KRASubId', $subkra->KRASubId)->sum('AppScor');
                                 }
                                 else{
                                    $subKraAchSum = $subkra->AppraiserScore;
                                 }
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
                        <td>
                        <input type="text" name="grandtotalfinalempreviewer" id="grandtotalfinalempreviewer" value="{{ round($krascoreSumreviewer->ReviewerFormAScore ?? 0, 2) }}">
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
                     $grandTotalScoreformb = 0;

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
                                       $grandTotalScoreformb += $subKraAchSum;
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
                        <td>{{ round($grandTotalScoreformb, 2) }}</td>
                     </tr>
                     <tr style="background-color: #76a0a3;font-weight:600;">
                        <td  class="text-right" colspan="11">Final Appraiser KRA Score Form B :</td>
                        <td>
                            <input type="text" name="grandtotalfinalempreviewerFormB" 
                            id="grandtotalfinalempreviewerFormB" value="{{ round($krascoreSumreviewerFormB->ReviewerFormBScore ?? 0, 2) }}">
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
                        <td>
                            <select style="width: 100%; background-color:#c4d9db;" id="gradeSelect">
                            <option value="{{ $gradeValue->id }}" 
                                @if($employeealldetailsforpms->Appraiser_EmpGrade == $gradeValue->id) 
                                    selected
                                @endif>
                                {{ $gradeValue->grade_name }}
                            </option>
                            <option value="{{ $nextGrade->id }}" selected>{{ $nextGrade->grade_name }}</option>
                            </select>
                        </td>

                        <td>
                        <select style="width: 100%; background-color:#c4d9db;" id="designationSelect">
                                @foreach($availableDesignations as $designation)
                                    <option value="{{ $designation->DesigId }}" style="white-space: nowrap;"
                                        @if($employeealldetailsforpms->Appraiser_EmpDesignation == $designation->DesigId) 
                                            selected
                                        @endif>
                                        {{ $designation->designation_name }}
                                    </option>
                                @endforeach
                            </select>

                        </td>
                        <td>
                           <input style="min-width: 300px;" value="{{$employeealldetailsforpms->Reviewer_Justification}}"id="promdescription" type="text">
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         @endif
         <style>
    /* Styling for Appraiser and Reviewer Tables */
    .appraiser-table { background-color: #e6f7ff; } /* Light Blue */
    .reviewer-table { background-color: #e6ffe6; } /* Light Green */
    .badge-appraiser { background-color: #007bff; color: white; } /* Blue Badge */
    .badge-reviewer { background-color: #28a745; color: white; } /* Green Badge */
</style>

<!-- SOFT SKILLS TRAINING -->
<div class="card">
    <div class="card-header">
        <h5><b>Training Requirements <i>[Mention training requirement during the next appraisal cycle.]</i></b></h5>
        <b>A) Soft Skills Training [Based on Behavioral Parameter]</b>
    </div>

    <div class="card-body table-responsive">
        <!-- Appraiser Table (Read-Only) -->
        <h5 class="text-primary"><b>Appraiser</b></h5>
        <table class="table mt-2 appraiser-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Topic</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($softSkillsAppraisal as $appraisal)
                    <tr>
                        <td>{{ $appraisal->Category }}</td>
                        <td>{{ $appraisal->Topic }}</td>
                        <td>{{ $appraisal->Description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Reviewer Table (Editable) -->
        <h5 class="text-success"><b>Reviewer</b></h5>
        <table class="table mt-2 reviewer-table" id="training-table-a">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Topic</th>
                    <th>Description</th>
                    <th></th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                @foreach($softSkillsReviewer as $index => $skill)
                    <tr>
                        <td><span>{{ $index + 1 }}</span></td>
                        <td>
                            <select class="category-select">
                                <option value="">Select Category</option>
                                @foreach($softSkills as $category => $topics)
                                    <option value="{{ trim($category) }}" {{ trim($category) === trim($skill->Category) ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="topic-select">
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
                        <td class="description-cell">
                            {{ trim($skill->Description) }}
                        </td>
                        <td><input type="hidden" class="hidden-tid" value=""></td>

                    </tr>
                @endforeach

                @if($softSkillsReviewer->isEmpty())
                    <tr>
                        <td><span>1</span></td>
                        <td>
                            <select class="category-select">
                                <option value="">Select Category</option>
                                @foreach($softSkills as $category => $skills)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="topic-select">
                                <option value="">Select Topic</option>
                            </select>
                        </td>
                        <td class="description-cell"></td>
                        <td><input type="hidden" class="hidden-tid" value=""></td>

                    </tr>
                @endif
            </tbody>
        </table>
        <button type="button" id="add-row-a" class="btn btn-primary">Add Row</button>
    </div>
</div>

<!-- FUNCTIONAL SKILLS TRAINING -->
<div class="card">
    <div class="card-header">
        <b>B) Functional Skills [Job Related]</b>
    </div>

    <div class="card-body table-responsive">
        <!-- Appraiser Table (Read-Only) -->
        <h5 class="text-primary"><b>Appraiser</b></h5>
        <table class="table mt-2 appraiser-table">
            <thead>
                <tr>
                    <th>Topic</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($functionalSkillsAppraisal as $appraisal)
                    <tr>
                        <td>{{ $appraisal->Topic }}</td>
                        <td>{{ $appraisal->Description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Reviewer Table (Editable) -->
        <h5 class="text-success"><b>Reviewer</b></h5>
        <table class="table mt-2 reviewer-table" id="training-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Topic</th>
                    <th>Description</th>
                    <th></th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                @foreach($functionalSkillsReviewer as $index => $skill)
                    <tr>
                        <td><span>{{ $index + 1 }}</span></td>
                        <td>
                            <select class="topic-select-selectb">
                                <option value="">Select Topic</option>
                                @foreach($trainings as $topics)
                                    <option value="{{ trim($topics->Topic) }}" {{ trim($topics->Topic) === trim($skill->Topic) ? 'selected' : '' }}>
                                        {{ $topics->Topic }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="description-cell-selectb">
                        @if($skill->Tid == 70)
                                {{ $pms_id->Reviewer_TechSkill_Oth ?? 'No description available' }}
                            @else
                                {{ trim($skill->Description) }}
                            @endif
                        </td>
                        <td><input type="hidden" class="hidden-tid-tech" value=""></td> <!-- Hidden Tid field -->

                    </tr>
                @endforeach

                @if($functionalSkillsReviewer->isEmpty())
                    <tr>
                        <td><span>1</span></td>
                   
                        <td>
                        <!-- Topic Dropdown -->
                        <select class="topic-select-selectb">
                            <option value="">Select Topic</option>
                            @foreach($trainings as $topic)
                                @if(strtolower($topic->Category) === strtolower($topic->Category))
                                    <option value="{{ $topic->Topic }}" data-tid="{{ $topic->Tid }}">{{ $topic->Topic }}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td class="description-cell-selectb">Select a topic to view description</td>
                    <td><input type="hidden" class="hidden-tid-tech" value=""></td> <!-- Hidden Tid field -->

                    </tr>
                @endif
            </tbody>
        </table>
        <button type="button" id="add-row" class="btn btn-primary">Add Row</button>
    </div>
</div>
<!-- REMARKS -->
<div class="card">
    <div class="card-header">
        <h5><b>Appraiser Remarks</b></h5>
    </div>
    <div class="card-body">
        <td>{{ $employeealldetailsforpms->Appraiser_Remark }} </td>
    </div>
</div>
<!-- REMARKS -->
<div class="card">
    <div class="card-header">
    <h5><b>Reviewer Remarks</b></h5>

    </div>
    <div class="card-body">
        <input id="revreamrks" value="{{ $employeealldetailsforpms->Reviewer_Remark }}" class="form-control" type="text" />
    </div>
</div>

      </div>
   </div>
   </div>
   <div class="card-footer">
      <button type="button" id="save-button" class="btn btn-primary">Save</button>
      <button type="submit" id="submit-button" class="btn btn-success">Submit</button>
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
     
      
            $(document).ready(function() {
    // Function to update pmsscoreformb and perform calculations
    function updateValues() {
        // Fetch the value from #grandtotalfinalempreviewerFormB and update #pmsscoreformb
        var grandTotalValue = parseFloat($("#grandtotalfinalempreviewerFormB").val()) || 0; // Get the value from the input field
        var grandTotalValueforma = parseFloat($("#grandtotalfinalempreviewer").val()) || 0; // Get the value from the input field

        // Update the value in #pmsscoreformb
        $("#pmsscoreformb").text(grandTotalValue.toFixed(2)); 
        $("#pmsscoreforma").text(grandTotalValueforma.toFixed(2)); 


        // Perform any additional calculations and updates (if needed)
        var formbwgt = parseFloat($("#formbwgt").text()) || 0;
        var formawgt = parseFloat($("#formawgt").text()) || 0;

        var pmsscoreformb = grandTotalValue; // Use the updated value of pmsscoreformb
        var pmsscoreforma = parseFloat($("#pmsscoreforma").text()) || 0;

        // Calculate weighted scores
        var formbscoreasperwgt = (pmsscoreformb * formbwgt) / 100;
        var formaperwgt = (pmsscoreforma * formawgt) / 100;

        // Update the weighted scores
        $("#pmsscoreformbasperwgt").text(formbscoreasperwgt.toFixed(2));
        $("#formasperwgt").text(formaperwgt.toFixed(2));

        // Calculate total score
        var totalAddB = (formaperwgt + formbscoreasperwgt).toFixed(2);
        $("#totaladdb").text(totalAddB);
    }

    // Listen for changes in #grandtotalfinalempreviewerFormB
    $("#grandtotalfinalempreviewerFormB").on('change input', function() {
        updateValues(); // Update values when the input field changes
    });
    $("#grandtotalfinalempreviewer").on('change input', function() {
        updateValues(); // Update values when the input field changes
    });

    // Call the function to initialize values on page load
    updateValues();
});


        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('#training-table-a tbody tr').forEach(row => {
    const topicSelect = row.querySelector('.topic-select');
    const hiddenTid = row.querySelector('.hidden-tid');

    // Get the selected topic from the dropdown
    const selectedTopic = topicSelect.value;

    // Fetch the softSkills data
    const topics = @json($softSkills); 

    if (selectedTopic) {
        let foundTid = null;

        // Loop through all categories to find the topic
        for (const category in topics) {
            const selectedSkill = topics[category].find(skill => skill.Topic.trim() === selectedTopic);
            if (selectedSkill) {
                foundTid = selectedSkill.Tid;
                break; // Stop searching once found
            }
        }

        // Set the Tid value if found
        if (foundTid) {
            hiddenTid.value = foundTid;
        } else {
            console.warn(`No Tid found for topic: ${selectedTopic}`);
        }
    }
});


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
        
                    // Find description for the selected topic by Tid
                    for (const category in topics) {
                        const categorySkills = topics[category];
                        const selectedTopic = categorySkills.find(skill => skill.Tid == topicId);
                        if (selectedTopic) {
                            description = selectedTopic.Description; // Set the description
                            // Set the Tid in the hidden input
                            hiddenTid.value = selectedTopic.Tid;
                            break;
                        }
                    }
        
                    // Display the description for the selected topic
                    row.querySelector('.description-cell').textContent = description;
                } else {
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
                            <select class="category-select">
                                <option value="">Select Category</option>
                                @foreach($softSkills as $category => $skills)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <!-- Topic Dropdown (will be populated based on category) -->
                            <select class="topic-select">
                                <option value="">Select Topic</option>
                            </select>
                        </td>
                        <td class="description-cell">Select a topic to view description</td>
                        <!-- Hidden Tid Input -->
                        <td><input type="hidden" class="hidden-tid" value=""></td>
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
                document.querySelectorAll('#training-table tbody tr').forEach(row => {
                                    const topicSelect = row.querySelector('.topic-select-selectb');
                                    const hiddenTid = row.querySelector('.hidden-tid-tech');

                                    const selectedTopic = topicSelect.selectedOptions[0]?.value.trim();

                                    // Fetch the softSkills data (already available in your script)
                                    const topics = @json($trainings); 

                                            if (selectedTopic) {
                                                // Find the matching topic object directly
                                                const selectedSkill = topics.find(skill => skill.Topic.trim() === selectedTopic);

                                                if (selectedSkill) {
                                                    hiddenTid.value = selectedSkill.Tid; // Set the hidden Tid value
                                                }
                                            }


                                });
                let rowCount = 1; // Keeps track of the number of rows
                const maxRows = 5; // Maximum number of rows
                        const tableBody = document.querySelector('#training-table tbody');
                        const addRowButton = document.getElementById('add-row');
                        const table = document.getElementById('training-table');

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
                                        <select class="topic-select-selectb">
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
                                    <td><input type="hidden" class="hidden-tid-tech" value=""></td> <!-- Hidden Tid field -->
                                `;
                        
                                // Append the new row to the table
                                tableBody.appendChild(newRow);
                        
                                // Hide delete button for the first row
                                if (tableBody.rows.length === 1) {
                                    newRow.querySelector('.delete-row-b').style.display = 'none';
                                }
                        
                                // Recheck delete buttons visibility for each row after adding
                                // updateDeleteButtonVisibility();
                                
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
                
            
                        // Event delegation to delete a row
                        table.addEventListener('click', function(event) {
                            // Check if the clicked target is the delete button
                            if (event.target.classList.contains('delete-row-b') || event.target.closest('.delete-row-b')) {
                                const row = event.target.closest('tr'); // Find the closest tr element
                                row.remove(); // Remove the row from the table
                    
                                // After row removal, check if it's the first row and hide delete button for it
                                const remainingRows = tableBody.rows;
                                if (remainingRows.length === 0) {
                                    return; // No rows left, so no need to hide anything
                                }
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

         var kraData = gatherKraData();
         var kraDataformb = gatherKraDataFormb(); // Gather all the data
         var reviewerpmsdata = gatherReviewerData();
         var trainingData = gatherTrainingData();
         var gatherpromotiondata =gatherPromotionRecommendationData();

         let grandtotalka = parseFloat($("#grandtotalfinalempreviewer").val()) || 0;
         let grandtotalkaformb = parseFloat($("#grandtotalfinalempreviewerFormB").val()) || 0;

         var revreamrks = document.getElementById('revreamrks').value;


         $.ajax({
            url: '/saveKraDataRev',  // Your route for saving data
            method: 'POST',
            data: {
               _token: '{{ csrf_token() }}',
               kraData: kraData,
               kraDataformb:kraDataformb,
               action: 'save',
               grandtotalka: grandtotalka,
               grandtotalkaformb:grandtotalkaformb,
               reviewerpmsdata:reviewerpmsdata,
               trainingData:trainingData,
               gatherpromotiondata:gatherpromotiondata,
               revreamrks:revreamrks,
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
                                        location.reload();
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

         var kraData = gatherKraData();
         var kraDataformb = gatherKraDataFormb(); // Gather all the data
         var reviewerpmsdata = gatherReviewerData();
         var trainingData = gatherTrainingData();
         var gatherpromotiondata =gatherPromotionRecommendationData();

         let grandtotalka = parseFloat($("#grandtotalfinalempreviewer").text()) || 0;
         let grandtotalkaformb = parseFloat($("#grandtotalfinalempreviewerFormB").text()) || 0;

         var revreamrks = document.getElementById('revreamrks').value;


         $.ajax({
            url: '/saveKraDataRev',  // Your route for saving data
            method: 'POST',
            data: {
               _token: '{{ csrf_token() }}',
               kraData: kraData,
               kraDataformb:kraDataformb,
               action: 'submit',
               grandtotalka: grandtotalka,
               grandtotalkaformb:grandtotalkaformb,
               reviewerpmsdata:reviewerpmsdata,
               trainingData:trainingData,
               gatherpromotiondata:gatherpromotiondata,
               revreamrks:revreamrks,
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
                                        location.reload();
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
      function gatherKraData() {
        var valid = true; // Flag to track validity

         var kraData = [];
         $('tr').each(function() {
            var kraId = $(this).data('kraid');
            var subKraId = $(this).data('subkraid');
            
            // Check if the element has id starting with 'input-rating-'
            if ($(this).find('#input-rating-' + subKraId).length) {
                // Retrieve the value of the input field (not text())
                var rating = $(this).find('#input-rating-' + subKraId).val();
            }
            // Check if the element has id starting with 'display-rating-'
            if ($(this).find('#display-rating-' + subKraId).length) {
                // Retrieve the text inside the span
                var rating = $(this).find('#display-rating-' + subKraId).text();
            }

            if ($(this).find('#input-rating-kra-' + kraId).length) {
                // Retrieve the value of the input field (not text())
                var krarating = $(this).find('#input-rating-kra-' + kraId).val();
            }

            // Check if the element has id starting with 'display-rating-'
            if ($(this).find('#display-value' + kraId).length) {
                // Retrieve the text inside the span
                var krarating = $(this).find('#display-value' + kraId).text();
            }

            var remarks = $(this).find('#textarea-remark-' + subKraId).val();
            var kraremarks = $(this).find('#kraremark' + kraId).val();
          
                 // Check if either remarks or kraremarks is empty
            if (!remarks || remarks === "" || !kraremarks || kraremarks === "") {
                // Highlight the textarea with a red border
                if (!remarks || remarks === "") {
                    $('#textarea-remark-' + subKraId).css('border', '2px solid red');
                    // Scroll to the Sub-KRA remarks field if it exists
                    var subKraElement = $('#textarea-remark-' + subKraId);
                    if (subKraElement.length) {
                        $('html, body').animate({
                            scrollTop: subKraElement.offset().top - 100  // Adjust -100 for some spacing from the top
                        }, 500);
                    }
                }
                if (!kraremarks || kraremarks === "") {
                    $('#kraremark' + kraId).css('border', '2px solid red');
                    // Scroll to the KRA remarks field if it exists
                    var kraElement = $('#kraremark' + kraId);
                    if (kraElement.length) {
                        $('html, body').animate({
                            scrollTop: kraElement.offset().top - 100  // Adjust -100 for some spacing from the top
                        }, 500);
                    }
                }
                valid = false; // Mark the form as invalid
            } else {
                // If remarks are not empty, remove the red border (if it exists)
                $('#textarea-remark-' + subKraId).css('border', '');
                $('#kraremark' + kraId).css('border', '');
            }
            var subKraScore = $(this).find('#subkrascoreforma' + subKraId).text();
            var KraScore = $(this).find('#krascorespan' + kraId).text();

            var subKralogScore = $(this).find('#logscoresubkra' + subKraId).text();
            var KralogScore = $(this).find('#logScorekra' + kraId).text();

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
         return kraData;
      }


        function gatherKraDataFormb() {
            var valid = true; // Flag to track validity
            var kraDataformb = []; // Array to hold the data

            // Loop through each row (this includes both the main form and subforms)
            $('tr[data-formbkraid]').each(function() {
                var formKraId = $(this).data('formbkraid'); // Main form KRA ID
                var subFormKraId = $(this).data('formbsubkraid'); // Subform KRA ID

                // For the main form: Retrieve the rating and score (if available)
                var rating = '';
                var krarating = '';
                
                // Main KRA Rating (from input or display)
                if (formKraId) {
                    if ($(this).find('#input-rating-formb-' + formKraId).length) {
                        krarating = $(this).find('#input-rating-formb-' + formKraId).val();
                    }
                    if ($(this).find('#display-rating-formb-' + formKraId).length) {
                        krarating = $(this).find('#display-rating-formb-' + formKraId).text();
                    }
                }

                // Subform KRA Rating (from input or display)
                if (subFormKraId) {
                    if ($(this).find('#input-rating-subformb-' + subFormKraId).length) {
                        rating = $(this).find('#input-rating-subformb-' + subFormKraId).val();
                    }
                    if ($(this).find('#display-rating-subformb-' + subFormKraId).length) {
                        rating = $(this).find('#display-rating-subformb-' + subFormKraId).text();
                    }
                }

                // Remarks for both main form and subform
                var remarks = $(this).find('#formbremark' + formKraId).val();
                var subFormRemarks = $(this).find('#subformbremark' + subFormKraId).val();

                // Check if remarks are empty and highlight them if necessary
                if ((!remarks || remarks === "") && formKraId) {
                    $(this).find('#formbremark' + formKraId).css('border', '2px solid red');
                    valid = false; // Mark as invalid
                } else {
                    $(this).find('#formbremark' + formKraId).css('border', '');
                }

                if ((!subFormRemarks || subFormRemarks === "") && subFormKraId) {
                    $(this).find('#subformbremark' + subFormKraId).css('border', '2px solid red');
                    valid = false; // Mark as invalid
                } else {
                    $(this).find('#subformbremark' + subFormKraId).css('border', '');
                }

                // Getting other required data such as scores and logic
                var kraScore = $(this).find('#krascoreformb' + formKraId).text();
                var subKraScore = $(this).find('#subkrascoreformb' + subFormKraId).text();

                // Fetching the log scores for both main and sub KRA
                var logScore = $(this).find('#logScorekraformb' + formKraId).val();
                var subLogScore = $(this).find('#logScoresubkraformb' + subFormKraId).val();  


                // Check if logScore or subLogScore is empty, '0.0', or '0.00', and fallback to text if necessary
                if (!logScore || logScore === "0.0" || logScore === "0.00") {
                    logScore = $(this).find('#logScorekraformb' + formKraId).text();  // Fallback to text
                }

                // if (!subLogScore || subLogScore === "0.0" || subLogScore === "0.00") {
                //     subLogScore = $(this).find('#logScoresubkraformb' + subFormKraId).text();  // Fallback to text
                // }
                console.log(subFormKraId);

                // Push the data to kraDataformb array for both the main and subforms
                if (formKraId || subFormKraId) {
                    kraDataformb.push({
                        formKraId: formKraId,
                        subFormKraId: subFormKraId,
                        rating: rating,
                        krarating: krarating,
                        logScore: logScore,
                        subLogScore: subLogScore,
                        subKraScore: subKraScore,
                        kraScore: kraScore,
                        remarks: remarks,
                        subFormRemarks: subFormRemarks,
                    });
                }
            });

            return kraDataformb; // Return the gathered data
        }
        function gatherReviewerData() {
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
    // Ensure the first option is selected by default if no option is selected
    function setFirstOptionSelected(selectElement) {
        let options = selectElement.options;
        
        // If no option is selected, set the first option as selected
        if (!selectElement.querySelector('option:checked')) {
            options[0].setAttribute('selected', 'selected');  // Set the first option as selected
        }
    }

    // Ensure the first option is selected by default on page load
    setFirstOptionSelected(document.getElementById('gradeSelect'));
    setFirstOptionSelected(document.getElementById('designationSelect'));

    // Handle 'change' event for the gradeSelect dropdown
    document.getElementById('gradeSelect').addEventListener('change', function() {
        let options = this.options;
        // Remove 'selected' from all options
        for (let option of options) {
            option.removeAttribute('selected');
        }
        // Add 'selected' to the selected option
        this.options[this.selectedIndex].setAttribute('selected', 'selected');
    });

    // Handle 'change' event for the designationSelect dropdown
    document.getElementById('designationSelect').addEventListener('change', function() {
        let options = this.options;
        // Remove 'selected' from all options
        for (let option of options) {
            option.removeAttribute('selected');
        }
        // Add 'selected' to the selected option
        this.options[this.selectedIndex].setAttribute('selected', 'selected');
    });
    });
document.addEventListener("DOMContentLoaded", function () {
    const reviewerInput = document.getElementById("grandtotalfinalempreviewer");
    const appraiserScore = parseFloat("{{ round($grandTotalScore, 2) }}");

    const reviewerInputformb = document.getElementById("grandtotalfinalempreviewerFormB");
    const appraiserScoreformb = parseFloat("{{ round($grandTotalScoreformb, 2) }}");

    const errorMsg = document.createElement("div");
    
    errorMsg.style.color = "red";
    errorMsg.style.fontSize = "12px";
    errorMsg.style.display = "none";
    errorMsg.textContent = "Reviewer score must be within ±10 of Appraiser score.";
    

    const errorMsgformb = document.createElement("div");
    
    errorMsgformb.style.color = "red";
    errorMsgformb.style.fontSize = "12px";
    errorMsgformb.style.display = "none";
    errorMsgformb.textContent = "Reviewer score must be within ±10 of Appraiser score.";
    
    reviewerInput.parentNode.appendChild(errorMsg);
    reviewerInputformb.parentNode.appendChild(errorMsgformb);


    reviewerInput.addEventListener("input", function () {
        let reviewerScore = parseFloat(reviewerInput.value) || 0;
        let minRange = appraiserScore - 10;
        let maxRange = appraiserScore + 10;

        if (reviewerScore < minRange || reviewerScore > maxRange) {
            reviewerInput.style.border = "2px solid red";
            errorMsg.style.display = "block";
        } else {
            reviewerInput.style.border = "2px solid green";
            errorMsg.style.display = "none";
        }
    });

    reviewerInputformb.addEventListener("input", function () {
        let reviewerScoreformb = parseFloat(reviewerInputformb.value) || 0;
        let minRange = appraiserScoreformb - 10;
        let maxRange = appraiserScoreformb + 10;

        if (reviewerScoreformb < minRange || reviewerScoreformb > maxRange) {
            reviewerInputformb.style.border = "2px solid red";
            errorMsgformb.style.display = "block";
        } else {
            reviewerInputformb.style.border = "2px solid green";
            errorMsgformb.style.display = "none";
        }
    });
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