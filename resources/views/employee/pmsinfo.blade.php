@include('employee.header')
<body class="mini-sidebar">
@include('employee.sidebar')

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
                                    <li class="breadcrumb-link active">Performance Management System  </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						
					<ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;" class="nav-link active" href="{{ route('pmsinfo') }}" role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                    <span class="d-none d-sm-block">PMS Information</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;" class="nav-link " href="{{ route('pms') }}"
                                    role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                    <span class="d-none d-sm-block">Employee</span>
                                </a>
                            </li>
                            @if($exists_appraisel)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;" class="nav-link " href="{{ route('appraiser') }}"
                                    role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Appraiser</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_reviewer)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;" class="nav-link" href="{{ route('reviewer') }}"
                                    role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Reviewer</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_hod)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;" class="nav-link" href="{{ route('hod') }}" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">HOD</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_mngmt)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;" class="nav-link" href="{{ route('management') }}"
                                    role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Management</span>
                                </a>
                            </li>
                            @endif

                        </ul>
					</div>
					
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="card">
							<div class="card-content">
								<div class="card-body">
									<div class="row">
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
												<div class="card mt-2">
													<div class="card-header">
														<h4 class="card-title float-start">Help</h4>
													</div>
													<div class="card-body">
														<ul class="help-list">
															@if($data['emp']['Schedule'] == 'Y')
															<li><b>KRA Help</b> <a class="float-end" target="_blank" href="./pdf/KRAHelpFile.pdf"><i class="fas fa-eye mr-2"></i></a></li>
															@endif
															@if($data['emp']['Appform'] == 'Y')
															<li><b>PMS Help</b> <a class="float-end" target="_blank" href="./pdf/PMSHelpFile.pdf"><i class="fas fa-eye mr-2"></i></a></li>
															@endif
															<li><b>FAQ</b> <a class="float-end" target="_blank" href="./pdf/faq.pdf"><i class="fas fa-eye mr-2"></i></a></li>
														</ul>
													</div>
												</div>

												<div class="card mt-3">
													<div class="card-header pb-0">
														<h4 class="card-title float-start" style="margin-top:5px;">Logics</h4>
														<span class="float-end">
														<select style="width:120px;" class="logic-select" onchange="showLogic(this.value)">
															<option value="select">Select Logic</option>
															<option value="logic-1" selected>Logic 1</option>
															<option value="logic-2">Logic 2</option>
															<option value="logic-2a">Logic 2A</option>
															<option value="logic-3">Logic 3</option>
																<option value="logic-4">Logic 4</option>
																<option value="logic-5">Logic 5</option>
																<option value="logic-6a">Logic 6A (For Sales)</option>
																<option value="logic-6b">Logic 6B (For Sales)</option>
															<option value="logic-6">Logic 6 (For Sales)</option>
															<option value="logic-7a">Logic 7A (For Sales)</option>
															<option value="logic-7">Logic 7 (For Sales)</option>
															<option value="logic-8">Logic 8 (For Production)</option>
															<option value="logic-10">Logic 10 (For Production)</option>
															<option value="logic-11">Logic 11 (Reverse Calculation)</option>
															<option value="logic-12">Logic 12</option>
															<option value="logic-13a">Logic 13A (Quantity: All Crops [Own Production])</option>
															<option value="logic-13b">Logic 13B (Quantity: All Crops [Seed to Seed])</option>
															<option value="logic-14a">Logic 14A (Germination: All OP Var, Hy Bhindi, Snake Gourd)</option>
															<option value="logic-14b">Logic 14B (Germination: Remaining Crops & Products)</option>
															<option value="logic-15a">Logic 15A (Genetic Purity: All OP)</option>
															<option value="logic-15C">Logic 15C (Genetic Purity: Hy Bhindi)</option>
															<option value="logic-16">Logic 16 (Seed Cost: All Crops)</option>
															<option value="logic-17">Logic 17 (Seed Delivery: All Crops)</option>
															<option value="logic-18">Logic 18 (For Sales)</option>
															<option value="logic-19">Logic 19 (For Sales)</option>
															<option value="logic-20">Logic 20 (For Finance)</option>
															<option value="logic-21">Logic 21 (For Finance)</option>


														</select>
														</span>
													</div>

													<div class="card-content">
														<div class="card-body">

														<!-- Logic 1 content -->
														<div id="logic-1" class="logic-card">
															<h5><b>Logic 1</b></h5>
															<p class="mb-2">Higher the achievement, higher the scoring till a limit</p>
															<table class="table table-pad text-center">
															<thead>
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

														<!-- Logic 2 content -->
														<div id="logic-2" class="logic-card d-none">
															<h5><b>Logic 2</b></h5>
															<p class="mb-2">Higher the achievement, max scored is 100</p>
															<table class="table table-pad text-center">
															<thead>
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

														<!-- Logic 2A content -->
														<div id="logic-2a" class="logic-card d-none">
															<h5><b>Logic 2A</b></h5>
															<p class="mb-2">Higher the achievement, higher the scoring till 110 as upper limit</p>
															<table class="table table-pad text-center">
															<thead>
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

														
													

													<!-- Logic 3 content -->
													<div id="logic-3" class="logic-card d-none">
													<h5><b>Logic 3</b></h5>
													<p class="mb-2">Either 100 or Zero</p>
													<table class="table table-pad text-center">
														<thead>
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

													<!-- Logic 4 content -->
													<div id="logic-4" class="logic-card d-none">
													<h5><b>Logic 4</b></h5>
													<p class="mb-2">Lower the actual, zero</p>
													<table class="table table-pad text-center">
														<thead>
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

												<!-- Logic 5 content -->
												<div id="logic-5" class="logic-card d-none">
												<h5><b>Logic 5</b></h5>
												<p class="mb-2">Higher the achievement, Max is 100, Below 70% achievement, Zero</p>
												<table class="table table-pad text-center">
													<thead>
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
														<td>100</td><td>< 70</td><td>0</td>
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

												<!-- Logic 6A content (For Sales) -->
												<div id="logic-6a" class="logic-card d-none">
												<h5><b>Logic 6A (For Sales)</b></h5>
												<p class="mb-2">Need to be 100% weightage, and lowest is zero if >25% return in FC_HY</p>
												<table class="table table-pad text-center">
													<thead>
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
														<td>100</td><td>Return more than 25%</td><td>0</td>
													</tr>
													</tbody>
												</table>
												</div>
												<!-- Logic 6B content (For Sales) -->
												<div id="logic-6b" class="logic-card d-none">
												<h5><b>Logic 6B (For Sales)</b></h5>
												<p class="mb-2">Need to be 100% weightage, and lower zero if >5% return in FC_OP</p>
												<table class="table table-pad text-center">
													<thead>
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

												<!-- Logic 6 content (For Sales) -->
												<div id="logic-6" class="logic-card d-none">
												<h5><b>Logic 6 (For Sales)</b></h5>
												<p class="mb-2">Need to be 150% weightage, and lower zero if >25% return in FC</p>
												<table class="table table-pad text-center">
													<thead>
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
														<td>100</td><td>Return more than 25%</td><td>0</td>
													</tr>
													</tbody>
												</table>
												</div>

												<!-- Logic 7A content (For Sales) -->
												<div id="logic-7a" class="logic-card d-none">
												<h5><b>Logic 7A (For Sales)</b></h5>
												<p class="mb-2">Need to be 120% weightage, and lowest is zero if >4% return in VEG</p>
												<table class="table table-pad text-center">
													<thead>
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
														<td>100</td><td>Return more than >4%</td><td>0</td>
													</tr>
													</tbody>
												</table>
												</div>

												<!-- Logic 7 content (For Sales) -->
												<div id="logic-7" class="logic-card d-none">
												<h5><b>Logic 7 (For Sales)</b></h5>
												<p class="mb-2">Need to be 150% weightage, and lower zero if >10% return in VEG</p>
												<table class="table table-pad text-center">
													<thead>
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
														<td>100</td><td>Return more than 10%</td><td>0</td>
													</tr>
													</tbody>
												</table>
												</div>

												<!-- Logic 8 content (For Production) -->
												<div id="logic-8" class="logic-card d-none">
												<h5><b>Logic 8 (For Production)</b></h5>
												<p class="mb-2">Higher Achievement on higher Grades, higher the multiple factor</p>
												<table class="table table-pad text-center">
													<thead>
													<tr>
														<th>Sub Logic</th>
														<th>Target</th>
														<th>Achievement</th>
														<th>Achievement Multiple Factor</th>
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

												<!-- Logic 10 content (For Production) -->
												<div id="logic-10" class="logic-card d-none">
												<h5><b>Logic 10 (For Production)</b></h5>
												<p class="mb-2">More than 10% deviation, Score = Zero</p>
												<table class="table table-pad text-center">
													<thead>
													<tr>
														<th>Target</th>
														<th>Achievement (Deviation%)</th>
														<th>Score (Multiple Factor)</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>100</td><td>< 90%</td><td>0</td>
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

												<!-- Logic 11 content -->
												<div id="logic-11" class="logic-card d-none">
													<h5><b>Logic 11 (Reverse Calculation)</b></h5>
													<p class="mb-2">[Higher the Achievement, lower the score]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>100</td><td>100</td></tr>
															<tr><td>100</td><td>90</td><td>111</td></tr>
															<tr><td>100</td><td>110</td><td>91</td></tr>
														</tbody>
													</table>
												</div>

												<!-- Logic 12 content -->
												<div id="logic-12" class="logic-card d-none">
													<h5><b>Logic 12</b></h5>
													<p class="mb-2">[Higher the achievement, Max is 110, Below 90% achievement, Zero]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>100</td><td>100</td></tr>
															<tr><td>100</td><td><90</td><td>0</td></tr>
															<tr><td>100</td><td>90</td><td>90</td></tr>
															<tr><td>100</td><td>110</td><td>110</td></tr>
														</tbody>
													</table>
												</div>

												<!-- Logic 13A content -->
												<div id="logic-13a" class="logic-card d-none">
													<h5><b>Logic 13A (Quantity: All Crops [Own Production])</b></h5>
													<p class="mb-2">[Score Decreases with achievement deviation on both sides of target]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>&gt;,=130-121</td><td>70</td></tr>
															<tr><td>100</td><td>120-111</td><td>80</td></tr>
															<tr><td>100</td><td>110-91</td><td>100</td></tr>
															<tr><td>100</td><td>90-81</td><td>90</td></tr>
															<tr><td>100</td><td>&lt;,=80</td><td>80</td></tr>
														</tbody>
													</table>
												</div>

												<!-- Logic 13B content -->
												<div id="logic-13b" class="logic-card d-none">
													<h5><b>Logic 13B (Quantity: All Crops [Seed to Seed])</b></h5>
													<p class="mb-2">[Score Decreases upto 70% with achievement deviation on both sides of target]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>140-131</td><td>70</td></tr>
															<tr><td>100</td><td>130-121</td><td>80</td></tr>
															<tr><td>100</td><td>120-81</td><td>100</td></tr>
															<tr><td>100</td><td>80-71</td><td>90</td></tr>
															<tr><td>100</td><td>&lt;,=70</td><td>70</td></tr>
														</tbody>
													</table>
												</div>

												<!-- Logic 14A content -->
												<div id="logic-14a" class="logic-card d-none">
													<h5><b>Logic 14A (Germination: All OP Var, Hy Bhindi, Snake Gourd)</b></h5>
													<p class="mb-2">[Score decreases to Zero with &lt;,= 75% achievement]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>&gt;,=91</td><td>110</td></tr>
															<tr><td>100</td><td>90-86</td><td>100</td></tr>
															<tr><td>100</td><td>85-81</td><td>90</td></tr>
															<tr><td>100</td><td>80-76</td><td>80</td></tr>
															<tr><td>100</td><td>&lt;,=75</td><td>0</td></tr>
														</tbody>
													</table>
												</div>

												<!-- Logic 14B content -->
												<div id="logic-14b" class="logic-card d-none">
													<h5><b>Logic 14B (Germination: Remaining Crops & products)</b></h5>
													<p class="mb-2">[Score decreases to Zero with = 80 % achievement]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>&gt;,=96</td><td>110</td></tr>
															<tr><td>100</td><td>95-91</td><td>100</td></tr>
															<tr><td>100</td><td>90-86</td><td>90</td></tr>
															<tr><td>100</td><td>85-81</td><td>60</td></tr>
															<tr><td>100</td><td>&lt;,=80</td><td>0</td></tr>
														</tbody>
													</table>
												</div>

												<!-- Logic 15A content -->
												<div id="logic-15a" class="logic-card d-none">
													<h5><b>Logic 15A (Genetic Purity: All OP)</b></h5>
													<p class="mb-2">[Score decreases to Zero below 95 % achievement]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>&gt;,=99</td><td>110</td></tr>
															<tr><td>100</td><td><99-98</td><td>90</td></tr>
															<tr><td>100</td><td><98-97</td><td>60</td></tr>
															<tr><td>100</td><td><97-96</td><td>50</td></tr>
															<tr><td>100</td><td><96-95</td><td>0</td></tr>
														</tbody>
													</table>
												</div>

												<!-- Logic 15C content -->
												<div id="logic-15C" class="logic-card d-none">
													<h5><b>Logic 15C (Genetic Purity: Hy Bhindi)</b></h5>
													<p class="mb-2">[Score decreases to Zero if &lt; 96 % achievement]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>&gt;=99</td><td>110</td></tr>
															<tr><td>100</td><td>99-98</td><td>100</td></tr>
															<tr><td>100</td><td>98-97</td><td>80</td></tr>
															<tr><td>100</td><td>97-96</td><td>60</td></tr>
															<tr><td>100</td><td>&lt;96</td><td>0</td></tr>
														</tbody>
													</table>
												</div>


												<!-- Logic 16 content -->
												<div id="logic-16" class="logic-card d-none">
													<h5><b>Logic 16 (Seed Cost: All Crops)</b></h5>
													<p class="mb-2">[Higher the achievement, lower the score]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>111-115</td><td>90</td></tr>
															<tr><td>100</td><td>106-110</td><td>95</td></tr>
															<tr><td>100</td><td>100-105</td><td>100</td></tr>
															<tr><td>100</td><td>99-95</td><td>105</td></tr>
															<tr><td>100</td><td>94-90</td><td>110</td></tr>
														</tbody>
													</table>
												</div>


												<!-- Logic 17 content -->
												<div id="logic-17" class="logic-card d-none">
													<h5><b>Logic 17 (Seed Delivery: All Crops)</b></h5>
													<p class="mb-2">[Higher the achievement numbers (DOD-HD), lower the score]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>&lt;15</td><td>100</td></tr>
															<tr><td>100</td><td>16-22</td><td>90</td></tr>
															<tr><td>100</td><td>23-29</td><td>80</td></tr>
															<tr><td>100</td><td>30-36</td><td>75</td></tr>
															<tr><td>100</td><td>37-42</td><td>50</td></tr>
															<tr><td>100</td><td>&gt;42</td><td>0</td></tr>
														</tbody>
													</table>
												</div>


												<!-- Logic 18 content -->
												<div id="logic-18" class="logic-card d-none">
													<h5><b>Logic 18 (For Sales)</b></h5>
													<p class="mb-2">[Higher the achievement, higher the scoring as per given slabs]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>80-120</td><td>As achievement</td></tr>
															<tr><td>100</td><td>70-79</td><td>50</td></tr>
															<tr><td>100</td><td>60-69</td><td>25</td></tr>
															<tr><td>100</td><td>&lt;60</td><td>0</td></tr>
														</tbody>
													</table>
												</div>


												<!-- Logic 19 content -->
												<div id="logic-19" class="logic-card d-none">
													<h5><b>Logic 19 (For Sales)</b></h5>
													<p class="mb-2">[Higher the achievement, max score is 100]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th>Target</th>
																<th>Achievement</th>
																<th>Score</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>80-100</td><td>As achievement</td></tr>
															<tr><td>100</td><td>70-80</td><td>50</td></tr>
															<tr><td>100</td><td>&lt;70</td><td>0</td></tr>
														</tbody>
													</table>
												</div>


												<!-- Logic 20 content -->
												<div id="logic-20" class="logic-card d-none">
													<h5><b>Logic 20 (For Finance)</b></h5>
													<p class="mb-2">[Delay & Accuracy Measurement: 0 or 110]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th rowspan="2">Target</th>
																<th colspan="2" style="text-align: center;">Achievement</th>
																<th rowspan="2">Score</th>
															</tr>
															<tr>
																<th>Enter Days Delayed (no.)</th>
																<th>Enter Mistakes (%)</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>0</td><td>0</td><td>0</td></tr>
															<tr><td>100</td><td>1</td><td>0</td><td>0</td></tr>
															<tr><td>100</td><td>0</td><td>0</td><td>110</td></tr>
															<tr><td>100</td><td>0</td><td>2</td><td>0</td></tr>
														</tbody>
													</table>
												</div>


												<!-- Logic 21 content -->
												<div id="logic-21" class="logic-card d-none">
													<h5><b>Logic 21 (For Finance)</b></h5>
													<p class="mb-2">[Delay & Accuracy Measurement: More will lead to zero Achievement]</p>
													<table class="table table-pad text-center">
														<thead>
															<tr>
																<th rowspan="2">Target</th>
																<th colspan="2" style="text-align: center;">Achievement</th>
																<th rowspan="2">Score</th>
															</tr>
															<tr>
																<th>Enter Days Delayed (no.)</th>
																<th>Enter Mistakes (%)</th>
															</tr>
														</thead>
														<tbody>
															<tr><td>100</td><td>0</td><td>1</td><td>70</td></tr>
															<tr><td>100</td><td>2</td><td>0.3</td><td>63</td></tr>
															<tr><td>100</td><td>4</td><td>0</td><td>0</td></tr>
															<tr><td>100</td><td>0</td><td>0</td><td>110</td></tr>
															<tr><td>100</td><td>1</td><td>0.1</td><td>81</td></tr>
															<tr><td>100</td><td>1</td><td>0</td><td>99</td></tr>
														</tbody>
													</table>
												</div>

													</div>
													</div>
												</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
											

												
												@if($data['emp']['Schedule'] == 'Y')
													@if($data['emp']['Msg'] == 'Y' && $kraLastDate && $kraDaysRemaining !== null && $kraDaysRemaining > 0)
													<b>Note:</b>
													<span class="danger">
														Last date for KRA Submission: {{ \Carbon\Carbon::parse($kraLastDate)->format('d F Y') }} : 
														{{ $kraDaysRemaining }} days Remaining  
													</span>
												@endif

												<div class="card">
												<div class="card-header pb-0">
													<h4 class="card-title">KRA Schedule</h4>
												</div>
												<div class="card-content">
													<div class="card-body">
														<table class="table table-striped">
															<thead>
																<tr>
																<th><b>SN</b></th>
																<th><b>Activity Title</b></th>
																<th><b>Process Owner</b></th>
																<th style="width:80px;"><b>Date From</b></th>
																<th style="width:80px;"><b>Date To</b></th>
																
															</th></tr>
															</thead>
															<tbody>
																		@foreach($kra_schedule_data as $index => $schedule)
																			<tr>
																				<td><b>{{ $index + 1 }}.</b></td>
																				<td><b>{{ $schedule->KRAActivity }}</b></td>
																				<td>{{ $schedule->KRAProcessOwner }}</td>
																			
																				<td>{{ \Carbon\Carbon::parse($schedule->KRASche_DateFrom)->format('d M Y') }}</td>
																				<td>{{ \Carbon\Carbon::parse($schedule->KRASche_DateTo)->format('d M Y') }}</td>
																				
																			</tr>
																		@endforeach
																	</tbody>
														</table>
													</div>
												</div>
												</div>
												@endif

												@if($data['emp']['Appform'] == 'Y')
												@if($data['emp']['Msg'] == 'Y' && $pmsLastDate && $pmsDaysRemaining !== null)
													<b>Note:</b>
													<div class="danger">
														Last date for PMS Submission: {{ \Carbon\Carbon::parse($pmsLastDate)->format('d F Y') }} : 
														
														{{ $pmsDaysRemaining }} days Remaining  
													</div>
												@endif

												<div class="card">
												<div class="card-header pb-0">
													<h4 class="card-title">Appraisal Schedule</h4>
												</div>
												<div class="card-content">
													<div class="card-body">
														<table class="table table-striped">
															<thead>
																<tr>
																<th><b>SN</b></th>
																<th><b>Activity Title</b></th>
																<th><b>Process Owner</b></th>
																<th style="width:80px;"><b>Date From</b></th>
																<th style="width:80px;"><b>Date To</b></th>
															</th></tr>
															</thead>
															<tbody>
																		@foreach($appraisal_schedule_data as $index => $schedule)
																			<tr>
																				<td><b>{{ $index + 1 }}.</b></td>
																				
																				<td><b>{{ $schedule->Activity }}</b></td>
																				<td>{{ $schedule->ProcessOwner }}</td>
																				<td>{{ \Carbon\Carbon::parse($schedule->Sche_DateFrom)->format('d M Y') }}</td>
																				<td>{{ \Carbon\Carbon::parse($schedule->Sche_DateTo)->format('d M Y') }}</td>
																			</tr>
																		@endforeach
																	</tbody>
														</table>
													</div>
												</div>
												</div>
											@endif

												
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
	function showLogic(logic) {
	  // Hide all logic cards
	  const logics = document.querySelectorAll('.logic-card');
	  logics.forEach(logicCard => {
		logicCard.classList.add('d-none');
	  });
  
	  // Show the selected logic card
	  const selectedLogic = document.getElementById(logic);
	  if (selectedLogic) {
		selectedLogic.classList.remove('d-none');
	  }
	}
		</Script>
