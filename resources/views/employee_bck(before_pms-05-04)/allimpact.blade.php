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
        <!-- Sidebar Start -->
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
                                    <li class="breadcrumb-link active">All Impact</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revanue Status Start -->
                <div class="card chart-card">
					<div class="card-body text-center">
					<?php
				// Fetch data from the database
				$impactDocuments = DB::table('hrm_impact_document')
					->orderBy('ImpactId', 'desc')
					->get();
				?>
				<div class="row">
					<?php foreach ($impactDocuments as $item): ?>
						<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
							<div class="card chart-card">
								<div class="card-header">
									<h5 class="mt-2">Volume - <?php echo htmlspecialchars($item->IVal); ?></h5>
								</div>
								<div class="card-body">
                                    <a title="Volume <?php echo htmlspecialchars($item->IVal); ?>" 
                                        href="https://s3.ap-south-1.amazonaws.com/vnrpeepal.bkt/Impact_Magazine/<?php echo htmlspecialchars($item->IDocName); ?>" 
                                        target="_blank">
                                            <img class="d-block w-100 p-3" 
                                                src="https://s3.ap-south-1.amazonaws.com/vnrpeepal.bkt/Impact_Magazine/<?php echo htmlspecialchars($item->IImg); ?>" 
                                                alt="Volume-<?php echo htmlspecialchars($item->IVal); ?>">
                                        </a>

									<!-- <a title="Volume <?php echo htmlspecialchars($item->IVal); ?>" 
									href="https://vnrseeds.co.in/AdminUser/VnrImpact/<?php echo htmlspecialchars($item->IDocName); ?>" 
									target="_blank">
										<img class="d-block w-100 p-3" 
											src="https://vnrseeds.co.in/AdminUser/VnrImpact/<?php echo htmlspecialchars($item->IImg); ?>" 
											alt="Volume-<?php echo htmlspecialchars($item->IVal); ?>">
									</a> -->
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
					</div>
				</div>

                @include('employee.footerbottom')

            </div>
        </div>
    </div>

    @include('employee.footer');