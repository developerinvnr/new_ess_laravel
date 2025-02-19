@include('employee.head')
@include('employee.header')
@include('employee.sidebar')

<body class="mini-sidebar">
	<div class="loader" style="display: none;">
	  <div class="spinner" style="display: none;">
		<img src="./SplashDash_files/loader.gif" alt="">
	  </div> 
	</div>
    <!-- Main Body -->
    <div class="page-wrapper">
        <!-- Header Start -->
        @include('employee.head')
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
									<a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Performance Management System - 2024 </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class=" pms-bpx">
						<a href="{{route('pms')}}" class="mb-0 sm-btn btn pms-btn" title="Employee" data-original-title="My KRA">Employee</a>
						@if($exists_appraisel)
							<a href="{{ route('appraiser') }}" class="mb-0 sm-btn btn pms-btn" title="Appraiser" data-original-title="Appraiser">Appraiser</a>
						@endif
						@if($exists_reviewer)
						<a href="{{route('reviewer')}}" class="mb-0 sm-btn btn pms-btn" title="Reviewer" data-original-title="Reviewer">Reviewer</a>
						@endif
						@if($exists_hod)
						<a href="{{route('hod')}}" class="mb-0 sm-btn btn pms-btn" title="HOD" data-original-title="HOD">HOD</a>
						@endif
						@if($exists_mngmt)
						<a href="{{route('management')}}" class="mb-0 sm-btn btn pms-btn" title="Management" data-original-title="Management">Management</a>
						@endif
						
					   </div>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="row">
													<div class="col-md-4 mb-3">KRA Help <a class="float-end" target="_blank" href="./pdf/KRAHelpFile.pdf"><b>Click to Large</b></a>
														<object style="width:200px;margin-top: 10px;border-top: 1px solid #ddd;padding-top: 15px;" class="pdf" data= "./pdf/KRAHelpFile.pdf"></object>
													</div>
													<div class="col-md-4 mb-3">PMS Help <a class="float-end" target="_blank" href="./pdf/PMSHelpFile.pdf"><b>Click to Large</b></a>
														<object style="width:200px;margin-top: 10px;border-top: 1px solid #ddd;padding-top: 15px;" class="pdf" data= "./pdf/PMSHelpFile.pdf"></object>
													</div>
													<div class="col-md-4 mb-3">FAQ <a class="float-end" target="_blank" href="./pdf/faq.pdf"><b>Click to Large</b></a>
														<object style="width:200px;margin-top: 10px;border-top: 1px solid #ddd;padding-top: 15px;" class="pdf" data= "./pdf/faq.pdf"></object>
													</div>
												</div>
						</div>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="card">
							<div class="card-content">
								<div class="card-body">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
											<b>Note:</b>
											<span class="danger">Last date for KRA Submission 15 December 2024</span>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
											<div class="card">
											<div class="card-header pb-0">
												<h4 class="card-title">KRA Schedule</h4>
											</div>
											<div class="card-content">
												<div class="card-body">
													<table class="table table-striped">
														<thead>
															<tr>
															<th><b>SN</b></th><th><b>Activity Title</b></th><th><b>Process Owner</b></th><th><b>Date From</b></th><th><b>Date To</b></th></th><th><b>Status</b></th></tr>
														 </thead>
														<tbody>
															<tr>
															<td><b>1.</b></td><td ><b>KRA setting</b></td><td>Team Member</td><td>20 Nov 2024</td><td>20 Dec 2024</td><td class="success">Submitted</td>
															</tr>
															<tr>
															<td><b>2.</b></td><td ><b>Review by Appraiser</b></td><td>Appraiser</td><td>01 Jan 2024</td><td>07 Jan 2024</td><td class="success">Submitted</td>
															</tr>
															<tr>
															<td><b>3.</b></td><td ><b>Review by reviewer</b></td><td>Reviewer</td><td>08 Jan 2024</td><td>14 Jan 2024</td><td class="success">Submitted</td>
															</tr>
															<tr>
															<td><b>4.</b></td><td ><b>Review by HOD</b></td><td>HOD</td><td>15 Jan 2024</td><td>21 Jan 2024</td><td class="danger">Draft</td>
															</tr>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											</div>
											
											<div class="card">
											<div class="card-header pb-0">
												<h4 class="card-title">Appraisal Schedule</h4>
											</div>
											<div class="card-content">
												<div class="card-body">
													<table class="table table-striped">
														<thead>
															<tr>
															<th><b>SN</b></th><th><b>Activity Title</b></th><th><b>Process Owner</b></th><th><b>Date From</b></th><th><b>Date To</b></th></th><th><b>Status</b></th></tr>
														 </thead>
														<tbody>
															<tr>
															<td><b>1.</b></td><td ><b>Appraisal roll out</b></td><td>HR</td><td>02 Jan 2024</td><td>02 Jan 2024</td><td class="success">Submitted</td>
															</tr>
															<tr>
															<td><b>2.</b></td><td ><b>Self Appraisal by Appraisee</b></td><td>Appraisee/ team members</td><td>02 Jan 2024</td><td>09 Jan 2024</td><td class="success">Submitted</td>
															</tr>
															<tr>
															<td><b>3.</b></td><td ><b>First Level appraisal by Appraiser & feedback session with Appraisee</b></td><td>Appraiser/ Reporting Manager</td><td>10 Jan 2024</td><td>16 Jan 2024</td><td class="success">Submitted</td>
															</tr>
															<tr>
															<td><b>4.</b></td><td ><b>Second level appraisal by Reviewer /HOD (Additional level for sales)</b></td><td>Reviewer/ Second Level Reporting Manager/ HOD</td><td>17 Jan 2024</td><td>31 Jan 2024</td><td class="danger">Draft</td>
															</tr>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											</div>
											
										</div>

										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
										
											<div class="card">
											<div class="card-header pb-0">
												<h4 class="card-title float-start">Logics</h4>
												<span class="float-end" style="margin-top:-12px;">
													<select class="">
														<option value="select">Select Logic </option>
														<option value="logic-1">Logic 01</option>
														<option value="logic-1">Logic 02</option>
														<option value="logic-1">Logic 03</option>
													</select>
												</span>
											</div>
											<div class="card-content">
												<div class="card-body">
													<h5><b>Logic 1</b></h5>
													<p class="mb-2">Higher the achievement, higher the scoring till a limit</p>
													<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>100</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>90</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td>110</td><td>110</td>
																</tr>
															</tbody>
														</table>														
														<!--All start logics-->
														<div class="card d-none">
										<div class="card-body">
											<div class="row">
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 1</b></h5>
														<p>Higher the achievement, higher the scoring till a limit</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>100</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>90</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td>110</td><td>110</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 2</b></h5>
														<p>Higher the achievement, max scored is 100</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>100</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>90</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td>110</td><td>100</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 2A</b></h5>
														<p>Higher the achievement, higher the scoring till 110 as upper limit</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>>110</td><td>110</td>
																</tr>
																<tr>
																	<td>100</td><td>110</td><td>110</td>
																</tr>
																<tr>
																	<td>100</td><td>100</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>90</td><td>90</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 3</b></h5>
														<p>Either 100 or Zero</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>100</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>90</td><td>0</td>
																</tr>
																<tr>
																	<td>100</td><td>110</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 4</b></h5>
														<p>Lower the actual, zero</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>100</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>90</td><td>0</td>
																</tr>
																<tr>
																	<td>100</td><td>110</td><td>100</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 5</b></h5>
														<p>Higher the achievement, Max is 100, Below 70% achievement, Zero</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>100</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td><70</td><td>0</td>
																</tr>
																<tr>
																	<td>100</td><td>80</td><td>80</td>
																</tr>
																<tr>
																	<td>100</td><td>110</td><td>100</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 6 (For Sale)</b></h5>
														<p>Need to be 150% weightage, and lower zero if>25% return in FC</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Sales Return</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>Return <= 10%</td><td>150</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between 10% to 15%</td><td>125</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between 15% to 20%</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between 20% to 25%</td><td>75</td>
																</tr>
																<tr>
																	<td>100</td><td>Return more then 25%</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 6A (For Sale)</b></h5>
														<p>Need to be 100% weightage, and owest is zero if>25% return in FC_HY</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Sales Return</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>Return < 15%</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between 15% to 20%</td><td>80</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between 20% to 25%</td><td>50</td>
																</tr>
																<tr>
																	<td>100</td><td>Return more then 25%</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 6B (For Sales)</b></h5>
														<p>Need to be 100% weightage, and lower zero if>5% return in FC_OP</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>Return < 5%</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between >=5%</td><td>0</td>
																</tr>
																
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 7 (For Sale)</b></h5>
														<p>Need to be 150% weightage, and lower zero if>10% return in VEG</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Sales Return</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>Return 0%</td><td>150</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between 0% to 2%</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between 2% to 5%</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between 5% to 10%</td><td>75</td>
																</tr>
																<tr>
																	<td>100</td><td>Return more then >10%</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 7A (For Sale)</b></h5>
														<p>Need to be 120% weightage, and lowest is zero if>4% return in VEG</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Sales Return</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>Return 0%</td><td>120</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between 0% to 2%</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between 2% to 3%</td><td>75</td>
																</tr>
																<tr>
																	<td>100</td><td>Return between 3% to 4%</td><td>50</td>
																</tr>
																<tr>
																	<td>100</td><td>Return more then >4%</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 8 (For Production)</b></h5>
														<p>Higher Achievment on higher Grades, higher the multiple factor</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Sub Logic</th>
																	<th>Target</th>
																	<th>Achievment</th>
																	<th>Achivement Multiple Factor</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Logic 8a</td><td>100</td><td>=, < 100</td><td>115</td>
																</tr>
																<tr>
																	<td>Logic 8b</td><td>100</td><td>=, < 100</td><td>100</td>
																</tr>
																<tr>
																	<td>Logic 8c</td><td>100</td><td>=, < 100</td><td>90</td>
																</tr>
																<tr>
																	<td>Logic 8d</td><td>100</td><td>=, < 100</td><td>65</td>
																</tr>
																<tr>
																	<td>Logic 8e</td><td>100</td><td>=, < 100</td><td>-100</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 9 (For Production)</b></h5>
														<p>Higher Achievment, higher the score till 90%,above 90% - 100%</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievment</th>
																	<th>Achivement Multiple Factor</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>100</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>110</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>90</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td><90</td><td><90</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 10 (For Production)</b></h5>
														<p>More than 10% deviation, Score=Zero</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement (Deviation%)</th>
																	<th>Score (Mutliple Factor)</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td><90%</td><td>0</td>
																</tr>
																<tr>
																	<td>100</td><td>90%</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>91-93%</td><td>105</td>
																</tr>
																<tr>
																	<td>100</td><td>94-97%</td><td>110</td>
																</tr>
																<tr>
																	<td>100</td><td>98-100%</td><td>120</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 11 (Reverse Calculation)</b></h5>
														<p>Higher the Achievment, lower the score</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>100</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>90</td><td>111</td>
																</tr>
																<tr>
																	<td>100</td><td>110</td><td>91</td>
																</tr>
																
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 12</b></h5>
														<p>Higher the achievement, Max is 110, Below 90% achievement, Zero</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>100</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td><90</td><td>0</td>
																</tr>
																<tr>
																	<td>100</td><td>90</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td>110</td><td>110</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div class="row">
												<h5>(For External Vegetable Seed Production)</h5>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 13A Quantity: All Crops [Own Production]</b></h5>
														<p>Score Decreases with achievement deviation on both sides of target</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>>,=130-121</td><td>70</td>
																</tr>
																<tr>
																	<td>100</td><td>120-111</td><td>80</td>
																</tr>
																<tr>
																	<td>100</td><td>110-91</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>90-81</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td><,=80</td><td>80</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 13B Quantity: All Crops [Seed to Seed]</b></h5>
														<p>Score Decreases upto 70% with achievement deviation on both sides of target</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>140-131</td><td>70</td>
																</tr>
																<tr>
																	<td>100</td><td>130-121</td><td>80</td>
																</tr>
																<tr>
																	<td>100</td><td>120-81</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>80-71</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td><,=70</td><td>70</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 14A Germination: All OP Var, Hy Bhindi, Snake Gourd</b></h5>
														<p>Score decreases to Zero with <,= 75% achievement</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>>,=91</td><td>110</td>
																</tr>
																<tr>
																	<td>100</td><td>90-86</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>85-81</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td>80-76</td><td>80</td>
																</tr>
																<tr>
																	<td>100</td><td><,=75</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 14B Germination: Remaining Crops & products</b></h5>
														<p>Score decreases to Zero with = 80 % achievement</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>>,=96</td><td>110</td>
																</tr>
																<tr>
																	<td>100</td><td>95-91</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>90-86</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td>85-81</td><td>60</td>
																</tr>
																<tr>
																	<td>100</td><td><,=80</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 15A Genetic Purity: All OP</b></h5>
														<p>Score decreases to Zero below 95 % achievement</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>>,=99</td><td>110</td>
																</tr>
																<tr>
																	<td>100</td><td><99-98</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td><98-97</td><td>60</td>
																</tr>
																<tr>
																	<td>100</td><td><97-96</td><td>50</td>
																</tr>
																<tr>
																	<td>100</td><td><96-95</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 15B Genetic Purity: All Hy (except Hy Bhindi)</b></h5>
														<p>Score decreases to Zero below 97 % achievement</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>>,=99.5(100)</td><td>110</td>
																</tr>
																<tr>
																	<td>100</td><td>99.5-99</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>99-98</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td>98-97</td><td>70</td>
																</tr>
																<tr>
																	<td>100</td><td><97</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 15C Genetic Purity: Hy Bhindi</b></h5>
														<p>Score decreases to Zero if < 96 % achievement</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>>,=99</td><td>110</td>
																</tr>
																<tr>
																	<td>100</td><td><99-98</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td><98-97</td><td>80</td>
																</tr>
																<tr>
																	<td>100</td><td><97-96</td><td>60</td>
																</tr>
																<tr>
																	<td>100</td><td><96</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 16 Seed Cost: All Crops</b></h5>
														<p>Higher the achievement lower the score</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>111-115</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td>106-110</td><td>95</td>
																</tr>
																<tr>
																	<td>100</td><td>100-105</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>99-95</td><td>105</td>
																</tr>
																<tr>
																	<td>100</td><td>94-90</td><td>110</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 17 Seed Delivery: All Crops</b></h5>
														<p>Higher the achievement numbers (DOD-HD), lower the score</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td><15</td><td>100</td>
																</tr>
																<tr>
																	<td>100</td><td>16-22</td><td>90</td>
																</tr>
																<tr>
																	<td>100</td><td>23-29</td><td>80</td>
																</tr>
																<tr>
																	<td>100</td><td>30-36</td><td>75</td>
																</tr>
																<tr>
																	<td>100</td><td>37-42</td><td>50</td>
																</tr>
																<tr>
																	<td>100</td><td>>42</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 18 For Sales</b></h5>
														<p>Higher the achievement, higher the scoring as per given slabs</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>80-120</td><td>As achievement</td>
																</tr>
																<tr>
																	<td>100</td><td>70-79</td><td>50</td>
																</tr>
																<tr>
																	<td>100</td><td>60-69</td><td>25</td>
																</tr>
																<tr>
																	<td>100</td><td>< 60</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 19 For Sales</b></h5>
														<p>Higher the achievement, max scored is 100</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th>Achievement</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>80-100</td><td>As achievement</td>
																</tr>
																<tr>
																	<td>100</td><td>70-80</td><td>50</td>
																</tr>
																<tr>
																	<td>100</td><td>< 70</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 20 For Finance</b></h5>
														<p>Delay & Accuracy Measurement: 0 or 110</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th colspan="2">Achievement <br>Enter Days Delayed (no.)  Enter Mistakes (%)</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>0</td><td>0</td><td>0</td>
																</tr>
																<tr>
																	<td>100</td><td>1</td><td>0</td><td>0</td>
																</tr>
																<tr>
																	<td>100</td><td>0</td><td>0</td><td>110</td>
																</tr>
																<tr>
																	<td>100</td><td>0</td><td>2</td><td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
													<div class="card-header" style="background-color: #d4f9e8;">
														<h5><b>Logic 21 For Finance</b></h5>
														<p>Delay & Accuracy Measurement: More will lead to zero Achivement</p>
													</div>
													<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
														<table class="table table-pad">
															<thead class="table-light">
																<tr>
																	<th>Target</th>
																	<th colspan="2">Achievement <br>Enter Days Delayed (no.)  Enter Mistakes (%)</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>100</td><td>0</td><td>1</td><td>70</td>
																</tr>
																<tr>
																	<td>100</td><td>2</td><td>0.3</td><td>63</td>
																</tr>
																<tr>
																	<td>100</td><td>4</td><td>0</td><td>0</td>
																</tr>
																<tr>
																	<td>100</td><td>0</td><td>0</td><td>110</td>
																</tr>
																<tr>
																	<td>100</td><td>1</td><td>0.1</td><td>81</td>
																</tr>
																<tr>
																	<td>100</td><td>1</td><td>0</td><td>99</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
<!--All end logics-->
												</div>
											</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
                <!-- Revanue Status Start -->
                <div class="row">
				@include('employee.footerbottom')

				</div>
        </div>
    </div>
    </div>
    
    <!--General message-->
    <div class="modal fade show" id="model4" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle3">General Message</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
          <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
            
        </div>
        <div class="modal-footer">
        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
        
        </div>
      </div>
      </div>
    </div>
	
    @include('employee.footer');
	<Script>
		$(document).ready(function() {
			$('.oldkrabtn').click(function() {
				$('#oldkrabox').toggle();
			});
			$('.oldkraclose').click(function() {
				$('#oldkrabox').toggle();
			});
		});
		</Script>
