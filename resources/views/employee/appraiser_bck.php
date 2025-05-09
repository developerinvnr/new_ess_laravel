
                     @if ($data['emp']['Appform'] == 'Y' && $formattedDOJ <= $apra_allowdoj && Auth::user()->employeegeneral->DepartmentId =='7')
                                        @if (($rowChe > 0) ||
                                            (isset($appraisal_schedule) && $CuDate >= $appraisal_schedule->AppFromDate && 
                                            $CuDate <= $appraisal_schedule->AppToDate && $appraisal_schedule->AppDateStatus == 'A' 
                                            <!-- && 
                                            $pms_id->Emp_PmsStatus == 1 && $pms_id->Appraiser_PmsStatus == 3 -->
                                            
                                            ) ||
                                            ($rowCh > 0 && isset($appraisal_schedule) 
                                            && $appraisal_schedule->AppDateStatus == 'A' 
                                            && $pms_id->Emp_PmsStatus == 1 && 
                                            $pms_id->Appraiser_PmsStatus == 3) ||
                                            (isset($appraisal_schedule) && 

                                            $CuDate >= $appraisal_schedule->RevFromDate && 
                                            $CuDate <= $appraisal_schedule->RevToDate &&
                                             $appraisal_schedule->RevDateStatus == 'A' &&
                                            $pms_id->Emp_PmsStatus == 1 && 
                                            
                                            $pms_id->Appraiser_PmsStatus == 3 && 
                                            $pms_id->Reviewer_PmsStatus == 3) ||
                                            (isset($appraisal_schedule) && 
                                            $CuDate >= $appraisal_schedule->HodFromDate &&
                                             $CuDate <= $appraisal_schedule->HodToDate &&
                                              $appraisal_schedule->HodDateStatus == 'A' &&
                                            $pms_id->Emp_PmsStatus == 1 && 
                                            $pms_id->Appraiser_PmsStatus == 3 && 
                                            $pms_id->Reviewer_PmsStatus == 3 &&
                                            $pms_id->HodSubmit_ScoreStatus == 3) ||
                                            ($pms_id->ExtraAllowPMS == 1)
                                        )
                                        <li class="nav-item">
                                            <a style="color: #0e0e0e;padding-top:10px !important;" class="nav-link pt-4 " id="team_appraisal_tab20" data-bs-toggle="tab" href="#teamappraisal" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
                                        </li>
                                        @endif
                                    @endif
                     
          

                                    ///reviewer

                                    @if (
                                        $data['emp']['Appform'] == 'Y' &&
                                        $formattedDOJ <= $apra_allowdoj &&
                                        Auth::user()->employeegeneral->DepartmentId == '7'
                                    )
                                        @if (
                                            ($rowChe > 0) ||
                                            (
                                                $pms_id->Emp_PmsStatus == 1 &&
                                                $pms_id->Appraiser_PmsStatus == 3
                                            ) ||
                                            (
                                                $rowCh > 0 &&
                                                isset($appraisal_schedule) &&
                                                $appraisal_schedule->AppDateStatus == 'A' &&
                                                $pms_id->Emp_PmsStatus == 1 &&
                                                $pms_id->Appraiser_PmsStatus == 3
                                            ) ||
                                            (
                                                isset($appraisal_schedule) &&
                                                $CuDate >= $appraisal_schedule->RevFromDate &&
                                                $CuDate <= $appraisal_schedule->RevToDate &&
                                                $appraisal_schedule->RevDateStatus == 'A' &&
                                                $pms_id->Emp_PmsStatus == 1 &&
                                                $pms_id->Appraiser_PmsStatus == 3 &&
                                                $pms_id->Reviewer_PmsStatus == 3
                                            ) ||
                                            (
                                                isset($appraisal_schedule) &&
                                                $CuDate >= $appraisal_schedule->HodFromDate &&
                                                $CuDate <= $appraisal_schedule->HodToDate &&
                                                $appraisal_schedule->HodDateStatus == 'A' &&
                                                $pms_id->Emp_PmsStatus == 1 &&
                                                $pms_id->Appraiser_PmsStatus == 3 &&
                                                $pms_id->Reviewer_PmsStatus == 3 &&
                                                $pms_id->HodSubmit_ScoreStatus == 3
                                            ) ||
                                            ($pms_id->ExtraAllowPMS == 1)
                                        )
                                            <li class="nav-item">
                                                <a style="color: #0e0e0e; padding-top: 10px !important;" class="nav-link pt-4" id="team_appraisal_tab20" data-bs-toggle="tab" href="#teamappraisal" role="tab" aria-controls="teamappraisal" aria-selected="false">
                                                    Team Appraisal
                                                </a>
                                            </li>
                                        @endif
                                    @endif


                                    



                  