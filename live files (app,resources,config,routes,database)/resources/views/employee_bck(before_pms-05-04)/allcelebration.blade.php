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
        <!-- Sidebar Start -->
        @include('employee.sidebar')
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
                                    <li class="breadcrumb-link active">All Celebration</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revanue Status Start -->
                <div class="row">
					<div class="col-sm-12">
					<div class="card">
						<div class="card-header">
							<h5>Monthly Celebration</h5>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-lg-4 col-sm-6 order-1">
									<div class="int-count2-box counter-text">
										<h1><span class="count-no1" data-to="654" data-speed="3000">30</span><span>+</span></h1>
										<p>Birthday</p>
									</div>
								</div>
								<div class="col-lg-4 order-3">
									<div class="int-count2-box counter-text ">
										<h1 class="back-img1"><span class="count-no1" data-to="12" data-speed="3000">12</span><span>+</span></h1>
										<p>Marriage Anniversary</p>
									</div>
								</div>
								<div class="col-lg-4 col-sm-6 order-2">
									<div class="int-count2-box counter-text">
										<h1 class="back-img2"><span class="count-no1" data-to="5" data-speed="3000">5</span><span>+</span></h1>
										<p>VNR Anniversary</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				  </div>
                    <div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h5>Birthday</h5>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                 
										  <div class="media">
											<img src="./images/7.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>1 June</b></div>
											</div>
										  </div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                 
											<div class="media">
												<img src="./images/3.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>3 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                  
											<div class="media">
												<img src="./images/1.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>4 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                  
											<div class="media">
												<img src="./images/4.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>5 June</b></div>
											</div>
											</div>
										</div>
									</div>
									
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
										  <div class="media">
											<img src="./images/7.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>7 June</b></div>
											</div>
										  </div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
											<div class="media">
												<img src="./images/1.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Jadgalpur</div>
												  </div>
												  <div class="text-success"><b>10 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
											<div class="media">
												<img src="./images/4.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>A.P. Singh</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>11 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
											<div class="media">
												<img src="./images/7.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Tejash Yadav</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: R&D</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Kohadiya</div>
												  </div>
												  <div class="text-success"><b>15 June</b></div>
											</div>
											</div>
										</div>
									</div>
									
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
										  <div class="media">
											<img src="./images/3.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Suresh Sharma</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Mahasamund</div>
												  </div>
												  <div class="text-success"><b>20 June</b></div>
											</div>
										  </div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
											<div class="media">
												<img src="./images/3.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Karan Kumar</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>24 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
											<div class="media">
												<img src="./images/4.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Kishor Verma</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>24 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
											<div class="media">
												<img src="./images/7.jpg" alt="">
												<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img src="./images/b-day-star.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>25 June</b></div>
											</div>
											</div>
										</div>
									</div>
								</div>
								<div class="ad-load-btn">
									<button class="btn btn-primary squer-btn mt-2 mr-2" data-original-title="" title="" fdprocessedid="u0mwii"><i class="fa fa-spin fa-spinner mr-2"></i>Load More</button>
								</div>
							</div>
							
						</div>
						<div class="card">
							<div class="card-header">
								<h5>Marriage Anniversary</h5>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                 
										  <div class="media">
											<img src="./images/1.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img style="width:50px;" src="./images/anniversary.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>7 June</b></div>
											</div>
										  </div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                 
											<div class="media">
												<img src="./images/7.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img style="width:50px;" src="./images/anniversary.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>8 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                  
											<div class="media">
												<img src="./images/3.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img style="width:50px;" src="./images/anniversary.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>10 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                  
											<div class="media">
												<img src="./images/4.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img style="width:50px;" src="./images/anniversary.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>12 June</b></div>
											</div>
											</div>
										</div>
									</div>
									
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
										  <div class="media">
											<img src="./images/1.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img style="width:50px;" src="./images/anniversary.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>12 June</b></div>
											</div>
										  </div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
											<div class="media">
												<img src="./images/4.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img style="width:50px;" src="./images/anniversary.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>14 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
											<div class="media">
												<img src="./images/3.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img style="width:50px;" src="./images/anniversary.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>29 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
											<div class="media">
												<img src="./images/1.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<img style="width:50px;" src="./images/anniversary.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>30 June</b></div>
											</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<div class="card">
							<div class="card-header">
								<h5>VNR Anniversary</h5>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                 
										  <div class="media">
											<img src="./images/1.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;position:relative;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<span>4</span>
														<img src="./images/star-1.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>1 June</b></div>
												  
											</div>
										  </div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                 
											<div class="media">
												<img src="./images/3.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;position:relative;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<span>4</span>
														<img src="./images/star-1.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>10 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                  
											<div class="media">
												<img src="./images/4.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;position:relative;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<span>4</span>
														<img src="./images/star-1.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>14 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box">                                  
											<div class="media">
												<img src="./images/7.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;position:relative;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<span>4</span>
														<img src="./images/star-1.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>18 June</b></div>
											</div>
											</div>
										</div>
									</div>
									
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
										  <div class="media">
											<img src="./images/4.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;position:relative;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<span>4</span>
														<img src="./images/star-1.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>21 June</b></div>
											</div>
										  </div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
											<div class="media">
												<img src="./images/3.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;position:relative;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<span>4</span>
														<img src="./images/star-1.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>22 June</b></div>
											</div>
											</div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
										<div class="prooduct-details-box ad-details-box2">
											<div class="media">
												<img src="./images/1.jpg" alt="">
											<div class="media-body ms-0">
												  <div class="product-name mb-2" style="border-bottom: 1px solid #ddd;padding-bottom: 9px;position:relative;">
													<h5><b>Sushant Mishra</b></h5>
													<span>Sales Executive</span>
													<div class="vnr-anny">
														<span>4</span>
														<img src="./images/star-1.png" />
													</div>
												  </div>
												  <div class="price"> 
													<div class="text-muted me-2">Dept: Production</div>
												  </div>
												  <div class="avaiabilty">
													<div class="text-success">HQ: Raipur</div>
												  </div>
												  <div class="text-success"><b>22 June</b></div>
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

    @include('employee.footer');