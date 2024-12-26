@include('employee.head')
@include('employee.header')
@include('employee.sidebar')

<body class="mini-sidebar">
<div id="loader" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
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
                                        <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Profile</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
          
                <div class="row">
                <!-- Revanue Status Start -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-none" >
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="">
                                
                                <div class="emp-profile-sec">
                                    <img alt="" class="profile-pic" src="./images/7.jpg" />
                                    <span class="edit-profile-link"><a href=""><i class="far fa-edit mr-2"></i></a></span>
                                    <div class="emp-name-profile">
                                        <h3><b>{{$employee->Fname .''.$employee->Sname.''.$employee->Lname}}</b></h3>
                                        <h4 class="mt-2" style="color:#2bb15b;"><b>Emp. ID: 1544</b></h4>
                                    </div>
                                    <div class="float-start" style="margin-left: 55px;margin-top: 55px;">
                                        <span class="profile-name-id"><i class="fa fa-phone-alt mr-2"></i> +91-9589457812</span>
                                        <span class="profile-name-id"><i class="far fa-envelope mr-2"></i> rohitkumar.vspl@gmail.com</span>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="card chart-card">
								<div class="card-body" style="min-height:375px;">
									<!-- Profile Picture and Name -->
									<div class="profile-header">
										<div class="profile-picture">
											<img src="./images/7.jpg" alt="Profile Picture">
										</div>
										<div class="profile-info">
											<h2>{{$employee->Fname .' '.$employee->Sname.' '.$employee->Lname}}</h2>
											<span >{{$employee->EmailId_Vnr}}</span>
											<h4 style="color:#000;">Emp. Code:{{$employee->EmpCode}}</h4>
										</div>
									</div>
									<div class="row mt-5">
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
											<div class="profile-details">
												<p><strong>Designation</strong><br><span>{{$employee->DesigName}}</span></p>
												<p><strong>Department</strong><br><span>{{$employee->DepartmentName}}</span></p>
												<p><strong>Grade</strong><br><span>{{$employee->GradeValue}}</span></p>
												<p><strong>Date of Joining</strong><br><span>{{$employee->DateJoining}}</span></p>
											</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
											<div class="profile-details">
												<p><strong>Function</strong><br><span>-</span></p>
												<!-- <p><strong>Region</strong><br><span>-</span></p>
												<p><strong>Zone</strong><br><span>-</span></p> -->
												<p><strong>HQ</strong><br><span>{{$employee->HqName}}</span></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
						<div class="card chart-card">
								<div class="card-header">
                                    <h4 class="has-btn float-start mt-2">Attendance 2024</h4>
									<span class="float-end">
										<select class="select2 form-control select-opt" id="yearname" fdprocessedid="7n33b9">
											  <option value="select">Select Year </option>
											  <option value="january">2019</option>
											  <option value="February">2020</option>
											  <option value="March">2021</option>
											  <option value="April">2022</option>
											  <option value="May">2023</option>
											  <option value="June">2024</option>
										</select>
									</span>
                                </div>
                                <div class="card-body">
                                    <table class="table table-c border d-none">
												<thead class="thead-dark">
													<tr>
														<th>Month</th>
														<th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th><th><span class="sun">S</span></th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th><th><span class="sun">S</span></th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th><th><span class="sun">S</span></th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th><th><span class="sun">S</span></th><th>M</th><th>T</th><th>W</th><th>T</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<div class="emp-name float-start">
																<span><a href="emp-details.html"><b>Jan</b></a></span>
															</div>
														</td>
														<td>1</td><td><span class="haf-day1">2</span></td><td>3</td><td>4</td><td><span class="atnd">5</span></td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>16</td><td>17</td><td>18</td><td><span class="haf-day2">19</span></td><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td>
													</tr>
													<tr>
														<td>
															<div class="emp-name float-start">
																<span class="name-circle">R</span>
																<span><b>Roshani</b></span>
															</div>
														</td>
														<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td><span class="atnd">13</span></td><td>14</td><td>15</td><td>16</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td>
													</tr>
													<tr>
														<td>
															<div class="emp-name float-start">
																<span class="name-circle">R</span>
																<span><b>Rahul</b></span>
															</div>
														</td>
														<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td><span class="atnd">29</span></td><td>30</td><td>31</td>
													</tr>
													<tr>
														<td>
															<div class="emp-name float-start">
																<span class="name-circle">H</span>
																<span><b>Hemant</b></span>
															</div>
														</td>
														<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td><span class="atnd">23</span></td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td>
													</tr>
													<tr>
														<td>
															<div class="emp-name float-start">
																<span class="name-circle">K</span>
																<span><b>Krishna</b></span>
															</div>
														</td>
														<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td><span class="atnd">21</span></td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td>
													</tr>
													<tr>
														<td>
															<div class="emp-name float-start">
																<span class="name-circle">K</span>
																<span><b>Suraj</b></span>
															</div>
														</td>
														<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td><span class="atnd">21</span></td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td>
													</tr>
												</tbody>
											</table>
                                </div>
							</div>
						</div>
                        
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="card chart-card">
								<div class="card-header">
                                    <h4 class="has-btn">Leave Balance</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
										<div class="col-md-6 col-sm-6 text-center mb-3" style="border-bottom: 1px solid #ddd;">
											<h6>Casual Leave(CL)</h6>
											<div class="mt-2 mb-3">
												<span class="leave-bal-use">05</span>
												<span class="leave-bal-bal">01</span>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 text-center mb-3" style="border-bottom: 1px solid #ddd;">
											<h6>Sick Leave(SL)</h6>
											<div class="mt-2 mb-3">
												<span class="leave-bal-use">00</span>
												<span class="leave-bal-bal">05</span>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 text-center mb-3" style="border-bottom: 1px solid #ddd;">
											<h6>Privilege Leave(PL)</h6>
											<div class="mt-2 mb-3">
												<span class="leave-bal-use">02</span>
												<span class="leave-bal-bal">04</span>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 text-center mb-3" style="border-bottom: 1px solid #ddd;">
											<h6>Earn Leave(EL)</h6>
											<div class="mt-2 mb-3">
												<span class="leave-bal-use">05</span>
												<span class="leave-bal-bal">25</span>
											</div>
										</div>
										<div class="col-md-12 text-center">
											<h6>Earn Leave(EL)</h6>
											<div class="mt-2 mb-3">
												<span class="leave-bal-use">00</span>
												<span class="leave-bal-bal">02</span>
											</div>
										</div>
									</div>
                                </div>
							</div>
                        </div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="card chart-card">	
                                <div class="card-header">
                                    <h4 class="has-btn">Query</h4>
                                </div>
                                <div class="card-body" style="height:238px;overflow-y:auto;">
                                    <div class="emp-query-box">
										<div style="font-size:10px;color:#7a7474;margin-bottom:5px;">
											<span style="margin-right:17px;">Label 1</span>
											<span style="margin-right:17px;">Label 2</span>
											<span style="margin-right:25px;">Label 3</span>
											<span>Label 4</span>
										</div>
										<div class="query-level" style="border-top: 2px solid #ddd;margin-bottom:10px;width:190px;">
											<span class="label1">&nbsp;</span>
											<span style="border: 2px solid #3f4040;" class="label2">&nbsp;</span>
											<span class="label3">&nbsp;</span>
											<span class="label4">&nbsp;</span>
										</div>
										<div style="font-size:10px;color:#7a7474;margin-bottom:5px;">
											<span style="margin-right:17px;">15 May</span>
											<span style="margin-right:17px;">18 May</span>
											<span style="margin-right:25px;">25 May</span>
											<span>30 May</span>
										</div>
										<div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
											<span class="float-start"><b>Dept.: Admin</b></span>
											<span class="float-end"><b>Sub: Washing</b></span>
										</div>
										<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  ut labore et dolore magna aliqua  Ut enim ad minim veniam, quis nostrud</p>
										<div class="float-start w-100" style="font-size:11px;">
											<span class="float-start"><b>Raise to:</b> 15 May 2024</b></span>
											<span class="float-end"><b>Solve:</b> 15 May 2024</span>
										</div>
									</div>
									<div class="emp-query-box" style="background-color:#E5F0F1;">
										<div style="font-size:10px;color:#7a7474;margin-bottom:5px;">
											<span style="margin-right:17px;">Label 1</span>
											<span style="margin-right:17px;">Label 2</span>
											<span style="margin-right:25px;">Label 3</span>
											<span>Label 4</span>
										</div>
										<div class="query-level" style="border-top: 2px solid #ddd;margin-bottom:10px;width:190px;">
											<span class="label1">&nbsp;</span>
											<span style="border: 2px solid #3f4040;" class="label2">&nbsp;</span>
											<span class="label3">&nbsp;</span>
											<span class="label4">&nbsp;</span>
										</div>
										<div style="font-size:10px;color:#7a7474;margin-bottom:5px;">
											<span style="margin-right:17px;">15 May</span>
											<span style="margin-right:17px;">18 May</span>
											<span style="margin-right:25px;">25 May</span>
											<span>30 May</span>
										</div>
										<div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
											<span class="float-start"><b>Dept.: Admin</b></span>
											<span class="float-end"><b>Sub: Washing</b></span>
										</div>
										<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  ut labore et dolore magna aliqua  Ut enim ad minim veniam, quis nostrud</p>
										<div class="float-start w-100" style="font-size:11px;">
											<span class="float-start"><b>Raise to:</b> 15 May 2024</b></span>
											<span class="float-end"><b>Solve:</b> 15 May 2024</span>
										</div>
									</div>
									<div class="emp-query-box">
										<div style="font-size:10px;color:#7a7474;margin-bottom:5px;">
											<span style="margin-right:17px;">Label 1</span>
											<span style="margin-right:17px;">Label 2</span>
											<span style="margin-right:25px;">Label 3</span>
											<span>Label 4</span>
										</div>
										<div class="query-level" style="border-top: 2px solid #ddd;margin-bottom:10px;width:190px;">
											<span class="label1">&nbsp;</span>
											<span style="border: 2px solid #3f4040;" class="label2">&nbsp;</span>
											<span class="label3">&nbsp;</span>
											<span class="label4">&nbsp;</span>
										</div>
										<div style="font-size:10px;color:#7a7474;margin-bottom:5px;">
											<span style="margin-right:17px;">15 May</span>
											<span style="margin-right:17px;">18 May</span>
											<span style="margin-right:25px;">25 May</span>
											<span>30 May</span>
										</div>
										<div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
											<span class="float-start"><b>Dept.: Admin</b></span>
											<span class="float-end"><b>Sub: Washing</b></span>
										</div>
										<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  ut labore et dolore magna aliqua  Ut enim ad minim veniam, quis nostrud</p>
										<div class="float-start w-100" style="font-size:11px;">
											<span class="float-start"><b>Raise to:</b> 15 May 2024</b></span>
											<span class="float-end"><b>Solve:</b> 15 May 2024</span>
										</div>
									</div>
                                </div>
                            </div>
						</div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="card chart-card">	
                                <div class="card-header">
                                    <h4 class="has-btn">Eligibility</h4>
                                </div>
                                <div class="card-body">
                                    
                                </div>
                            </div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="card chart-card">
								<div class="card-header">
                                    <h4 class="has-btn">Training</h4>
                                </div>
                                <div class="card-body" style="height:238px;overflow-y:auto;">
                                    <div class="emp-training-box">
										<div class="float-start w-100">
											<span class="float-start"><b>Prevention of Sexual Harassment (POSH)</b></span>
											<span class="float-end emp-tra-day"><b>0.5 Day</b></span>
										</div>
										<div class="float-start w-100 pb-1 mb-1" style="border-bottom:1px solid #ddd;font-size:11px;">
											<span class="float-start">22 Sep 2023     to     22 Sep 2023</span>
											<span class="float-end"><b>Mr. Hakimuddin F. Saify</b></span>
										</div>
										<div class="float-start w-100 pb-2 mb-2" style="font-size:11px;">
											<span class="float-start">ANM Consultants </span>
											<span class="float-end"> <i class="fas fa-map-marker-alt"></i> <b>Corporate Centre, Raipur</b></span>
										</div>
									</div>
									<div class="emp-training-box" style="background-color:#E5F0F1;">
										<div class="float-start w-100">
											<span class="float-start"><b>Presentation Skill - Session 4</b></span>
											<span class="float-end emp-tra-day"><b>0.5 Day</b></span>
										</div>
										<div class="float-start w-100 pb-1 mb-1" style="border-bottom:1px solid #ddd;font-size:11px;">
											<span class="float-start">22 Sep 2023     to     22 Sep 2023</span>
											<span class="float-end"><b>Mr. Nandkishore Sharma</b></span>
										</div>
										<div class="float-start w-100 pb-2 mb-2" style="font-size:11px;">
											<span class="float-start">Internal Trainer</span>
											<span class="float-end"> <i class="fas fa-map-marker-alt"></i> <b>Corporate Centre, Raipur</b></span>
										</div>
									</div>
									<div class="emp-training-box">
										<div class="float-start w-100">
											<span class="float-start"><b>Prevention of Sexual Harassment (POSH)</b></span>
											<span class="float-end emp-tra-day"><b>0.5 Day</b></span>
										</div>
										<div class="float-start w-100 pb-1 mb-1" style="border-bottom:1px solid #ddd;font-size:11px;">
											<span class="float-start">22 Sep 2023     to     22 Sep 2023</span>
											<span class="float-end"><b>Mr. Hakimuddin F. Saify</b></span>
										</div>
										<div class="float-start w-100 pb-2 mb-2" style="font-size:11px;">
											<span class="float-start">ANM Consultants </span>
											<span class="float-end"> <i class="fas fa-map-marker-alt"></i> <b>Corporate Centre, Raipur</b></span>
										</div>
									</div>
                                </div>
							</div>
                        </div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="card chart-card">	
                                <div class="card-header">
                                    <h4 class="has-btn">Documents</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table ">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>SN</th>
                                                                            <th>Documents Name</th>
                                                                            <th>View</th>
                                                                            <th>Download</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody> 	
                                                                    
                                                                    
                                                                    <tr>
                                                                    <td >1.</td>
                                                                    <td >Passport</td>
                                                                    <td><img style="width:30px;" src="images/excel-invoice.jpg" /></td>
                                                                    <td><a><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td >2.</td>
                                                                    <td >Account Passbook</td>
                                                                    <td><img style="width:30px;" src="images/excel-invoice.jpg" /></td>
                                                                    <td><a><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                                                    </tr>
                                                                         
                                                                    <tr>
                                                                    <td >3.</td>
                                                                    <td >Driving Licence No.</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    </tr>			
                                                                    
																	<tr>
                                                                    <td >4.</td>
                                                                    <td >Pancard</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    </tr>																	
                                                                        
                                                                               
                                                                </tbody></table>
                                </div>
                            </div>
						</div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="card chart-card">	
                                <div class="card-header">
                                    <h4 class="has-btn">Assets</h4>
                                </div>
                                <div class="card-body">
                                    
                                </div>
                            </div>
						</div>
                    </div>
                    
              
            </div>
        </div>
    </div>
		@include('employee.footer')

