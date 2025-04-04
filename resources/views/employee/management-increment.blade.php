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
                                    <li class="breadcrumb-link active">PMS - Management </li>
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
								<a style="color: #0e0e0e;min-width:105px;"  class="nav-link"  href="{{ route('pmsinfo') }}" role="tab" aria-selected="true">
									<span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
									<span class="d-none d-sm-block">PMS Information</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;"  class="nav-link"  href="{{route('pms')}}" role="tab" aria-selected="true">
									<span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
									<span class="d-none d-sm-block">Employee</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('appraiser') }}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Appraiser</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('reviewer')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Reviewer</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('hod')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">HOD</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link active" href="{{route('management')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Management</span>
								</a>
							</li>
							
						</ul>
					</div>
					
                <!-- Revanue Status Start -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
						<div class="mfh-machine-profile">
							
							<ul class="nav nav-tabs bg-light mb-3" id="myTab1" role="tablist" >   
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4 " id="profile-tab20"  href="{{route('management')}}#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA 2024</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4" id="profile-tab20" href="{{route('management')}}#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA New 2025-26</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4 active" id="team_appraisal_tab20" data-bs-toggle="tab" href="#teamappraisal" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;min-width:115px;" class="nav-link pt-4 text-center" id="team_report_tab20"  href="{{route('managementReport')}}" role="tab" aria-controls="teamreport" aria-selected="false">Report</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;min-width:115px;" class="nav-link pt-4 text-center" id="team_graph_tab20" href="{{route('managementGraph')}}" role="tab" aria-controls="teamgraph" aria-selected="false">Graph</a>
								</li>
							</ul>
							<div class="tab-content ad-content2" id="myTabContent2">
								<div class="tab-pane fade active show" id="teamappraisal" role="tabpanel">
									<div class="row">
										<div class="mfh-machine-profile">
                                            <div style="margin-top:-40px;float:left;margin-left:660px;">
												<ul class="kra-btns nav nav-tabs border-0" id="myTab1" role="tablist">
													<li class="mt-1"><a  id="home-tab1"
														href="{{route('managementAppraisal')}}" role="tab"
														aria-controls="home" aria-selected="true">Score <i
															class="fas fa-star mr-2"></i></a></li>
													<li class="mt-1"><a class="" id="Promotion-tab20"
														href="{{route('managementPromotion')}}" role="tab"
														aria-controls="Promotion" aria-selected="false">Promotion
														<i class="fas fa-file-alt mr-2"></i></a></li>
													<li class="mt-1"><a class="active" id="Increment-tab21"
														data-bs-toggle="tab" href="#Increment" role="tab"
														aria-controls="Increment" aria-selected="false">Increment <i class="fas fa-file-invoice mr-2"></i></a></li>
												</ul>
											</div>
											<div class="tab-content splash-content2" id="myTabContent2">
												<style>
													.rating-box input{width:50px;min-height:24px;height:24px;font-weight: 600;}
												</style>
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
												id="Increment" role="tabpanel">
												<div class="card increments-section">
													<div class="card-header increments-section-header" style="background-color:#7d9ea1;">
														<div class="float-start mr-2" style="margin-top:3px;">
															<h6 style="margin-bottom: 2px;color:#fff;">Select Department and Grade</h5>
															<select class="mr-2" style="height:24px;">
																<option>Select Department</option>
																<option>All</option>
																<option>Sales</option>
															</select>
															<select class="mr-2" style="height:24px;">
																<option>Select Grade</option>
																<option>All</option>
																<option>J1</option>
															</select>
														</div>
														<div class="">
															<div class="float-start rating-box mr-2 text-center"><b>2.2</b> <input type="number" class="form-control" ></div>
															<div class="float-start rating-box mr-2 text-center"><b>2.5</b> <input type="number" class="form-control" ></div>
															<div class="float-start rating-box mr-2 text-center"><b>2.9</b> <input type="number" class="form-control" ></div>
															<div class="float-start rating-box mr-2 text-center"><b>3.0</b> <input type="number" class="form-control" ></div>
															<div class="float-start rating-box mr-2 text-center"><b>3.2</b> <input type="number" class="form-control" ></div>
															<div class="float-start rating-box mr-2 text-center"><b>3.5</b> <input type="number" class="form-control" ></div>
															<div class="float-start rating-box mr-2 text-center"><b>4.0</b> <input type="number" class="form-control" ></div>
														</div>
													</div>
													
													<div class="card-body table-container table-responsive dd-flex align-items-center p-0">
														<table class="increments-section-table table table-pad table-bordered inc-table mt-1" style="font-size:11px;">
															<thead>
																<tr>
																	<th rowspan="2" class="text-center">SN.</th>
																	<th rowspan="2" class="text-center">EC</th>
																	<th rowspan="2" style="width:110px;">Name</th>
																	<th rowspan="2" class="text-center" style="width:50px;">DOJ</th>
																	<th rowspan="2" style="width:95px;">Department</th>
																	<th rowspan="2" style="width:95px;">Designation</th>
																	<th rowspan="2" class="text-center">Grade</th>
																	<th rowspan="2" class="text-center">Grade Change Year</th>
																	<th class="text-center" colspan="2">Last Carrection</th>
																	<th class="text-center" colspan="2">Previous CTC</th>
																	<th class="text-center" colspan="8">Proposed</th>
																	<th class="text-center" colspan="3">Total Proposed</th>
																</tr>
																<tr>
																	<th class="text-center">%</th>
																	<th class="text-center" style="width:48px;">Year</th>
																	<th class="text-center">Fixed</th>
																	<th class="text-center" style="width:48px;">Total</th>
																	<th class="text-center" >Rating</th>
																	<th class="text-center">Designation</th>
																	<th class="text-center">Grade</th>
																	<th class="text-center">Pro. Rata (%)</th>
																	<th class="text-center">Actual (%)</th>
																	<th class="text-center">CTC</th>
																	<th class="text-center">Corr.</th>
																	<th class="text-center">Corr.(%)</th>
																	<th class="text-center">Inc</th>
																	<th class="text-center">CTC</th>
																	<th class="text-center">Final (%)</th>
																</tr>
															</thead>
															<tbody>
																<tr class="export-btn-section" style="background-color: #ed843e;">
																	<td colspan="10"><a class="btn btn-sm btn-primary mr-2" href="">Export with Blank</a> <a class="btn btn-sm btn-primary mr-2" href="">Export with Data</a> <a class="btn btn-sm btn-success mr-2" href="">Save</a><b style="float:right;margin-top:5px;">Total</b></td>
																	<td class="text-right"><b>5,86,73,495/-</b></td>
																	<td class="text-right"><b>5,86,73,495/-</b></td>
																	<td colspan="3"></td>
																	<td class="text-center"><b>0.19</b></td>
																	<td class="text-center"><b>0.05</b></td>
																	<td class="text-right"><b>58703527/-</b></td>
																	<td class="text-right"><b>58703527/-</b></td>
																	<td class="text-right"><b>0</b></td>
																	<td class="text-center"><b>0</b></td>
																	<td class="text-right"><b>30032/-</b></td>
																	<td class="text-center"><b>0.05</b></td>
																</tr>
																<tr>
																	<td>1. <a title="History" href="" id="toggle"><i class="fas fa-eye"></i></a></td>
																	<td class="text-center">1047</td>
																	<td><input class="inputbox" type="text" value="Parmar Bhikhushi" readonly></td>
																	<td class="text-center"><b>Sep-20</b></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="Production" readonly></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="FA.Prod" readonly></td>
																	<td class="text-center">S2</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-center">5.42</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-center r-color"><b>2.5</b></td>
																	<td></td>
																	<td class="text-center"></td>
																	<td class="text-center">8</td>
																	<td class="text-center"><input type="text" style="width:50px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-right"><input type="text" style="width:70px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-center">0</td>
																	<td class="text-right p-color"><b>202706/-</b></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-center">8</td>
																</tr>
																<tr>
																	<td class="p-0" colspan="23">
																	<div class="col-md-12 p-0" id="fulldetails" style="display:none;">
																		
																		<table class="table border table-pad mb-1 table-striped history-table" >
																			<thead style="position:relative;z-index:0;">
																				<tr style="position:relative;z-index:0;top:0;">
																					<th colspan="5" style="text-align:center;">VNR Career History</th>
																					<th colspan="2" style="text-align:center;border-left:1px solid #fff;border-right:1px solid #fff;">Gross Salary Per Month </th>
																					<th colspan="6" style="text-align:center;border-right:1px solid #fff;">CTC</th>
																					<th rowspan="2" style="text-align:center;">Score</th>
																					<th rowspan="2" style="text-align:center;">Rating</th>
																				</tr>
																				<tr>
																					<th style="text-align:center;">Pre. Grade</th>
																					<th style="text-align:center;">Pro. Grade</th>
																					<th style="text-align:center;">Pre. Designation</th>
																					<th style="text-align:center;">Pro. Designation</th>
																					<th style="text-align:center;border-right:1px solid #fff;">Change Date</th>
																					<th style="text-align:center;">Total Proposed</th>
																					<th style="text-align:center;border-right:1px solid #fff;">Total %</th>
																					<th style="text-align:center;">Previous CTC</th>
																					<th style="text-align:center;">Proposed Increments</th>
																					<th style="text-align:center;">Increments %</th>
																					<th style="text-align:center;">CTC Benchmark</th>
																					<th style="text-align:center;">Total Proposed</th>
																					<th style="text-align:center;border-right:1px solid #fff;">Total %</th>
																					
																				</tr>
																			</thead>
																			
																			<tbody>
																				<tr>
																					<td>M1</td>
																					<td>M1</td>
																					<td>Area Sales Coordinator</td>
																					<td>Area Sales Coordinator</td>
																					<td>1-Jan-24</td>
																					
																					<td><b>-</b></td>
																					<td>-</td>
																					<td><b>1374728/-</b></td>
																					<td><b>1397654/-</b></td>
																					<td>5.60</td>
																					<td>0</td>
																					<td><b>1397654/-</b></td>
																					<td>5.60</td>
																					<td><b>82.00</b></td>
																					<td><b>4.00</b></td>
																				</tr>
																				<tr>
																					<td>M1</td>
																					<td>M1</td>
																					<td>Area Sales Coordinator</td>
																					<td>Area Sales Coordinator</td>
																					<td>1-Jan-23</td>
																					
																					<td><b>-</b></td>
																					<td>-</td>
																					<td><b>1278804/-</b></td>
																					<td><b>1374728/-</b></td>
																					<td>7.50</td>
																					<td>0</td>
																					<td><b>1374728/-</b></td>
																					<td>7.50</td>
																					<td><b>80.00</b></td>
																					<td><b>3.00</b></td>
																				</tr>
																				<tr>
																					<td>M1</td>
																					<td>M1</td>
																					<td>Area Sales Coordinator</td>
																					<td>Area Sales Coordinator</td>
																					<td>1-Jan-22</td>
																					
																					<td><b>-</b></td>
																					<td>-</td>
																					<td><b>1206423</b></td>
																					<td>-</td>
																					<td>-</td>
																					<td>-</td>
																					<td><b>1206423</b></td>
																					<td>-</td>
																					<td><b>00.00</b></td>
																					<td><b>3.20</b></td>
																				</tr>
																				<tr>
																					<td>J4</td>
																					<td>M1</td>
																					<td>Territory Business Manager</td>
																					<td>Area Sales Coordinator</td>
																					<td>1-Jan-20</td>
																					
																					<td><b>-</b></td>
																					<td>-</td>
																					<td><b>1020073/-</b></td>
																					<td><b>1106845/-</b></td>
																					<td>0</td>
																					<td>0</td>
																					<td><b>1106845/-</b></td>
																					<td>-</td>
																					<td><b>00.00</b></td>
																					<td><b>3.20</b></td>
																				</tr>
																				<tr>
																					<td>J4</td>
																					<td>M1</td>
																					<td>Territory Business Manager</td>
																					<td>Area Sales Coordinator</td>
																					<td>1-Jan-20</td>
																					
																					<td><b>-</b></td>
																					<td>-</td>
																					<td><b>1020073/-</b></td>
																					<td><b>1106845/-</b></td>
																					<td>8.50</td>
																					<td>0</td>
																					<td><b>1106845/-</b></td>
																					<td>8.50</td>
																					<td><b>84.00</b></td>
																					<td><b>3.20</b></td>
																				</tr>
																				<tr>
																					<td>0</td>
																					<td>6</td>
																					<td>Territory Business Manager</td>
																					<td>Territory Business Manager</td>
																					<td>10-Oct-19</td>
																					
																					<td><b>32673/-</b></td>
																					<td>17.00</td>
																					<td><b>426049/-</b></td>
																					<td>-</td>
																					<td>-</td>
																					<td>-</td>
																					<td>-</td>
																					<td>-</td>
																					<td><b>87.00</b></td>
																					<td><b>3.50</b></td>
																				</tr>
																				<tr>
																					<td>0</td>
																					<td>0</td>
																					<td>Sales Officer</td>
																					<td>Sales Executive</td>
																					<td>10-Oct-18</td>
																					<td><b>18348/-</b></td>
																					<td>27.42</td>
																					<td><b>248321/-</b></td>
																					<td>-</td>
																					<td>-</td>
																					<td>-</td>
																					<td>-</td>
																					<td>-</td>
																					<td><b>86.00</b></td>
																					<td><b>3.50</b></td>
	
																				</tr>
																			</tbody>
	
																		</table>
																	</div>
																</td>
																</tr>

																<tr>
																	<td>2.</td>
																	<td class="text-center">1047</td>
																	<td><input class="inputbox" type="text" value="Parmar Bhikhushi" readonly></td>
																	<td class="text-center"><b>Sep-20</b></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="Production" readonly></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="FA.Prod" readonly></td>
																	
																	<td class="text-center">S2</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-center">5.42</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-center r-color"><b>2.5</b></td>
																	<td></td>
																	<td class="text-center"></td>
																	<td class="text-center">8</td>
																	<td class="text-center"><input type="text" style="width:50px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-right"><input type="text" style="width:70px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-center">0</td>
																	<td class="text-right p-color"><b>202706/-</b></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-center" >8</td>
																</tr>
																<tr>
																	<td>3.</td>
																	<td class="text-center">1047</td>
																	<td><input class="inputbox" type="text" value="Parmar Bhikhushi" readonly></td>
																	<td class="text-center"><b>Sep-20</b></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="Production" readonly></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="FA.Prod" readonly></td>
																	
																	<td class="text-center">S2</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-center">5.42</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-center r-color"><b>2.5</b></td>
																	<td></td>
																	<td class="text-center"></td>
																	<td class="text-center">8</td>
																	<td class="text-center"><input type="text" style="width:50px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-right"><input type="text" style="width:70px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-center">0</td>
																	<td class="text-right p-color"><b>202706/-</b></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-center">8</td>
																</tr>
																<tr>
																	<td>4.</td>
																	<td class="text-center">1047</td>
																	<td><input class="inputbox" type="text" value="Parmar Bhikhushi" readonly></td>
																	<td class="text-center"><b>Sep-20</b></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="Production" readonly></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="FA.Prod" readonly></td>
																	
																	<td class="text-center">S2</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-center">5.42</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-center r-color"><b>2.5</b></td>
																	<td></td>
																	<td class="text-center"></td>
																	<td class="text-center">8</td>
																	<td class="text-center"><input type="text" style="width:50px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-right"><input type="text" style="width:70px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-center">0</td>
																	<td class="text-right p-color"><b>202706/-</b></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-center" >8</td>
																</tr>
																<tr>
																	<td>5.</td>
																	<td class="text-center">1047</td>
																	<td><input class="inputbox" type="text" value="Parmar Bhikhushi" readonly></td>
																	<td class="text-center"><b>Sep-20</b></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="Production" readonly></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="FA.Prod" readonly></td>
																	
																	<td class="text-center">S2</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-center">5.42</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-center r-color"><b>2.5</b></td>
																	<td></td>
																	<td class="text-center"></td>
																	<td class="text-center">8</td>
																	<td class="text-center"><input type="text" style="width:50px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-right"><input type="text" style="width:70px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-center">0</td>
																	<td class="text-right p-color"><b>202706/-</b></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-center" >8</td>
																</tr>
																<tr>
																	<td>6.</td>
																	<td class="text-center">1047</td>
																	<td><input class="inputbox" type="text" value="Parmar Bhikhushi" readonly></td>
																	<td class="text-center"><b>Sep-20</b></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="Production" readonly></td>
																	<td><input style="width:60px !important;" class="inputbox" type="text" value="FA.Prod" readonly></td>
																	
																	<td class="text-center">S2</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-center">5.42</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-center r-color"><b>2.5</b></td>
																	<td></td>
																	<td class="text-center"></td>
																	<td class="text-center">8</td>
																	<td class="text-center"><input type="text" style="width:50px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-right"><input type="text" style="width:70px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-center">0</td>
																	<td class="text-right p-color"><b>202706/-</b></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-center" >8</td>
																</tr>
																<tr>
																	<td>7.</td>
																	<td class="text-center">1047</td>
																	<td>Parmar Bhikhushi</td>
																	<td class="text-center"><b>Sep-20</b></td>
																	<td>Production</td>
																	<td>FA.Prod</td>
																	<td class="text-center">S2</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-center">5.42</td>
																	<td class="text-center">Jan-24</td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-right p-color"><b>253451/-</b></td>
																	<td class="text-center r-color"><b>2.5</b></td>
																	<td></td>
																	<td class="text-center"></td>
																	<td class="text-center">8</td>
																	<td class="text-center"><input type="text" style="width:50px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-right"><input type="text" style="width:70px;border:1px solid #7b9fa3;" class="form-control"></td>
																	<td class="text-center">0</td>
																	<td class="text-right p-color"><b>202706/-</b></td>
																	<td class="text-right p-color"><b>273727/-</b></td>
																	<td class="text-center" >8</td>
																</tr>
															</tbody>
														</table>
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
                @include('employee.footerbottom')
        	</div>
    	</div>
    </div>

@include('employee.footer')
<script>
    $(document).ready(function(){
        $("#toggle").click(function(e){
            e.preventDefault();
            $("#fulldetails").slideToggle(300);
        });
    });
</script>