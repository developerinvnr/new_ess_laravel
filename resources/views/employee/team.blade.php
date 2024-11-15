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
                                        <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">My Team</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
				<div class="row">
    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="#attendance">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon1.png" alt="Attendance Icon">
                        <h5 class="ad-title mb-0">Attendance</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="#leave">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/leave-day.png" alt="Leave Icon">
                        <h5 class="ad-title mb-0">Leave</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="#team">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon2.png" alt="Assets Icon">
                        <h5 class="ad-title mb-0">Assets</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="#eligibility">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/eligibility-icon.png" alt="Eligibility Icon">
                        <h5 class="ad-title mb-0">Eligibility</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="#training">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon5.png" alt="Training Icon">
                        <h5 class="ad-title mb-0">Training</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="team-salary.html">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/team-cost.png" alt="Team Cost Icon">
                        <h5 class="ad-title mb-0"> Cost</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="#query">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon4.png" alt="Query Icon">
                        <h5 class="ad-title mb-0">Query</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="#separation">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/separation-icon.png" alt="Separation Icon">
                        <h5 class="ad-title mb-0">Separation</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                        <div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6">
						<div class="card ad-info-card-">
							<div class="card-header">
								<img style="width:30px;" class="float-start me-3" src="./images/icons/icon6.png">
								<div class="">
									<h5><b>Team's</b></h5>
									<p>View today team’s structure, hierarchy and attendance records</p>
								</div>
							</div>
							<div class="card-body border-bottom-d" style="height: 450px;overflow-y: scroll;overflow-x: hidden;">
							<div class="row">
								<div class="tree col-md-12 d-none mb-4">
									<ul style="padding-top:0px;">
										<li>
											<span><img style="width:60px;" src="./images/7.jpg"></span>
											<ul>
												<li>
													<span><img src="./images/1.jpg"></span>
												</li>
												<li>
													<span><img src="./images/3.jpg"></span>
												</li>
												<li>
													<span><b>5</b> <i class="fas fa-plus"></i></span>
												</li>
												
											</ul>
										</li>
									</ul>
								</div>
								<div class="col-md-12 table-responsive">
                                    <table class="table table-styled mb-0">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="img-thumb">
                                                        
                                                        <img src="images/3.jpg" alt="">
                                                        
														
                                                    </span>
                                                </td>
												<td>
												<div class="ml-2">
													<span>Ayushi</span>
													<br><small class="me-2"><b>In:</b> 00:00 am</small> <small><b>Out:</b> 00:00 pm</small>
													<p>test ...</p>
												</div>
												</td>
                                                <td class="relative">
                                                    <a class="action-btn" href="javascript:void(0);">
                                                        <svg class="default-size " viewBox="0 0 341.333 341.333 ">
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path d="M170.667,85.333c23.573,0,42.667-19.093,42.667-42.667C213.333,19.093,194.24,0,170.667,0S128,19.093,128,42.667 C128,66.24,147.093,85.333,170.667,85.333z "></path>
                                                                        <path d="M170.667,128C147.093,128,128,147.093,128,170.667s19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 S194.24,128,170.667,128z "></path>
                                                                        <path d="M170.667,256C147.093,256,128,275.093,128,298.667c0,23.573,19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 C213.333,275.093,194.24,256,170.667,256z "></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                    <div class="action-option">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);"><i class="far fa-eye mr-2"></i>View</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="img-thumb">
                                                        
                                                        <img src="images/7.jpg" alt="">
                                                    </span>
                                                </td>
												<td>
													<div class="ml-2">
														<span>Sameer Kumar</span>
														<br><small class="me-2"><b>In:</b> <span class="danger">09:40 am</span></small> <small><b>Out:</b> 00:00 pm</small>
														<p>test ...</p>
													</div>
												</td>
                                                <td class="relative">
                                                    <a class="action-btn" href="javascript:void(0);">
                                                        <svg class="default-size " viewBox="0 0 341.333 341.333 ">
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path d="M170.667,85.333c23.573,0,42.667-19.093,42.667-42.667C213.333,19.093,194.24,0,170.667,0S128,19.093,128,42.667 C128,66.24,147.093,85.333,170.667,85.333z "></path>
                                                                        <path d="M170.667,128C147.093,128,128,147.093,128,170.667s19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 S194.24,128,170.667,128z "></path>
                                                                        <path d="M170.667,256C147.093,256,128,275.093,128,298.667c0,23.573,19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 C213.333,275.093,194.24,256,170.667,256z "></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                    <div class="action-option">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);"><i class="far fa-eye mr-2"></i>View</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="img-thumb">
                                                        
                                                        <img src="images/1.jpg" alt="">
                                                        
                                                    </span>
                                                </td>
												<td>
													<div class="ml-2">
														<span>Kausal Mishra</span>
														<br><small class="me-2"><b>In:</b> 09:00 am</small> <small><b>Out:</b> 00:00 pm</small>
														<p>test ...</p>
													</div>
												</td>
                                                <td class="relative">
                                                    <a class="action-btn" href="javascript:void(0);">
                                                        <svg class="default-size " viewBox="0 0 341.333 341.333 ">
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path d="M170.667,85.333c23.573,0,42.667-19.093,42.667-42.667C213.333,19.093,194.24,0,170.667,0S128,19.093,128,42.667 C128,66.24,147.093,85.333,170.667,85.333z "></path>
                                                                        <path d="M170.667,128C147.093,128,128,147.093,128,170.667s19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 S194.24,128,170.667,128z "></path>
                                                                        <path d="M170.667,256C147.093,256,128,275.093,128,298.667c0,23.573,19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 C213.333,275.093,194.24,256,170.667,256z "></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                    <div class="action-option">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);"><i class="far fa-eye mr-2"></i>View</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
											<tr>
                                                <td>
                                                    <span class="img-thumb">
                                                        
                                                        <img src="images/1.jpg" alt="">
                                                        
                                                    </span>
                                                </td>
												<td>
													<div class="ml-2">
														<span>Kausal Mishra</span>
														<br><small class="me-2"><b>In:</b> 09:00 am</small> <small><b>Out:</b> 00:00 pm</small>
														<p>test ...</p>
													</div>
												</td>
                                                <td class="relative">
                                                    <a class="action-btn" href="javascript:void(0);">
                                                        <svg class="default-size " viewBox="0 0 341.333 341.333 ">
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path d="M170.667,85.333c23.573,0,42.667-19.093,42.667-42.667C213.333,19.093,194.24,0,170.667,0S128,19.093,128,42.667 C128,66.24,147.093,85.333,170.667,85.333z "></path>
                                                                        <path d="M170.667,128C147.093,128,128,147.093,128,170.667s19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 S194.24,128,170.667,128z "></path>
                                                                        <path d="M170.667,256C147.093,256,128,275.093,128,298.667c0,23.573,19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 C213.333,275.093,194.24,256,170.667,256z "></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                    <div class="action-option">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);"><i class="far fa-eye mr-2"></i>View</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
											<tr>
                                                <td>
                                                    <span class="img-thumb">
                                                        
                                                        <img src="images/4.jpg" alt="">
                                                        
                                                    </span>
                                                </td>
												<td>
													
													<div class="ml-2">
														<span>Kabeer Mishra</span>
														<br><small class="me-2"><b>In:</b> 09:30 am</small> <small><b>Out:</b> 00:00 pm</small>
														<p>test ...</p>
													</div>
												</td>
                                                <td class="relative">
                                                    <a class="action-btn" href="javascript:void(0);">
                                                        <svg class="default-size " viewBox="0 0 341.333 341.333 ">
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path d="M170.667,85.333c23.573,0,42.667-19.093,42.667-42.667C213.333,19.093,194.24,0,170.667,0S128,19.093,128,42.667 C128,66.24,147.093,85.333,170.667,85.333z "></path>
                                                                        <path d="M170.667,128C147.093,128,128,147.093,128,170.667s19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 S194.24,128,170.667,128z "></path>
                                                                        <path d="M170.667,256C147.093,256,128,275.093,128,298.667c0,23.573,19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 C213.333,275.093,194.24,256,170.667,256z "></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                    <div class="action-option">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);"><i class="far fa-eye mr-2"></i>View</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
											
											<tr>
                                                <td>
                                                    <span class="img-thumb">
                                                        
                                                        <img src="images/1.jpg" alt="">
                                                        
                                                    </span>
                                                </td>
												<td>
													<div class="ml-2">
														<span>Kausal Mishra</span>
														<br><small class="me-2"><b>In:</b> 09:00 am</small> <small><b>Out:</b> 00:00 pm</small>
														<p>test ...</p>
													</div>
												</td>
                                                <td class="relative">
                                                    <a class="action-btn" href="javascript:void(0);">
                                                        <svg class="default-size " viewBox="0 0 341.333 341.333 ">
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path d="M170.667,85.333c23.573,0,42.667-19.093,42.667-42.667C213.333,19.093,194.24,0,170.667,0S128,19.093,128,42.667 C128,66.24,147.093,85.333,170.667,85.333z "></path>
                                                                        <path d="M170.667,128C147.093,128,128,147.093,128,170.667s19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 S194.24,128,170.667,128z "></path>
                                                                        <path d="M170.667,256C147.093,256,128,275.093,128,298.667c0,23.573,19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 C213.333,275.093,194.24,256,170.667,256z "></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                    <div class="action-option">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);"><i class="far fa-eye mr-2"></i>View</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
											
											<tr>
                                                <td>
                                                    <span class="img-thumb">
                                                        
                                                        <img src="images/1.jpg" alt="">
                                                        
                                                    </span>
                                                </td>
												<td>
													<div class="ml-2">
														<span>Kausal Mishra</span>
														<br><small class="me-2"><b>In:</b> 09:00 am</small> <small><b>Out:</b> 00:00 pm</small>
														<p>test ...</p>
													</div>
												</td>
                                                <td class="relative">
                                                    <a class="action-btn" href="javascript:void(0);">
                                                        <svg class="default-size " viewBox="0 0 341.333 341.333 ">
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path d="M170.667,85.333c23.573,0,42.667-19.093,42.667-42.667C213.333,19.093,194.24,0,170.667,0S128,19.093,128,42.667 C128,66.24,147.093,85.333,170.667,85.333z "></path>
                                                                        <path d="M170.667,128C147.093,128,128,147.093,128,170.667s19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 S194.24,128,170.667,128z "></path>
                                                                        <path d="M170.667,256C147.093,256,128,275.093,128,298.667c0,23.573,19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 C213.333,275.093,194.24,256,170.667,256z "></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                    <div class="action-option">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);"><i class="far fa-eye mr-2"></i>View</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
											
											<tr>
                                                <td>
                                                    <span class="img-thumb">
                                                        
                                                        <img src="images/1.jpg" alt="">
                                                        
                                                    </span>
                                                </td>
												<td>
													<div class="ml-2">
														<span>Kausal Mishra</span>
														<br><small class="me-2"><b>In:</b> 09:40 am</small> <small><b>Out:</b> 00:00 pm</small>
														<p>test ...</p>
													</div>
												</td>
                                                <td class="relative">
                                                    <a class="action-btn" href="javascript:void(0);">
                                                        <svg class="default-size " viewBox="0 0 341.333 341.333 ">
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path d="M170.667,85.333c23.573,0,42.667-19.093,42.667-42.667C213.333,19.093,194.24,0,170.667,0S128,19.093,128,42.667 C128,66.24,147.093,85.333,170.667,85.333z "></path>
                                                                        <path d="M170.667,128C147.093,128,128,147.093,128,170.667s19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 S194.24,128,170.667,128z "></path>
                                                                        <path d="M170.667,256C147.093,256,128,275.093,128,298.667c0,23.573,19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 C213.333,275.093,194.24,256,170.667,256z "></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                    <div class="action-option">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);"><i class="far fa-eye mr-2"></i>View</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
								<div class="tree col-md-12 text-center mt-3">
									<a href="team.html" class="btn-outline secondary-outline mr-2 sm-btn" fdprocessedid="msm7d">View Team Member</a>
								</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6">
						<div class="card ad-info-card-">
							<div class="card-header">
								<img  style="width:30px;" class="float-start me-3" src="./images/icons/icon3.png">
								<div class="">
								<h5><b>Request approval for my teams</b></h5>
								<p>Streamlined leave approvals and pending request tracking.</p>
								</div>
							</div>
							<div class="card-body border-bottom-d" style="height: 450px;overflow-y: scroll;overflow-x: hidden;">
								<div class="card p-3 mb-3" style="border:1px solid #ddd;">
									<div>
										<label class="mb-0 badge badge-secondary" title="" data-original-title="CL">CL</label>
										<span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span style="border-radius:3px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3 Days</b></small></span>
									</div>
									<p style="border-bottom:1px solid #ddd;"><small>I have to attend to a medical emergency of a close relative. I will have to be away from 2 days. i will resume work from. <a data-bs-toggle="modal" data-bs-target="#approvalpopup"  class="link btn-link p-0">More...</a></small></p>
									
									
									
									<div class="mt-2">
										<a href="" style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn mr-2 effect-btn btn btn-primary" title="" data-original-title="Pending">Pending</a>
									</div>
								</div>
								
								<div class="card p-3 mb-3" style="border:1px solid #ddd;">
									<div>
										<label class="mb-0 badge badge-secondary" title="" data-original-title="CL">CL</label>
										<span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span style="border-radius:3px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3 Days</b></small></span>
									</div>
									<p style="border-bottom:1px solid #ddd;"><small>I have to attend to a medical emergency of a close relative. I will have to be away from 2 days. i will resume work from. <a data-bs-toggle="modal" data-bs-target="#approvalpopup"  href="" class="link btn-link p-0">More...</a></small></p>
									
									<div class="mt-2">
										<a href="" style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn mr-2 effect-btn btn btn-success" title="" data-original-title="Approval">Approved</a>
									</div>
								</div>
								
								<div class="card p-3 mb-3" style="border:1px solid #ddd;">
									<div>
										<label class="mb-0 badge badge-secondary" title="" data-original-title="CL">SL</label>
										<span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span style="border-radius:3px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3 Days</b></small></span>
									</div>
									<p style="border-bottom:1px solid #ddd;"><small>I have to attend to a medical emergency of a close relative. I will have to be away from 2 days. i will resume work from. <a data-bs-toggle="modal" data-bs-target="#approvalpopup"  href="" class="link btn-link p-0">More...</a></small></p>
									
									<div class="mt-2">
										<a href="" style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn mr-2 effect-btn btn btn-danger" title="" data-original-title="Approval">Rejected</a>
									</div>
								</div>
								
								<div class="card p-3 mb-3" style="border:1px solid #ddd;">
									<div>
										<label class="mb-0 badge badge-secondary" title="" data-original-title="CL">PL</label>
										<span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span style="border-radius:3px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3 Days</b></small></span>
									</div>
									<p style="border-bottom:1px solid #ddd;"><small>I have to attend to a medical emergency of a close relative. I will have to be away from 2 days. i will resume work from. <a data-bs-toggle="modal" data-bs-target="#approvalpopup" href="" class="link btn-link p-0">More...</a></small></p>
									
									<div class="mt-2">
										<a href="" style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn mr-2 effect-btn btn btn-success" title="" data-original-title="Approval">Approval</a>
										<a href="" style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn mr-2 effect-btn btn btn-danger" title="" data-original-title="Approval">Reject</a>
									</div>
								</div>
								
                            </div>
							
						</div>
					</div>
					</div>
                    </div>
					
					
                    <!----Right side --->
                    <div class="col-xl-4 col-lg-4 col-md-8 col-sm-12">
						<div class="card chart-card ">
                            <div class="card-header">
                                <h4 class="has-btn float-start">Task / Chat</h4>
								
                            </div>
                            <div class="card-body border-bottom-d" style="height:490px;overflow-y:auto;">
								
                            </div>
                        </div>
                    </div>
					
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
						<div class="card chart-card ">
                            <div class="card-header" id="attendance">
                                <h4 class="has-btn float-start">Monthly Attendance</h4>
                            </div>
                            <div class="card-body" style="height:808px;overflow-y:auto;overflow-x:hidden;">
								<div class="img-thumb atte-box">
									<img class="float-start me-2" src="images/7.jpg" />
									<div class="float-start" style="min-width:250px;">
										<div class=""><a href="single-details.html">Rohit Kumar</a> <span class="float-end" style="font-size:11px;"><b>Emp Code: 1254</b></span></div>
										<div class="mt-1" style="border-top:1px solid #ddd;">
											<div class="att-count"><span class="count present-c">25</span><span>Present</span></div>
											<div class="att-count"><span class="count absent-c">5</span><span>Absent</span></div>
											<div class="att-count"><span class="count leave-c">5</span><span>Leave</span></div>
											<div class="att-count"><span class="count od-c">5</span><span>OD</span></div>
											
										</div>
									</div>
									<div class="float-end">
										<a style="padding:20px 5px;" class="calender-show-btn"><i class="fas fa-angle-down mt-4 mr-2"></i></a>
									</div>
								</div>
								
								<div style="margin-top:70px;display:none;" class="calendar-wrapper mb-4"></div>
								
								<div class="img-thumb atte-box">
									<img class="float-start me-2" src="images/7.jpg" />
									<div class="float-start" style="min-width:250px;">
										<div class=""><a href="single-details.html">Rohit Kumar</a> <span class="float-end" style="font-size:11px;"><b>Emp Code: 1254</b></span></div>
										<div class="mt-1" style="border-top:1px solid #ddd;">
											<div class="att-count"><span class="count present-c">25</span><span>Present</span></div>
											<div class="att-count"><span class="count absent-c">5</span><span>Absent</span></div>
											<div class="att-count"><span class="count leave-c">5</span><span>Leave</span></div>
											<div class="att-count"><span class="count od-c">5</span><span>OD</span></div>
											
										</div>
									</div>
									<div class="float-end">
										<a style="padding:20px 5px;"><i class="fas fa-angle-down mt-4 mr-2"></i></a>
									</div>
								</div>
								<div class="img-thumb atte-box">
									<img class="float-start me-2" src="images/7.jpg" />
									<div class="float-start" style="min-width:250px;">
										<div class=""><a href="single-details.html">Rohit Kumar</a> <span class="float-end" style="font-size:11px;"><b>Emp Code: 1254</b></span></div>
										<div class="mt-1" style="border-top:1px solid #ddd;">
											<div class="att-count"><span class="count present-c">25</span><span>Present</span></div>
											<div class="att-count"><span class="count absent-c">5</span><span>Absent</span></div>
											<div class="att-count"><span class="count leave-c">5</span><span>Leave</span></div>
											<div class="att-count"><span class="count od-c">5</span><span>OD</span></div>
											
										</div>
									</div>
									<div class="float-end">
										<a style="padding:20px 5px;"><i class="fas fa-angle-down mt-4 mr-2"></i></a>
									</div>
								</div>
								<div class="img-thumb atte-box">
									<img class="float-start me-2" src="images/7.jpg" />
									<div class="float-start" style="min-width:250px;">
										<div class=""><a href="single-details.html">Rohit Kumar</a> <span class="float-end" style="font-size:11px;"><b>Emp Code: 1254</b></span></div>
										<div class="mt-1" style="border-top:1px solid #ddd;">
											<div class="att-count"><span class="count present-c">25</span><span>Present</span></div>
											<div class="att-count"><span class="count absent-c">5</span><span>Absent</span></div>
											<div class="att-count"><span class="count leave-c">5</span><span>Leave</span></div>
											<div class="att-count"><span class="count od-c">5</span><span>OD</span></div>
											
										</div>
									</div>
									<div class="float-end">
										<a style="padding:20px 5px;"><i class="fas fa-angle-down mt-4 mr-2"></i></a>
									</div>
								</div>
								<div class="img-thumb atte-box">
									<img class="float-start me-2" src="images/7.jpg" />
									<div class="float-start" style="min-width:250px;">
										<div class=""><a >Rohit Kumar</a> <span class="float-end" style="font-size:11px;"><b>Emp Code: 1254</b></span></div>
										<div class="mt-1" style="border-top:1px solid #ddd;">
											<div class="att-count"><span class="count present-c">25</span><span>Present</span></div>
											<div class="att-count"><span class="count absent-c">5</span><span>Absent</span></div>
											<div class="att-count"><span class="count leave-c">5</span><span>Leave</span></div>
											<div class="att-count"><span class="count od-c">5</span><span>OD</span></div>
											
										</div>
									</div>
									<div class="float-end">
										<a style="padding:20px 5px;"><i class="fas fa-angle-down mt-4 mr-2"></i></a>
									</div>
								</div>
								<div class="img-thumb atte-box">
									<img class="float-start me-2" src="images/7.jpg" />
									<div class="float-start" style="min-width:250px;">
										<div class=""><a >Rohit Kumar</a> <span class="float-end" style="font-size:11px;"><b>Emp Code: 1254</b></span></div>
										<div class="mt-1" style="border-top:1px solid #ddd;">
											<div class="att-count"><span class="count present-c">25</span><span>Present</span></div>
											<div class="att-count"><span class="count absent-c">5</span><span>Absent</span></div>
											<div class="att-count"><span class="count leave-c">5</span><span>Leave</span></div>
											<div class="att-count"><span class="count od-c">5</span><span>OD</span></div>
											
										</div>
									</div>
									<div class="float-end">
										<a style="padding:20px 5px;"><i class="fas fa-angle-down mt-4 mr-2"></i></a>
									</div>
								</div>
                            </div>
                        </div>
					</div>
					
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
						<div class="row">
							<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8" >
								<div class="card chart-card ">
									<div class="card-header" id="attendance">
										<h4 class="has-btn float-start">Leave</h4>
									</div>
									<div class="card-body" style="height:300px;overflow-y:auto;overflow-x:hidden;">
										<table class="table team-leave table" >
														<thead style="background-color:transparent;">
															<tr>
																<th>SN</th>
																<th>Name</th>
																<th>EC</th>
																<th><span class="leave-h">CL</span></th>
																<th><span class="leave-h">PL</span></th>
																<th><span class="leave-h">SL</span></th>
																<th><span class="leave-h">EL</span></th>
																<th><span class="leave-h">FL</span></td>
																<th>Balance</td>
															</tr>
														</thead>
														<tbody> 
														<tr>
														<td >1.</td>
														<td>
															<span class="img-thumb">
																<span class="ml-2">Krishna</span>
															</span>
														</td>
														<td>1254</td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">2</span>/<span class="bal">4</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">5</span>/<span class="bal">24</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">1</span></b></td>
														<td><b><span class="use">8</span>/<span class="bal">38</span></b></td>
														</tr>
														
														<tr>
														<td >2.</td>
														<td>
															<span class="img-thumb">
																<span class="ml-2">Samridh Kumar</span>
															</span>
														</td>
														<td>1254</td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">2</span>/<span class="bal">4</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">5</span>/<span class="bal">24</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">1</span></b></td>
														<td><b><span class="use">8</span>/<span class="bal">38</span></b></td>
														</tr>
															 
														<tr>
														<td >3.</td>
														<td>
															<span class="img-thumb">
																<span class="ml-2">Karan Kumar</span>
															</span>
														</td>
														<td>1254</td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">2</span>/<span class="bal">4</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">5</span>/<span class="bal">24</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">1</span></b></td>
														<td><b><span class="use">8</span>/<span class="bal">38</span></b></td>
														</tr>
														<tr>
														<td >4.</td>
														<td>
															<span class="img-thumb">
																<span class="ml-2">Karan Kumar</span>
															</span>
														</td>
														<td>1254</td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">2</span>/<span class="bal">4</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">5</span>/<span class="bal">24</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">1</span></b></td>
														<td><b><span class="use">8</span>/<span class="bal">38</span></b></td>
														</tr>
														<tr>
														<td >5.</td>
														<td>
															<span class="img-thumb">
																<span class="ml-2">Karan Kumar</span>
															</span>
														</td>
														<td>1254</td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">2</span>/<span class="bal">4</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">5</span>/<span class="bal">24</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">1</span></b></td>
														<td><b><span class="use">8</span>/<span class="bal">38</span></b></td>
														</tr>
														<tr>
														<td >6.</td>
														<td>
															<span class="img-thumb">
																<span class="ml-2">Karan Kumar</span>
															</span>
														</td>
														<td>1254</td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">2</span>/<span class="bal">4</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">5</span>/<span class="bal">24</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">1</span></b></td>
														<td><b><span class="use">8</span>/<span class="bal">38</span></b></td>
														</tr>
														<tr>
														<td >7.</td>
														<td>
															<span class="img-thumb">
																<span class="ml-2">Karan Kumar</span>
															</span>
														</td>
														<td>1254</td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">2</span>/<span class="bal">4</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">5</span></b></td>
														<td><b><span class="use">5</span>/<span class="bal">24</span></b></td>
														<td><b><span class="use">0</span>/<span class="bal">1</span></b></td>
														<td><b><span class="use">8</span>/<span class="bal">38</span></b></td>
														</tr>
														
														</tbody>
														</table>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" >
								<div class="card chart-card ">
									<div class="card-header" id="attendance">
										<h4 class="has-btn float-start">Query</h4>
									</div>
									<div class="card-body" style="height:300px;overflow-y:auto;overflow-x:hidden;">
										<ul class="query-list">
											<li>
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
												<div ><span><b>Rakesh Mishra</b></span><span class="float-end"><b>EC - 1254</b></span></div>
											<p style="font-size:11px;">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even <a data-bs-toggle="modal" data-bs-target="#querypopup"  class="link btn-link p-0">More...</a></p>
											<div class>
												<span><b>Dept.:</b> Admin</span> <span class="float-end"><b>Sub.:</b> Washing</span>
											</div>
											</li>
											<li>
												<div class="query-level" style="    border-top: 2px solid #ddd;margin-bottom:10px;width:190px;">
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
												<div ><span><b>Rakesh Mishra</b></span><span class="float-end"><b>EC - 1254</b></span></div>
											<p style="font-size:11px;">There are many variations of passages of Lorem Ipsum available, but the <a data-bs-toggle="modal" data-bs-target="#querypopup"  class="link btn-link p-0">More...</a></p>
											<div class>
												<span><b>Dept.:</b> Admin</span> <span class="float-end"><b>Sub.:</b> Washing</span>
											</div>
											</li>
											<li>
												<div class="query-level" style="    border-top: 2px solid #ddd;margin-bottom:10px;width:190px;">
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
												<div ><span><b>Rakesh Mishra</b></span><span class="float-end"><b>EC - 1254</b></span></div>
											<p style="font-size:11px;">There are many variations of passages of Lorem Ipsum <a data-bs-toggle="modal" data-bs-target="#querypopup"  class="link btn-link p-0">More...</a></p>
											<div class>
												<span><b>Dept.:</b> Admin</span> <span class="float-end"><b>Sub.:</b> Washing</span>
											</div>
											</li>
											<li>
												<div class="query-level" style="    border-top: 2px solid #ddd;margin-bottom:10px;width:190px;">
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
												<div ><span><b>Rakesh Mishra</b></span><span class="float-end"><b>EC - 1254</b></span></div>
											<p style="font-size:11px;">but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even <a data-bs-toggle="modal" data-bs-target="#querypopup"  class="link btn-link p-0">More...</a></p>
											<div class>
												<span><b>Dept.:</b> Admin</span> <span class="float-end"><b>Sub.:</b> Washing</span>
											</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" >
								<div class="card chart-card ">
									<div class="card-header" id="attendance">
										<h4 class="has-btn float-start">Team Accessibility</h4>
									</div>
									<div class="card-body" style="height:450px;overflow-y:auto;overflow-x:hidden;padding-top:0px;">
										<div class="mfh-machine-profile">
										<ul class="nav nav-tabs" id="myTab1" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" id="assets-tab1" data-bs-toggle="tab" href="#assets" role="tab" aria-controls="assets" aria-selected="true">Assets</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="eligibility-tab20" data-bs-toggle="tab" href="#eligibility" role="tab" aria-controls="eligibility" aria-selected="false">Eligibility</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="training-tab21" data-bs-toggle="tab" href="#training" role="tab" aria-controls="training" aria-selected="false">Training</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="report-tab22" data-bs-toggle="tab" href="#report" role="tab" aria-controls="report" aria-selected="false">Report</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="kra-tab22" data-bs-toggle="tab" href="#kra" role="tab" aria-controls="kra" aria-selected="false">KRA</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="cost-tab22" data-bs-toggle="tab" href="#cost" role="tab" aria-controls="cost" aria-selected="false">Cost</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="separation-tab22" data-bs-toggle="tab" href="#separation" role="tab" aria-controls="separation" aria-selected="false">Separation</a>
											</li>
										</ul>
										<div class="tab-content splash-content2 mt-3" id="myTabContent2">
											<div class="tab-pane fade active show" id="assets" role="tabpanel">
												<p>Assets details</p>
											</div>
											<div class="tab-pane fade" id="kra" role="tabpanel">
												<p>KRA</p>
											</div>
											<div class="tab-pane fade" id="cost" role="tabpanel">
												<p>cost</p>
											</div>
											<div class="tab-pane fade" id="separation" role="tabpanel">
												<p>separation</p>
											</div>
											<div class="tab-pane fade" id="eligibility" role="tabpanel">
												<table class="table table-bordered" >
														<thead style="background-color:#cfdce1;">
															<tr>
																<th>SN</th>
																<th>Name</th>
																<th>Emp Code</th>
																<th>Function</th>
																<th>Designation</th>
																<th>Grade</th>
																<th>HQ</th>
																<th>Detail</td>
															</tr>
														</thead>
														<tbody> 
														<tr>
														<td >1</td>
														<td>
															<span class="img-thumb">
																<img src="./images/1.jpg" alt="">
																<span class="ml-2">Krishna</span>
															</span>
														</td>
														<td>1254</td>
														<td>Support</td>
														<td>Excutive IT</td>
														<td>J1</td>
														<td >Raipur</td>
														<td><a href="">View</a></td>
														</tr>
														
														<tr>
														<td >2</td>
														<td>
															<span class="img-thumb">
																<img src="./images/1.jpg" alt="">
																<span class="ml-2">Samridh Kumar</span>
															</span>
														</td>
														<td>1254</td>
														<td>Support</td>
														<td>Excutive IT</td>
														<td>J1</td>
														<td >Raipur</td>
														<td><a href="">View</a></td>
														</tr>
															 
														<tr>
														<td >3</td>
														<td>
															<span class="img-thumb">
																<img src="./images/1.jpg" alt="">
																<span class="ml-2">Karan Kumar</span>
															</span>
														</td>
														<td>1254</td>
														<td>Support</td>
														<td>Excutive IT</td>
														<td>J1</td>
														<td >Raipur</td>
														<td><a href="">View</a></td>
														</tr>		
														</tbody></table>
											</div>
											<div class="tab-pane fade" id="training" role="tabpanel">
												<table class="table table-bordered" >
														<thead style="background-color:#cfdce1;">
															<tr>
																<th>SN</th>
																<th>Name</th>
																<th>Emp Code</th>
																<th>Function</th>
																<th>Designation</th>
																<th>Grade</th>
																<th>HQ</th>
																<th>Detail</td>
															</tr>
														</thead>
														<tbody> 
														<tr>
														<td >1</td>
														<td>
															<span class="img-thumb">
																<img src="./images/1.jpg" alt="">
																<span class="ml-2">Krishna</span>
															</span>
														</td>
														<td>1254</td>
														<td>Support</td>
														<td>Excutive IT</td>
														<td>J1</td>
														<td >Raipur</td>
														<td><a href="">View</a></td>
														</tr>
														
														<tr>
														<td >2</td>
														<td>
															<span class="img-thumb">
																<img src="./images/1.jpg" alt="">
																<span class="ml-2">Samridh Kumar</span>
															</span>
														</td>
														<td>1254</td>
														<td>Support</td>
														<td>Excutive IT</td>
														<td>J1</td>
														<td >Raipur</td>
														<td><a href="">View</a></td>
														</tr>
															 
														<tr>
														<td >3</td>
														<td>
															<span class="img-thumb">
																<img src="./images/1.jpg" alt="">
																<span class="ml-2">Karan Kumar</span>
															</span>
														</td>
														<td>1254</td>
														<td>Support</td>
														<td>Excutive IT</td>
														<td>J1</td>
														<td >Raipur</td>
														<td><a href="">View</a></td>
														</tr>		
														</tbody></table>
											</div>
											<div class="tab-pane fade" id="report" role="tabpanel">
												<p>REPORT</p>
											</div>
										</div>
									</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" >
							<div class="mfh-machine-profile">
							<ul class="nav nav-tabs" id="myTab1" role="tablist" style="background-color:#a5cccd;border-radius: 10px 10px 0px 0px;">
								<li class="nav-item">
									<a style="color: #0e0e0e;" class="nav-link active" id="myteam" data-bs-toggle="tab" href="#MyteamTab" role="tab" aria-controls="MyteamTab" aria-selected="false">My team</a>
								</li>
								<li class="nav-item d-none">
									<a style="color: #0e0e0e;" class="nav-link" id="attendance" data-bs-toggle="tab" href="#AttendanceTab" role="tab" aria-controls="AttendanceTab" aria-selected="false">Attendance</a>
								</li>	
							</ul>
							<div class="tab-content ad-content2" id="myTabContent2">
								<div class="tab-pane fade active show" id="MyteamTab" role="MyteamTab">
									<div class="card chart-card">
                   
                            <div class="card-body table-responsive">
								<style>
.tree{
	float:left;
	min-width:1500px;
	overflow-x:auto;
}								
.tree ul:first-child {
    padding-top: 20px;
    position: relative;
    transition: all 0.5s;
	float:left;
	width:100%;
}

.tree li {
    float: left;
    text-align: center;
    list-style-type: none;
    position: relative;
    padding: 20px 5px 0 5px;
    transition: all 0.5s;
}

.tree li::before, .tree li::after {
    content: '';
    position: absolute;
    top: 0;
    right: 50%;
    border-top: 1px solid #ccc;
    width: 50%;
    height: 20px;
}

.tree li::after {
    right: auto;
    left: 50%;
    border-left: 1px solid #ccc;
}

.tree li:only-child::after, .tree li:only-child::before {
    display: none;
}

.tree li:only-child {
    padding-top: 0;
}

.tree li:first-child::before, .tree li:last-child::after {
    border: 0 none;
}

.tree li:last-child::before {
    border-right: 1px solid #ccc;
    border-radius: 0 5px 0 0;
}

.tree li:first-child::after {
    border-radius: 5px 0 0 0;
}

.tree li div.emp {
    border: 1px solid #ccc;
    padding: 5px 5px;
    text-decoration: none;
    color: #666;
    border-radius: 5px;
    display: inline-block;
    transition: all 0.5s;
	font-size:11px;
	font-weight:500;
	position:relative;
	margin-bottom:10px;
}
.tree li div.emp img{
width:30px;

}
.tree li div.emp span{color: #9d8f8f;font-size:10px;}
}

.tree li div.emp:hover, .tree li div.emp:hover+ul li div.emp {
    background: #c8e4f8;
    color: #000;
    border: 1px solid #94a0b4;
}
.blink-animation {
    position: absolute;
    left: 5px;
    top: 5px;
	right:auto;
	bottom:auto;
	}

					</style>
					
								<div class="tree">
        <ul>
            <li style="width:100%;float:left;">
                <div class="emp"><img style="width:70px;" src="./images/7.jpg"><br>Ajay Kumar Dewangan<br><span>Manager<br>[Raipur] M1</span></div>
                <ul>
                    <li>
						
                        <div class="emp">
							<img src="./images/1.jpg"><br>Sandeep Kumar Dewangan<br><span>Excutive IT<br>[Raipur] J4</span>
						</div>
						
                        <ul>
                            <li><div class="emp"><img src="./images/4.jpg"><br> Sunil Sahu<br><span>Excutive IT<br>[Raipur] J1</span></div></li>
                            <li><div class="emp"><img src="./images/4.jpg"><br> Dipesh Chandrakar<br><span>Excutive IT<br>Raipur J1</span></div></li>
                            <li><div class="emp"><img src="./images/4.jpg"><br> Rakesh kumar<br><span>Excutive IT<br>Raipur J1</span></div></li>
                            <li><div class="emp"><img src="./images/4.jpg"><br> Rakesh kumar<br><span>Excutive IT<br>Raipur J1</span></div></li>
                            <li><div class="emp"><img src="./images/4.jpg"><br> Rakesh kumar<br><span>Excutive IT<br>Raipur J1</span></div></li>
                        </ul>
                    </li>
                    <li>
                        <div class="emp">
							<img src="./images/3.jpg"><br>Vaibhavi Soni<br><span>Excutive IT<br>Raipur J1</span>
						</div>
						<ul>
                            <li><div class="emp"><img src="./images/4.jpg"><br> Sunil Sahu<br><span>Excutive IT<br>Raipur J1</span></div></li>
                            <li><div class="emp"><img src="./images/4.jpg"><br> Dipesh Chandrakar<br><span>Excutive IT<br>Raipur J1</span></div></li>
                            <li><div class="emp"><img src="./images/4.jpg"><br> Rakesh kumar<br><span>Excutive IT<br>Raipur J1</span></div></li>
                        </ul>
						
                    </li>
					<li>
                        <div class="emp"><img src="./images/4.jpg"><br>Ashok Dewangan <br><span>Excutive IT<br>Raipur J3</span>
						</div>
						<ul>
                            <li><div class="emp"><img src="./images/4.jpg"><br> Sunil</div>
								<ul>
                            <li><div class="emp"><img src="./images/4.jpg"><br> Sunil</div></li>
                            <li><div class="emp"><img src="./images/4.jpg"><br> Dipesh</div></li>
							
                        </ul>
							</li>
                            <li><div class="emp">Rakesh</div></li>
                        </ul>
                    </li>
					<li>
                        <div class="emp"><img src="./images/4.jpg"><br>Narayan Kumar Yadav <br><span>Excutive IT<br>Raipur J2</span>
                       
						</div>
                    </li>
					<li>
                        <div class="emp"><img src="./images/4.jpg"><br>Shubham Karangale <br><span>Excutive IT<br>Raipur J1</span>
                       
						</div>
                    </li>
					<li>
                        <div class="emp"><img src="./images/4.jpg"><br>Devendra Verma<br><span>Excutive IT<br>Raipur J1</span>
                       
						</div>
                    </li>
					<li>
                        <div class="emp">
							<img src="./images/4.jpg"><br>Devendra Verma<br><span>Excutive IT<br>Raipur J1</span>
						</div>
                    </li>
					
					<li>
                        <div class="emp"><img src="./images/4.jpg"><br>Devendra Verma<br><span>Excutive IT<br>Raipur J1</span>
                       
						</div>
                    </li>
					<li>
                        <div class="emp"><img src="./images/4.jpg"><br>Devendra Verma<br><span>Excutive IT23<br>Raipur J1</span>
						</div>
                    </li>
					
                </ul>
            </li>
        </ul>
		</div>
							</div>
						</div>
								</div>
								<div class="tab-pane fade" id="AttendanceTab" role="AttendanceTab">
									<div class="card">
										<div class="card-body table-responsive">
											<div class="row">
												<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
													<div class="form-group s-opt">
														<label for="city" class="col-form-label">Select Month</label>
														<select class="select2 form-control select-opt" id="city">
															  <option value="CL">Jan</option>
															  <option value="SL">Feb</option>
															  <option value="PL">March</option>
															  <option value="EL">April</option>
															  <option value="EL">June</option>
															  <option value="EL">July</option>
															  <option value="EL">August</option>
															  <option value="EL">September</option>
															  <option value="EL">October</option>
														</select>
														<span class="sel_arrow">
															<i class="fa fa-angle-down "></i>
														</span>
													</div>
												</div>
											</div>
											
											<table class="table table-c border">
												<thead class="thead-dark">
													<tr>
														<th>May Month</th>
														<th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th><th><span class="sun">S</span></th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th><th><span class="sun">S</span></th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th><th><span class="sun">S</span></th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th><th><span class="sun">S</span></th><th>M</th><th>T</th><th>W</th><th>T</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<div class="emp-name float-start">
																<span class="name-circle">K</span>
																<span><a href="emp-details.html"><b>Kausal</b></a></span>
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
								
								<div class="tab-pane fade" id="Eligibility" role="Eligibility">
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
													<table class="table table-bordered" >
														<thead style="background-color:#cfdce1;">
															<tr>
																<th>SN</th>
																<th>Name</th>
																<th>Emp Code</th>
																<th>Designation</th>
																<th>Grade</th>
																<th>HQ</th>
																<th>Detail</td>
															</tr>
														</thead>
														<tbody> 
														<tr>
														<td >1</td>
														<td>
															<span class="img-thumb">
																<img src="./images/1.jpg" alt="">
																<span class="ml-2">Krishna</span>
															</span>
														</td>
														<td>1254</td>
														<td>Excutive IT</td>
														<td>J1</td>
														<td >-</td>
														<td>-</td>
														</tr>
														
														<tr>
														<td >2</td>
														<td>
										<span class="img-thumb">
											<img src="./images/1.jpg" alt="">
											<span class="ml-2">Samridh Kumar</span>
										</span>
									</td>
														<td>-</td>
														<td>-</td>
														<td>-</td>
														<td >-</td>
														<td>-</td>
														</tr>
															 
														<tr>
														<td >3</td>
														<td>
										<span class="img-thumb">
											<img src="./images/1.jpg" alt="">
											<span class="ml-2">Karan Kumar</span>
										</span>
									</td>
														<td>-</td>
														<td>-</td>
														<td>-</td>
														<td >-</td>
														<td>-</td>
														</tr>		
														</tbody></table>
												</div>
                                            </div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="Training" role="Training">
									<div class="card table-card">
										<div class="card-body">
											<div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                                <table class="table table-bordered" >
                                                                    <thead style="background-color:#cfdce1;">
                                                                        <tr>
                                                                            <th>SN</th>
                                                                            <th>Name</th>
                                                                            <th>Emp Code</th>
                                                                            <th>Subject</th>
                                                                            <th>Year</th>
                                                                            <th>Date From</th>
                                                                            <th>Date To</td>
                                                                            <th>Day</td>
                                                                            <th>Location</td>
                                                                            <th>Institute</td>
                                                                            <th>Trainer</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody> 	
                                                                    
                                                                    
                                                                    <tr>
                                                                    <td >1</td>
                                                                    <td>
                                                    <span class="img-thumb">
                                                        <img src="./images/1.jpg" alt="">
                                                        <span class="ml-2">Krishna</span>
                                                    </span>
                                                </td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td >-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    </tr>
																	
                                                                    <tr>
                                                                    <td >2</td>
                                                                    <td>
                                                    <span class="img-thumb">
                                                        <img src="./images/1.jpg" alt="">
                                                        <span class="ml-2">Samridh Kumar</span>
                                                    </span>
                                                </td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td >-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    </tr>
                                                                         
                                                                    <tr>
                                                                    <td >3</td>
                                                                    <td>
                                                    <span class="img-thumb">
                                                        <img src="./images/1.jpg" alt="">
                                                        <span class="ml-2">Karan Kumar</span>
                                                    </span>
                                                </td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td >-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    </tr>		
																	</tbody></table>
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
	
	<div class="modal fade show" id="approvalpopup" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle3">Approval Details</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
		<div class="mb-4">
			<label class="mb-0 badge badge-secondary" title="" data-original-title="CL">CL</label>
			<span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span style="border-radius:3px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3 Days</b></small></span>
		</div>
		<p>I have to attend to a medical emergency of a close relative. I will have to be away from 2 days. i will resume work from. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>            
        </div>
        <div class="modal-footer">
        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
        
        </div>
      </div>
      </div>
    </div>
	<!--Approval Message-->
    <div class="modal fade show" id="querypopup" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle3">Query Details</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
		<p><b>Department - Admin</b></p>
		<p><b>Subject - ----</b></p>
		<p>
		<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even</p> <br>
		<p>Raise Date:15 May 2024</p>
			<table class="table table-border mt-2">
				<thead>
					<tr><td>Level 1</td><td>Level 2</td><td>Level 3</td></tr>
				</thead>
				<tr>
					<td><b>Done</b></td><td><b>Open<b></td><td><b>Pending</b></td>
				<tr>
				<tr>
					<td>16 May</td><td>19 May</td><td>Pending</td>
				<tr>
			</table>
			</div>
        <div class="modal-footer">
        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
        
        </div>
      </div>
      </div>
    </div>
	
	
	
    <!--Attendence Authorisation-->
    <div class="modal fade show" id="model3" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle3">Attendance Authorisation</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
          <p>This option is only for missed attendance or late In-time/early out-time attendance and not for leave application. <span class="danger">Do not apply leave here.</span></p>
          <br>
          <p><b>Request Date: 06-05-2023</b><br>
            In: <span class="danger">09:35 AM Late</span>              Out: 06:10 PM</p><br>
            <form>
              <div class="form-group">
              <label class="col-form-label">Reason:</label>
              <input type="text" class="form-control">
              </div>
              <div class="form-group">
              <label class="col-form-label">Message:</label>
              <textarea class="form-control"></textarea>
              </div>
            </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send</button>
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