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
				@php
            			$ratingsnew = DB::table('hrm_pms_rating')
                        ->select('RatingName', 'Rating')
                        ->where('YearId', $PmsYId)
                        ->where('CompanyId', Auth::user()->CompanyId)
                        ->where('RatingStatus', 'A')
                        ->get();
                        $groupedRatings = $ratingsnew->groupBy('RatingName');

                @endphp
                    <div class="rating-ranges text-success">
                    <b>Rating Ranges:</b>
                    @foreach($groupedRatings as $ratingName => $ratingsneww)
                        @php
                            // Get all rating values for the same RatingName
                            $ratingValues = $ratingsneww->pluck('Rating')->implode(', ');
                        @endphp
                        <span class="rating-range-item- mr-2">
                            <b class="text-danger">{{ $ratingValues }}</b> - {{ $ratingName }}
                        </span>
                    @endforeach
                </div>
                <!-- Revanue Status Start -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
						<div class="mfh-machine-profile">
							
							<ul class="nav nav-tabs bg-light mb-3" id="myTab1" role="tablist" >   
								<!-- <li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4 " id="profile-tab20" href="{{route('management')}}#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA 2024</a>
								</li> -->
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4" id="profile-tab20" href="{{route('management')}}#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA New 2025-26</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4" id="team_appraisal_tab20" href="{{route('managementAppraisal')}}" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;min-width:115px;" class="nav-link pt-4 text-center " id="team_report_tab20" href="{{route('managementReport')}}" role="tab" aria-controls="teamreport" aria-selected="false">Report</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;min-width:115px;" class="nav-link pt-4 text-center active" id="team_graph_tab20" data-bs-toggle="tab" href="#teamgraph" role="tab" aria-controls="teamgraph" aria-selected="false">Graph</a>
								</li>
							</ul>
							<div class="tab-content ad-content2" id="myTabContent2">
								
							<div class="tab-pane fade active show" id="teamgraph" role="tabpanel">
								<div class="row">
									<div class="mfh-machine-profile">
										<div style="margin-top:-40px;float:left;margin-left:660px;">
											
											<ul class="kra-btns nav nav-tabs border-0" id="ratingTab1" role="tablist">
												<li class="mt-1"><a class="active" id="ratinggraph-tab1"
													data-bs-toggle="tab" href="#ratinggraph" role="tab"
													aria-controls="ratinggraph" aria-selected="true">Rating Graph <i
														class="fas fa-star mr-2"></i></a></li>
												
												<!-- <li class="mt-1"><a class="" id="overallratinggraph-tab21"
													data-bs-toggle="tab" href="#overallratinggraph" role="tab"
													aria-controls="overallratinggraph" aria-selected="false">Overall Rating Graph <i class="fas fa-file-invoice mr-2"></i></a></li>
											 -->
												</ul>
										</div>
									
										<div class="tab-content splash-content2" >
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
										 role="tabpanel" id="ratinggraph">
												<div class="card">
												<table class="table table-bordered">
                                             <thead>
                                                   <tr>
                                                      <th colspan="{{ count($ratings) + 1 }}"><b>Total Employees: {{ $totalemployee }}</b></th>
                                                   </tr>
                                                   <tr>
                                                      <th>Rating</th>
                                                      @foreach($ratings as $rating)
                                                         <th>{{ number_format($rating, 1) }}</th> {{-- Ensure 1 decimal format --}}
                                                      @endforeach
                                                   </tr>
                                             </thead>
                                             <tbody>
                                                    <tr>
                                                      <td><b>Employee</b></td>
                                                      @foreach($ratings as $rating)
                                                         <td>{{ $ratingDataEmployee[number_format($rating, 1)] ?? 0 }}</td>
                                                      @endforeach
                                                   </tr>
                                                   <tr>
                                                      <td><b>Appraiser</b></td>
                                                      @foreach($ratings as $rating)
                                                         <td>{{ $ratingData[number_format($rating, 1)] ?? 0 }}</td>
                                                      @endforeach
                                                   </tr>
                                                  
                                                   <tr>
                                                      <td><b>Reviewer</b></td>
                                                      @foreach($ratings as $rating)
                                                         <td>{{ $ratingDataEmployeeReviewer[number_format($rating, 1)] ?? 0 }}</td>
                                                      @endforeach
                                                   </tr>
                                                   <tr>
                                                      <td><b>HOD</b></td>
                                                      @foreach($ratings as $rating)
                                                         <td>{{ $ratingDataEmployeeHod[number_format($rating, 1)] ?? 0 }}</td>
                                                      @endforeach
                                                   </tr>
												   <tr>
                                                      <td><b>Management</b></td>
                                                      @foreach($ratings as $rating)
                                                         <td>{{ $ratingDataEmployeeMang[number_format($rating, 1)] ?? 0 }}</td>
                                                      @endforeach
                                                   </tr>
                                             </tbody>
                                          </table>

                                          <!-- Graph Section -->
                                          <h3>Management PMS Rating Graph</h3>
                                          <canvas id="hodChart" width="900" height="400"></canvas>

													<!-- <div class="add-graph col-md-8">
														<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
														<canvas id="ratingChart"></canvas>
														<script>
															const ctx = document.getElementById('ratingChart').getContext('2d');
															const ratings = [1.0, 2.0, 2.5, 2.7, 2.9, 3.0, 3.2, 3.4, 3.5, 3.7, 3.9, 4.0, 4.2, 4.4, 4.5, 4.7, 4.9, 5.0];
															const expected = [0, 0, 0.09, 0.15, 0.21, 0.24, 0.3, 0.39, 0.42, 0.36, 0.27, 0.21, 0.15, 0.12, 0.09, 0, 0, 0];
															const actual = [0, 0, 0, 0, 0, 1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

															new Chart(ctx, {
																type: 'line',
																data: {
																	labels: ratings,
																	datasets: [
																		{
																			label: 'Expected',
																			data: expected,
																			borderColor: 'blue',
																			backgroundColor: 'blue',
																			fill: false,
																			tension: 0.3,
																		},
																		{
																			label: 'Actual',
																			data: actual,
																			borderColor: 'red',
																			backgroundColor: 'red',
																			fill: false,
																			tension: 0.3,
																		}
																	]
																},
																options: {
																	responsive: true,
																	scales: {
																		x: {
																			title: {
																				display: true,
																				text: 'Rating'
																			}
																		},
																		y: {
																			title: {
																				display: true,
																				text: 'Frequency'
																			}
																		}
																	}
																}
															});
														</script>
													</div> -->
												</div>
											</div>
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade"
										 role="tabpanel" id="overallratinggraph">
												<div class="card">
													<div class="card-header">
														<h5>Overall Rating Graph</h5>
													</div>
													<div class="card-body table-responsive dd-flex align-items-center">
														<table class="table table-pad">
															<thead>
																<tr>
																	<th>Rating</th>
																	<th>1.0</th>
																	<th>2.0</th>
																	<th>2.5</th>
																	<th>2.7</th>
																	<th>2.9</th>
																	<th>3.0</th>
																	<th>3.2</th>
																	<th>3.4</th>
																	<th>3.5</th>
																	<th>3.7</th>
																	<th>3.9</th>
																	<th>4.0</th>
																	<th>4.2</th>
																	<th>4.4</th>
																	<th>4.5</th>
																	<th>4.7</th>
																	<th>4.9</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Employee</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>1</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>1</td>
																	<td>1</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																</tr>
																<tr>
																	<td>Appariser</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>2</td>
																	<td>0</td>
																	<td>0</td>
																	<td>1</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																</tr>
																<tr>
																	<td>Reviewer</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>1</td>
																	<td>2</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																</tr>
																<tr>
																	<td>HOD</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>1</td>
																	<td>0</td>
																	<td>2</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="add-graph">
														<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.41.1/apexcharts.min.js"></script>
														<style>
															#employeeRatingChart {
																max-width: 650px;
																margin: 35px auto;
															}
														</style>
														<div id="employeeRatingChart"></div>
														<script>
															var options = {
																chart: {
																	type: 'line',
																	height: 350,
																	zoom: {
																		enabled: false
																	}
																},
																series: [
																	{
																		name: 'Employee',
																		data: [0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0]
																	},
																	{
																		name: 'Appariser',
																		data: [0, 0, 0, 0, 0, 0, 2, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0]
																	},
																	{
																		name: 'Reviewer',
																		data: [0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0]
																	},
																	{
																		name: 'HOD',
																		data: [0, 0, 0, 0, 0, 1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0]
																	}
																],
																xaxis: {
																	categories: ["1.0", "2.0", "2.5", "2.7", "2.9", "3.0", "3.2", "3.4", "3.5", "3.7", "3.9", "4.0", "4.2", "4.4", "4.5", "4.7", "4.9"]
																},
																stroke: {
																	width: 3,
																	curve: 'smooth'
																},
																title: {
																	text: 'Role-Based Rating Trends',
																	align: 'left'
																},
																markers: {
																	size: 5,
																	hover: {
																		sizeOffset: 4
																	}
																},
																tooltip: {
																	shared: true,
																	intersect: false
																}
															};
															var chart = new ApexCharts(document.querySelector("#employeeRatingChart"), options);
															chart.render();
														</script>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>  

<script>
	document.addEventListener("DOMContentLoaded", function () {
		const ratingData = @json($ratingData); // Original dataset
		const ratingDataEmployee = @json($ratingDataEmployee); // New dataset
		const ratingDataEmployeeReviewer = @json($ratingDataEmployeeReviewer); // New dataset
		const ratingDataEmployeeHod = @json($ratingDataEmployeeHod); // New dataset
		const ratingDataEmployeeMang = @json($ratingDataEmployeeMang); // New dataset

		const overallrating = @json($overallrating); // New dataset

		const ratings = @json($ratings).map(rating => rating.toFixed(1));

		// Prepare data values for all datasets
		const dataValues = ratings.map(rating => ratingData[rating] ?? null);
		const dataValuesEmployee = ratings.map(rating => ratingDataEmployee[rating] ?? null);
		const dataValuesReviewer = ratings.map(rating => ratingDataEmployeeReviewer[rating] ?? null);
		const dataValuesHod = ratings.map(rating => ratingDataEmployeeHod[rating] ?? null);
		const dataValuesMang = ratings.map(rating => ratingDataEmployeeMang[rating] ?? null);

		const dataValuesOverall = ratings.map(rating => overallrating[rating] ?? null);
				// Function to get the maximum value and its index from an array, ignoring nulls
			function getMaxAndIndex(arr) {
				const nonNullValues = arr.filter(val => val !== null);
				const maxValue = Math.max(...nonNullValues); // Maximum value from the non-null values
				const index = arr.indexOf(maxValue); // Get the index of that value from the original array
				return { maxValue, index };
			}

			// Apply the function to each dataset and get the maximum value and its index
			const maxDataValues = getMaxAndIndex(dataValues);
			const maxDataValuesEmployee = getMaxAndIndex(dataValuesEmployee);
			const maxDataValuesReviewer = getMaxAndIndex(dataValuesReviewer);
			const maxDataValuesHod = getMaxAndIndex(dataValuesHod);
			const maxDataValuesMang = getMaxAndIndex(dataValuesMang);

			// Combine all max values into one array to find the global maximum
			const allMaxValues = [
				maxDataValues.maxValue,
				maxDataValuesEmployee.maxValue,
				maxDataValuesReviewer.maxValue,
				maxDataValuesHod.maxValue,
				maxDataValuesMang.maxValue
			];

			// Find the global max value
			const globalMaxValue = Math.max(...allMaxValues);

			// Now, you can get the dataset with the global max value:
			let globalMaxIndex = -1;
			if (globalMaxValue === maxDataValues.maxValue) globalMaxIndex = maxDataValues.index;
			else if (globalMaxValue === maxDataValuesEmployee.maxValue) globalMaxIndex = maxDataValuesEmployee.index;
			else if (globalMaxValue === maxDataValuesReviewer.maxValue) globalMaxIndex = maxDataValuesReviewer.index;
			else if (globalMaxValue === maxDataValuesHod.maxValue) globalMaxIndex = maxDataValuesHod.index;
			else if (globalMaxValue === maxDataValuesMang.maxValue) globalMaxIndex = maxDataValuesMang.index;

			console.log("Global max value:", globalMaxValue);
			console.log("Global max value index:", globalMaxIndex);

		const ctx = document.getElementById("hodChart").getContext("2d");

		new Chart(ctx, {
			type: "line",
			data: {
				labels: ratings, // X-axis → Ratings
				datasets: [
					{
							label: "Standard Rating",
							data: overallrating, // Y-axis → Employee count (Original)
							borderColor: "rgba(0, 123, 255, 0.9)", // New color (e.g., blue with opacity)
							borderWidth: 4,
							pointRadius: 7, // Bigger points
							pointBackgroundColor: "blue", // New point color (e.g., blue)
							pointBorderColor: "white", // White outline
							pointBorderWidth: 2,
							fill: false,
							spanGaps: true,
							tension: 0.3
					},
					{
						label: "Employee Rating",
						data: dataValuesEmployee, 
						borderColor: "#FF4500", // Orange-Red
						borderWidth: 3,
						pointRadius: 6,
						pointBackgroundColor: "#FF6347", // Tomato
						pointBorderColor: "white",
						pointBorderWidth: 2,
						fill: false,
						spanGaps: true,
						tension: 0.3
					},
					{
						label: "Appraiser Rating",
						data: dataValues, 
						borderColor: "#008000", // Dark Green
						borderWidth: 3,
						pointRadius: 6, 
						pointBackgroundColor: "#32CD32", // Lime Green
						pointBorderColor: "white",
						pointBorderWidth: 2,
						fill: false,
						spanGaps: true,
						tension: 0.3
					},
					{
						label: "Reviewer Rating",
						data: dataValuesReviewer, 
						borderColor: "#4169E1", // Royal Blue
						borderWidth: 3,
						pointRadius: 6,
						pointBackgroundColor: "#1E90FF", // Dodger Blue
						pointBorderColor: "white",
						pointBorderWidth: 2,
						fill: false,
						spanGaps: true,
						tension: 0.3
					},
					{
						label: "HOD Rating",
						data: dataValuesHod, 
						borderColor: "#8A2BE2", // Bright Purple
						borderWidth: 3,
						pointRadius: 6,
						pointBackgroundColor: "#9400D3", // Dark Violet
						pointBorderColor: "white",
						pointBorderWidth: 2,
						fill: false,
						spanGaps: true,
						tension: 0.3
					},
					{
					label: "Management Rating",
					data: dataValuesMang,
					borderColor: "#FF8C00", // Dark Orange
					borderWidth: 3,
					pointRadius: 6,
					pointBackgroundColor: "#FFA500", // Orange
					pointBorderColor: "white",
					pointBorderWidth: 2,
					fill: false,
					spanGaps: true,
					tension: 0.3
					}

				],
			},
			options: {
				responsive: false,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: true,
						position: 'right', // or 'left' or 'top', but 'right' or 'left' stacks vertically
						labels: {
							boxWidth: 30,
							padding: 20,
							font: { size: 14, weight: 'bold' },
							color: 'black',
						}
					}
				},
				scales: {
					x: { 
						title: { display: true, text: "Ratings", color: "black", font: { size: 16, weight: "bold" } },
						grid: { display: false }
					},
					y: { 
						title: { display: true, text: "Total Employees", color: "black", font: { size: 16, weight: "bold" } },
						min: 1, max: globalMaxValue + 2,
						ticks: { stepSize: 1, color: "black" },
						grid: { color: "rgba(0, 0, 0, 0.1)" }
					},
				},
			},
		});
	});
</script>